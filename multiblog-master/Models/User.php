<?php
include_once("../Config/db.php");



class User
{
  private $db;

	public function __construct()
	{
        $instance = db::getInstance();
        $this->db = $instance->getConnect();
	}

//*-*-*-*-*-*-*-*-*-*METHODS GET INFO USER-*-*-*-*-*-*-*-*-*-*-*//

	public function getInfoUser($id,$namefield="")
	{
		$instance = db::getInstance();
		$bdd = $instance->getConnect();

		$query = "SELECT * FROM users WHERE id = :id";
		$search = $bdd->prepare($query);
	 	$search->execute(array(":id" => $id));
	 	$nbRes = $search->rowCount();
	 	
		if($namefield != "")
    {
			$res = $search->fetch();
      return $res[$namefield];
    }
    else if ($namefield == "")
    {
      $res = $search->fetchAll(PDO::FETCH_ASSOC);
      return $res;
    }
    else
    {
      return false;
    } 
	 	
	}



//*-*-*-*-*-*-*-*-METHOD REGISTER USER -*-*-*-*-*-*-*-*-*-*//

	public function registerUser($firstname, $lastname, $username, $email, $password, $admin = 3, $ban = 0)
	{
		$instance = db::getInstance();
		$bdd = $instance->getConnect();

		$password_hash = password_hash($password, PASSWORD_DEFAULT);

		$query = "INSERT INTO users (firstname, lastname, username, email, password, groupstatus, banstatus) VALUES (:firstname, :lastname, :username, :email, :password, :group, :banstatus )";
		// echo $firstname;
  //   echo $lastname;
  //   echo $username;
  //   echo $email;
  //   echo $password;
  //   echo $admin;
  //   echo $ban;

		$search = $bdd->prepare($query);

		$search->bindparam(":firstname", $firstname, PDO::PARAM_STR);
		$search->bindparam(":lastname", $lastname, PDO::PARAM_STR);
		$search->bindparam(":username", $username, PDO::PARAM_STR);
		$search->bindparam(":email", $email, PDO::PARAM_STR);
		$search->bindparam(":password", $password_hash, PDO::PARAM_STR);
		$search->bindparam(":group", $admin, PDO::PARAM_INT);
    $search->bindparam(":banstatus", $ban, PDO::PARAM_INT);
		$res = $search->execute();  

		if($res != 0)
			return true;
		else
			return false;
	}

//-*-*-*-*-*-*-*-*-* METHODS EDIT USER-*-*-*-*-*-*-*-*-*//	

	public function editUser($namefield, $value, $id)
	{
		$instance = db::getInstance();
		$bdd = $instance->getConnect();
		$query = "UPDATE users SET ".$namefield." = :value WHERE id = :id";
		$search = $bdd->prepare($query);
		$search->bindparam(":value", $value, PDO::PARAM_STR);
		$search->bindparam(":id", $id, PDO::PARAM_INT);
		$res = $search->execute();
		
		if($res != 0)
			return true;
		else
			return false;
	}

//-*-*-*-*-*-*-*-*-* METHODS DELETE USER-*-*-*-*-*-*-*-*-*//	

	public function deleteUser($id)
	{
		$instance = db::getInstance();
		$bdd = $instance->getConnect();
		$query = "DELETE FROM users WHERE id = :id";
		$search = $bdd->prepare($query);
		$search->bindparam(":id", $id, PDO::PARAM_INT);
		$res = $search->execute();
		
		if($res != 0)
			return true;
		else
			return false;

	}

//-*-*-*-*-*-*-*-*-* METHODS LOGIN USER-*-*-*-*-*-*-*-*-*//	

	public function login($username,$password,$is_cookie)
    {
       try
       {
          $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
          $stmt->execute(array(':username'=>$username));
          $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
          if($stmt->rowCount() > 0)
          {
             if(password_verify($password, $userRow['password']))
             {      
              if($is_cookie==1)
             	{
             		setcookie("user_id", $userRow['id'], time() + (86400 * 30), "/");	
             	}
             	else
             	{
                  $_SESSION['user_id'] = $userRow['id'];          		
             	}

                return true;
             }
             else
             {
                return false;
             }
          }
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       }
   }

//-*-*-*-*-*-*-*-*-* METHODS CHECK IF IS ADMIN-*-*-*-*-*-*-*-*-*//	

	public function isAdmin($user_id)
    {
       try
       {
          $stmt = $this->db->prepare("SELECT group FROM users WHERE id = :user_id LIMIT 1");
          $stmt->execute(array(':user_id'=>$user_id));
          $userRow=$stmt->fetch(PDO::FETCH_ASSOC);

          if($stmt->rowCount() > 0)
          	return $userRow["group"];
          
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       }
   }

//-*-*-*-*-*-*-*-*-* METHODS CHECK IF USER EXIST -*-*-*-*-*-*-*-*-*//	

   public function existUser($username,$email){

       try
       {
          $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email or username = :username LIMIT 1");
          $stmt->bindparam(":email", $email, PDO::PARAM_STR);
          $stmt->bindparam(":username", $username, PDO::PARAM_STR);
          $stmt->execute();
          $userRow=$stmt->fetch(PDO::FETCH_ASSOC);

          return $stmt->rowCount();     
          
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       }

   }


    public function getSelectUser($user_id)
   {

    try
    {
      $req = $this->db->prepare("SELECT first_name,last_name,id FROM users WHERE id <> :user_id ");
      $req->execute(array(':user_id'=> $user_id));
      $req->execute();

      if($req->rowCount() > 0)
      {
        while($userRow=$req->fetch())
        {
          echo "<option value='".$userRow['id']."' >".ucfirst($userRow['first_name'])." ".strtoupper($userRow['last_name'])."</option>";   
        }
      }
    }
    catch(PDOException $e)
    {
     echo $e->getMessage();
   }    
 }
 //-*-*-*-*-*-*-*-*-*METHOD SOCIAL NETWORK*-*-*-*-*-*-*-*-*-*//
  public function follow($follow_id, $follower_id)
  {
    $instance = db::getInstance();
    $bdd = $instance->getConnect();
    $query = "UPDATE followers SET  user_id = :follow_id, follower_id = :follower_id";
    $search = $bdd->prepare($query);
    $search->bindparam(":follow_id", $follow_id, PDO::PARAM_INT);
    $search->bindparam(":follower_id", $follower_id, PDO::PARAM_INT);

    $res = $search->execute();
    
    ($res != 0)? true : false;
      
  }

  public function getFollowers($id)
  {
    $instance = db::getInstance();
    $bdd = $instance->getConnect();
    $query = "SELECT users.username FROM users INNER JOIN followers ON users.id = followers.user_id GROUP BY followers.user_id";
    $search = $bdd->prepare($query);
    $search->bindparam(":follow_id", $follow_id, PDO::PARAM_INT);
    $search->bindparam(":follower_id", $follower_id, PDO::PARAM_INT);

    $res = $search->execute();
    
    ($res != 0)? true : false;
      
  }
  
  


//-*-*-*-*-*-*-*-*-*END METHOD SOCIAL NETWORK*-*-*-*-*-*-*-*-*-*//


};

