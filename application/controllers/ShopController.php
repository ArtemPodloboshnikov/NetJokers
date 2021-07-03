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
	class ShopController extends Controller
	{

		/**
		 * Render the view of action 'index'
		 * 
		 * @return void  
		 */
		
		public function showAction()
		{

			$result = $this->model->getProducts();

			$params = [

				'products' => $result,
				'newOrder' => function($user_uuid, $product_id, $count){ return $this->model->newOrder($user_uuid, $product_id, $count);},
				'css' => ['shop']
			];
			$this->view->render("Shop", $params);
		}

		public function basketAction()
		{

			$result = $this->model->getBasket($_SESSION['user_uuid']);

			$params = [

				'basket' => $result,
				'deleteOrder' => function($user_uuid, $product_id, $count){ $this->model->deleteOrder($user_uuid, $product_id, $count);},
				'css' => ['shop', 'basket']
			];
			$this->view->render("Basket", $params);
		}

		public function shopMakerAction()
		{

			if ($_SESSION['user_right'] == 'seller' || $_SESSION['user_right'] == 'journalist_seller')
			{

				$params = [

					'getMyProducts' => function($user_uuid){ return $this->model->getMyProducts($user_uuid); },
					'tagsAsOption' => function($what){ return $this->model->tagsAsOption($what);},
					'css' => ['newsMaker', 'newOneShow']
				];
				$this->view->render('Storeroom', $params);
			}
			else
			{

				$this->view->errorCode(403);
			}
		}
	}


?>