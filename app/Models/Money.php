<?php

namespace App\Models;

use App\Traits\FormattedTimestamps;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Cast\IntToFloat;
use Database\Factories\MoneyFactory;

class Money extends Model
{
    use HasFactory, FormattedTimestamps;
    
    protected $casts = [
        'value' => IntToFloat::class,
    ];
    
    protected $fillable = [
        'value',
        'currency'
    ];
    
    public function calculate_percentage(Percentage $percentage) {
        
        $value = round($this->value * ($percentage->value/100),2);
        
        return MoneyFactory::createMoney($value, $this->currency);
    }
    
    public function sum_up_money(Money $money) {
        
        if($this->currency !== $money->currency){
            throw new BadRequestHttpException("An error occured. Please try again later.");
        }
        
        $value = round($this->value + $money->value, 2);
        
        return MoneyFactory::createMoney($value, $this->currency);
    }
}
