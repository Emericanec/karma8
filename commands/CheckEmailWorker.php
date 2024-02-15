<?php

use function Karma8\Core\runWorker;
use function Karma8\Jobs\checkUsersEmail;

include_once __DIR__ . "/../src/bootstrap.php";

$maxWorkersCount = isset($argv[1]) ? (int)$argv[1] : 1;

runWorker(
  'check_email_worker',
  fn() => checkUsersEmail(),
  $maxWorkersCount
);
