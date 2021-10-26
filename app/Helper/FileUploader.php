<?php

namespace App\Helper;

use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class FileUploader
{
    public static function uploadImage($request)
    {
        $imageFile = $request->file('organisation.logo');

        $extensions = ['jpeg', 'png', 'jpg', 'gif', 'svg'];
        self::validateFiles($request, $imageFile, $extensions, 'organisation.logo');

        $uploadFolder = 'images';

        $image_uploaded_path = $imageFile->store($uploadFolder, 'public');

        $image_array = array(
            "image_name" => basename($image_uploaded_path),
            "image_url" => Storage::disk('public')->url($image_uploaded_path),
            "mime" => $imageFile->getClientMimeType()
        );

        return Image::create($image_array);
    }

    private static function validateFiles($request, $file, $extensions, $type)
    {
        $validator = Validator::make($request->all(), [
            $type => "required"
        ]);

        if ($validator->fails()) {
            throw new BadRequestHttpException($validator->messages(), null, 400);
        }

        if (!in_array($file->getClientOriginalExtension(), $extensions)) {
            throw new BadRequestHttpException($validator->messages(), null, 400);
        }
    }
}
