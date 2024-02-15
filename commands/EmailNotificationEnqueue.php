<?php

use function Karma8\Core\runWorker;
use function Karma8\Jobs\enqueueEmailNotification;

include_once __DIR__ . "/../src/bootstrap.php";

$days = isset($argv[1]) ? (int)$argv[1] : 1;

runWorker(
  "email_{$days}_days_notification_enqueue",
  fn() => enqueueEmailNotification($days)
);
