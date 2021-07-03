<?php 
	
	namespace application\core;

	use application\core\View;
	/**
	 * This class starts controllers 
	 * based on the url
	 * 
	 * @package  application\core
	 * @category Routes
	 */
	class Router	
	{
		/**
		 * @var array $routes Contains the key (template) – name 
		 * of the route and the value – its parameters
		 * 
		 */
		protected $routes = [];
		/**
		 * @var array $params Contains the 
		 * parameters of current route
		 * 
		 */
		protected $params = [];

		
		public function __construct()
		{

			$routes = require 'application/config/routes.php';
			foreach ($routes as $key => $val) 
			{
				$this->add($key, $val);
			}
			
		}
		/**
		 * Adds a value to the array $routes. 
		 * Turning the key (route name) into a template
		 * 
		 * 
		 * @param string $route  Future key of the array $routes.
		 * Contains the route name
		 * @param string $params Parameters of route (controller, action)
		 * @return void 		 Filled array $routes
		 */
		private function add($route, $params)
		{

			$route = "#^".$route."$#";
			$this->routes[$route] = $params;
		}

		/**
		 * Searches for the entered address in array $routes 
		 * 
		 * 
		 * @return boolean Success – true, fail – false
		 * 
		 */
		private function match()
		{

			if (isset($_SESSION['view']))
			{

				unset($_SESSION['view']);
			}
			$url = trim($_SERVER['REQUEST_URI'], '/');
			$url = trim(str_replace('NetJokers', '', $url), '/'); // Delete this line
			
			foreach ($this->routes as $key => $val) 
			{
				
				if (preg_match($key, $url, $matches))
				{
					$this->params = $val;
					return true;
				}
				
			}
			return $this->matchAddition($url);
			 
		}

		private function matchAddition($url)
		{	

			

			$advancedOption = false;
			
			$withoutAddition = explode("/", $url)[0];
			
			switch ($withoutAddition) {
				case 'news':
						
					
					$this->params = ["controller" => "news", "action" => "getOneNew"];
					break;
				case 'search':

					
					$this->params = ["controller" => "main", "action" => "search"];
					break;
				case 'profile':
					$this->params = ["controller" => "main", "action" => "profile"];
					break;
				case 'forums':
					$this->params = ["controller" => "forums", "action" => "getOneForum"];
					break;
				default:
					# code...
					break;
			}
			$advancedOption = str_replace($withoutAddition."/", "", $url);
			if (strpos($advancedOption, "/") !== false)
			{
				$advancedOption = explode("/", $advancedOption);
			}
			return $advancedOption;
		}

		/**
		 * Passes $params to the controller 
		 * and launches the desired action
		 * 
		 * @return void
		 */
		public function run()
		{

			if ($addition = $this->match())
			{

				$path = 'application\controllers\\'.ucfirst($this->params['controller']).'Controller';

				if (class_exists($path)) 
				{

					if ($this->params['action'] != 'newsMaker' && $this->params['action'] != 'preview' && isset($_SESSION['temp_dir_article']))
					{
						$jsonName = '/who.json';
						$json = json_decode(htmlspecialchars_decode(file_get_contents($_SESSION['temp_dir_article'].$jsonName)), true);
						$json['body'] = $_SESSION['body_news_maker'];
						debug($json);
						$json['title'] = $json['title'];
						$json['name'] = $json['name'];
						$time = strtotime("now");
						$timenow = date("d-m-Y", $time); 
						$json['date'] = $newdate = date("d-m-Y", strtotime("+3 month", $time));
						$json['tags'] = $_SESSION['tags_news_maker'];

						file_put_contents($_SESSION['temp_dir_article'].$jsonName, json_encode($json));

						unset($_SESSION['temp_dir_article']);
						unset($_SESSION['title_news_maker']);
						if (isset($_SESSION['body_news_maker']))
							unset($_SESSION['body_news_maker']);
						if (isset($_SESSION['tags_news_maker']))
							unset($_SESSION['tags_news_maker']);
					}
					$action = $this->params['action']."Action";
					if (method_exists($path, $action))
					{
						
						$controller = new $path($this->params);

						if (is_string($addition) || is_array($addition))
						{
							$controller->$action($addition);

						}
						else
						{
							$controller->$action();
						}
						

					} else
					{
						//echo "Method not found: ".$action;
						View::errorCode(404);
					}

				} else
				{
					//echo "Class not found: ".$path;
					View::errorCode(404);
				}

			} else 
			{

				//echo "Route not found";
				View::errorCode(404);
			}
		}
	}	
?>