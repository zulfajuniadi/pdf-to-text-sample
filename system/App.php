<?php

use \Slim\Slim;

class App extends Slim
{
    public function __construct() {
        parent::__construct([
            'templates.path' => '../views'
        ]);
    }
}