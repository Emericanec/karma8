<?php

namespace Karma8\Database;

define('QUEUE_STATUS_NEW', 0);
define('QUEUE_STATUS_IN_PROGRESS', 1);

define('JOB_ID_CHECK_EMAIL', 1);
define('JOB_ID_SEND_BEFORE_3_DAYS', 2);
define('JOB_ID_SEND_BEFORE_1_DAYS', 3);

function dequeue(int $jobId, $limit = 1000): array {
  $connection = getConnection();

  $selectQuery = "SELECT * FROM queue WHERE job_id = ? AND status = ? LIMIT {$limit} FOR UPDATE;";
  $updateQuery = "UPDATE queue SET status = ? WHERE job_id = ? AND status = ? LIMIT {$limit};";

  mysqli_begin_transaction($connection);
  $result = mysqli_execute_query($connection, $selectQuery, [
    $jobId,
    QUEUE_STATUS_NEW,
  ]);
  mysqli_execute_query($connection, $updateQuery, [
    QUEUE_STATUS_IN_PROGRESS,
    $jobId,
    QUEUE_STATUS_NEW,
  ]);
  mysqli_commit($connection);

  if (!$result) {
    return [];
  }

  $rows = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }

  return $rows;
}

function enqueue(int $userId, int $jobId): bool {
  $connection = getConnection();

  $query = "INSERT IGNORE INTO queue (user_id, job_id) VALUES (?, ?)";

  return (bool)mysqli_execute_query($connection, $query, [$userId, $jobId]);
}

function queueDone(int $queueId): bool {
  $connection = getConnection();

  $query = "DELETE FROM queue WHERE id = ?";

  return (bool)mysqli_execute_query($connection, $query, [$queueId]);
}
