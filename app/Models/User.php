<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use App\Traits\FormattedTimestamps;
use App\Util\CompanyRoles;
use App\Util\UserRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\UserActivity;
use Musonza\Chat\Traits\Messageable;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, FormattedTimestamps, Messageable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'email',
        'first_name',
        'last_name',
        'phone_number',
        'job_title',
        'country',
        'city',
        'address',
        'postal_code',
        'password',
        'status',
        'organisation_id',
        'role',
        'image_id',
        'is_verified',
        'two_factor_code',
        'two_factor_expires_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
        'password'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime:Y-m-d H:i',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
    
    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    public function organisation()
    {
        return $this->belongsTo(Organisation::class);
    }
    
    public function saved_products()
    {
        return $this->belongsToMany(Product::class, 'saved_products');
    }
    
    public function user_activities()
    {
        return $this->hasMany(UserActivity::class);
    }
    
    public function is_from_seller_organisation()
    {
        if(!$this->organisation){
            return false;
        }
        
        return in_array($this->organisation->organisation_role, CompanyRoles::getSellerRolesArray());
    }
    
    public function is_from_buyer_organisation()
    {
        if(!$this->organisation){
            return false;
        }
        
        return in_array($this->organisation->organisation_role, CompanyRoles::getBuyerRolesArray());
    }

    public function isAdmin(): bool
    {
        return $this->role == UserRoles::$ROLE_ADMIN;
    }

    public function isCompanyAdmin(bool $orAdmin = false): bool
    {
        $result = $this->role == UserRoles::$ROLE_COMPANY_ADMIN;
        return $orAdmin ? ($result || $this->isAdmin()) : $result;
    }

    public function generateTwoFactorCode()
    {
        $this->timestamps = false;
        $this->two_factor_code = rand(100000, 999999);
        $this->two_factor_expires_at = now()->addMinutes(10);
        $this->save();
        return $this->two_factor_code;
    }

    public function resetTwoFactorCode()
    {
        $this->timestamps = false;
        $this->two_factor_code = null;
        $this->two_factor_expires_at = null;
        $this->save();
    }
}
