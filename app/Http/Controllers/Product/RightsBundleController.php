<?php
namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\RightsBundle;
use App\Helper\SearchFormatter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Product\CreateRightsBundleRequest;
use App\Http\Requests\Product\UpdateRightsBundleRequest;
use App\Http\Resources\Resource;
use App\DataTransformer\Product\CreateRightsBundlesDataTransformer;
use App\DataTransformer\Product\UpdateRightsBundlesDataTransformer;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\CollectionResource;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Illuminate\Support\Facades\DB;
use Throwable;

class RightsBundleController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rightsBundle = SearchFormatter::getSearchQueries($request, RightsBundle::class);

        $rightsBundle = $rightsBundle->paginate($request->input('per_page'));

        return CollectionResource::make($rightsBundle);
    }

    public function show(RightsBundle $rightsBundle)
    {
        return new CollectionResource($rightsBundle);
    }

    public function store(CreateRightsBundleRequest $request)
    {
        try {
            
            $arrayRequest = $request->validated();

            $product = Product::findOrFail($arrayRequest['product_id']);

            Gate::authorize('update', $product);

            $product = CreateRightsBundlesDataTransformer::transformData($arrayRequest, $product);

            return (new ProductResource($product))->response()->setStatusCode(Response::HTTP_CREATED);
        } catch (Throwable $e) {
            DB::rollback();
            throw new BadRequestHttpException($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\RightsBundle $rightsBundle
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRightsBundleRequest $request, RightsBundle $rightsBundle)
    {
        try {
            
            $arrayRequest = $request->validated();

            $product = Product::findOrFail($rightsBundle->product_id);

            Gate::authorize('update', $product);

            $product = UpdateRightsBundlesDataTransformer::transformData($arrayRequest, $rightsBundle);

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
    public function destroy(RightsBundle $rightsBundle)
    {
        $product = Product::findOrFail($rightsBundle->product_id);
        Gate::authorize('delete', $product);

        $product->rights_bundles()->detach($rightsBundle->id);
        $product->save();

        $rightsBundle->delete();

        return response()->json([
            'message' => 'Bundle deleted!'
        ]);
    }
}
