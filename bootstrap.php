<?php

require_once __DIR__ . '/dbconn.php';

require_once __DIR__ . '/forms.php';

function redirect ($location, $code = 302) {
  header('Location: ' . $location);
  http_response_code($code);
  die();
}