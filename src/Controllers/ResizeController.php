<?php

namespace Mafftor\LaravelFileManager\Controllers;

use Intervention\Image\Facades\Image;
use Mafftor\LaravelFileManager\Events\ImageIsResizing;
use Mafftor\LaravelFileManager\Events\ImageWasResized;

class ResizeController extends LfmController
{
    /**
     * Display image for resizing.
     *
     * @return mixed
     */
    public function getResize()
    {
        $ratio = 1.0;
        $image_name = request('img');

        $original_image = Image::make($this->lfm->setName($image_name)->storage->get());
        $original_width = $original_image->width();
        $original_height = $original_image->height();

        $scaled = false;

        // FIXME size should be configurable
        if ($original_width > 600) {
            $ratio = 600 / $original_width;
            $width = $original_width * $ratio;
            $height = $original_height * $ratio;
            $scaled = true;
        } else {
            $width = $original_width;
            $height = $original_height;
        }

        if ($height > 400) {
            $ratio = 400 / $original_height;
            $width = $original_width * $ratio;
            $height = $original_height * $ratio;
            $scaled = true;
        }

        return view('laravel-file-manager::resize')
            ->with('img', $this->lfm->pretty($image_name))
            ->with('height', number_format($height, 0))
            ->with('width', $width)
            ->with('original_height', $original_height)
            ->with('original_width', $original_width)
            ->with('scaled', $scaled)
            ->with('ratio', $ratio);
    }

    /**
     * Perform resize
     *
     * @return string
     */
    public function performResize()
    {
        $image_name = request('img');
        $image_path = $this->lfm->setName($image_name)->path('absolute');

        event(new ImageIsResizing($image_path));

        $image = $this->lfm->setName($image_name)->storage->get();
        $resizedImage = Image::make($image)->resize(request('dataWidth'), request('dataHeight'))
            ->stream()
            ->detach();

        // Same new image
        $this->lfm->setName($image_name)->storage->put($resizedImage, 'public');
        // make new thumbnail
        $this->lfm->makeThumbnail($image_name);

        event(new ImageWasResized($image_path));

        return parent::$success_response;
    }
}
