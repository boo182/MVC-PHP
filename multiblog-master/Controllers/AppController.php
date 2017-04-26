<?php

// include_once('./../Models/User.php');


class AppController
{

	public function __construct()
	{

	}

	protected $model;
	protected $newclass;

	public function loadModel($model)
	{
		$this->model = $model;
	}

	public function render($file=null,...$data)
	{

		include_once('./../new_twig.php');
		$string = "/" . $file[0] . "/" . $file[1] . ".twig";

		// echo "<pre>";
		// print_r($data[0][1]);
		// echo "</pre>";

		echo $twig->render($string,array('data' => $data));

	}

	public function beforeRender()
	{

	}

	protected function redirect($param)
	{

	}


}

?>