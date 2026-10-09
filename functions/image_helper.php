<?php

function uploadUserImage($file)
{
    if (!isset($file) || $file["error"] === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    if ($file["error"] !== UPLOAD_ERR_OK) {
        return false;
    }

    if ($file["size"] > 5 * 1024 * 1024) {
        return false;
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file["tmp_name"]);

    $allowed = [
        "image/jpeg" => "jpg",
        "image/png" => "png",
        "image/webp" => "webp"
    ];

    if (!isset($allowed[$mime])) {
        return false;
    }

    $directory = __DIR__ . "/../uploads/users/";

    if (!is_dir($directory)) {
        mkdir($directory, 0755, true);
    }

    $filename = "user_" . bin2hex(random_bytes(8)) . "." . $allowed[$mime];

    $destination = $directory . $filename;

    if (!move_uploaded_file($file["tmp_name"], $destination)) {
        return false;
    }

    return $filename;
}


function deleteUserImage($filename)
{
    if (!$filename) {
        return;
    }

    $filename = basename($filename);

    $path = __DIR__ . "/../uploads/users/" . $filename;

    if (is_file($path)) {
        unlink($path);
    }
}