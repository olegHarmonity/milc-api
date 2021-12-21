<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Percentage;
use App\Models\VatRule;
use App\Util\VatRuleNames;

class VatRuleSeeder extends Seeder
{
    public function run()
    {
        $ruleTypes = VatRuleNames::getRules();
        for ($i = 1; $i <= 4; $i ++) {
            for ($j = 0; $j < 3; $j ++) {
                $vat = Percentage::factory()->create();
                VatRule::factory()->create([
                    'organisation_id' => $i,
                    'rule_type' => $ruleTypes[$j],
                    'country' => array_random(['DE','AU','GB','HR','US']),
                    'vat_id' => $vat->id
                ]);
            }
        }
    }
}
