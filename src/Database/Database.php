<?php

namespace Karma8\Database;

use mysqli;
use function Karma8\Core\getSetting;

function getConnection(): ?mysqli {
  global $_MYSQL_CONNECT;

  if (null === $_MYSQL_CONNECT) {
    $connect = mysqli_connect(
      getSetting('mysql.host'),
      getSetting('mysql.username'),
      getSetting('mysql.password'),
      getSetting('mysql.database')
    );

    if (false !== $connect) {
      $_MYSQL_CONNECT = $connect;
    }
  }

  return $_MYSQL_CONNECT;
}
