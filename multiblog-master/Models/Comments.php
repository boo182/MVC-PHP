<?php
include_once("../Config/db.php");



class Comments
{
	public function __construct()
	{

	}

//*-*-*-*-*-*-*-*-*-*METHODS GET COMMENT FROM ARTICLE -*-*-*-*-*-*-*-*-*-*-*//

	public function getComments($article_id)
	{
		//echo $article_id;
		$instance = db::getInstance();
		$bdd = $instance->getConnect();

		$query = "SELECT comments.*, users.username FROM comments 
		INNER JOIN users ON users.id = comments.author_id 
		WHERE article_id = :id";
		$query = $bdd->prepare($query);
		$query->bindparam(":id", $article_id);
	 	$query->execute();
	 	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	 	//var_dump($res);
	 	return $res;
	}


//*-*-*-*-*-*-*-*-METHOD ADD COMMENT -*-*-*-*-*-*-*-*-*-*//

	public function addComment($comment, $author_id, $article_id)
	{
		$instance = db::getInstance();
		$bdd = $instance->getConnect();


		$query = "INSERT INTO comments (comment, author_id, article_id, creation_date) VALUES(:comment, :author_id, :article_id, CURDATE())";
		
		$search = $bdd->prepare($query);
		$search->bindparam(":comment", $comment, PDO::PARAM_STR);
		$search->bindparam(":author_id", $author_id, PDO::PARAM_INT);
		$search->bindparam(":article_id", $article_id, PDO::PARAM_INT);
		$res = $search->execute();

		if($res != 0)
			return true;
		else
			return false;

	}

//-*-*-*-*-*-*-*-*-* METHODS EDIT COMMENT -*-*-*-*-*-*-*-*-*//	

	public function editComment($comment, $article_id, $author_id, $comment_id)
	{
		$instance = db::getInstance();
		$bdd = $instance->getConnect();
		$query = "UPDATE comments SET comment = :comment WHERE article_id = :id AND author_id = :author_id AND comment_id";
		$search = $bdd->prepare($query);
		$search->bindparam(":comment", $comment, PDO::PARAM_STR);
    $search->bindparam(":article_id", $id, PDO::PARAM_INT);
		$search->bindparam(":author_id", $id, PDO::PARAM_INT);
		$res = $search->execute();
		
		if($res != 0)
			return true;
		else
			return false;
	}

//-*-*-*-*-*-*-*-*-* METHODS DELETE COMMENT-*-*-*-*-*-*-*-*-*//	

	public function deleteComment($comment_id, $author_id)
	{
		$instance = db::getInstance();
		$bdd = $instance->getConnect();
		$query = "DELETE FROM comments WHERE id = :id AND author_id = :author_id";
		$search = $bdd->prepare($query);
    $search->bindparam(":id", $comment_id, PDO::PARAM_INT);
		$search->bindparam(":author_id", $author_id, PDO::PARAM_INT);
		$res = $search->execute();
		
		if($res != 0)
			return true;
		else
			return false;

	}
}
?>

