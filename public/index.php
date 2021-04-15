<?php

use Meast\Router\Router;
use Symfony\Component\HttpFoundation\Request;

require '../vendor/autoload.php';

$request = Request::createFromGlobals();

$router = new Router($request);

$router->get('/', 'homepage', function () {
    echo '<h1>Page d\'accueil</h1>';
});

$router->run();