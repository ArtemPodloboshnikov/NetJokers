<?php  
	
	namespace application\core;

	use application\core\View;

	/**
	 * Base class of controllers 
	 * 
	 * @package  application\core
	 * @category Controller
	 */
	abstract class Controller
	{
		/** @var array 				   	 $routeParams Contains parameters of current route */
		public $routeParams;
		/** @var application\core\View   $view 		  Object of class View */
		public $view;
		/** @var application\models\**** $model 	  Contains model (object) of current route*/
		public $model;

		public function __construct($routeParams)
		{

			$this->routeParams = $routeParams;
			$this->view = new View($routeParams);
			$this->model = $this->loadModel($routeParams['controller']);

			if (!isset($_SESSION['user_name']) && ($routeParams['controller'] != 'main' && $routeParams['action'] != 'index'))
			{
				if (!isset($_SESSION['page']))
				{

					$_SESSION['page'] = $_SERVER['REQUEST_URI'];
				}
				$this->view->redirect("http://".$_SERVER['SERVER_NAME']."/NetJokers/auth");		
			}

			

			

		}

		/**
		 * Load the current model
		 * 
		 * @param  string $name Name of current model
		 * @return object 		Object of current model 
		 */
		public function loadModel($name)
		{

			$path = 'application\models\\'.ucfirst($name);
			if (class_exists($path))
			{
				
				return new $path;
			}
		}
	}

?>