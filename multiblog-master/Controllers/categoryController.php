<?php
require_once("../Models/Category.php");


class categoryController extends AppController
{

	public function __construct($nameclass)
	{
		$this->newclass = new $nameclass(); 
	}
}



?>