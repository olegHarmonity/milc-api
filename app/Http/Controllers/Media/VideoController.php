<?php

namespace App\Http\Controllers\Media;

use App\Helper\FileUploader;
use App\Http\Controllers\Controller;
use App\Http\Requests\Core\CreateVideoRequest;
use App\Http\Resources\CollectionResource;
use App\Http\Resources\Resource;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class VideoController extends Controller
{
    public function index()
    {
        return new  CollectionResource(Video::all());
    }

    public function show(int $id)
    {
        return new Resource(Video::findOrFail($id));
    }

    public function store(CreateVideoRequest $request)
    {
        Gate::authorize('create', Video::class);

        if ($request->file('video')) {
            $video = FileUploader::uploadFile($request, 'video');

            return (new Resource($video))
                ->response()
                ->setStatusCode(Response::HTTP_CREATED);
        }

        throw new BadRequestHttpException("Video must be a file!", null, 400);
    }

    public function destroy(Video $video)
    {
        Gate::authorize('delete', $video);

        $video->delete();

        return response("Video successfully deleted!", Response::HTTP_NO_CONTENT);
    }
}
