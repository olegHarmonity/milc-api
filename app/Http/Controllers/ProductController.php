<?php

namespace App\Http\Controllers;

use App\DataTransformer\Product\ProductStoreDataTransformer;
use App\DataTransformer\Product\ProductUpdateDataTransformer;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Resources\CollectionResource;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Product\ProductResourceV2;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Throwable;
use \Gate;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::query()->with('content_type', 'genres', 'available_formats')->get();

        return ProductResourceV2::collection($products);
    }

    public function show(Product $product)
    {
        $product->load(
            'available_formats',
            'genres',
            'dub_files',
            'subtitles',
            'promotional_videos',
            'rights_information',
            'rights_information.available_rights',
            'content_type',
            'production_info',
            'production_info.directors',
            'production_info.producers',
            'production_info.writers',
            'production_info.cast',
            'marketing_assets',
            'marketing_assets.key_artwork',
            'marketing_assets.production_images',
            'movie',
            'screener',
            'trailer'
        );

        return new ProductResourceV2($product);
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
}
