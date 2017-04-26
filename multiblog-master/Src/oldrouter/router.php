<?php

include_once('./../dispatcher.php');

class Router
{

protected $controller;
protected $method;
protected $param = null;


public function __construct()
{

$url = $_SERVER['REQUEST_URI'];
$tab = explode("/",$url);

$this->controller = $tab[3];
$this->method = $tab[4];
$this->param = $tab[5];

// var_dump($tab);

$verification = $this->verificationController();

$this->checkredirection($verification);

}

protected function verificationController()
{

$file = "../Controllers/" . $this->controller . "Controller.php";
$verification = is_file($file);


return $verification;

}

protected function checkredirection($verification)
{
	if($verification == true)
	{
		//echo "show dispatcher";
		$newdispatcher = new Dispatcher($this->controller, $this->method, $this->param);

	}
	else
	{
		echo "unknow controller";
		header("Location: Webroot/index.php");
	}

}

}

?>