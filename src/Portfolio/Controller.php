<?php

namespace Vortrixs\Portfolio\Portfolio;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Controller {
    public function __construct(private Model $model, private View $view) {

    }

    public function __invoke(Response $response) {
        var_dump($this->model::class, $this->view::class);

        return $response;
    }
}