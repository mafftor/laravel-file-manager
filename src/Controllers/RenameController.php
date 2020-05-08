<?php

namespace Mafftor\LaravelFileManager\Controllers;

use Mafftor\LaravelFileManager\Events\ImageIsRenaming;
use Mafftor\LaravelFileManager\Events\ImageWasRenamed;
use Mafftor\LaravelFileManager\Events\FolderIsRenaming;
use Mafftor\LaravelFileManager\Events\FolderWasRenamed;

class RenameController extends LfmController
{
    public function getRename()
    {
        $old_name = $this->helper->input('file');
        $new_name = $this->helper->input('new_name');

        $old_file = $this->lfm->pretty($old_name);
        $is_directory = $old_file->getLfm()->isDirectory();

        if (empty($new_name)) {
            if ($is_directory) {
                return parent::error('folder-name');
            } else {
                return parent::error('file-name');
            }
        }

        if ($is_directory) {
            if (config('lfm.alphanumeric_directory', true) && preg_match('/[^\w-]/i', $new_name)) {
                return parent::error('folder-alnum');
            } elseif ($this->lfm->setName($new_name)->exists()) {
                return parent::error('rename');
            }
        } else {
            if (config('lfm.alphanumeric_filename', true) && preg_match('/[^\w-]/i', $new_name)) {
                return parent::error('file-alnum');
            }

            $extension = $old_file->extension();
            if ($extension) {
                $new_name .= '.' . $extension;
            }

            if ($this->lfm->setName($new_name)->exists()) {
                return parent::error('rename');
            }
        }


        $new_file = $this->lfm->setName($new_name)->path('absolute');

        if ($is_directory) {
            event(new FolderIsRenaming($old_file->path(), $new_file));
        } else {
            event(new ImageIsRenaming($old_file->path(), $new_file));
        }

        if ($old_file->hasThumb()) {
            $this->lfm->setName($old_name)->thumb()
                ->move($this->lfm->setName($new_name)->thumb());
        }

        $this->lfm->setName($old_name)
            ->move($this->lfm->setName($new_name));

        if ($is_directory) {
            event(new FolderWasRenamed($old_file->path(), $new_file));
        } else {
            event(new ImageWasRenamed($old_file->path(), $new_file));
        }

        return parent::$success_response;
    }
}
