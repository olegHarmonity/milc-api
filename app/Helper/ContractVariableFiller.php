<?php
namespace App\Helper;

use App\Models\Contract;
use Locale;

class ContractVariableFiller
{
    public static function handleVariablePopulation(string $contractText, Contract $contract){
        
        $seller = $contract->seller()->first();
        $buyer = $contract->buyer()->first();

        $variables = [
            'created_at' => date('F jS Y', strtotime($contract->created_at)),
            'seller.company_name' => $seller->organisation_name,
            'buyer.company_name' => $buyer->organisation_name,
            'seller.country' => Locale::getDisplayRegion('-'.$seller->country, 'en'),
            'buyer.country' => Locale::getDisplayRegion('-'.$buyer->country, 'en'),
        ];
        
        return self::fillVariables($variables, $contractText);
    }
    
    public static function fillVariables(array $variables, string $contractText){
        foreach ($variables as $variable => $value){
            $variable = str_replace('_', '\_', $variable);
            $contractText = str_replace("<%".$variable."%>", $value, $contractText);
        }
        
        return  $contractText;
    }
}

