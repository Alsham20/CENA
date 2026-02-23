<?php

namespace App\Services;

use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class FileService
{
    public static function uploadFile($file, $path)
    {

        $thumbnailPath = 'public/'."{$path}/thumbnail";
        if (! Storage::exists($thumbnailPath)) {
            Storage::makeDirectory($thumbnailPath);
        }

        $filename = $file->hashName();
        $file->storeAs('public/'.$path, $filename);

        //resize if  more than 1200px
        $image = ImageManager::gd()->read(Storage::path('public/'.$path.'/'.$filename));
        if ($image->width() > 1200) {
            $image->scaleDown(1200);
            $image->save(Storage::path('public/'.$path.'/'.$filename));
        }

        // create new image instance
        $image = ImageManager::gd()->read(Storage::path('public/'.$path.'/'.$filename));

        // resize to 300 x 200 pixel
        $image->resize(150, 150);

        // save thumbnail
        $image->save(Storage::path($thumbnailPath.'/'.$filename));

        $media = Media::create([
            'name' => $filename,
            'path' => '/'.$path,
            'type' => $file->extension(),
            'base_url' => asset('storage/'),
            'thumbnail' => 'thumbnail/'.$filename,
            'size' => $file->getSize(),
            'author_id' => auth()->user()->id,

        ]);

        return $media;
    }

    public static function uploadOtherFile($file, $path)
    {
        $filename = $file->hashName();
        $file->storeAs('public/'.$path, $filename);

        return [
            'name' => $filename,
            'path' => '/'.$path,
            'type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'extension' => $file->getClientOriginalExtension(),
            'base_url' => asset('storage/app/public'),
            'author_id' => auth()->user()->id,
        ];

    }
}
