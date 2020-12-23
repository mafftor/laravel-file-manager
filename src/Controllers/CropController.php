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
     *
     * @param bool $overWrite
     */
    public function getCropimage($overWrite = true)
    {
        $image_name = request('img');
        $target_name = $image_name;
        $image_path = $this->lfm->setName($image_name)->path('absolute');

        event(new ImageIsCropping($image_path));

        $crop_info = request()->only('dataWidth', 'dataHeight', 'dataX', 'dataY');

        // crop image
        $croppedImage = Image::make($this->lfm->setName($image_name)->storage->get())
            ->crop(...array_values($crop_info))
            ->stream()
            ->detach();

        // Overwrite
        if (!$overWrite) {
            $fileParts = explode('.', $image_name);
            $fileParts[count($fileParts) - 2] = $fileParts[count($fileParts) - 2] . '_cropped_' . time();
            $target_name = implode('.', $fileParts);
        }

        // Replace or create new image
        $this->lfm->setName($target_name)->storage->put($croppedImage, 'public');
        // make new thumbnail
        $this->lfm->makeThumbnail($target_name);

        event(new ImageWasCropped($image_path));
    }

    /**
     * Crop the image (called via ajax).
     */
    public function getNewCropimage()
    {
        $this->getCropimage(false);
    }
}
