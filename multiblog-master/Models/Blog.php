<?php
include_once("../Config/db.php");



class Blog
{

	
	public function addBlog($author_id, $name)
	{
		$query = "INSERT INTO blogs (name, author_id) VALUES(:name, :author_id)";
		$instance = db::getInstance();
		$bdd = $instance->getConnect();
		
		$search = $bdd->prepare($query);
		$search->bindparam(":name", $name, PDO::PARAM_STR);
		$search->bindparam(":author_id", $author_id, PDO::PARAM_INT);
		$res = $search->execute();
		return $res;
	}

	public function getBlog($author_id)
	{
		$instance = db::getInstance();
		$bdd = $instance->getConnect();
		$query = "SELECT * FROM blogs WHERE author_id = :author_id";
		$search = $bdd->prepare($query);
		$search->bindparam(":author_id", $author_id);
		$search->execute();
		$res = $search->fetchAll(PDO::FETCH_ASSOC);
		return $res;
	}

	public function updateTheme($blog_id)
	{
		$query = "UPDATE blogs set theme = :theme WHERE id = :blog_id";
		$instance = db::getInstance();
		$bdd = $instance->getConnect();
		
		$search = $bdd->prepare($query);
		$search->bindparam(":theme", $theme, PDO::PARAM_STR);
		$search->bindparam(":blog_id", $blog_id, PDO::PARAM_STR);
		$res = $search->execute();
		return $res;
		
	}

	public function deleteTheme($blog_id)
	{
		$query = "DELETE FROM blogs WHERE id = :blog_id";
		$instance = db::getInstance();
		$bdd = $instance->getConnect();
		$search = $bdd->prepare($query);
		$search->bindparam(":blog_id", $blog_id, PDO::PARAM_STR);
		$res = $search->execute();
		return $res;
		
	}





}
?>