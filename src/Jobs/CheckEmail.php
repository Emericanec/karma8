<?php

namespace Karma8\Jobs;

use function Karma8\Database\queueDone;
use function Karma8\Database\dequeue;
use function Karma8\Database\enqueue;
use function Karma8\Database\getUserById;
use function Karma8\Database\getUsersForEmailCheck;
use function Karma8\Database\updateUserCheckedById;
use function Karma8\Email\check_email;

function enqueueUserEmailsForCheck(): void {
  // 4 days ahead
  $validTsFrom = strtotime(date('Y-m-d 00:00:00', strtotime("+4 days")));
  $validTsTo   = strtotime(date('Y-m-d 23:59:59', strtotime("+4 days")));
  $lastId = 0;
  while (true) {
    $users = getUsersForEmailCheck($validTsFrom, $validTsTo, $lastId);
    if (empty($users)) {
      break;
    }

    foreach ($users as $user) {
      enqueue((int)$user['id'], JOB_ID_CHECK_EMAIL);
    }

    $lastId = (int)$user['id'];
  }
}

function checkUsersEmail(): void {
  while (true) {
    $rows = dequeue(JOB_ID_CHECK_EMAIL);
    if (empty($rows)) {
      break;
    }

    foreach ($rows as $row) {
      $user = getUserById((int)$row['user_id']);
      if (empty($user) || $user['checked']) {
        queueDone((int)$row['id']);
        continue;
      }

      $email = (string)$user['email'];

      $isValid = check_email($email);
      updateUserCheckedById((int)$user['id'], (bool)$isValid);
      queueDone((int)$row['id']);
    }
  }
}
