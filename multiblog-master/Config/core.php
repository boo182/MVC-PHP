<?php
//include_once("../Models/Admin.php");
include_once("../Models/Blog.php");
//include_once("../Models/Comments.php");
include_once("../Models/Article.php");
include_once("../Models/User.php");
include_once("../Controllers/AppController.php");
include_once("../Controllers/userController.php");
include_once("../Controllers/adminController.php");
include_once("../Controllers/articleController.php");
include_once("../Controllers/categoryController.php");
include_once("../Src/Router.php");
include_once("../Src/session.php");

$router = new App\Router($_GET['url']);



?>