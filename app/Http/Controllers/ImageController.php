<?php

namespace App\Http\Controllers;

use App\Helper\FileUploader;
use App\Http\Requests\Core\CreateImageRequest;
use App\Http\Resources\ImageResource;
use App\Http\Resources\Resource;
use App\Models\Image;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use \Gate;

class ImageController extends Controller
{
    public function index()
    {
        return new  ImageResource(Image::all());
    }

    public function show(int $id)
    {
        return new ImageResource(Image::findOrFail($id));
    }

    public function store(CreateImageRequest $request)
    {
        Gate::authorize('create', Image::class);

        if ($request->file('image')) {
            $image = FileUploader::uploadFile($request, 'image');

            return (new Resource($image))
                ->response()
                ->setStatusCode(Response::HTTP_CREATED);
        }

        throw new BadRequestHttpException("Image must be a file!", null, 400);
    }

    public function destroy(Image $image)
    {
        Gate::authorize('delete', $image);

        $image->delete();

        return response("Image successfully deleted!", Response::HTTP_NO_CONTENT);
    }
}
