<?php
namespace App\Services;

class ArticleService {
    public function handleUploadedImage($file, $name, $type) {
        $typeFile = explode('/', $file->getMimeType());
        $extensionFile = $typeFile[1];
        $newFileName = $name . '_' . time() . '.' . $extensionFile;
        $path = $file->storeAs('public/'.$type, $newFileName);
        return $path;
    }
}
