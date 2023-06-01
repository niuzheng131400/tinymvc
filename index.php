<?php

use core\App;

define('APP_NAME', basename(__FILE__, '.php'));
require __DIR__ . '/core/App.php';
App::run();