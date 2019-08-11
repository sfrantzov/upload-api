<?php
/**
 * Created by PhpStorm.
 * User: stoyan
 * Date: 8/9/19
 * Time: 12:18 AM
 */

namespace App\Interfaces;

/**
 * Interface FileStorageInterface
 * @package App\Interfaces
 */
interface FileStorageInterface
{
    /**
     * @param $storageFile
     * @param $inputFile
     * @return string
     */
    public function write($storageFile, $inputFile);

    /**
     * @param $fileName
     * @return string
     */
    public function read($fileName);
}