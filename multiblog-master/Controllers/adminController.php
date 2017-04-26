<?php
require_once("../Models/Admin.php");


class adminController extends AppController
{
	private $groupUser;
	private $loadUser;

	public function __construct()
	{
		$this->newclass = new Admin(); 
		$this->loadUser = new User();
		$this->loadCategory = new Category();
		if(isset($_SESSION['user_id']))
		{
			$this->groupUser = $this->loadUser->getInfoUser($_SESSION['user_id'],"groupstatus");
		}
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

	public function displayCategories(){

	if($this->groupUser==1)
	{
		$dataCat = $this->loadCategory->getCategories();
		$tab2[0] = "admin";
        $tab2[1] = "listcategories";

        $this->render($tab2,$dataCat);
	}
	
	}

	public function edit_category($id){
	if($_POST)
	{

		$this->loadCategory->editCategories("name", $_POST['category'], $id);
		$tab2[0] = "admin";
	    $tab2[1] = "listcategories";
	    $this->render($tab2);
	}
	else
		{
			$dataCat = $this->loadCategory->getOneCategory($id);
			$tab2[0] = "admin";
	        $tab2[1] = "editcategories";
	        $this->render($tab2,$dataCat);
		}
	}

	public function add_category(){
	if($_POST)
	{

		$this->loadCategory->addCategories($_POST['category']);
		$tab2[0] = "admin";
	    $tab2[1] = "listcategories";
	    $this->render($tab2);
	}
	else
		{
			$tab2[0] = "admin";
	        $tab2[1] = "addcategory";
	        $this->render($tab2);
		}
	}

	public function displayUsers(){

	if($this->groupUser==1)
	{
		$dataUser = $this->newclass->getUsers();
		$tab2[0] = "admin";
        $tab2[1] = "listuser";

        $this->render($tab2,$dataUser);
	}
	
	}

	public function deleteCat($id){
		echo "delete";
		$this->loadCategory->deleteCategories($id);
		$tab2[0] = "admin";
	    $tab2[1] = "listcategories";
	    $this->render($tab2);
	}

	public function register()
	{
		$dataGroup = $this->newclass->getGroup();
		if($_POST)
		{
			$firstname = $_POST['firstname']; 
			$lastname = $_POST['lastname']; 
			$username = $_POST['username']; 
			$email = $_POST['email']; 
			$password = $_POST['password'];
			$level = $_POST['level'];
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
				if($this->loadUser->existUser($username, $email) > 0)
				{
					$flag = 1;
					$error .= "The username or email already exist !<br/>";
					$tab2[0] = "admin";
		       	 	$tab2[1] = "register";
		        	$this->render($tab2,$error);
				}
				else
				{
					echo "add";
					$this->newclass->create_User($firstname, $lastname, $username, $email, $password, $level);
					$error = "Registration Complete !";
					$tab2[0] = "admin";
			        $tab2[1] = "listuser";
			        $this->render($tab2,$error);
				}

			}
			else
			{
				$tab2[0] = "admin";
		        $tab2[1] = "register";
		        $this->render($tab2,$error);
			}

       	}else{

			$tab2[0] = "admin";
	        $tab2[1] = "register";
	        $this->render($tab2,$dataGroup);
       	}

	}


	public function edit_profile($id)
	{
		$groupUser = $this->loadUser->getInfoUser($id,"groupstatus");
		$dataGroup = $this->newclass->getGroup();
		if($_POST)
		{
			$firstname = $_POST['firstname']; 
			$lastname = $_POST['lastname']; 
			$username = $_POST['username']; 
			$email = $_POST['email']; 
			$avatar = $_POST['avatar']; 
			$level = $_POST['level'];	
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
					$this->loadUser->editUser("firstname", $firstname, $id);
					$this->loadUser->editUser("lastname", $lastname, $id);
					$this->loadUser->editUser("username", $username, $id);
					$this->loadUser->editUser("email", $email, $id);
					$this->loadUser->editUser("avatar", $avatar, $id);
					$this->loadUser->editUser("groupstatus", $level, $id);
					$data = $this->loadUser->getInfoUser($id);
					$tab2[0] = "admin";
			        $tab2[1] = "listuser";
			        $this->render($tab2,$data);
			}
			else
			{
				$tab2[0] = "admin";
		        $tab2[1] = "edituser";
		        $this->render($tab2,$error);
			}

       	}else{

			if(isset($id))
			{
				$data = $this->loadUser->getInfoUser($id);
				$tab2[0] = "admin";
		        $tab2[1] = "edituser";
		        $this->render($tab2,[$data,$dataGroup]);
			}
       	}

	}


}



?>