<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
        'jwt_key' => 'CHAVESUPERSECRETADAAPI',

        'db' => [
            'host' => 'kozima.mysql.dbaas.com.br',
            'user' => 'kozima',
            'password' => 'kozima123',
            'dbname' => 'kozima'
        ]
    ],
];
