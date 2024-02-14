<?php

namespace App\Services\CompressService;

use Archive_Tar;
use Exception;
use Illuminate\Support\Facades\Log;
use ZipArchive;
use function PHPUnit\Framework\throwException;

class CompressFileService
{
    /**
     * @throws Exception
     */
    public function maker(String $filePath, String $destination, String $format): void
    {
        switch ($format) {
            case 'zip':
                self::makeZip($filePath, $destination.'.zip');
                break;
            case '7z':
                self::make7z($filePath, $destination.'.7z');
                break;
            case 'tar.gz':
                self::makeTarGz($filePath, $destination.'.tar.gz');
                break;
            default:
                throw new Exception('format does not support.');
        }
    }

    private function makeZip($filePath, $destination): void
    {
        $zip = new ZipArchive;
        if ($zip->open($destination, ZipArchive::CREATE) === true) {
            $zip->addFile($filePath);
            $zip->close();
        }
    }

    private function make7z($filePath, $destination): void
    {
        // Ensure the 7zip command is available and the PHP exec function is not disabled
        shell_exec("7z a -t7z {$destination} {$filePath}");
    }

    private function makeTarGz($filePath, $destination): void
    {
        $tar = new Archive_Tar($destination);
        $tar->create([$filePath]);
    }
}
