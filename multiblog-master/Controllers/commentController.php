<?php
require_once("../Models/Comments.php");


class commentController extends AppController
{

	public function __construct($nameclass)
	{
		$this->newclass = new $nameclass(); 
	}

	public function displayComment{

	}
}



?>