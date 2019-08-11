<?php
/**
 * Created by PhpStorm.
 * User: stoyan
 * Date: 8/9/19
 * Time: 12:14 AM
 */

namespace App\Model;

use App\Interfaces\FileStorageInterface;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

/**
 * Local file storage
 * Class LocalFileStorage
 * @package App\Model
 */
class LocalFileStorage implements FileStorageInterface
{
    /**
     * @param $storageFile
     * @param $inputFile
     * @return string|void
     */
    public function write($storageFile, $inputFile)
    {
        Storage::disk('local')->put($storageFile, Crypt::encrypt(file_get_contents($inputFile)));
    }

    /**
     * @param $fileName
     * @return mixed|void
     */
    public function read($fileName)
    {
        return Crypt::decrypt(Storage::disk('local')->get($fileName));
    }
}