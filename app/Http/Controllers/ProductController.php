<?php

namespace App\Http\Controllers;

use App\DataTransformer\Product\ProductStoreDataTransformer;
use App\DataTransformer\Product\ProductUpdateDataTransformer;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Resources\CollectionResource;
use App\Http\Resources\Product\ProductResource;
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
        return new CollectionResource(Product::all());
    }

    public function show(int $id)
    {
        return new ProductResource(Product::find($id));
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
