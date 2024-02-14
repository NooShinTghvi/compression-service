<?php

namespace App\Http\Controllers;


use App\Http\Requests\CompressFile\UploadRequest;
use App\Jobs\CompressFileJob;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class CompressFileController extends Controller
{
    /**
     * @throws Throwable
     */
    public function upload(UploadRequest $request)
    {
        $filePath = $this->getUploadFilePath($request);
        $storagePath = $this->getStoragePath($request);

        $batch = Bus::batch([
            new CompressFileJob($filePath, $storagePath)
        ])->dispatch();

        $batchId = data_get($batch, 'id');
        return response()->json([
            'message' => 'file uploaded successfully.',
            'download-link' => route('compress.download', ['batchId' => $batchId]),
            'uuid' => $batchId
        ]);
    }

    public function download($batchId)
    {
        $batch = Bus::findBatch($batchId);

        if (!isset($batch)) {
            return response()->json([
                'message' => 'not found.'
            ], Response::HTTP_NOT_FOUND);
        }
        return match (true) {
            $batch->finished() => $this->handleFinishedBatch($batchId),
            $batch->cancelled() => $this->handleCancelledBatch(),
            default => $this->handleDoingBatch()
        };
    }

    private function handleFinishedBatch($batchId)
    {
        $cacheKey = 'compress_file_results_'.$batchId;
        return Cache::has($cacheKey)
            ? response()->download(Cache::get($cacheKey))
            : response()->json([
                'message' => 'file expired.'
            ], Response::HTTP_NOT_FOUND);
    }

    private function handleCancelledBatch()
    {
        return response()->json([
            'message' => 'try again.'
        ], Response::HTTP_BAD_REQUEST);
    }

    private function handleDoingBatch()
    {
        return response()->json([
            'message' => 'the process is doing'
        ]);
    }

    private function getUploadFilePath(UploadRequest $request)
    {
        return storage_path('app/').$request->file('file')->storePublicly();
    }

    private function getStoragePath(UploadRequest $request)
    {
        return storage_path("app/public/compress-result_".time()."_".$request->file('file')->getFilename());
    }
}


