<?php
namespace App\Facade;

use App\Services\CompressService\CompressFileService;
use Exception;

class CompressFileServiceFacade
{
    protected CompressFileService $compressFileService;

    public function __construct()
    {
        $this->compressFileService = new CompressFileService();
    }

    /**
     * @throws Exception
     */
    public function compressFile($filePath, $destination, $format): void
    {
        $this->compressFileService->maker($filePath, $destination, $format);
    }
}
