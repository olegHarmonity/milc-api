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

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, FormattedTimestamps;

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
    
    public function is_from_seller_organisation()
    {
        return in_array($this->organisation->organisation_role, CompanyRoles::getSellerRolesArray());
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
}
