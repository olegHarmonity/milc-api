<?php

namespace App\Http\Controllers;

use App\Helper\FileUploader;
use App\Http\Requests\Core\CreateAudioRequest;
use App\Http\Resources\CollectionResource;
use App\Http\Resources\Resource;
use App\Models\Audio;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class AudioController extends Controller
{
    public function index()
    {
        return new  CollectionResource(Audio::all());
    }

    public function show(int $id)
    {
        return new Resource(Audio::findOrFail($id));
    }

    public function store(CreateAudioRequest $request)
    {
        Gate::authorize('create', Audio::class);

        if ($request->file('audio')) {
            $audio = FileUploader::uploadFile($request, 'audio');

            return (new Resource($audio))
                ->response()
                ->setStatusCode(Response::HTTP_CREATED);
        }

        throw new BadRequestHttpException("Audio must be a file!", null, 400);
    }


    public function destroy(Audio $audio)
    {
        Gate::authorize('delete', $audio);

        $audio->delete();

        return response("Audio successfully deleted!", Response::HTTP_NO_CONTENT);
    }
}
