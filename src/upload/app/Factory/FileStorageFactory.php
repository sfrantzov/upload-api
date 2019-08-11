<?php
/**
 * Created by PhpStorm.
 * User: stoyan
 * Date: 8/9/19
 * Time: 12:15 AM
 */

namespace App\Factory;

use App\Exceptions\FileException;

/**
 * Class FileStorageFactory
 * @package App\Factory
 */
class FileStorageFactory
{
    /**
     * @var array
     */
    protected $storage = [
        '1' => \App\Model\LocalFileStorage::class
    ];


    /**
     * @param $storageId
     * @return mixed
     * @throws FileException
     */
    public function createService($storageId)
    {
        if (!isset($this->storage[$storageId])) {
            throw new FileException('Invalid factory for storage id ' . $storageId);
        }

        $className = $this->storage[$storageId];

        return new $className();
    }
}
