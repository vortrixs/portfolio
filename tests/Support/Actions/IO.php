<?php

namespace Tests\Support\Actions;

trait IO
{
    public function createFile(string  $path, mixed $data = null)
    {
        if (file_exists($path)) {
            return;
        }

        file_put_contents($path, $data, LOCK_EX);
    }

    public function deleteFile($path)
    {
        if (!file_exists($path))
        {
            return;
        }

        unlink($path);
    }
}
