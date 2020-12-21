<?php

namespace Mafftor\LaravelFileManager\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DownloadController extends LfmController
{
    public function getDownload()
    {
        $filepath = $this->helper->getCategoryName() . request('working_dir') . '/' . request('file');

        try {
            if (Storage::disk($this->helper->config('disk'))->exists($filepath)) {
                return Storage::disk($this->helper->config('disk'))->download($filepath);
            }
        } catch (\Exception $e) {
            // Do not need to throw the exception
        }

        Log::error('[laravel-file-manager] File not found - ' . $filepath);
        abort(404);
    }
}
