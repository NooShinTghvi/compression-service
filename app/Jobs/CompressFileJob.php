<?php namespace App\Jobs;

use App\Services\CompressService\CompressFileService;
use Exception;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CompressFileJob implements ShouldQueue
{
    use Batchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * @var string
     */
    private string $format;
    private CompressFileService $service;

    public function __construct(
        public string $filePath,
        public string $destination,
    ) {
        $this->format = config('compress-file.type');
        $this->service = new CompressFileService();
    }

    /**
     * @throws Exception
     */
    public function handle(): void
    {
        $this->service->maker($this->filePath, $this->destination, $this->format);
        $this->storeResult();
    }

    /**
     * @return void
     */
    private function storeResult(): void
    {
        Cache::remember('compress_file_results_'.$this->batch()->id, 60 * 60 * 24, function () {
            return $this->destination.'.'.$this->format;
        });
    }
}
