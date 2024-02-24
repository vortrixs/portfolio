<?php

namespace Tests\Support\Helper;

trait LocalhostServer {
    private const SERVER_URL = 'localhost:9999';

    private int $localhost_server_pid;

    public function _before() {
        if (is_callable('parent::_before')) {
            parent::_before();
        }

        $this->localhost_server_pid = exec('php -S ' . self::SERVER_URL . ' -t ' . codecept_root_dir('public') . '  > /dev/null 2>&1 & echo $!');

        while (false === @get_headers('http://' . self::SERVER_URL)) {
            // wait for server to start
        }

        if (!is_int($this->localhost_server_pid)) {
            throw new \Error('Localhost server could not start');
        }
     }

     public function _after() {
        if (is_callable('parent::_after')) {
            parent::_after();
        }

        if (!isset($this->localhost_server_pid)) {
            throw new \Error('Trying to shut down localhost server, but the process was not found');
        }

        exec('sudo kill -9 ' . $this->localhost_server_pid);
     }
}