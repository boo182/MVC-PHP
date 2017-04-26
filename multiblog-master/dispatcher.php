<?php

class Dispatcher
{

protected $controller;
protected $method;
protected $param;
protected $objet;
protected $model;

public function __construct($controller,$method,$param)
{
	//echo "construct dispatcher";

$this->controller = $controller;
$this->method = $method;
$this->param = $param;

$verification = $this->verificationMethod();

$this->execution($verification);


}

protected function verificationMethod()
{
	
	
	$controller = $this->controller;

	// $controller = explode(".", $controller);

	// var_dump($controller[0]);
	$controller = $controller."Controller";

	switch ($controller) {

		case 'articleController':
			$this->model = new Articles();
		break;

		case 'userController':
			$this->model = new User();
		break;
		
		default:
			# code...
			break;
	}


	$newcontroller = new $controller();
	$newcontroller->loadModel($this->model);

	$this->objet = $newcontroller;

	$verification = method_exists($newcontroller, $this->method);

	return $verification;

}

protected function execution($verification)
{
	if($verification == true)
	{
		$method = $this->method;
		$this->objet->$method($this->param);
	}
	else
	{
		echo "not a good method";
		header('index.php');
	}
}



}
?>