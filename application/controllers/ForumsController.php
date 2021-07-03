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
	class ForumsController extends Controller
	{

		/**
		 * Render the view of action 'index'
		 * 
		 * @return void  
		 */
		public function showAction()
		{
			
		
			
			$result = $this->model->getForums();
		
			$params = [

				'forums' => $result,
				'tagsAsOption' => function($what = 'tag'){ $this->model->tagsAsOption($what);},
				'start_search' => function($getString, $getTags, $getCategories, $columns, $columnForSearchTags, $columnForSearchString, $category){ return $this->model->search($getString, $getTags, $getCategories, $columns, $columnForSearchTags, $columnForSearchString, $category);},
				'css' => ['show']
			];
			$this->view->render('Forums', $params);
		}
		public function getOneForumAction($addition)
		{
			
			$result = $this->model->getForum($addition);



			//debug($result);
			$params = [

				'forum' => $result,
				'formHandler' => function($params, $functions){ return $this->model->formHandler($params, $functions);},
				'css' => ['forumOneShow']
			];
			
		
			$this->view->render($result['name'], $params);
		}
	}


?>