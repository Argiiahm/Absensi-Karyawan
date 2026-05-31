<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class DownloadFaceModels extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'face:download-models';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download MediaPipe WASM and face landmarker model files locally for instant loading';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $destPath = public_path('models');
        if (!File::exists($destPath)) {
            File::makeDirectory($destPath, 0755, true);
        }

        // MediaPipe Wasm & Task files
        $this->info('Starting MediaPipe files download...');
        $mediaPipeFiles = [
            'https://cdn.jsdelivr.net/npm/@mediapipe/tasks-vision@0.10.8/wasm/vision_wasm_internal.wasm' => 'vision_wasm_internal.wasm',
            'https://cdn.jsdelivr.net/npm/@mediapipe/tasks-vision@0.10.8/wasm/vision_wasm_internal.js' => 'vision_wasm_internal.js',
            'https://storage.googleapis.com/mediapipe-models/face_landmarker/face_landmarker/float16/1/face_landmarker.task' => 'face_landmarker.task',
        ];

        foreach ($mediaPipeFiles as $url => $filename) {
            $filePath = $destPath . DIRECTORY_SEPARATOR . $filename;
            if (File::exists($filePath)) {
                $this->comment("File already exists: {$filename}, skipping.");
                continue;
            }
            $this->downloadFile($url, $filePath);
        }

        $this->info('All MediaPipe files downloaded successfully!');
    }

    protected function downloadFile($url, $filePath)
    {
        $this->info("Downloading from {$url}...");
        try {
            $context = stream_context_create([
                'http' => [
                    'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)\r\n",
                    'timeout' => 300
                ]
            ]);
            $source = fopen($url, 'r', false, $context);
            if ($source) {
                file_put_contents($filePath, $source);
                $this->info("Successfully saved " . basename($filePath));
            } else {
                $this->error("Failed to open URL: {$url}");
            }
        } catch (\Exception $e) {
            $this->error("Error downloading " . basename($filePath) . ": " . $e->getMessage());
        }
    }
}
