<?php
require_once __DIR__ . '/vendor/autoload.php';
$page = "blog";

$loader = new Twig_Loader_Filesystem(__DIR__ . '/Views'); // Dossier contenant les templates

//var_dump($loader);

$twig = new Twig_Environment($loader, array(
  'cache' => false,
  'debug' => true,
));

$twig->addExtension(new Twig_Extension_Debug());
 ?>