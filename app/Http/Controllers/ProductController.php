<?php

namespace App\Http\Controllers;

use App\Helper\FileUploader;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\User\RegisterUserRequest;
use App\Http\Resources\CollectionResource;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Resource;
use App\Http\Resources\User\RegisterResource;
use App\Models\MarketingAssets;
use App\Models\MovieFormat;
use App\Models\Organisation;
use App\Models\Person;
use App\Models\Product;
use App\Models\ProductionInfo;
use App\Models\RightsInformation;
use App\Models\User;
use App\Util\UserRoles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Throwable;

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
        try {
            $user = auth()->user();
            $organisation = $user->organisation()->first();

            DB::beginTransaction();
            $arrayRequest = $request->all();

            if(isset($arrayRequest['available_formats'])) {
                $availableFormatsRequest = $arrayRequest['available_formats'];
                unset($arrayRequest['available_formats']);
            }

            $productionInfoRequest = $arrayRequest['production_info'];

            if(isset($productionInfoRequest['directors'])) {
                $directorsRequest = $productionInfoRequest['directors'];
                unset($productionInfoRequest['directors']);
            }
            if(isset($productionInfoRequest['producers'])) {
                $producersRequest = $productionInfoRequest['producers'];
                unset($productionInfoRequest['producers']);
            }
            if(isset($productionInfoRequest['writers'])) {
                $writersRequest = $productionInfoRequest['writers'];
                unset($productionInfoRequest['writers']);
            }
            if(isset($productionInfoRequest['cast'])) {
                $castRequest = $productionInfoRequest['cast'];
                unset($productionInfoRequest['cast']);
            }

            unset($arrayRequest['production_info']);

            $marketingAssetsRequest = $arrayRequest['marketing_assets'];
            unset($arrayRequest['marketing_assets']);

            $rightsInformationRequest = $arrayRequest['rights_information'];
            unset($arrayRequest['rights_information']);

            $productRequest = $arrayRequest;

            $productionInfo = ProductionInfo::create($productionInfoRequest);
            $productRequest['production_info_id'] = $productionInfo->id;

            if(isset($directorsRequest)){
                foreach ($directorsRequest as $directorRequest) {
                    $director = Person::create($directorRequest);
                    $productionInfo->directors()->attach($director->id);
                }
            }

            if(isset($producersRequest)){
                foreach ($producersRequest as $producerRequest) {
                    $producer = Person::create($producerRequest);
                    $productionInfo->producers()->attach($producer->id);
                }
            }

            if(isset($writersRequest)){
                foreach ($writersRequest as $writerRequest) {
                    $writer = Person::create($writerRequest);
                    $productionInfo->writers()->attach($writer->id);
                }
            }

            if(isset($castRequest)){
                foreach ($castRequest as $castRequestItem) {
                    $cast = Person::create($castRequestItem);
                    $productionInfo->cast()->attach($cast->id);
                }
            }

            $marketingAssets = MarketingAssets::create($marketingAssetsRequest);
            $productRequest['marketing_assets_id'] = $marketingAssets->id;

            $rightsInformationArray = [];
            foreach ($rightsInformationRequest as $rightsInformationRequestItem) {

                if(isset($rightsInformationRequestItem['available_rights'])) {
                    $availableRightsRequest = $rightsInformationRequestItem['available_rights'];
                    unset($rightsInformationRequestItem['available_rights']);
                }

                $rightsInformation = RightsInformation::create($rightsInformationRequestItem);

                if(isset($availableRightsRequest)) {
                    foreach ($availableRightsRequest as $availableRightId) {
                        $rightsInformation->available_rights()->attach($availableRightId);
                    }
                }

                $rightsInformationArray[] = $rightsInformation;
            }

            $productRequest['organisation_id'] = $organisation->id;

            $product = Product::create($productRequest);

            foreach ($availableFormatsRequest as $availableFormatId) {
                $product->available_formats()->attach($availableFormatId);
            }

            foreach ($rightsInformationArray as $rightsInformation) {
                $product->rights_information()->attach($rightsInformation->id);
                $rightsInformation->product_id = $product->id;
                $rightsInformation->save();
            }

            $productionInfo->product_id = $product->id;
            $productionInfo->save();

            $marketingAssets->product_id = $product->id;
            $marketingAssets->save();


            DB::commit();

            return (new ProductResource($product))
                ->response()
                ->setStatusCode(Response::HTTP_CREATED);

        } catch (Throwable $e) {
            DB::rollback();
            throw new BadRequestHttpException($e->getMessage());
        }
    }
}
