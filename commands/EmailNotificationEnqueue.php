<?php

use function Karma8\Jobs\enqueueEmailNotification;

include_once __DIR__ . "/../src/bootstrap.php";

$days = isset($argv[1]) ? (int)$argv[1] : 1;

$lockFile = sys_get_temp_dir() . "email_{$days}_days_notification_enqueue.lock";
$fp       = fopen($lockFile, "w");

if (flock($fp, LOCK_EX | LOCK_NB)) {
  enqueueEmailNotification($days);

  flock($fp, LOCK_UN);
} else {
  echo "CheckEmail process already running";
}

fclose($fp);
