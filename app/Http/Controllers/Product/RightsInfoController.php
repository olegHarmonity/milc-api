<?php
namespace App\Http\Controllers\Product;

use App\DataTransformer\Product\CreateRightsInfoDataTransformer;
use App\DataTransformer\Product\UpdateRightsInfoDataTransformer;
use App\Http\Controllers\Controller;
use App\Models\RightsInformation;
use App\Http\Requests\Product\CreateRightsInfoRequest;
use App\Http\Requests\Product\UpdateRightsInfoRequest;
use App\Http\Resources\Resource;
use App\Helper\SearchFormatter;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\CollectionResource;
use Throwable;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class RightsInfoController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rightsBundle = SearchFormatter::getSearchQueries($request, RightsInformation::class);

        $rightsBundle = $rightsBundle->paginate($request->input('per_page'));

        return CollectionResource::make($rightsBundle);
    }

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

    public function update(UpdateRightsInfoRequest $request,RightsInformation $rightsInfo)
    {
        try {
            
            $arrayRequest = $request->validated();

            $product = Product::findOrFail($rightsInfo->product_id);

            Gate::authorize('update', $product);

            $product = UpdateRightsInfoDataTransformer::transformData($arrayRequest, $rightsInfo);

            return (new ProductResource($product))->response()->setStatusCode(Response::HTTP_CREATED);
        } catch (Throwable $e) {
            DB::rollback();
            throw new BadRequestHttpException($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\RightsBundle $rightsBundle
     * @return \Illuminate\Http\Response
     */
    public function destroy(RightsInformation $rightsInfo)
    {

        $product = Product::findOrFail($rightsInfo->product_id);
        Gate::authorize('delete', $product);

        $product->rights_information()->detach($rightsInfo->id);
        $product->save();
        
        $rightsInfo->available_rights()->detach();

        $rightsInfo->delete();

        return response()->json([
            'message' => 'Information deleted!'
        ]);
    }
}

