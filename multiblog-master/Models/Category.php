<?php
include_once("../Config/db.php");



class Category
{
	public function __construct()
	{

	}

//*-*-*-*-*-*-*-*-*-*METHODS GET-*-*-*-*-*-*-*-*-*-*-*//
	public function getCategories()
	{
		$instance = db::getInstance();
		$bdd = $instance->getConnect();
		$query = "SELECT * FROM categories";
		$search = $bdd->prepare($query);
	 	$search->execute();
	 	$res = $search->fetchAll(PDO::FETCH_ASSOC);
	 	return $res;
	}

	public function getOneCategory($id)
	{
		$instance = db::getInstance();
		$bdd = $instance->getConnect();
		$query = "SELECT * FROM categories WHERE id = :id";
		$search = $bdd->prepare($query);
		$search->bindparam(":id", $id, PDO::PARAM_INT);
	 	$search->execute();
	 	$res = $search->fetchAll(PDO::FETCH_ASSOC);
	 	return $res;
	}

//-*-*-*-*-*-*-*-*-* METHODS EDIT CATEGORIES -*-*-*-*-*-*-*-*-*//	

	public function editCategories($namefield, $value, $id)
	{
		echo "edit";
		$instance = db::getInstance();
		$bdd = $instance->getConnect();
		$query = "UPDATE categories SET ".$namefield." = :value WHERE id = :id";
		$search = $bdd->prepare($query);
		$search->bindparam(":value", $value, PDO::PARAM_STR);
		$search->bindparam(":id", $id, PDO::PARAM_INT);
		$res = $search->execute();
		
		if($res != 0)
			return true;
		else
			return false;
	}

	public function addCategories($name)
	{
		echo "add";
		$instance = db::getInstance();
		$bdd = $instance->getConnect();
		$query = "INSERT INTO categories (name) VALUES (:name)";
		$search = $bdd->prepare($query);
		$search->bindparam(":name", $name, PDO::PARAM_STR);
		$res = $search->execute();
		
		if($res != 0)
			return true;
		else
			return false;
	}

//-*-*-*-*-*-*-*-*-* METHODS DELETE CATEGORIES -*-*-*-*-*-*-*-*-*//	

	public function deleteCategories($id)
	{
		echo "delete";
		$instance = db::getInstance();
		$bdd = $instance->getConnect();
		$query = "DELETE FROM categories WHERE id = :id";
		$search = $bdd->prepare($query);
		$search->bindparam(":id", $id, PDO::PARAM_INT);
		$res = $search->execute();
		
		if($res != 0)
			return true;
		else
			return false;

	}
}
?>