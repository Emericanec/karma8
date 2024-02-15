<?php

namespace Karma8\Database;

function getUsersForEmailCheck(int $validTsFrom, int $validTsTo, $fromId = 0): array {
  $connection = getConnection();

  $query = "
    SELECT id, email
    FROM users 
    WHERE id > ? AND validts >= ? AND validts <= ? AND checked = 0 AND confirmed = 0
    LIMIT 1000
  ";

  $result = mysqli_execute_query($connection, $query, [
    $fromId,
    $validTsFrom,
    $validTsTo,
  ]);

  $rows = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }

  return $rows;
}

function getUserForNotification(int $validTsFrom, int $validTsTo, $fromUserId = 0): array {
  $connection = getConnection();

  // we think that when user confirmed email "valid" field will change to 1 too
  $query = "
    SELECT id, email
    FROM users 
    WHERE id > ? AND validts >= ? AND validts <= ? AND valid = 1
    LIMIT 1000
  ";

  $result = mysqli_execute_query($connection, $query, [
    $fromUserId,
    $validTsFrom,
    $validTsTo,
  ]);

  $rows = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }

  return $rows;
}

function updateUserCheckedById(int $id, bool $isValid): bool {
  $connection = getConnection();

  $query = "UPDATE users SET checked = 1, valid = ? WHERE id = ?";

  return (bool)mysqli_execute_query($connection, $query, [$isValid ? 1 : 0, $id]);
}

function getUserById(int $id): ?array {
  $connection = getConnection();

  $query = "SELECT * FROM users WHERE id = ?";

  $result = mysqli_execute_query($connection, $query, [$id]);

  if (!$result) {
    return null;
  }

  return (array)mysqli_fetch_assoc($result);
}
