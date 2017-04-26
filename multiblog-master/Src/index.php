<?php
include_once('Router.php');
include_once('Route.php');
include_once('RouterException.php');

$router = new App\Router($_GET['url']);

$router->get('/', function(){echo 'homepage';});
$router->get('/posts', function(){echo 'tous les articles';});
$router->get('/blog/:id', "article#show");

$router->post('/posts/:id', function($id){echo 'Poster pour l\'article '.$id.'<br/><pre>'.print_r($_POST, true).'</pre>';});

$router->run();

?>