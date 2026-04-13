<?php
use Slim\Factory\AppFactory;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/controllers/AlunniController.php';

$app = AppFactory::create();
 
$app->get('/alunni', "AlunniController:index");
$app->get('/alunni/{id}', "AlunniController:coca");
$app->post('/alunni', "AlunniController:ina");
$app->put('/alunni/{id}', "AlunniController:mara");
$app->delete('/alunni/{id}', "AlunniController:dona");

$app->run();
