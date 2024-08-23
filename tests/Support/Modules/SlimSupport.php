<?php

namespace Tests\Support\Modules;

use DoclerLabs\CodeceptionSlimModule\Module\Slim;

class SlimSupport extends Slim
{
    public function getApp()
    {
        return $this->app;
    }
}
