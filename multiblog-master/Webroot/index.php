<?php
session_start();
include_once("../Config/db.php");
require '../vendor/autoload.php';
include_once("../Config/core.php");

if(isset($_SESSION['user_id']))
{
	$loadUser = new User();
	$ban = $loadUser->getInfoUser($_SESSION['user_id'],"banstatus");

	if($ban == 1)
	{
		echo "tu es banni adieu !";
		header("HTTP/1.0 404 TU ES BANNI ADIEU");
		exit;
	}
}

if(!isset($_SESSION['user_id']) && isset($_GET['registration']) && $_GET['registration']!=1)
{
	$loadUser->loginForm();
	echo "no session";
}

//echo $_SESSION['user_id'];

//-*-*-*-*-*-*-*-*-* HOMEPAGE *-*-*-*-*-*-*-*-*//	

$router->get('/home', "article#displayHome");
$router->post('/', "user#loginForm");
$router->get('/', "article#displayHome");

//-*-*-*-*-*-*-*-*-* DISPLAY BLOG USER-*-*-*-*-*-*-*-*-*//	

$router->get('/blog/:id', "article#displayBlog");

//-*-*-*-*-*-*-*-*-* DISPLAY ARTICLE OF THE BLOG -*-*-*-*-*-*-*-*-*//	

$router->get('/blog/article/:id', "article#displayArticle");

//-*-*-*-*-*-*-*-*-* DISPLAY ARTICLE FROM CATEGORY -*-*-*-*-*-*-*-*-*//	

$router->get('/category/:id', "article#displayCategory");

//-*-*-*-*-*-*-*-*-* ADD LIKE -*-*-*-*-*-*-*-*-*//	

$router->get('/like/:id', "article#like");

//-*-*-*-*-*-*-*-*-* DELETE USER -*-*-*-*-*-*-*-*-*//	

$router->get('/delete/:id', "user#deleteUser");

//-*-*-*-*-*-*-*-*-* LOGOUT USER -*-*-*-*-*-*-*-*-*//	

$router->get('logout', "user#logout");

//-*-*-*-*-*-*-*-*-* DISPLAY AND TREATMENT ARTICLE FORM -*-*-*-*-*-*-*-*-*//	

$router->get('add-article', "article#add_article");
$router->post('add-article', "article#add_article");

//-*-*-*-*-*-*-*-*-* DISPLAY AND TREATMENT REGISTRATION FORM -*-*-*-*-*-*-*-*-*//	

$router->get('registration', "user#register");
$router->post('registration', "user#register");

//-*-*-*-*-*-*-*-*-* DISPLAY AND TREATMENT EDIT PROFILE FORM -*-*-*-*-*-*-*-*-*//	

$router->get('edit-profile', "user#edit_profile");
$router->post('edit-profile', "user#edit_profile");

//-*-*-*-*-*-*-*-*-* DISPLAY AND TREATMENT LOGIN FORM -*-*-*-*-*-*-*-*-*//	

$router->get('login', "user#loginForm");
$router->post('login', "user#loginForm");


//-*-*-*-*-*-*-*-*-* LISTING USERS ADMIN -*-*-*-*-*-*-*-*-*//	

$router->get('listusers', "admin#displayUsers");

//-*-*-*-*-*-*-*-*-* LISTING CATEGORY ADMIN -*-*-*-*-*-*-*-*-*//	

$router->get('listcategory', "admin#displayCategories");

//-*-*-*-*-*-*-*-*-* LISTING CATEGORY ADMIN -*-*-*-*-*-*-*-*-*//	

$router->get('addcategory', "admin#add_category");
$router->post('addcategory', "admin#add_category");

//-*-*-*-*-*-*-*-*-* DELETE CATEGORY -*-*-*-*-*-*-*-*-*//	

$router->get('deletecategory/:id', "admin#deleteCat");

//-*-*-*-*-*-*-*-*-* EDIT CATEGORY ADMIN -*-*-*-*-*-*-*-*-*//	

$router->get('/editcategory/:id', "admin#edit_category");
$router->post('/editcategory/:id', "admin#edit_category");

//-*-*-*-*-*-*-*-*-* EDIT USERS ADMIN -*-*-*-*-*-*-*-*-*//	

$router->get('/edituser/:id', "admin#edit_profile");
$router->post('/edituser/:id', "admin#edit_profile");


//-*-*-*-*-*-*-*-*-* LISTING USERS ADMIN -*-*-*-*-*-*-*-*-*//	

$router->get('adduser', "admin#register");
$router->post('adduser', "admin#register");

//-*-*-*-*-*-*-*-*-* METHODS RUN THE ROUTING -*-*-*-*-*-*-*-*-*//	

$router->run();

?>