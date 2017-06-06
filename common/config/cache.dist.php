<?php defined('SYSPATH') or die('No direct script access.');

return [
    'file'    => [
        'driver'             => 'file',
        'cache_dir'          => APPPATH . 'cache',
        'default_expire'     => 86400,
        'ignore_on_delete'   => [
            '.gitignore',
            '.git',
            '.svn'
        ]
    ]
];
