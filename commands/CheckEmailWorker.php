<?php

use function Karma8\Jobs\checkUsersEmail;

include_once __DIR__ . "/../src/bootstrap.php";

$maxWorkersCount = isset($argv[1]) ? (int)$argv[1] : 1;

$locked = false;
for ($currentWorkerNum = 1; $currentWorkerNum <= $maxWorkersCount; $currentWorkerNum++) {
  $lockFile = sys_get_temp_dir() . "check_email_worker_{$currentWorkerNum}.lock";

  $fp = fopen($lockFile, "w");

  if (flock($fp, LOCK_EX | LOCK_NB)) {
    $locked = true;
    break;
  }

  fclose($fp);
}

if ($locked && isset($fp)) {
  checkUsersEmail();
  flock($fp, LOCK_UN);
  fclose($fp);
} else {
  echo "{$maxWorkersCount} processes already is running" . PHP_EOL;
}
