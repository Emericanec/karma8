<?php

namespace Karma8;

use function Karma8\Core\getEnvValue;

include_once __DIR__ . "/bootstrap.php";

$GLOBALS['_SETTINGS'] = [
  'mysql' => [
    'host'     => getEnvValue('MYSQL_HOST', '127.0.0.1:3306'),
    'database' => getEnvValue('MYSQL_DATABASE', 'karma'),
    'username' => getEnvValue('MYSQL_USERNAME', 'root'),
    'password' => getEnvValue('MYSQL_PASSWORD', ''),
  ],
  'email' => [
    'from' => getEnvValue('EMAIL_FROM', 'noreply@mail.com'),
  ],
];
