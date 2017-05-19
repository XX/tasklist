<?php

namespace util;

use Application;

class FileHelper
{
    public static function uploadAndGetImageFile($uploadDir = null)
    {
        if (!isset($_FILES['file'])) {
            return null;
        }

        if (empty($uploadDir)) {
            $uploadDir = Application::$config['uploadDir'];
        }
        $imageWidth = Application::$config['image']['width'];
        $imageHeight = Application::$config['image']['height'];

        if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
            $tmpPath = $_FILES['file']['tmp_name'];
            $name = $_FILES['file']['name'];

            $pathInfo = pathinfo($name);
            $type = $pathInfo['extension'];
            $shortName = $pathInfo['filename'];

            $lowerType = strtolower($type);
            if ($lowerType === "jpg" || $lowerType === "jpeg" || $lowerType === "png" || $lowerType === "gif") {
                static::scaleImage($tmpPath, $imageWidth, $imageHeight);
                $targetPath = $uploadDir . $name;
                $count = 1;
                while (file_exists($targetPath)) {
                    if (static::compareFiles($tmpPath, $targetPath)) {
                        return $targetPath;
                    }
                    $targetPath = $uploadDir . "$shortName-$count.$type";
                    $count++;
                }

                if (move_uploaded_file($tmpPath, $targetPath)) {
                    return $targetPath;
                }
            }
        }
        return null;
    }

    public static function compareFiles($pathFileA, $pathFileB)
    {
        return filesize($pathFileA) === filesize($pathFileB)
            && md5_file($pathFileA) === md5_file($pathFileB);
    }

    public static function scaleImage($imagePath, $width, $height) {
        $imagick = new \Imagick(realpath($imagePath));
        $imagick->scaleImage($width, $height, true);
        $imagick->writeImage($imagePath);
    }
}