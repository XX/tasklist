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
            $fileName = $_FILES['file']['name'];

            $pathInfo = self::getPathInfo($fileName);
            $type = $pathInfo['ext'];
            $shortName = $pathInfo['name'];

            $lowerType = strtolower($type);
            if ($lowerType === "jpg" || $lowerType === "jpeg" || $lowerType === "png" || $lowerType === "gif") {
                static::scaleImage($tmpPath, $imageWidth, $imageHeight);
                $targetName = $fileName;
                $targetPath = $uploadDir . $targetName;
                $count = 1;
                while (file_exists($targetPath)) {
                    if (static::compareFiles($tmpPath, $targetPath)) {
                        return $targetName;
                    }
                    $targetName = "$shortName-$count.$type";
                    $targetPath = $uploadDir . $targetName;
                    $count++;
                }

                if (move_uploaded_file($tmpPath, $targetPath)) {
                    return $targetName;
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

    public static function getPathInfo($path)
    {
        $info = [
            'file' => '',
            'name' => '',
            'ext' => ''
        ];

        $file = $path;
        $separatorPos = strrpos($path, '/');
        if ($separatorPos !== false) {
            $file = substr($path, $separatorPos + 1);
        }

        if ($file !== false) {
            $info['file'] = $file;

            $name = $file;
            $dotPos = strrpos($file, '.');
            if ($dotPos !== false) {
                $name = substr($file, 0, $dotPos);
                $ext = substr($file, $dotPos + 1);
                if ($ext !== false) {
                    $info['ext'] = $ext;
                }
            }
            $info['name'] = $name;
        }

        return $info;
    }
}