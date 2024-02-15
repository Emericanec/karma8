<?php

namespace Karma8\Core;

function loadEnv(string $path): void {
  global $_ENV;

  $envContent = file_get_contents($path);
  $envLines   = explode("\n", $envContent);

  $_ENV = [];
  foreach ($envLines as $line) {
    $line = trim($line);
    if ($line && str_contains($line, '=') && !str_starts_with($line, '#')) {
      [$key, $value] = explode('=', $line, 2);
      $_ENV[$key] = $value;
    }
  }
}

function getEnvValue(string $key, $default = null): mixed {
  global $_ENV;

  return $_ENV[$key] ?? $default;
}
