<?php
namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\RightsBundle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Product\CreateRightsBundleRequest;
use App\Http\Resources\Resource;
use App\DataTransformer\Product\CreateRightsBundlesDataTransformer;
use App\Http\Resources\Product\ProductResource;
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
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * Display the specified resource.
     *
     * @param \App\Models\RightsBundle $rightsBundle
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\RightsBundle $rightsBundle
     * @return \Illuminate\Http\Response
     */
    public function edit(RightsBundle $rightsBundle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\RightsBundle $rightsBundle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RightsBundle $rightsBundle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\RightsBundle $rightsBundle
     * @return \Illuminate\Http\Response
     */
    public function destroy(RightsBundle $rightsBundle)
    {
        //
    }
}
