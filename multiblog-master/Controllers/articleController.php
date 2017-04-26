<?php
require_once("../Models/Article.php");


class articleController extends AppController
{

	public function __construct()
	{
		$this->newclass = new Article(); 
	}

	public function add_article()
	{
		$flag = 0;
		$loadUser = new User();
		$loadCategories = new Category();
		$loadBlogs = new Blog();
	    $dataCategories = $loadCategories->getCategories();
	    $dataBlogs = $loadBlogs->getBlog($_SESSION['user_id']);
	    $groupUser = $loadUser->getInfoUser($_SESSION['user_id'],"groupstatus");
	    //var_dump($dataBlogs);
	    if(isset($_POST['add_blog']) && isset($_SESSION['user_id']))
	    {
	    	$blog_name = $_POST['blogname'];

			if(strlen($blog_name) < 3)
			{
				$flag = 1;
			}

			if($flag == 0)
			{
				$loadBlogs->addBlog($_SESSION['user_id'],$blog_name);
		    	$tab[0] = "article"; 
			    $tab[1] = "add_article";
			    $this->render($tab,[$dataCategories,$dataBlogs]);				
			}
			else
			{
		    	$tab[0] = "article"; 
			    $tab[1] = "add_article";
			    $this->render($tab,[$dataCategories,$dataBlogs]);				
			}	    	
	    }


		if(isset($_POST['add_article']) && isset($_SESSION['user_id']))
		{
			
			echo "add article";

			$title = $_POST['title']; 
			$content = $_POST['content']; 
			$image = $_POST['image'];
			$tags = $_POST['tags'];
			$category_id = $_POST['category'];
			$blog_id = $_POST['blog'];

			if(strlen($title) < 3 || strlen($title) > 25)
			{
				$flag = 1;
			}
			else if(strlen($content) < 3)
			{
				$flag = 1;
			}
			else if(strlen($tags) < 3)
			{
				$flag = 1;
			}
			else if($category_id == 0)
			{
				$flag = 1;
			}
			else if($blog_id == 0)
			{
				$flag = 1;
			}
			
			if($flag == 0)
			{
				$this->newclass->post_article($title, $content, $blog_id, $image, $tags, $category_id);	
				$tab[0] = "homepage"; 
		        $tab[1] = "index";
		        $this->render($tab,$dataCategories);
			}
			else 
			{
				$error = "Not a valid article";

	    		$tab[0] = "article"; 
		        $tab[1] = "add_article";
		        $this->render($tab,[$dataCategories,$dataBlogs,$groupUser]);
			}
		}
		else
		{
	    	if($groupUser != 3)
	    	{
		    	$tab[0] = "article"; 
			    $tab[1] = "add_article";
			    $this->render($tab,[$dataCategories,$dataBlogs,$groupUser]);
	    	}
	    	else
	    	{
	    		$this->displayHome();
	    	}
		}		
	}

	public function modify_article($title, $content, $image, $blog_id)
	{
		$flag = 0;
		if(strlen($title) < 3 || strlen($title) > 25)
		{
			$flag = 1;
		}
		else if(strlen($content) < 3)
		{
			$flag = 1;
		}
		else if($blog_id < 1 || $blog_id == null)
		{
			$flag = 1;
		}
		
		if($flag == 0)
		{
			$this->model->put_article($title, $content, $blog_id, $image=null);
		}
		else 
		{
			echo "Not a valid article modification";
		}
		
	}

	public function delete_article($article_id)
	{
		$this->model->delete_article($id);
	}

	public function like($id)
	{
		$this->newclass->like($id);
		header('Location: ../');
	}


	public function display_articles($blog_id)
	{
		return $this->model->get_articles($blog_id);
	}

	public function get_random($nbr)
	{
		$this->model->random_articles($rand);
	}

	public function displayBlog($id){

		
		$article_info = $this->newclass->get_articles($id);
		$blog_info = $this->newclass->get_bloginfo($id);
		$tab2[0] = "blog";
        $tab2[1] = "blog";

        $this->render($tab2,[$article_info,$blog_info]);
	}

	public function displayHome()
    {
    	$loadUser = new User();
    	$loadCategories = new Category();
    	if(isset($_SESSION['user_id']))
    	{
    		$dataCategories = $loadCategories->getCategories();
    		$loadSession = new Session($_SESSION['user_id']);
    		$dataArticles = $this->newclass->random_articles(50);
    		$groupUser = $loadUser->getInfoUser($_SESSION['user_id'],"groupstatus");
    		//echo "articles";
    		//var_dump($dataArticles);
    		$tab[0] = "homepage"; 
	        $tab[1] = "index";
	        $this->render($tab,[$dataCategories,$dataArticles,$groupUser]);
    	}
    	else
    	{
    		$tab[0] = "User"; 
	        $tab[1] = "login";
	        $this->render($tab);
    	}
    }

    public function displayCategory($id)
    {
    	
    	$loadUser = new User();
    	$loadCategories = new Category();
    	$groupUser = $loadUser->getInfoUser($_SESSION['user_id'],"groupstatus");
    	if(isset($_SESSION['user_id']))
    	{
    		$dataCategories = $loadCategories->getCategories();
    		$CategoryName = $loadCategories->getOneCategory($id);
    		$dataArticles = $this->newclass->getArticlesFromCategory($id);
    		//echo "articles";
    		//var_dump($dataArticles);
    		$tab[0] = "article"; 
	        $tab[1] = "category";
	        $this->render($tab,[$dataCategories,$dataArticles,$CategoryName,$groupUser]);
    	}
    	else
    	{
    		$tab[0] = "User"; 
	        $tab[1] = "login";
	        $this->render($tab);
    	}
    }

    public function displayArticle($id){

		$loadComment = new Comments();
		$dataComment = $loadComment->getComments($id);
		$article_info = $this->newclass->get_spec_article($id);
		$tab2[0] = "blog";
        $tab2[1] = "article";

        //var_dump($dataComment);

        $this->render($tab2,[$article_info]);
    }

}



?>