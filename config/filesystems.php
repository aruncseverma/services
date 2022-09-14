<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3", "rackspace"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' =>  '/storage',
            'visibility' => 'public',
        ],

        // jhay was here for private images and albums
        'private' => [
            'driver'    => 'local',
            'root'      => storage_path('app/private'),
            'url'       => '/storage',
            'visibility'=> 'private',
        ],
        // end jhay

        // for silver validation images
        'mug_shots' => [
            'driver' => 'local',
            'root' => storage_path('app/assets/mug_shots'),
            'url' => null,
            'visibility' => 'private'
        ],

        // for gold validation images
        'private_photo_id' => [
            'driver' => 'local',
            'root' => storage_path('app/assets/private_photo_id'),
            'url' => null,
            'visibility' => 'private'
        ],

        // public videos
        'public_videos' => [
            'driver' => 'local',
            'root' => storage_path('app/assets/videos'),
            'url' => '/storage/app/assets/videos',
            'visibility' => 'public',
        ],

        'public_thumbnail' => [
            'driver' => 'local',
            'root' => storage_path('app/assets/videos/thumb'),
            'url' => null,
            'visibility' => 'public',
        ],

        'tmp' => [
            'driver' => 'local',
            'root' => storage_path('app/tmp'),
            'url' => null,
            'visibility' => 'public'
        ],

        // public videos
        'private_videos' => [
            'driver' => 'local',
            'root' => storage_path('app/assets/videos/private'),
            'url' => null,
            'visibility' => 'private',
        ],

        'private_thumbnails' => [
            'driver' => 'local',
            'root' => storage_path('app/assets/videos/private/thumb'),
            'url' => null,
            'visibility' => 'private',
        ],

        // profile photos (agency)
        'agency_photos' => [
            'driver' => 'local',
            'root' => storage_path('app/assets/photos/agency'),
            'url' => null,
            'visibility' => 'public',
        ],

        // profile photos (member)
        'member_photos' => [
            'driver' => 'local',
            'root' => storage_path('app/assets/photos/member'),
            'url' => null,
            'visibility' => 'public',
        ],

        // post photos
        'post_photos' => [
            'driver' => 'local',
            'root' => storage_path('app/assets/photos/post'),
            'url' => null,
            'visibility' => 'public',
        ],

        'invoice' => [
            'driver' => 'local',
            'root' => storage_path('app/assets/photos/invoice'),
            'url' => null,
            'visibility' => 'private'
        ],

        'admin' => [
            'driver' => 'local',
            'root' => storage_path('app/assets/photos/admin'),
            'url' => null,
            'visibility' => 'public'
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
        ],

    ],

];
