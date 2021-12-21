<?php
namespace App\Http\Controllers\Order;

use App\Models\Contract;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Helper\SearchFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\UpdateAdminContractRequest;
use App\Http\Requests\Order\UpdateOrganisationContractRequest;
use App\Http\Resources\CollectionResource;
use App\Http\Resources\Resource;
use Database\Factories\ContractFactory;
use Throwable;

class ContractController extends Controller
{

    public function index(Request $request)
    {
        Gate::authorize('viewAny', Contract::class);

        $user = $this->user();
        $contractsQuery = null;
        if (! $user->isAdmin()) {
            $contractsQuery = Contract::where(function ($q) use ($user) {
                $q->where('seller_id', $user->organisation->id)->orWhere('buyer_id', $user->organisation->id);
            });
        }

        $contracts = SearchFormatter::getSearchQueries($request, Contract::class, $contractsQuery);

        $contracts = $contracts->with('seller:id,organisation_name', 'buyer:id,organisation_name', 'rights_bundle:id,product_id', 'rights_bundle.product:id,title', 'order:id,order_number,contract_accepted,contract_accepted_at');

        $contracts = $contracts->select([
            'id',
            'accepted_at',
            'is_default',
            'buyer_id',
            'seller_id',
            'rights_bundle_id',
            'order_id'
        ]);

        $contracts = $contracts->paginate($request->input('per_page'));

        return CollectionResource::make($contracts);
    }

    public function show(Request $request, $id)
    {
        $contract = Contract::findOrFail($id);

        Gate::authorize('view', $contract);

        return (new Resource($contract))->response()->setStatusCode(200);
    }

    public function showCheckoutContract(Request $request, $orderNumber)
    {
        try {
            $order = Order::where('order_number', 'LIKE', $orderNumber)->first();

            Gate::authorize('view', $order);

            $contract = Contract::where('order_id', '=', $order->id)->first();

            if (! $contract) {
                $contract = ContractFactory::createFromOrder($order);
            }

            $order->contract_id = $contract->id;
            $order->save();

            return (new Resource($contract))->response()->setStatusCode(200);
        } catch (Throwable $e) {
            DB::rollback();
            throw new BadRequestHttpException($e->getMessage());
        }
    }

    public function showAdminDefaultContract(Request $request)
    {
        try {
            $defaultContract = Contract::where([
                [
                    'seller_id',
                    '=',
                    null
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
                ],
                [
                    'is_default',
                    '=',
                    true
                ]
            ])->first();

            Gate::authorize('viewAdminDefault', $defaultContract);

            return (new Resource($defaultContract))->response()->setStatusCode(200);
        } catch (Throwable $e) {
            DB::rollback();
            throw new BadRequestHttpException($e->getMessage());
        }
    }

    public function showOrganisationDefaultContract(Request $request)
    {
        try {

            Gate::authorize('viewAny', Contract::class);

            $user = $this->user();

            $defaultContract = Contract::where([
                [
                    'seller_id',
                    '=',
                    $user->organisation_id
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
                ],
                [
                    'is_default',
                    '=',
                    true
                ]
            ])->first();

            if (! $defaultContract) {
                $defaultContract = ContractFactory::createOrganisationDefault($user->organisation_id);
            }

            Gate::authorize('viewOrganisationDefault', $defaultContract);

            return (new Resource($defaultContract))->response()->setStatusCode(200);
        } catch (Throwable $e) {
            DB::rollback();
            throw new BadRequestHttpException($e->getMessage());
        }
    }

    public function updateAdminDefaultContract(UpdateAdminContractRequest $request)
    {
        try {

            $defaultContract = Contract::where([
                [
                    'seller_id',
                    '=',
                    null
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
                ],
                [
                    'is_default',
                    '=',
                    true
                ]
            ])->first();

            Gate::authorize('viewAdminDefault', $defaultContract);

            $defaultContractRequest = $request->validated();

            $defaultContract->update($defaultContractRequest);

            $defaultContract->save();

            return (new Resource($defaultContract))->response()->setStatusCode(200);
        } catch (Throwable $e) {
            DB::rollback();
            throw new BadRequestHttpException($e->getMessage());
        }
    }

    public function updateOrganisationDefaultContract(UpdateOrganisationContractRequest $request)
    {
        try {
            Gate::authorize('viewAny', Contract::class);

            $user = $this->user();

            $defaultContract = Contract::where([
                [
                    'seller_id',
                    '=',
                    $user->organisation_id
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
                ],
                [
                    'is_default',
                    '=',
                    true
                ]
            ])->first();

            if (! $defaultContract) {
                $defaultContract = ContractFactory::createOrganisationDefault($user->organisation_id);
            }

            Gate::authorize('viewOrganisationDefault', $defaultContract);

            $defaultContractRequest = $request->validated();

            $defaultContract->update($defaultContractRequest);

            $defaultContract->save();

            return (new Resource($defaultContract))->response()->setStatusCode(200);
        } catch (Throwable $e) {
            DB::rollback();
            throw new BadRequestHttpException($e->getMessage());
        }
    }
}
