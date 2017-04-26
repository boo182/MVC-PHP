<?php
include_once("../Config/db.php");



class userGroup
{
  private $db;

	public function __construct()
	{
        $instance = db::getInstance();
        $this->db = $instance->getConnect();
	}

  public function read($user_id)
  {
    $query = "SELECT group FROM users WHERE id = :user_id";
    $req = $this->db->prepare($query)
    $req->bindparam(":user_id", $user_id, PDO::PARAM_INT);
    $req->execute();
    return $res;
  }


};

