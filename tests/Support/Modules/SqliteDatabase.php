<?php

namespace Tests\Support\Modules;

use Codeception\Module;
use Codeception\TestInterface;

class SqliteDatabase extends Module
{
    public function _before(TestInterface $test)
    {
        $path = codecept_output_dir($this->config['filename']);

        if (file_exists($path)) {
            unlink($path);
        }

        file_put_contents($path, null, LOCK_EX);

        parent::_before($test);
    }

    public function getDatabaseFile() {
        return codecept_output_dir($this->config['filename']);
    }
}
