<?php

namespace App\Http\Controllers;

use App\Helper\FileUploader;
use App\Http\Requests\Core\CreateFileRequest;
use App\Http\Resources\CollectionResource;
use App\Http\Resources\Resource;
use App\Models\File;
use Illuminate\Http\Request;
use \Gate;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class FileController extends Controller
{
    public function index()
    {
        return new  CollectionResource(File::all());
    }

    public function show(int $id)
    {
        return new Resource(File::findOrFail($id));
    }


    public function store(CreateFileRequest $request)
    {
        Gate::authorize('create', File::class);

        if ($request->file('file')) {
            $file = FileUploader::uploadFile($request, 'file');

            return (new Resource($file))
                ->response()
                ->setStatusCode(Response::HTTP_CREATED);
        }

        throw new BadRequestHttpException("File must be a file!", null, 400);
    }

    public function destroy(File $file)
    {
        Gate::authorize('delete', $file);

        $file->delete();

        return response("File successfully deleted!", Response::HTTP_NO_CONTENT);
    }
}
