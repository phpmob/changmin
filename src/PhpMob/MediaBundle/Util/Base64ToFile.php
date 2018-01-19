<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpMob\MediaBundle\Util;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class Base64ToFile
{
    /**
     * @param string $base64String
     *
     * @return \SplFileInfo
     */
    public static function createFileInfo(string $base64String): \SplFileInfo
    {
        preg_match('/data:(.*);/', $base64String, $matchMime);
        preg_match('/data:image\/(.*);base64/', $base64String, $matchExt);

        $fileName = sprintf('/%s.%s', uniqid(), $matchExt[1]);
        $outputFile = sys_get_temp_dir() . $fileName;
        $fileResource = fopen($outputFile, 'wb');
        $base64Data = explode(',', $base64String);

        fwrite($fileResource, base64_decode($base64Data[1]));
        fclose($fileResource);

        return new \SplFileInfo($outputFile);
    }

    /**
     * @param string $base64String
     *
     * @return UploadedFile
     */
    public static function createUploadedFile(string $base64String): UploadedFile
    {
        $file = self::createFileInfo($base64String);

        return new UploadedFile(
            $file->getRealPath(), $file->getFilename(), mime_content_type($file->getRealPath())
        );
    }
}
