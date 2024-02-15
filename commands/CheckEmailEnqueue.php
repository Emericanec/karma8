<?php

use function Karma8\Core\runWorker;
use function Karma8\Jobs\enqueueUserEmailsForCheck;

include_once __DIR__ . "/../src/bootstrap.php";

runWorker(
  "check_email_enqueue",
  fn() => enqueueUserEmailsForCheck()
);
