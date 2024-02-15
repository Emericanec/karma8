<?php

namespace Karma8\Jobs;

use function Karma8\Core\getSetting;
use function Karma8\Database\dequeue;
use function Karma8\Database\enqueue;
use function Karma8\Database\getUserById;
use function Karma8\Database\getUserForNotification;
use function Karma8\Database\queueDone;
use function Karma8\Email\send_email;

function enqueueEmailNotification(int $days): void {
  $jobId = match ($days) {
    1 => JOB_ID_SEND_BEFORE_1_DAYS,
    3 => JOB_ID_SEND_BEFORE_3_DAYS,
  };

  $validTsFrom = strtotime(date('Y-m-d 00:00:00', strtotime("+{$days} days")));
  $validTsTo   = strtotime(date('Y-m-d 23:59:59', strtotime("+{$days} days")));
  $lastId      = 0;
  while (true) {
    $users = getUserForNotification($validTsFrom, $validTsTo, $lastId);
    if (empty($users)) {
      break;
    }

    foreach ($users as $user) {
      enqueue((int)$user['id'], $jobId);
    }

    $lastId = (int)$user['id'];
  }
}

function sendEmailNotification(int $days) {
  $jobId = match ($days) {
    1 => JOB_ID_SEND_BEFORE_1_DAYS,
    3 => JOB_ID_SEND_BEFORE_3_DAYS,
  };

  while (true) {
    $rows = dequeue($jobId);
    if (empty($rows)) {
      break;
    }

    foreach ($rows as $row) {
      $user = getUserById((int)$row['user_id']);
      if (!$user['valid']) {
        queueDone((int)$row['id']);
        continue;
      }

      $email    = (string)$user['email'];
      $username = (string)$user['username'];

      send_email((string)getSetting('email.from'), $email, "{$username}, your subscription is expiring soon");
      queueDone((int)$row['id']);
    }
  }
}
