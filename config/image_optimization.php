<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | The default disk used to store optimized WebP images.
    |
    */
    'disk' => env('IMAGE_OPTIMIZATION_DISK', 'public'),

    /*
    |--------------------------------------------------------------------------
    | Upload & Processing Limits
    |--------------------------------------------------------------------------
    |
    | max_upload_size_kb : Maximum input file size before processing (default: 10 MB = 10240 KB).
    | max_dimension      : Maximum width and height in pixels (default: 2560 px).
    | target_size_kb     : Target maximum size in KB for converted WebP output (default: 1024 KB = 1 MB).
    |
    */
    'max_upload_size_kb' => env('IMAGE_MAX_UPLOAD_KB', 10240),
    'max_dimension' => env('IMAGE_MAX_DIMENSION', 2560),
    'target_size_kb' => env('IMAGE_TARGET_SIZE_KB', 1024),

    /*
    |--------------------------------------------------------------------------
    | WebP Compression Quality Presets
    |--------------------------------------------------------------------------
    |
    | default  : Initial quality for photos and general raster graphics (82-85).
    | qris     : High quality preset for QRIS / barcodes to guarantee 100% scannability (98).
    | min      : Minimum acceptable stepped-down quality for general images (65).
    | min_qris : Minimum acceptable quality for QRIS to avoid pixel blur or decoding failure (90).
    |
    */
    'quality' => [
        'default' => 85,
        'qris' => 98,
        'min' => 65,
        'min_qris' => 90,
    ],
];
