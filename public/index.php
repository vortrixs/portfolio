<?php

namespace Vortrixs\Portfolio\Public;

$bootstrap = require_once('../src/App.php');

$app = call_user_func($bootstrap);

$app->run();