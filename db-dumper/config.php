<?php

$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

return [
    'database' => [
        'driver' => getenv('DATABASE_DRIVER'),
        'db_name' => getenv('DATABASE_NAME'),
        'username' => getenv('DATABASE_USERNAME'),
        'password' => getenv('DATABASE_PASSWORD'),
        'dump_folder' => getenv('DUMP_FOLDER'),
    ],
	
	'archive' => [
		'folder' => getenv('ZIP_FOLDER'),
//		'mode' => getenv('ZIP_FREQUENCY'),
	],

    'log' => [
        'path' => getenv('LOG_PATH')
    ]
];