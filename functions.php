<?php
// Require Composer autoloader if installed on it's own
if (file_exists($composer = __DIR__ . '/vendor/autoload.php')) {
  require_once $composer;
}

// src includes
require_once 'lib/setup.php';
require_once 'lib/bootstrap.php';
