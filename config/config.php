<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    'connection'=>config('database.default'),
    'authorize' => false,
    'rules' =>[
        'mimes' => 'jpg,jpeg,png,svg,webp,gif,mp4,mpg,mpeg,avi,mov,flv,swf,mkv',
        'size' => [
            'limit_max' => false,
            'max' => 102400, //The value is in kilobytes
            'limit_min' => false,
            'min' => 1024, //The value is in kilobytes
        ],
        'attachments' =>[//set rules for multiple files
            'limit_max_quantity'=>false,
            'max_quantity'=>5,            
            'limit_min_quantity'=>false,
            'min_quantity'=>1,
        ]
    ]
];
