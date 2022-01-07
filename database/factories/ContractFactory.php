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
            'contract_text_part_2' => File::get(Storage::disk('local')->path('contracts/default_contract_part_2.md')),
            'is_default' => true
        ];
    }

    public static function createFromOrder(Order $order)
    {
        
        $sellerId = $order->seller_id;
        $defaultContract = Contract::where([
            [
                'seller_id',
                '=',
                $sellerId
            ],
            [
                'buyer_id',
                '=',
                null
            ],
            [
                'order_id',
                '=',
                null
            ]
        ])->first();

        if (! $defaultContract) {
            $defaultContract = Contract::where('is_default', true)->first();
        }

        $contract = new Contract();
        
        $contract->order_id = $order->id;
        $contract->seller_id = $sellerId;
        $contract->buyer_id = auth()->user()->organisation->id;
        $contract->rights_bundle_id = $order->rights_bundle_id;
        $contract->contract_text = "";
        $contract->contract_text_part_2 = "";
        $contract->contract_appendix = "";
        $contract->save();

        $contract->contract_text = ContractVariableFiller::handleVariablePopulation($defaultContract->contract_text, $contract);

        $contract->contract_text_part_2 = ContractVariableFiller::handleVariablePopulation($defaultContract->contract_text_part_2, $contract);

        $contract->save();

        return $contract;
    }

    public static function createOrganisationDefault($organisationId)
    {
        $defaultContract = Contract::where('is_default', true)->first();

        $contract = new Contract();
        
        $contract->is_default = true;
        $contract->seller_id = $organisationId;
        $contract->contract_text = "";
        $contract->contract_text_part_2 = "";
        $contract->contract_appendix = "";
        $contract->save();

        $contract->contract_text = ContractVariableFiller::handleVariablePopulation($defaultContract->contract_text, $contract, true);

        $contract->contract_text_part_2 = ContractVariableFiller::handleVariablePopulation($defaultContract->contract_text_part_2, $contract, true);

        $contract->save();

        return $contract;
    }
}
