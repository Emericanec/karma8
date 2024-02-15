<?php

namespace Karma8\Core;

function runWorker(string $lockKey, int $maxWorkersCount, callable $function): void {
  $locked = false;
  for ($currentWorkerNum = 1; $currentWorkerNum <= $maxWorkersCount; $currentWorkerNum++) {
    $lockFile = sys_get_temp_dir() . "{$lockKey}_{$currentWorkerNum}.lock";

    $fp = fopen($lockFile, "w");

    if (flock($fp, LOCK_EX | LOCK_NB)) {
      $locked = true;
      break;
    }

    fclose($fp);
  }

  if ($locked && isset($fp)) {
    $function();
    flock($fp, LOCK_UN);
    fclose($fp);
  } else {
    echo "{$maxWorkersCount} processes already is running" . PHP_EOL;
  }
}