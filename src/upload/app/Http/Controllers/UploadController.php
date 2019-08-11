<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Model\File;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\ParameterBag;

class UploadController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function upload(Request $request)
    {
        try {
            $storageId = env('FILE_STORAGE');
            $files = $request->json();

            $this->validateInput($files);

            $uploaded = [];
            foreach ($files as $remoteFile) {
                $file = new File();
                $url = $file->saveFile($storageId, $remoteFile);
                $uploaded[] = [
                    'name' => $remoteFile['fileName'],
                    'url' => !empty($url) ? URL::to($url) : null
                    ];
            }
            return  $this->success('Files uploaded', ['files' => $uploaded]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }

        return $this->error('File storage fail');
    }

    /**
     * @param $uuid
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function download($uuid)
    {
        try {
            $file = File::where('uuid', $uuid)->first();
            if ($file) {
                $file->stream();
                exit;
            }
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }

        return $this->error('Invalid file');
    }

    /**
     * @param string $message
     * @param array $params
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function success($message, array $params = [])
    {
        return response()->json(
            [
                'success' => 1,
                'message' => $message
            ] + $params
        );
    }

    /**
     * @param $error
     * @param array $params
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function error($error, array $params = [])
    {
        return response()->json(
            [
                'success' => 0,
                'message' => $error
            ] + $params
        );
    }

    /**
     * @param ParameterBag $files
     * @throws \Exception
     */
    protected function validateInput(ParameterBag $files) {

        if (!count($files)) {
            throw new \Exception(env('FILE_ERROR_MESSAGE') . ' ' . Helper::fileUploadMaxSize() . ' / ' . Helper::postMaxSize());
        }

        foreach ($files as $remoteFile) {
            if (!isset($remoteFile['fileName'])
                || !isset($remoteFile['fileContent'])) {
                throw new \Exception('Invalid request');
            }
        }
    }

}
