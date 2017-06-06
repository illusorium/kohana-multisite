<?php defined('SYSPATH') OR die('No direct script access.');

return [
    'default' => [
        /**
         * The following options must be set:
         *
         * string   key     secret passphrase
         * integer  mode    encryption mode, one of MCRYPT_MODE_*
         * integer  cipher  encryption cipher, one of the Mcrpyt cipher constants
         */
        'key' => 'Long_enough_random_string_as_salt',
        'cipher' => MCRYPT_RIJNDAEL_128,
        'mode'   => MCRYPT_MODE_NOFB
    ]
];
