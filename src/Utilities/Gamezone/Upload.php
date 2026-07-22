<?php

namespace Utilities\Gamezone;

class Upload
{
    public static function saveImage(
        array $file,
        string $directory,
        array $allowedExtensions = ["jpg", "jpeg", "png", "webp"]
    ): ?string {

        if (
            !isset($file["tmp_name"]) ||
            $file["error"] !== UPLOAD_ERR_OK
        ) {
            return null;
        }

        $extension = strtolower(
            pathinfo(
                $file["name"],
                PATHINFO_EXTENSION
            )
        );

        if (!in_array($extension, $allowedExtensions)) {
            return null;
        }

        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        $fileName = uniqid("", true) . "." . $extension;

        $destination = rtrim($directory, "/\\") .
            DIRECTORY_SEPARATOR .
            $fileName;

        if (!move_uploaded_file(
            $file["tmp_name"],
            $destination
        )) {
            return null;
        }

        return $fileName;
    }

    public static function deleteImage(
        string $directory,
        string $fileName
    ): bool {

        $file = rtrim($directory, "/\\") .
            DIRECTORY_SEPARATOR .
            $fileName;

        if (file_exists($file)) {
            return unlink($file);
        }

        return false;
    }
}
