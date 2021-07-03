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
	class MainController extends Controller
	{

		/**
		 * Render the view of action 'index'
		 * 
		 * @return void  
		 */
		public function indexAction()
		{
			
			
			$news = $this->model->db->row("SELECT new_id as id, title, body, cover FROM news ORDER BY new_id DESC");
			$params = [

				'news' => $news
			];
			$this->view->render('Main page', $params);
		}

		public function downloadAction()
		{
			$this->view->render('Download page', []);
		}
		public function manageAction()
		{
			if ($_SESSION['user_right'] == 'admin')
			{
				$data = $this->model->db->row("SELECT new_id as id, title, body, cover FROM news ORDER BY new_id DESC");
				$history = $this->model->db->row("SELECT * FROM history");

				if (!empty($history))
				{
					$user_uuid_history = [];
					$history_ids = [];
					$dirNameByDate = [];
					$month = '';
					$day = '';
					$year;

					$countEvent;

					for ($i = 0 ; $i < count($history); $i++) {
						$history[$i]['user_name'] = $this->model->db->row("SELECT name FROM users WHERE user_uuid='".$history[$i]['user_uuid']."'")[0]['name'];
						$user_uuid_history[] = $history[$i]['user_uuid'];
						$history_ids[] = $history[$i]['history_id'];
						

						$day = date("d", strtotime($history[$i]['date']));
						$month = date("F", strtotime($history[$i]['date']));
						$year = date("Y", strtotime($history[$i]['date']));

						$dirNameByDate[] = date("d", strtotime($history[$i]['date']))."_".date("m", strtotime($history[$i]['date']))."_".$year;
						$countEvent[$year][$month][$day] = 1;
						foreach ($history as $val) {

							$all_day = date("d", strtotime($val['date']));
							$all_month = date("F", strtotime($val['date']));
							$all_year = date("Y", strtotime($val['date']));
							//debug($all_day);
							if ($all_day == $day 
								&& $all_month == $month
								&& $all_year == $year)
								$countEvent[$year][$month][$day]++;

						}
						if ($countEvent[$year][$month][$day] > 1)
							$countEvent[$year][$month][$day]--;
						//$month = date("m", strtotime($history[$i]['date']));
						//$month = getMonth((int)$month);

						$history[$i]['date'] = date("d.m.Y h:i", strtotime($history[$i]['date'])); 
						unset($history[$i]['user_uuid']);
					}

					$titleDate;

					foreach ($history as $val) {
						$month = date("F", strtotime($val['date']));
						$year = date("Y", strtotime($val['date']));
						$titleDate[$year][$month] = $month.", ".$year;
					}
					//debug($countEvent);
				}


				$params = [

					'news' => $data,
					'history' => $history,
					'countEvent' => $countEvent,
					'titleDate' => $titleDate,
					'day' => $day,
					//'dirNameByDate' => $dirNameByDate,
					'deleteFromHistory' => function($id=0){ $this->model->deleteFromHistory($id);},
					'createExcel' => function($history, $title){ $this->model->createExcel($history, $title);},
					'css' => ['manage']
				];
				$this->view->render('Admin page', $params);
			}
			else
			{
				$this->view->errorCode(403);
			}
		}
		public function searchAction($addition='')
		{
			if ($addition != '')
			{

				$result = $this->model->getSearchResultByAddress($addition);


			}
			else
			{

				$result = '';

			}
			$AllTags = $this->model->getTags("WHERE name LIKE '#%' ORDER BY name ASC");
			$AllCategory = $this->model->getTags("WHERE name NOT LIKE '#%' ORDER BY name ASC");

			$params = [

				'search' => $result,

				'tagsAll' => $AllTags,

				'categoryAll' => $AllCategory,

				'start_search' => function($getString, $getTags, $getCategories, $columns, $columnForSearchTags, $columnForSearchString, $category){ return $this->model->search($getString, $getTags, $getCategories, $columns, $columnForSearchTags, $columnForSearchString, $category);},
				'tagsAsOption' => function($what = 'tag'){ $this->model->tagsAsOption($what);},

				'css' => ['search']
				
			];

			$this->view->render('Search', $params);
		}
		public function subscribeAction()
		{
			$params = [


				'css' => ['subscribe']
			];
			$this->view->render('Subscribe', $params);
		}
		public function authenticationAction()
		{
			$params = [

				'userAuthentication' => function($name, $password){ return $this->model->userAuthentication($name, $password); },
				'css' => ['authentication']
			];
			$this->view->render('Authentication', $params);
		}
		public function previewAction()
		{

			$params = [

				'css' => ['newOneShow']
			];

			$this->view->render('Preview', $params);
		}


		public function profileAction($addition='')
		{
			if ($addition == '')
			{
				$addition = $_SESSION['user_uuid'];
			}
			$data = $this->model->getDataOfProfile($addition);
			
			$params = [


				'deleteFileListener' => function($button, $pathToFile){ $this->model->deleteFileListener($button, $pathToFile);},
				'data' => $data,
				'css' => ['profile']
			];
			$this->view->render('Profile', $params);
		}
	}


?>