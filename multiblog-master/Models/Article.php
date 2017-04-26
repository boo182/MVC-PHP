<?php
include_once("../Config/db.php");



class Article
{
	public function __construct()
	{

	}

//*-*-*-*-*-*-*-*-*-*METHODS GET-*-*-*-*-*-*-*-*-*-*-*//
	public function get_articles($blog_id)
	{
		$instance = db::getInstance();
		$bdd = $instance->getConnect();
		$query = "SELECT articles.* FROM articles 
		INNER JOIN blogs ON blogs.id = articles.blog_id
		INNER JOIN users ON users.id = blogs.author_id 
		WHERE articles.blog_id = :blog_id";
		$search = $bdd->prepare($query);
		$search->execute(array(":blog_id" => $blog_id));
	 	$search->execute();
	 	$nbRes = $search->rowCount();
	 	$res = $search->fetchAll(PDO::FETCH_ASSOC);
	 	return $res;
	}

	public function getArticlesFromCategory($category_id)
	{
		$instance = db::getInstance();
		$bdd = $instance->getConnect();
		$query = "SELECT articles.*, users.username, users.avatar FROM articles 
		INNER JOIN blogs ON blogs.id = articles.blog_id
		INNER JOIN users ON users.id = blogs.author_id 
		INNER JOIN categories ON categories.id = articles.category_id
		WHERE categories.id = :category_id";
		$search = $bdd->prepare($query);
		$search->execute(array(":category_id" => $category_id));
	 	$search->execute();
	 	$nbRes = $search->rowCount();
	 	$res = $search->fetchAll(PDO::FETCH_ASSOC);
	 	return $res;
	}

	public function get_bloginfo($blog_id)
	{
		$instance = db::getInstance();
		$bdd = $instance->getConnect();
		$query = "SELECT blogs.name as blog_name, users.* FROM blogs
		INNER JOIN users ON users.id = blogs.author_id 
		WHERE blogs.id = :blog_id";
		$search = $bdd->prepare($query);
		$search->execute(array(":blog_id" => $blog_id));
	 	$search->execute();
	 	$nbRes = $search->rowCount();
	 	$res = $search->fetchAll(PDO::FETCH_ASSOC);
	 	return $res;
	}

	public function random_articles($rand)
	{
		$instance = db::getInstance();
		$bdd = $instance->getConnect();

		$query = "SELECT articles.image, articles.category_id, articles.blog_id, articles.tags, articles.likes, articles.id, users.username, users.avatar FROM articles
		INNER JOIN blogs on blogs.id = articles.blog_id
		INNER JOIN users on users.id = blogs.author_id 
		ORDER BY id DESC";
		$search = $bdd->prepare($query);
		$search->execute(array(":rand" => $rand));
		$res = $search->fetchAll(PDO::FETCH_ASSOC);
		//var_dump($res);
		return $res;		
	}
	
	public function get_spec_article($id)
	{
		$instance = db::getInstance();
		$bdd = $instance->getConnect();
		$query = "SELECT articles.*, comments.* FROM articles 
		INNER JOIN comments on comments.article_id = articles.id
		WHERE articles.id = :id";
		$search = $bdd->prepare($query);
		$search->execute(array(":id" => $id));
		$nbRes = $search->rowCount();
		$res = $search->fetch(PDO::FETCH_ASSOC);
		//var_dump($res);
		return $res;

	}
//-*-*-*-*-*-*-*-*END OF METHOD GET *-*-*-*-*-*-*-*-*-*//

//*-*-*-*-*-*-*-*-METHOD TASK MODIF-*-*-*-*-*-*-*-*-*-*//

	public function post_article($title, $content, $blog_id, $image, $tags, $category_id)
	{
		echo "insert";
		
		$query = "INSERT INTO articles (title, content, blog_id, image, creation_date, edition_date, tags, category_id) VALUES(:title, :content, :blog_id, :image, CURDATE(), CURDATE(), :tags, :category_id )";
		$instance = db::getInstance();
		$bdd = $instance->getConnect();
		
		$search = $bdd->prepare($query);
		$search->bindparam(":title", $title, PDO::PARAM_STR);
		$search->bindparam(":content", $content, PDO::PARAM_STR);
		$search->bindparam(":blog_id", $blog_id, PDO::PARAM_INT);
		$search->bindparam(":category_id", $category_id, PDO::PARAM_INT);
		$search->bindparam(":image", $image, PDO::PARAM_STR);
		$search->bindparam(":tags", $tags, PDO::PARAM_STR);

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

	public function put_article($id, $title, $content, $blog_id, $image)
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

//-*-*-*-*-*-*-*-*-*END METHODS TASK MODIF-*-*-*-*-*-*-*-*-*//	

//-*-*-*-*-*-*-*-*-*METHOD SOCIAL NETWORK*-*-*-*-*-*-*-*-*-*//
	public function like($id)
	{
		$instance = db::getInstance();
		$bdd = $instance->getConnect();
		$query = "UPDATE articles SET likes = likes + 1 WHERE id = :id";
		$search = $bdd->prepare($query);
		$search->bindparam(":id", $id, PDO::PARAM_INT);
		$res = $search->execute();
		
		return $res;
			
	}



//-*-*-*-*-*-*-*-*-*END METHOD SOCIAL NETWORK*-*-*-*-*-*-*-*-*-*//

}
?>