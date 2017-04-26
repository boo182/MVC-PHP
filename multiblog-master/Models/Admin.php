<?php
include_once("../Config/db.php");



class Admin
{
	public function __construct()
	{

	}
//*-*-*-*-*-*-*-*-*-*-*-*METHODS ON USER*-*-*-*-*-*-*-*-*-*-*-//
	function getUsers()
	{
		$instance = db::getInstance();
		$bdd = $instance->getConnect();
		$query = "SELECT * FROM users";
		$search = $bdd->prepare($query);
	 	$search->execute();
	 	$nbRes = $search->rowCount();
	 	$res = $search->fetchAll(PDO::FETCH_ASSOC);
	 	if($nbRes != 0)
	 	{
	 		return $res;
	 	}
	 	else
	 	{
	 		return false;
	 	}
	}

	function getGroup()
	{
		$instance = db::getInstance();
		$bdd = $instance->getConnect();
		$query = "SELECT * FROM userGroup";
		$search = $bdd->prepare($query);
	 	$search->execute();
	 	$nbRes = $search->rowCount();
	 	$res = $search->fetchAll(PDO::FETCH_ASSOC);
	 	if($nbRes != 0)
	 	{
	 		return $res;
	 	}
	 	else
	 	{
	 		return false;
	 	}
	}

	function get_spec_user($username)
	{
		$instance = db::getInstance();
		$bdd = $instance->getConnect();
		$query = "SELECT * FROM users WHERE username = :username";
		$search->execute(array(":username" => $username));
		$search = $bdd->prepare($query);
	 	$search->execute();
	 	$nbRes = $search->rowCount();
	 	$res = $search->fetchAll(PDO::FETCH_ASSOC);
	 	if($nbRes != 0)
	 	{
	 		return $res;
	 	}
	 	else
	 	{
	 		return false;
	 	}
	}

	public function modify_user($id, $firstname, $lastname, $username, $email, $password, $admin, $avatar)
	{
		$hash = password_hash($password, PASSWORD_DEFAULT);
		$query = "UPDATE users SET firstname = :firstname, lastname = :lastname, username = :username, email = :email, hash = :hash, admin = :admin, avatar = :avatar WHERE id = :id";
		$instance = db::getInstance();
		$bdd = $instance->getConnect();
		
		$search = $bdd->prepare($query);
		$search = $bdd->prepare($query);
		$search->bindparam(":id", $id, PDO::PARAM_INT);
		$search->bindparam(":firstname", $firstname, PDO::PARAM_STR);
		$search->bindparam(":username", $username, PDO::PARAM_STR);
		$search->bindparam(":lastname", $lastname, PDO::PARAM_STR);
		$search->bindparam(":email", $email, PDO::PARAM_STR);
		$search->bindparam(":hash", $hash, PDO::PARAM_STR);
		$search->bindparam(":admin", $admin, PDO::PARAM_INT);
		$search->bindparam(":avatar", $avatar, PDO::PARAM_str);

		$res = $search->execute();
		var_dump($res);
		if($res != false)
		{
			return true;
		}
		else
		{
			return false;
		}

	}

	public function create_User($firstname, $lastname, $username, $email, $password, $admin)
	{
		echo "add";
		echo $admin;
		echo $firstname;
		echo $lastname;
		echo $username;
		echo $email;
		$instance = db::getInstance();
		$bdd = $instance->getConnect();

		$hash = password_hash($password, PASSWORD_DEFAULT);
		echo $hash;

		$query = "INSERT INTO users (firstname, lastname, username, email, password, groupstatus) VALUES (:firstname,:lastname, :username, :email, :password, :admin)";
		var_dump($query);
		$search = $bdd->prepare($query);
		$search->bindparam(":firstname", $firstname, PDO::PARAM_STR);
		$search->bindparam(":username", $username, PDO::PARAM_STR);
		$search->bindparam(":lastname", $lastname, PDO::PARAM_STR);
		$search->bindparam(":email", $email, PDO::PARAM_STR);
		$search->bindparam(":password", $hash, PDO::PARAM_STR);
		$search->bindparam(":admin", $admin, PDO::PARAM_INT);
		$res = $search->execute();
		var_dump($res);
		if($res != 0)
		{
			return true;
		}
		else
		{
			return false;
		}

	}

