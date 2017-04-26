<?php

class Session extends AppController{

	private $session;

	public function __construct($session=""){

		$this->session = $session;
		$this->load($this->session);
		$this->write($this->session);

		if($session=="")
		{
			$tab2[0] = "User";
	        $tab2[1] = "login";
	        $this->render($tab2);
		}
	}

	static public function read()
	{
		return $this->session;
	}

	static public function write($session)
	{
		$_SESSION['user_id'] = $session;		
	}

	static public function delete($session)
	{
		if(isset($session))
		{
        	unset($session);
		}		
	}

	static public function destroy()
	{
		if(isset($session))
		{
			session_destroy();
		}		
	}

	static public function load($session)
	{
		//session_start();
	}
}

// read, write, delete, destroy and load

?>

