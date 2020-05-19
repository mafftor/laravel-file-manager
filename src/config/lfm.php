<?php

/*
|--------------------------------------------------------------------------
| Documentation for this config:
|--------------------------------------------------------------------------
| online  => http://mafftor.github.io/laravel-file-manager/config
| offline => vendor/mafftor/laravel-file-manager/docs/config.md
 */

return [
    /*
    |--------------------------------------------------------------------------
    | Routing
    |--------------------------------------------------------------------------
    |
    | If you want to define your own routes, please set 'use_package_routes'
    | to false! Or change 'route.attributes' for your needs.
    |
    | Note, You always can check active routes and be sure that you have not
    | defined routes several times.
    | run for checking => 'php artisan route:list'
    |
    */

    'route' => [
        'use_package_routes' => true,

        'attributes' => [
            'prefix' => 'filemanager',
            'middleware' => [
                'web',
                'auth',
            ],
        ],
    ],


    /*
    |--------------------------------------------------------------------------
    | Folder privacy
    |--------------------------------------------------------------------------
    |
    | If both options are set to false, then shared folder will be activated.
    |
    */

    'allow_private_folder' => false,

    // Flexible way to customize client folders accessibility
    // If you want to customize client folders, publish tag="lfm_handler"
    // Then you can rewrite userField function in App\Handler\ConfigHandler class
    // And set 'user_field' to App\Handler\ConfigHandler::class
    // Ex: The private folder of user will be named as the user id.
    'private_folder_name' => Mafftor\LaravelFileManager\Handlers\ConfigHandler::class,

    'allow_shared_folder' => true,

    'shared_folder_name' => 'shares',

    /*
    |--------------------------------------------------------------------------
    | Folder Names
    |--------------------------------------------------------------------------
    */

    'folder_categories' => [
        'image' => [
            'folder_name' => 'photos',
            'startup_view' => 'list',
            'max_size' => 50000, // size in KB
            'valid_mime' => [
                'image/jpeg',
                'image/pjpeg',
                'image/png',
                'image/gif',
                'image/svg+xml',
            ],
        ],
        'file' => [
            'folder_name' => 'files',
            'startup_view' => 'grid',
            'max_size' => 50000, // size in KB
            'valid_mime' => [
                'application/pdf',
                'text/plain',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Folder defaults
    |--------------------------------------------------------------------------
    |
    | Setup default type of file-manager. Choose one of 'folder_categories' keys
    | which you want to set as default.
    | It works when you open the file-manager in new window
    | without specific $_GET parameters ?type=file OR ?type=image
    |
    | Supported by default: 'file', 'image'
    | (See 'folder_categories' keys above)
    |
    */

    'default_category_type' => 'image',

    /*
    |--------------------------------------------------------------------------
    | Features
    |--------------------------------------------------------------------------
    |
    | Configure your features here by setting true or false.
    | You can use it for hiding or displaying some features.
    |
    */

    'features' => [
        'move' => true,
        'resize' => true,
        'crop' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Upload and Validation
    |--------------------------------------------------------------------------
    |
    | We highly recommend you to leave alphanumeric setting by default (true)
    | It may save you from problems in the future
    |
    */

    'disk' => 'public',

    'alphanumeric_filename' => true,
    'alphanumeric_directory' => true,

    'should_validate_size' => true,
    'should_validate_mime' => true,

    /*
    |--------------------------------------------------------------------------
    | File naming [Upload]
    |--------------------------------------------------------------------------
    |
    | 'uniqid' - Generate a unique ID (length:13) (e.g. 5e94a2653ef6a)
    | 'slug' - Generate friendly "slug" ("Te sT 1.txt" => "te-st-1.txt")
    |
    | 'duplicate' - behavior on files with identical name
    |   '-%s' - create new file with postfix file.txt => file-1.txt, file-2.txt
    |     where '%s' is number '-1', '-2' will be generated automatically
    |   true - old file will be replaced with new one
    |   false - will show `error-file-exist` error and stop upload
    |
    | Note!
    |   Make sure that you have enabled only one feature of rename_file
    |   'uniqid' or 'slug' because of conflicts
    |
    */

    'rename_file' => [
        'uniqid' => false,
        'slug' => true,

        'duplicate' => '-%s',
    ],

    /*
    |--------------------------------------------------------------------------
    | Compression
    |--------------------------------------------------------------------------
    |
    | Define the quality of the image. Data ranging from 0
    | (poor quality, small file) to 100 (best quality, big file).
    | Quality is only applied if you're encoding JPG format
    | since PNG compression is lossless and does not affect image quality.
    |
    | 'APIKeyFromTinyPng.Com' - set API key to use TinyPNG.com
    | 90 - default value, recommended value is between 80-90
    | false - to disable compression
    |
    */

    'compress_image' => 90,

    /*
    |--------------------------------------------------------------------------
    | Thumbnail
    |--------------------------------------------------------------------------
    |
    | If 'should_create_thumbnails' true, image thumbnails would be created
    | during upload
    | 'raster_mimetypes' - Create thumbnails automatically only for listed types
    |
    */

    'should_create_thumbnails' => true,

    'thumb_folder_name' => 'thumbs',

    'raster_mimetypes' => [
        'image/jpeg',
        'image/pjpeg',
        'image/png',
    ],

    'thumb_img_width' => 200, // px
    'thumb_img_height' => 200, // px

    /*
    |--------------------------------------------------------------------------
    | File Extension Information
    |--------------------------------------------------------------------------
    */

    'file_type_array' => [
        'pdf' => 'Adobe Acrobat',
        'doc' => 'Microsoft Word',
        'docx' => 'Microsoft Word',
        'xls' => 'Microsoft Excel',
        'xlsx' => 'Microsoft Excel',
        'zip' => 'Archive',
        'gif' => 'GIF Image',
        'jpg' => 'JPEG Image',
        'jpeg' => 'JPEG Image',
        'png' => 'PNG Image',
        'ppt' => 'Microsoft PowerPoint',
        'pptx' => 'Microsoft PowerPoint',
    ],

    /*
    |--------------------------------------------------------------------------
    | php.ini override
    |--------------------------------------------------------------------------
    |
    | These values override your php.ini settings before uploading files
    | Set these to false to ingnore and apply your php.ini settings
    |
    | Please note that the 'upload_max_filesize' & 'post_max_size'
    | directives are not supported.
    */

    'php_ini_overrides' => [
        'memory_limit' => '256M',
    ],
];