	public function delete_user($id)
	{
		$instance = db::getInstance();
		$bdd = $instance->getConnect();
		$query = "DELETE FROM users WHERE id = :id";
		$search = $bdd->prepare($query);
		$search->bindparam(":id", $id, PDO::PARAM_INT);
		$res = $search->execute();
		
		if($res != 0)
		{
			return true;
		}
		else
		{
			return false;
		}

	}
//*-*-*-*-*-*-*-*-*-*END OF ADMIN USERS METHOD*-*-*-*-*-*-*-*-*-*-*-*//

//*-*-*-*-*-*-*-*-*-*METHODS GET-*-*-*-*-*-*-*-*-*-*-*//
	public function get_articles()
	{
		$instance = db::getInstance();
		$bdd = $instance->getConnect();
		$query = "SELECT * FROM articles";
		$search = $bdd->prepare($query);
	 	$search->execute();
	 	$nbRes = $search->rowCount();
	 	$res = $search->fetchAll(PDO::FETCH_ASSOC);
	 	if($nbRes != 0)
	 	{
	 		return $res;
	 	}
	 	else
	 	{
	 		return false;
	 	}
	 	
	}
	public function get_spec_article($id, $namefield)
	{
		$instance = db::getInstance();
		$bdd = $instance->getConnect();
		$query = "SELECT * FROM articles WHERE id = :id";
		$search = $bdd->prepare($query);
		$search->execute(array(":id" => $id));
		$nbRes = $search->rowCount();
		$res = $search->fetch(PDO::FETCH_ASSOC);
		var_dump($res[$namefield]);

		if($nbRes != 0)
	 	{
	 		return $res[$namefield];
	 	}
	 	else
	 	{
	 		return false;
	 	}

	}
//-*-*-*-*-*-*-*-*END OF METHOD GET *-*-*-*-*-*-*-*-*-*//

//*-*-*-*-*-*-*-*-METHOD ARTICLE MODIF-*-*-*-*-*-*-*-*-*-*//

	public function post_article($title, $content, $category_id, $image=null)
	{
		$query = "INSERT INTO articles (title, content, category_id, image, creation_date, edition_date) VALUES(:title, :content, :category_id, :image, CURDATE(), CURDATE() )";
		$instance = db::getInstance();
		$bdd = $instance->getConnect();
		
		$search = $bdd->prepare($query);
		$search->bindparam(":title", $title, PDO::PARAM_STR);
		$search->bindparam(":content", $content, PDO::PARAM_STR);
		$search->bindparam(":category_id", $category_id, PDO::PARAM_STR);
		$search->bindparam(":image", $image, PDO::PARAM_STR);

		$res = $search->execute();
		var_dump($res);
		if($res != false)
		{
			return true;
		}
		else
		{
			return false;
		}

	}

	public function put_article($id, $title, $content, $category_id, $image)
	{
		$instance = db::getInstance();
		$bdd = $instance->getConnect();
		$query = "UPDATE tasks SET title = :title, content = :content, edition_date = CURDATE(), image = :image WHERE id = :id";
		$search = $bdd->prepare($query);
		$search->bindparam(":title", $title, PDO::PARAM_STR);
		$search->bindparam(":content", $content, PDO::PARAM_STR);
		$search->bindparam(":image", $image, PDO::PARAM_STR);
		$search->bindparam(":id", $id, PDO::PARAM_INT);
		$res = $search->execute();
		
		if($res != 0)
		{
			return true;
		}
		else
		{
			return false;
		}

	}
	public function delete_article($id)
	{
		$instance = db::getInstance();
		$bdd = $instance->getConnect();
		$query = "DELETE FROM article WHERE id = :id";
		$search = $bdd->prepare($query);
		$search->bindparam(":id", $id, PDO::PARAM_INT);
		$res = $search->execute();
		
		if($res != 0)
		{
			return true;
		}
		else
		{
			return false;
		}

	}

//-*-*-*-*-*-*-*-*-*END METHODS ARTICLE MODIF-*-*-*-*-*-*-*-*-*//	


}
?>