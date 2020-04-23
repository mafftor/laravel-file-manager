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
     */

    'use_package_routes' => true,

    /*
    |--------------------------------------------------------------------------
    | Shared folder / Private folder
    |--------------------------------------------------------------------------
    |
    | If both options are set to false, then shared folder will be activated.
    |
     */

    'allow_private_folder' => true,

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
        'file' => [
            'folder_name' => 'files',
            'startup_view' => 'grid',
            'max_size' => 50000, // size in KB
            'valid_mime' => [
                'application/pdf',
                'text/plain',
            ],
        ],
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

    'default_category_type' => 'file',

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
    ],

    /*
    |--------------------------------------------------------------------------
    | Upload / Validation
    |--------------------------------------------------------------------------
    |
    | We highly recommend you to leave alphanumeric setting by default (true)
    | It may save you from problems in the future
    |
    */

    'disk' => 'public',

    'rename_file' => false,

    'alphanumeric_filename' => true,

    'alphanumeric_directory' => true,

    'should_validate_size' => true,

    'should_validate_mime' => true,

    // behavior on files with identical name
    // setting it to true cause old file replace with new one
    // setting it to false show `error-file-exist` error and stop upload
    'over_write_on_duplicate' => false,

    /*
    |--------------------------------------------------------------------------
    | Thumbnail
    |--------------------------------------------------------------------------
     */

    // If true, image thumbnails would be created during upload
    'should_create_thumbnails' => true,

    'thumb_folder_name' => 'thumbs',

    // Create thumbnails automatically only for listed types.
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
