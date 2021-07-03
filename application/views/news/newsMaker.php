<?php 
	
	ini_set("display_errors", 1);

	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	
	$_SESSION['page'] = $_SESSION['constants']['CURRENT_DOMEN'].'journal';
	//unset($_SESSION['temp_dir_article']);
	//debug($_SESSION['temp_dir_article']);
	
	if (isset($_POST['next']) && $_POST['newsTitle'] != "")
	{
		$json = $this->readJSON($_POST['newsTitle'], "title", "body", "tags");

		$_SESSION['temp_dir_article'] = "public/images/news/temp_".RusToLat($json['title']);
		$_SESSION['title_news_maker'] = $json['title'];
		$_SESSION['body_news_maker'] = $json['body'];
		$_SESSION['tags_news_maker'] = $json['tags'];
	}

	if (isset($_POST['loadCover']))
	{
		$loadFile($_FILES['fileCover'], "", $_SESSION['temp_dir_article'], $_SESSION['page']);
	}	

	
	if (isset($_POST['next']) && $_POST['title'] != "")
	{
		if (!file_exists("public/images/news/temp_".RusToLat($_POST['title'])))
		{

			$_SESSION['temp_dir_article'] = "public/images/news/temp_".RusToLat($_POST['title']);

			$_SESSION['title_news_maker'] = $_POST['title'];

			mkdir($_SESSION['temp_dir_article']);
			//debug($_SESSION['temp_dir_article']);
			file_put_contents($_SESSION['temp_dir_article']."/who.json", "{'name': '".$_SESSION['user_name']."', 'date': '".date("d-m-Y")."', 'title': '".$_POST['title']."'}");
			

		}
	}

	if (isset($_POST['openMyArticle']) && $_POST['newsTitle'] != "")
	{
		$this->redirect($_SESSION['constants']['CURRENT_DOMEN']."news/".$_POST['newsTitle']);
	}

	if (isset($_POST['publishArticle']))
	{
		$links = $this->arrayLinksToString($_POST['tags'], $_POST['categories'], $_POST['categories_tags']);
		//debug($links);
		$publishArticle($_SESSION['title_news_maker'], $_POST['body_news_maker'], $links, "");
	}
	if (isset($_POST['saveArticle']))
	{
		if ($_POST['title'] != $_SESSION['title_news_maker'])
		{
			
			

			$newPath = explode("/", $_SESSION['temp_dir_article']);
			unset($newPath[count($newPath) - 1]);
			$newPath[] = "temp_".RusToLat($_POST['title']);
			$newPath = implode("/", $newPath);
			//debug($newPath);
			rename($_SESSION['temp_dir_article'], $newPath);

			$_SESSION['temp_dir_article'] = $newPath;

			$pathToJSON = $_SESSION['temp_dir_article']."/who.json";

			$_SESSION['title_news_maker'] = $_POST['title'];

			$this->writeJSON($pathToJSON, 
			['title' => $_POST['title']]);
		}

		$links = $this->arrayLinksToString($_POST['tags'], $_POST['categories'], $_POST['categories_tags']);

		$_SESSION['body_news_maker'] = $_POST['content'];
		

		$this->writeJSON($pathToJSON, 
			['date' => date("Y-m-d"), 
			'body' => $_POST['content'], 
			'tags' => $links]);
	}
	if (isset($_SESSION['temp_dir_article']))
	{
		require 'application/views/news/newsMakerMain.php';
	}
	else if (!isset($_SESSION['temp_dir_article']))
	{
		require 'application/views/news/newsMakerTitle.php';
	}
	
	
 ?>
