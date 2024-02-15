<?php

use function Karma8\Core\runWorker;
use function Karma8\Jobs\sendEmailNotification;

include_once __DIR__ . "/../src/bootstrap.php";

$maxWorkersCount = isset($argv[1]) ? (int)$argv[1] : 1;
$days            = isset($argv[2]) ? (int)$argv[2] : 1;

runWorker(
  "email_notification_{$days}_worker",
  fn() => sendEmailNotification($days),
  $maxWorkersCount
);
