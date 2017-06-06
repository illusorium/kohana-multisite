<?php defined('SYSPATH') OR die('No direct access allowed.');

return [
    'default' => [
        'type'       => 'MySQLi',
        'connection' => [
            'hostname'   => 'localhost',
//            'port'       => '3306',
            'database'   => 'database',
            'username'   => 'db_user',
            'password'   => 'password',
            'persistent' => false,
        ],
        'table_prefix' => '',
        'charset'      => 'utf8',
        'caching'      => false
    ]
];
