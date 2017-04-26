<?php
require_once("../Models/User.php");
require_once("../Models/Admin.php");
//require_once("../Models/Blog.php");
require_once("../Models/Comments.php");
require_once("../Models/Admin.php");



class userController extends AppController
{

  public function __construct()
  {
    $this->newclass = new User(); 
  }

	public function secure_input($data, $require)
    {
    	if($require == "on" && $data != "")
    	{
    		$data = trim($data);
 			$data = stripslashes($data);
 			$data = htmlspecialchars($data);
 			return $data;
    	}
    	else
    	{
    		return false;
    	}
 		
	}

	public function register()
	{
		if($_POST)
		{
			$firstname = $_POST['firstname']; 
			$lastname = $_POST['lastname']; 
			$username = $_POST['username']; 
			$email = $_POST['email']; 
			$password = $_POST['password']; 
			$pass_conf = $_POST['password_confirmation']; 	
			$error = "";
			$flag = 0;

			if(($firstname < 3 || $firstname > 20) && $this->secure_input($firstname, "on") == false)
			{
				$flag = 1;
				$error .= "Your first name must have at least 3 letters<br/>";
			}
			if(($lastname < 3 || $lastname > 20) && $this->secure_input($lastname, "on") == false)
			{
				$flag = 1;
				$error .= "Your last name must have at least 3 letters<br/>";

			}
			if(($username < 3 || $username > 20) && $this->secure_input($username, "on") == false)
			{
				$flag = 1;
				$error .= "Invalid username<br>";

			}
			if((!preg_match("#^[\w.-]+@[\w.-]+\.[a-z]{2,6}$#i", $email)))
			{
				$flag = 1;
				$error .= "Invalid email<br/>";
			}
			if($this->secure_input($password, "on") == false || $password != $pass_conf)
			{
				$flag = 1;
				$error .= "Invalid password<br/>";
			}
			
			if($flag == 0)
			{
				if($this->newclass->existUser($username, $email) > 0)
				{
					$flag = 1;
					$error .= "The username or email already exist !<br/>";
					$tab2[0] = "User";
		       	 	$tab2[1] = "register";
		        	$this->render($tab2,$error);
				}
				else
				{
					echo "add";
					$this->newclass->registerUser($firstname, $lastname, $username, $email, $password);
					$error = "Registration Complete !";
					$tab2[0] = "User";
			        $tab2[1] = "login";
			        $this->render($tab2,$error);
				}

			}
			else
			{
				$tab2[0] = "User";
		        $tab2[1] = "register";
		        $this->render($tab2,$error);
			}

       	}else{

			$tab2[0] = "User";
	        $tab2[1] = "register";
	        $this->render($tab2);
       	}

	}

	public function edit_profile()
	{
		$groupUser = $this->newclass->getInfoUser($_SESSION['user_id'],"groupstatus");

		if($_POST)
		{
			$firstname = $_POST['firstname']; 
			$lastname = $_POST['lastname']; 
			$username = $_POST['username']; 
			$email = $_POST['email']; 
			$avatar = $_POST['avatar']; 	
			$error = "";
			$flag = 0;

			if(($firstname < 3 || $firstname > 20) && $this->secure_input($firstname, "on") == false)
			{
				$flag = 1;
				$error .= "Your first name must have at least 3 letters<br/>";
			}
			if(($lastname < 3 || $lastname > 20) && $this->secure_input($lastname, "on") == false)
			{
				$flag = 1;
				$error .= "Your last name must have at least 3 letters<br/>";

			}
			if(($username < 3 || $username > 20) && $this->secure_input($username, "on") == false)
			{
				$flag = 1;
				$error .= "Invalid username<br>";

			}
			if((!preg_match("#^[\w.-]+@[\w.-]+\.[a-z]{2,6}$#i", $email)))
			{
				$flag = 1;
				$error .= "Invalid email<br/>";
			}
			
			if($flag == 0)
			{
					$id = $_SESSION['user_id'];
					$this->newclass->editUser("firstname", $firstname, $id);
					$this->newclass->editUser("lastname", $lastname, $id);
					$this->newclass->editUser("username", $username, $id);
					$this->newclass->editUser("email", $email, $id);
					$this->newclass->editUser("avatar", $avatar, $id);
					$data = $this->newclass->getInfoUser($_SESSION['user_id']);
					$tab2[0] = "User";
			        $tab2[1] = "edit_profile";
			        $this->render($tab2,$data);
			}
			else
			{
				$tab2[0] = "User";
		        $tab2[1] = "edit_profile";
		        $this->render($tab2,$error);
			}

       	}else{

			if(isset($_SESSION['user_id']))
			{
				$data = $this->newclass->getInfoUser($_SESSION['user_id']);
				$tab2[0] = "User";
		        $tab2[1] = "edit_profile";
		        $this->render($tab2,[$data,$groupUser]);
			}
       	}

	}

	public function is_loggedin()
   {
      if(isset($_SESSION['user_id']) || isset($_COOKIE['user_id']))
      {
         return true;
      }
   }
 
   public function redirect($url)
   {
       header("Location: $url");
   }	
 
   public function logout()
   {
        
   		if(isset($_SESSION['user_id']))
   		{
   			session_destroy();
        	unset($_SESSION['user_id']);
   		}


   		if(isset($_COOKIE['user_id']))
   		{
   			setcookie('user_id', null, -1, '/');
   		}

        return true;
   }


	public function loginForm()
	{

		if(!empty($_POST))
		{
			$username = $_POST['username'];
			$password = $_POST['password'];
			$is_cookie = $_POST['is_cookie'];

			if($this->secure_input($username, "on")==false && $this->secure_input($password, "on")==false)
			{
				$error = "Invalid username and/or password";
				$tab2[0] = "User";
	        	$tab2[1] = "login";
	        	$this->render($tab2,$error);
				return false;
			}
			else
			{			
				if($this->newclass->login($username,$password,$is_cookie)==true)
				{
					$tab2[0] = "homepage";
		        	$tab2[1] = "index";
		        	$this->render($tab2);
				}
				else
				{
					$error = "Invalid username and/or password";
					$tab2[0] = "User";
		        	$tab2[1] = "login";
		        	$this->render($tab2,$error);
				}
			}
		}
		else
		{
			$tab2[0] = "User";
        	$tab2[1] = "login";
        	$this->render($tab2);			
		}
	}


	public function displayProfile($user_id)
    {
        $data = $this->model->getInfoUser($user_id);
        $tab2[0] = "Views";
        $tab2[1] = "template";
        $this->render($tab2,$data);
    }

	public function deleteUser($user_id)
    {
		if(isset($_SESSION['user_id']))
		{
			if($_SESSION['user_id'] == $user_id)
			{
				echo "your account has been deleted";
				session_destroy();
        		unset($_SESSION['user_id']);
		     	$this->newclass->deleteUser($user_id);
		     	header('Location: ../');
			}
		}
    }
}

?>