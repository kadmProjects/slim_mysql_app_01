<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

       // Default renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/app/views/',
        ],

        // Twig renderer settings
        'twig' => [
            'view_path' => __DIR__ . '/app/views/',
            'cache_path' => __DIR__ . '/../cache',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        // Database settings
        'db' => [
            'host' => 'localhost',
            'user' => 'root',
            'pass' => '123456',
            'dbname' => 'slim-app-01',
        ]
    ],
];
