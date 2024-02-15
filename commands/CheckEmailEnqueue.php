<?php

use function Karma8\Jobs\enqueueUserEmailsForCheck;

include_once __DIR__ . "/../src/bootstrap.php";

$lockFile = sys_get_temp_dir() . "check_email_enqueue.lock";
$fp       = fopen($lockFile, "w");

if (flock($fp, LOCK_EX | LOCK_NB)) {
  enqueueUserEmailsForCheck();

  flock($fp, LOCK_UN);
} else {
  echo "CheckEmail process already running";
}

fclose($fp);
