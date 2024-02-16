<?php

namespace Karma8\Email;

// internal check if the email is clearly not valid then we don’t want to spend money on checking it
function check_email_internal(string $email): bool {
  return (bool)filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * price: 1/call
 * @param string $email
 * @return int
 */
function check_email(string $email): int {
  if (!check_email_internal($email)) {
    return 0;
  }

  sleep(mt_rand(1, 2));

  return mt_rand(0, 1);
}

function send_email(string $from, string $to, string $text): bool {
  sleep(mt_rand(1, 10));

  return mt_rand(0, 100) > 5; // even if email is valid can return false (example: no free space on email account)
}
