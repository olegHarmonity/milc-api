<?php
namespace App\Helper;

use App\Models\Contract;
use Locale;

class ContractVariableFiller
{
    public static function handleVariablePopulation(string $contractText, Contract $contract, $is_empty = false)
    {
        $seller = $contract->seller()->first();
        
        if($is_empty){
            $variables = [
                'seller.company_name' => $seller->organisation_name,
                'seller.country' => Locale::getDisplayRegion('-' . $seller->country, 'en'),
                'seller.post_code' => $seller->postal_code,
                'seller.address' => $seller->address,
                'seller.email' => $seller->email
            ];
            
            return self::fillVariables($variables, $contractText);
        }
        
        $buyer = $contract->buyer()->first();
        $rightsBundle = $contract->rights_bundle()->first();
        $product = $rightsBundle->product()->first();

        $languages = $product->dubbing_languages;
        $languages = array_unique(array_merge($languages, $product->subtitle_languages));
        $languages = implode(',', $languages);

        $territories = $rights = $startDate = $endDate = $newTerritories = $available_rights = [];
        foreach ($rightsBundle->bundle_rights_information()->get() as $rightsInfo) {
            foreach ($rightsInfo->territories as $item) {
                foreach ($item as $territory) {
                    $newTerritories[] = $territory;
                }
            }
            foreach ($rightsInfo->available_rights as $available_right) {
                $available_rights[] = $available_right->name;
            }
            $territories = array_unique(array_merge($territories, $newTerritories));
            $rights = array_unique(array_merge($rights, $available_rights));
            $startDate = array_unique(array_merge($startDate, [
                $rightsInfo->available_from_date
            ]));
            $endDate = array_unique(array_merge($endDate, [
                $rightsInfo->expiry_date
            ]));
        }

        $territories = implode(',', $territories);
        $rights = implode(',', $rights);
        $startDate = implode('/', $startDate);
        $endDate = implode('/', $endDate);

        $variables = [
            'created_at' => date('F jS Y', strtotime($contract->created_at)),
            'seller.company_name' => $seller->organisation_name,
            'buyer.company_name' => $buyer->organisation_name,
            'seller.country' => Locale::getDisplayRegion('-' . $seller->country, 'en'),
            'buyer.country' => Locale::getDisplayRegion('-' . $buyer->country, 'en'),
            'languages' => $languages,
            'territories' => $territories,
            'rights' => $rights,
            'licence_start_date' => $startDate,
            'licence_duration_years' => $endDate,
            'seller.post_code' => $seller->postal_code,
            'seller.address' => $seller->address,
            'seller.email' => $seller->email
        ];

        return self::fillVariables($variables, $contractText);
    }

    public static function fillVariables(array $variables, string $contractText)
    {
        foreach ($variables as $variable => $value) {
            $variable = str_replace('_', '\_', $variable);
            $contractText = str_replace("<%" . $variable . "%>", $value, $contractText);
        }

        return $contractText;
    }
}

