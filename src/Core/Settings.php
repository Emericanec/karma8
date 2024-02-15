<?php

namespace Karma8\Core;

function getSetting(string $name, mixed $default = null): mixed {
  require_once __DIR__ . "/../settings.php";

  global $_SETTINGS;

  $path = explode('.', $name);

  $isFound = true;
  $value = $_SETTINGS;
  foreach ($path as $pathPart) {
    if (!isset($value[$pathPart])) {
      $isFound = false;
      break;
    }

    $value = $value[$pathPart];
  }

  return $isFound ? $value : $default;
}