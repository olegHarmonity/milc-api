<?php

namespace Database\Factories;

use App\Models\Contract;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Helper\ContractVariableFiller;

class ContractFactory extends Factory
{
    protected $model = Contract::class;

    public function definition()
    {
        return [
            'contract_text' => File::get(Storage::disk('local')->path('contracts/default_contract.md')),
            'is_default' => true,
        ];
    }
    
    public static function createFromOrder(Order $order) {
        
        $defaultContract = Contract::where('is_default',true)->first();
        
        $contract = new Contract();
        
        $contract->order_id = $order->id;
        $contract->seller_id = $order->organisation->id;
        $contract->buyer_id = $order->buyer_user->organisation->id;
        $contract->rights_bundle_id = $order->rights_bundle_id;
        $contract->contract_text = "";
        $contract->save();
        
        $contract->contract_text = ContractVariableFiller::handleVariablePopulation($defaultContract->contract_text, $contract);
        
        $contract->save();
        
        return $contract;
    }
}
