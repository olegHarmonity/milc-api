<?php
namespace App\Helper;

use App\Models\User;

class RequiredDataChecker
{

    public static function checkIfCanAddProduct(User $user)
    {
        $canAddProduct = true;
        $message = null;

        $organisation = $user->organisation;

        if (count($organisation->vat_rules()->get()) === 0) {
            $canAddProduct = false;
            $message = "Please fill in the VAT";
        }

        if (! $organisation->iban or ! $organisation->swift_bic or ! $organisation->bank_name) {
            $canAddProduct = false;
            if (! $message) {
                $message = "Please fill in the banking";
            } else {
                $message = $message . " and banking";
            }
        }
        
        if ($message) {
            $message = $message . " section under your organisation settings.";
        }
        
        return [
            'success' => $canAddProduct,
            'message' => $message
        ];
    }

    public static function checkIfCanBuyProduct(User $user)
    {
        $canBuyProduct = true;
        $message = null;

        $organisation = $user->organisation;
        $organisationOwner = $organisation->organisation_owner()->first();

        if (! $organisation->email or 
            ! $organisation->phone_number or 
            ! $organisation->address or 
            ! $organisation->postal_code or 
            ! $organisation->city or 
            ! $organisation->country or 
            ! $organisation->registration_number) {
            $canBuyProduct = false;
            $message = "Please fill in the address";
        }

        if (! $organisation->iban or ! $organisation->swift_bic or ! $organisation->bank_name) {
            $canBuyProduct = false;
            if (! $message) {
                $message = "Please fill in the banking";
            } else {
                $message = $message . " and banking";
            }
        }

        if ($message) {
            $message = $message . " section under your organisation settings";
        }
        
        if (! $organisationOwner->address or ! $organisationOwner->postal_code or ! $organisationOwner->city) {
            $canBuyProduct = false;
            if (! $message) {
                $message = "Please fill in the address section under your user settings";
            } else {
                $message = $message . " and the address section under your user settings";
            }
        }

        if ($message) {
            $message = $message . ".";
        } 
        return [
            'success' => $canBuyProduct,
            'message' => $message
        ];
    }
}

