<?php

namespace App\Model;

use App\Exceptions\FileException;
use App\Factory\FileStorageFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Ramsey\Uuid\Uuid;

class File extends Model
{
    const DOWNLOAD_URL = 'file/';

    protected $table = 'file';

    protected $fillable = ['storage_id', 'name', 'path', 'mime_type', 'size', 'extention'];

    /**
     * @param $storageId
     * @param $file
     * @return null|string
     * @throws FileException
     */
    public function saveFile($storageId, $file)
    {
        $fileName = $file['fileName'];
        $extension = $this->getExtension($fileName);

        $fileContent = base64_decode($file['fileContent']);
        $filePath = $this->saveTmpFile($fileContent);
        $uploadFile = $this->getStorageFilePath($extension);

        $this->storage_id = $storageId;
        $this->name = $fileName;
        $this->file = $uploadFile;
        $this->mime_type = mime_content_type($filePath);
        $this->size = strlen($fileContent);
        $this->extension = $extension;
        $this->uuid = Uuid::uuid1()->toString();

        if (!$this->validate()) {
            return null;
        }

        if ($this->save()) {
            $storageService = $this->getStorage($storageId);
            $storageService->write($uploadFile, $filePath);
            $this->deleteTmpFile($filePath);
            return env('API_VERSION') . self::DOWNLOAD_URL . $this->uuid;
        }

        throw new FileException('File save failed');

    }


    /**
     * @throws FileException
     */
    public function stream()
    {
        $content = $this->getStorage($this->storage_id)->read($this->file);
        if($content) {
            header('Content-Description: File Transfer');
            header('Content-Type: ' . $this->mime_type);
            header('Content-Disposition: attachment; filename="' . $this->name . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . strlen($content));
            echo $content;

            exit;
        } else {
            throw new FileException('File does not exists');
        }
    }

    /**
     * @param $extension
     * @return string
     * @throws \Exception
     */
    protected function getStorageFilePath($extension)
    {
        return (new \DateTimeImmutable)->format('Y-m-d') . '/'. Uuid::uuid1()->toString() . '.' . $extension;
    }

    /**
     * @param $storageId
     * @return mixed
     * @throws FileException
     */
    protected function getStorage($storageId)
    {
        return (new FileStorageFactory())->createService($storageId);
    }

    /**
     * @param $fileContent
     * @return string
     */
    protected function saveTmpFile($fileContent)
    {
        $filePath = "/tmp/" . str_random(16);
        file_put_contents($filePath, $fileContent);

        return $filePath;

    }

    /**
     * @param $filePath
     */
    protected function deleteTmpFile($filePath)
    {
        unlink($filePath);
    }

    /**
     * @param $fileName
     * @return mixed
     */
    protected function getExtension($fileName)
    {
        $pathInfo = pathinfo($fileName);
        return $pathInfo['extension'];
    }

    /**
     * @return bool
     */
    protected function validate()
    {
        $validExtensions = explode(' ', env('FILE_ALLOWED_TYPES'));
        $validMimeTypes = explode(' ', env('FILE_ALLOWED_MIME_TYPES'));

        if (in_array($this->extension, $validExtensions)
            && in_array($this->mime_type, $validMimeTypes)
        ) {
            return true;
        }

        return false;
    }
}
