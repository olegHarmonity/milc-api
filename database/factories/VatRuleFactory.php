<?php

namespace Database\Factories;

use App\Models\VatRule;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Util\VatRuleNames;

class VatRuleFactory extends Factory
{
    protected $model = VatRule::class;
    
    public function definition()
    {
        return [
            'rule_type' => VatRuleNames::$DOMESTIC,
            'country' => 'DE',
            'vat_id' => 1,
            'organisation_id' => 1
        ];
    }
}
