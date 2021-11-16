<?php

namespace App\Http\Controllers;

use App\DataTransformer\Product\ProductStoreDataTransformer;
use App\DataTransformer\Product\ProductUpdateDataTransformer;
use App\Helper\SearchFormatter;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Resources\CollectionResource;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Throwable;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        return new CollectionResource(SearchFormatter::getSearchResults($request, Product::class));
        
        /*$products = Product::query()->with(
            'content_type:id,name',
            'genres:id,name',
            'available_formats:id,name',
            'marketing_assets:id,key_artwork_id',
            'marketing_assets.key_artwork:id,image_name,image_url'
        );

        if ($oid = $request->input('organisation_id')) {
            $products->where('organisation_id', $oid);
        }

        $products = $products->get([
            'id', 'title', 'synopsis', 'runtime', 'content_type_id', 'marketing_assets_id'
        ]);

        return CollectionResource::make($products);*/
    }

    public function show(int $id)
    {
        return new ProductResource(Product::findOrFail($id));
    }

    public function store(CreateProductRequest $request)
    {
        Gate::authorize('create', Product::class);

        try {
            $user = auth()->user();
            $organisation = $user->organisation()->first();

            $product = ProductStoreDataTransformer::transformData($request->all(), $organisation);

            return (new ProductResource($product))
                ->response()
                ->setStatusCode(Response::HTTP_CREATED);
        } catch (Throwable $e) {
            DB::rollback();
            throw new BadRequestHttpException($e->getMessage());
        }
    }

    public function update(CreateProductRequest $request, Product $product)
    {
        Gate::authorize('update', $product);

        try {
            $product = ProductUpdateDataTransformer::transformData($request->all(), $product);

            return (new ProductResource($product))
                ->response()
                ->setStatusCode(Response::HTTP_OK);
        } catch (Throwable $e) {
            DB::rollback();
            throw new BadRequestHttpException($e->getMessage());
        }
    }

    public function destroy(Product $product)
    {
        // TODO: Add gate
        // TODO: Delete also all relations and all associated files of the product (in observer?)

        $product->delete();

        return response()->json([
            'message' => 'Product deleted!'
        ]);
    }
}
