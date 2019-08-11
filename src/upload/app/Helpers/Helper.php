<?php
/**
 * Created by PhpStorm.
 * User: stoyan
 * Date: 8/10/19
 * Time: 2:07 PM
 */
namespace App\Helpers;

class Helper
{
    static function fileUploadMaxSize() {
        static $max_size = -1;

        if ($max_size < 0) {
            $max_size = Helper::postMaxSize();

            // If upload_max_size is less, then reduce. Except if upload_max_size is
            // zero, which indicates no limit.
            $upload_max = Helper::parseSize(ini_get('upload_max_filesize'));
            if ($upload_max > 0 && $upload_max < $max_size) {
                $max_size = $upload_max;
            }
        }
        return $max_size;
    }

    static function postMaxSize() {
        static $max_size = -1;

        if ($max_size < 0) {
            $post_max_size = Helper::parseSize(ini_get('post_max_size'));
            if ($post_max_size > 0) {
                $max_size = $post_max_size;
            }
        }
        return $max_size;
    }

    static function parseSize($size) {
        $unit = preg_replace('/[^bkmgtpezy]/i', '', $size);

        // Remove the non-unit characters from the size.
        $size = preg_replace('/[^0-9\\.]/', '', $size);

        // Remove the non-numeric characters from the size.
        if ($unit) {

            // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
            return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
        }
        else {
            return round($size);
        }
    }

}