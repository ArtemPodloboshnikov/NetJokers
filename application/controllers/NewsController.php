<?php  
	
	namespace application\controllers;

	use application\core\Controller;
	/**
	 * This is the controller of main page
	 * 
	 * @property array $routeParams
	 * @property View  $view
	 * @property [object of current model] $model
	 * 
	 * @package packagename application\controllers
	 * @category Controller
	 */
	class NewsController extends Controller
	{

		/**
		 * Render the view of action 'index'
		 * 
		 * @return void  
		 */
		public function showAction()
		{
			
		
			
			$result = $this->model->getNews();
		
			$params = [

				'news' => $result,
				'tagsAsOption' => function($what = 'tag'){ $this->model->tagsAsOption($what);},
				'tagsAsCheckbox' => function($name, $what = 'tag'){ $this->model->tagsAsCheckbox($name, $what);},
				'start_search' => function($getString, $getTags, $getCategories, $columns, $columnForSearchTags, $columnForSearchString, $category){ return $this->model->search($getString, $getTags, $getCategories, $columns, $columnForSearchTags, $columnForSearchString, $category);},
				'css' => ['show']
			];
			$this->view->render('News', $params);
		}
		public function getOneNewAction($addition)
		{

			$result = $this->model->getNew($addition);



			//debug($result);
			$params = [

				'new' => $result,
				'likeToggle' => function($id, $columnId, $user_uuid, $table){ $this->model->likeToggle($id, $columnId, $user_uuid, $table);},
				'counterViews' => function($ip, $title){ return $this->model->counterViews($ip, $title);},
				'formHandler' => function($params, $functions){ return $this->model->formHandler($params, $functions);},
				'css' => ['newOneShow']
			];
			
		
			$this->view->render($result['title'], $params);
		}
		
		public function newsMakerAction()
		{
			ini_set("display_errors", 1);

			error_reporting(E_ERROR | E_WARNING | E_PARSE);

			if ($_SESSION['user_right'] == 'journalist' || $_SESSION['user_right'] == 'journalist_seller' || $_SESSION['user_right'] == 'admin')
			{

				$params = [

					'getMyNews' => function($user_uuid){ return $this->model->getMyNews($user_uuid); },
					'tagsAsOption' => function($what){ return $this->model->tagsAsOption($what);},
					'tagsAsCheckbox' => function($name, $what = 'tag'){ $this->model->tagsAsCheckbox($name, $what);},
					'loadFile' => function($loadFile, $text, $path, $url){ $this->model->loadFile($loadFile, $text, $path, $url);},
					'publishArticle' => function($title, $body, $tags_category_id, $cover){ $this->model->makeNewArticle($title, $body, $tags_category_id, $cover);},
					'css' => ['newsMaker', 'newOneShow']
				];
				$this->view->render('Journal', $params);
			}
			else
			{
				$this->view->errorCode(403);
			}

		}
	}


?>