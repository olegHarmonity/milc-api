<?php
namespace App\Http\Controllers\Product;

use App\DataTransformer\Product\CreateRightsInfoDataTransformer;
use App\Http\Controllers\Controller;
use App\Models\RightsInformation;
use App\Http\Requests\Product\CreateRightsInfoRequest;
use App\Http\Resources\Resource;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\CollectionResource;
use Throwable;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class RightsInfoController extends Controller
{

    public function show($id)
    {
        $rightsInfo = RightsInformation::findOrFail($id);

        $rightsInfoResource = new Resource($rightsInfo);

        $availableRights = $rightsInfo->available_rights;

        $availableRightsArray = [];
        foreach ($availableRights as $availableRight) {
            $availableRightsArray[] = new Resource($availableRight);
        }

        $rightsInfoResource['available_rights'] = $availableRightsArray;

        return $rightsInfoResource;
    }

    public function store(CreateRightsInfoRequest $request)
    {
        try {
            $arrayRequest = $request->validated();

            $product = Product::findOrFail($arrayRequest['product_id']);

            Gate::authorize('update', $product);

            $product = CreateRightsInfoDataTransformer::transformData($arrayRequest, $product);

            return (new ProductResource($product))->response()->setStatusCode(Response::HTTP_CREATED);
        } catch (Throwable $e) {
            DB::rollback();
            throw new BadRequestHttpException($e->getMessage());
        }
    }
}

