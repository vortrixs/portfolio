<?php

namespace Tests;

$bootstrap = require_once('src/App.php');

$app = call_user_func($bootstrap);

return $app;