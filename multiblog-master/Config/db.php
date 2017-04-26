<?php
$instance = db::getInstance();
$bdd = $instance->getConnect();

class db 
{
	public static $_bdd = null;
	private $dbh;

	public static function getInstance()
	{

		if(is_null(self::$_bdd))
		{
			self::$_bdd = new db();  
		}

		return self::$_bdd;
	}



	#fonction de connnexion à la DB
	const ERROR_LOG_FILE="error.log";
	public function __construct()
	{
		$host = "";
		$username = "";
		$passwd = "";
		$port = "3306";
		$db = "blog";



		$dsn = "mysql:host=".$host.";dbname=".$db.";port=".$port;
		$user_name = $username;
		$password = $passwd;

		try
		{
			$this->dbh = new PDO($dsn, $user_name, $password);
		}
		catch (PDOException $e)
		{	
			echo "PDO ERROR: ".$e->getMessage()." storage in ".ERROR_LOG_FILE."\n";
			file_put_contents (ERROR_LOG_FILE, $e->getMessage());
			return false;
		}

	}
	public function getConnect()
	{
		return $this->dbh;
	}
}



?>
