<?php

namespace Mafftor\LaravelFileManager\Controllers;

use Intervention\Image\Facades\Image;
use Mafftor\LaravelFileManager\Events\ImageIsCropping;
use Mafftor\LaravelFileManager\Events\ImageWasCropped;

class CropController extends LfmController
{
    /**
     * Show crop page.
     *
     * @return mixed
     */
    public function getCrop()
    {
        return view('laravel-file-manager::crop')
            ->with([
                'working_dir' => request('working_dir'),
                'img' => $this->lfm->pretty(request('img'))
            ]);
    }

    /**
     * Crop the image (called via ajax).
     */
    public function getCropimage($overWrite = true)
    {
        $image_name = request('img');
        $image_path = $this->lfm->setName($image_name)->path('absolute');

        if (! $overWrite) {
            $fileParts = explode('.', $image_name);
            $fileParts[count($fileParts) - 2] = $fileParts[count($fileParts) - 2] . '_cropped_' . time();
            $crop_name = implode('.', $fileParts);
        }

        event(new ImageIsCropping($image_path));

        $crop_info = request()->only('dataWidth', 'dataHeight', 'dataX', 'dataY');

        // crop image
        $croppedImage = Image::make($this->lfm->setName($image_name)->storage->get())
            ->crop(...array_values($crop_info))
            ->stream()
            ->detach();

        if (! $overWrite) {
            $this->lfm->setName($crop_name)->storage->put($croppedImage);
            // make new thumbnail
            $this->lfm->makeThumbnail($crop_name);
        } else {
            $this->lfm->setName($image_name)->storage->put($croppedImage);
            // make new thumbnail
            $this->lfm->makeThumbnail($image_name);
        }

        event(new ImageWasCropped($image_path));
    }

    public function getNewCropimage()
    {
        $this->getCropimage(false);
    }
}
