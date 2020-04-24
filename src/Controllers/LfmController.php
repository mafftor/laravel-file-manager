<?php

namespace Mafftor\LaravelFileManager\Controllers;

use Mafftor\LaravelFileManager\Lfm;
use Mafftor\LaravelFileManager\LfmPath;

class LfmController extends Controller
{
    protected static $success_response = 'OK';

    public function __construct()
    {
        $this->applyIniOverrides();
    }

    /**
     * Set up needed functions.
     *
     * @return object|null
     */
    public function __get($var_name)
    {
        if ($var_name === 'lfm') {
            return app(LfmPath::class);
        } elseif ($var_name === 'helper') {
            return app(Lfm::class);
        }
    }

    /**
     * Show the filemanager.
     *
     * @return mixed
     */
    public function show()
    {
        $actions = [
            [
                'name' => 'rename',
                'icon' => 'edit',
                'label' => trans('laravel-file-manager::lfm.menu-rename'),
                'multiple' => false,
            ],
            [
                'name' => 'download',
                'icon' => 'download',
                'label' => trans('laravel-file-manager::lfm.menu-download'),
                'multiple' => false
            ],
        ];

        if (config('lfm.features.move', true)) {
            $actions = array_merge($actions, [
                [
                    'name' => 'move',
                    'icon' => 'paste',
                    'label' => trans('laravel-file-manager::lfm.menu-move'),
                    'multiple' => true
                ],
            ]);
        }

        if (config('lfm.features.resize', true)) {
            $actions = array_merge($actions, [
                [
                    'name' => 'resize',
                    'icon' => 'ruler-combined',
                    'label' => trans('laravel-file-manager::lfm.menu-resize'),
                    'multiple' => false
                ],
            ]);
        }

        if (config('lfm.features.crop', true)) {
            $actions = array_merge($actions, [
                [
                    'name' => 'crop',
                    'icon' => 'crop',
                    'label' => trans('laravel-file-manager::lfm.menu-crop'),
                    'multiple' => false
                ],
            ]);
        }

        $actions = array_merge($actions, [
            [
                'name' => 'trash',
                'icon' => 'trash',
                'label' => trans('laravel-file-manager::lfm.menu-delete'),
                'multiple' => true
            ],
        ]);

        return view('laravel-file-manager::index')
            ->withHelper($this->helper)
            ->withActions($actions);
    }

    /**
     * Check if any extension or config is missing.
     *
     * @return array
     */
    public function getErrors()
    {
        $arr_errors = [];

        if (!extension_loaded('gd') && !extension_loaded('imagick')) {
            array_push($arr_errors, trans('laravel-file-manager::lfm.message-extension_not_found'));
        }

        if (!extension_loaded('exif')) {
            array_push($arr_errors, 'EXIF extension not found.');
        }

        if (!extension_loaded('fileinfo')) {
            array_push($arr_errors, 'Fileinfo extension not found.');
        }

        $mine_config_key = 'lfm.folder_categories.'
            . $this->helper->currentLfmType()
            . '.valid_mime';

        if (!is_array(config($mine_config_key))) {
            array_push($arr_errors, 'Config : ' . $mine_config_key . ' is not a valid array.');
        }

        return $arr_errors;
    }

    /**
     * @param $error_type
     * @param array $variables
     * @return mixed
     */
    public function error($error_type, $variables = [], $code = 400)
    {
        return $this->helper->error($error_type, $variables, $code);
    }

    /**
     * Overrides settings in php.ini.
     *
     * @return null
     */
    public function applyIniOverrides()
    {
        $overrides = config('lfm.php_ini_overrides');
        if ($overrides && is_array($overrides) && count($overrides) === 0) {
            return;
        }

        foreach ($overrides as $key => $value) {
            if ($value && $value != 'false') {
                ini_set($key, $value);
            }
        }
    }
}
