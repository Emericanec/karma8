<?php

use function Karma8\Database\getConnection;

include_once __DIR__ . "/../src/bootstrap.php";

$connection = getConnection();

$sqlFile     = __DIR__ . '/../db.sql';
$sqlCommands = file_get_contents($sqlFile);

mysqli_multi_query($connection, $sqlCommands);
