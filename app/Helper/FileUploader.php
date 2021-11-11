<?php

namespace App\Helper;

use App\Models\Audio;
use App\Models\File;
use App\Models\Image;
use App\Models\Video;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class FileUploader
{
    public static function uploadFile($request, $fileType, $field = null)
    {
        $fileTypes = ["file", "video", "image", "audio"];

        if (!in_array($fileType, $fileTypes)) {
            throw new BadRequestHttpException("Attached file must be one of fthe ollowing types: " . implode(",", $fileTypes), null, 400);
        }

        if ($field === null) {
            $field = $fileType;
        }

        $file = $request->file($field);

        self::validateFiles($request, $file, $fileType, $field);

        $uploadFolder = $fileType . 's';

        $image_uploaded_path = $file->store($uploadFolder, 'public');

        $image_array = array(
            $fileType . "_name" => basename($image_uploaded_path),
            $fileType . "_url" => Storage::disk('public')->url($image_uploaded_path),
            "mime" => $file->getClientMimeType()
        );

        switch ($fileType) {
            case 'image':
                return Image::create($image_array);
            case 'audio':
                return Audio::create($image_array);
            case 'video':
                return Video::create($image_array);
            case 'file':
                return File::create($image_array);
        }
    }

    private static function validateFiles($request, $file, $type, $field)
    {

        $extensions = [
            'image' => ['jpeg', 'png', 'jpg', 'gif', 'svg'],
            'video' => ['mp4'],
            'audio' => ['mpga', 'mp3', 'wav', 'audio/mpeg', 'audio/mpeg4-generic', 'audio/mp3', 'audio/mpga',],
            'file' => ['srt', 'txt'],
        ];

        $validator = Validator::make($request->all(), [
            $field => "required"
        ]);

        if ($validator->fails()) {
            throw new BadRequestHttpException($validator->messages(), null, 400);
        }

        if (!in_array($file->getClientOriginalExtension(), $extensions[$type])) {
            throw new BadRequestHttpException($validator->messages(), null, 400);
        }
    }
}
