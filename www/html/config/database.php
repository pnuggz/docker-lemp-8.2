<?php

return [
    'mysql' => [
        'host' => $_ENV['MYSQL_HOST'],
        'port' => $_ENV['MYSQL_PORT'],
        'database' => $_ENV['MYSQL_DATABASE'],
        'user' => $_ENV['MYSQL_USER'],
        'password' => $_ENV['MYSQL_PASSWORD'],
    ],
];
