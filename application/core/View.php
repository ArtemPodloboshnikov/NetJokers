<?php  
	
	namespace application\core;

	use application\lib\Markdown;
	/**
	 * This class destined for render page
	 * 
	 * @package  application\core
	 * @category View
	 */
	class View
	{
		/** @var string $path 		 Consists of [controller name/action name] */
		private $path;
		/** @var array  $routeParams Contains controller and action of current route */
		private $routeParams;
		
		private $layout = 'default';

		private $markdown;

		public function __construct($routeParams)
		{

			$this->routeParams = $routeParams;
			$this->path = $routeParams["controller"]."/".$routeParams["action"];
			$this->markdown = new Markdown();
			
		}

		/**
		 * Displays the page based on $path
		 * 
		 * @param string $title  Title for page
		 * @param  array $params Data to display
		 * @return void
		 */
		public function render($title, $params = [])
		{
			extract($params);
			$path = 'application/views/'.$this->path.".php";
			//echo $this->layout;
			if (file_exists($path))
			{
				ob_start();
					require $path;
				$content = ob_get_clean();

				require 'application/views/layouts/'.$this->layout.".php";
				

			}else{

				echo "View not found:".$this->path;
			}
		} 

		/**
		 * Displaying the error code on the screen
		 * 
		 * @param  integer $code Code of state http
		 * @return void 		 Loads the error page
		 */
		public static function errorCode($code)
		{
			http_response_code($code);

			$codeDescription = [403 => 'Доступ запрещён', 404 => "Страницы не существует"];

			$path = 'application/views/errors/error.php';
			if (file_exists($path))
			{
				require $path;
			}else
			{
				echo "Page error not found: ".$code;
			}
			
			exit;
		}

		/**
		 * Redirects to another page [Use it before any data output 
		 * to the page]
		 * 
		 * @param  string $url Any url address for redirection
		 * @return void
		 */
		public function redirect($url)
		{

			header("Location: ".$url);
			exit;
		}

		public function formattingPath($text)
		{

			$text = str_replace('@MyImages', $_SESSION['constants']['CURRENT_DOMEN']."public/images/users", $text);
			$text = str_replace('@TempArticle', $_SESSION['constants']['CURRENT_DOMEN'].$_SESSION['temp_dir_article'], $text);

			return $text;
		}
		public function showTagsAsLinks($tags, $separator = ' ')
		{

			foreach ($tags as $key => $val) {
				
				$href = str_replace('#', '', $val);
				echo "<a href='http://localhost/NetJokers/search/$href'>".$this->validationDateFromDB($val)."</a>".$separator;
			}
		}

		public function showQuestions($questions)
		{
			$i = 0;
			
			while (isset($questions[$i]))
			{

				div("class='showComments__question'");
					a("href='".$questions['forum_id']."/".$questions[$i]['comment_uuid']."'"); 
						echo $this->validationDateFromDB($questions[$i]['question']); 
					a();
				div();
				$i++;
			}
	
		}

		public function showSlides($array, $href, $slidesClasses)
		{
			$j = 0;
			$k = 0;
			$isCloseTag = true;
			for($i = 0; $i < count($array); $i++)
			{

			
				if ($j == 0)
				{
					div("class='breakNews__threeNews ".$slidesClasses[$k]."'");
					$isCloseTag = false;
					$k++;
				}
			
			
					div("class='breakNews__new'");
						a("class='breakNews__new-content'", "style=\"background-image: url('".("http://localhost/NetJokers/public/images/$href/".$array[$i]['cover'])."');\"", "href='$href/".$array[$i]['id']."'");
					
							div("class='breakNews__new-title'");
								div("class='breakNews__new-title_wrap'");
									h1(""); 
										echo $this->validationDateFromDB($array[$i]['title']); 
									h1();
								div();
							div();
							div("class='breakNews__new-description'");
								p(""); 
									echo $this->validationDateFromDB($array[$i]['body']); 
								p();
							div();
						a();
					div();
			

				$j++;
				if ($j == 3)
				{
					div();
					$isCloseTag = true;
					$j = 0;
				}
			
		
			}

			if (!$isCloseTag)
			{
				div();
			}
		}
		public function showBlock($array, $href, $count)
		{

			$j = 0;
		for($i = 0; $i < count($array); $i++)
		{

			
			if ($j == 0)
			{
				div("class='breakNews'");
				div("class='breakNews__threeNews'");
			}
			
			
				div("class='breakNews__new'");
					a("class='breakNews__new-content'", "style=\"background-image: url('".("http://localhost/NetJokers/public/images/$href/".$array[$i]['cover'])."');\"", "href='$href/".$array[$i]['id']."'");
					
						div("class='breakNews__new-title'");
							div("class='breakNews__new-title_wrap'");
								h1(""); echo $this->validationDateFromDB($array[$i]['title']); 
								h1();
							div();
						div();
						div("class='breakNews__new-description'");
							p(""); 
								echo $this->validationDateFromDB($array[$i]['body']); 
							p();
						div();
					a();
				div();
			

			$j++;
			if ($j == $count)
			{
				div();
				div();
				$j = 0;
			}
			
		
		}

		}
		public function showProductAsLinks($links, $separator = ' ')
		{
			$pastCategories = [];
			$flag = false;

			foreach ($links as $key => $val) {
				
				foreach ($pastCategories as $key => $category) {
					
					if ($category == $val['category_name'])
					{
						$flag = true;
						break;
					}
				}
				if ($flag){

					$flag = false;
					continue;
				}

				echo "<a href='#".$val['category_name']."'>".$this->validationDateFromDB($val['category_name'])."</a>".$separator;

				$pastCategories[] = $val['category_name'];
			}
		}
		public function markdown($string)
		{

			return $this->markdown->text($string);
		}
		public function validationDateFromDB($string, $markdown=false)
		{

			if ($markdown == false)
			{
				$result = htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
			}
			else
			{

				$string = $this->markdown->text($string);
				$result = htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
			}

			return $result;
		}
		public function convertRUB()
		{

			$url = 'https://undefined/v1/cryptocurrency/listings/latest';
$parameters = [
  'start' => '1',
  'limit' => '5000',
  'convert' => 'RUB'
];

$headers = [
  'Accepts: application/json',
  'X-CMC_PRO_API_KEY: b54bcf4d-1bca-4e8e-9a24-22ff2c3d462c'
];
$qs = http_build_query($parameters); // query string encode the parameters
$request = "{$url}?{$qs}"; // create the request URL


$curl = curl_init(); // Get cURL resource
// Set cURL options
curl_setopt_array($curl, array(
  CURLOPT_URL => $request,            // set the request URL
  CURLOPT_HTTPHEADER => $headers,     // set the headers 
  CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
));

$response = curl_exec($curl); // Send the request, save the response
//print_r(json_decode($response)); // print json decoded response
curl_close($curl); // Close request
return $curl;
		}

		public function showOrders($orders)
		{
			$i = 0;
			while(isset($orders[$i])){

				div("class='product'");
						h2("");
							echo $orders[$i]['name'];
						h2();
						div("class='product__image'");

							
							
							img("alt='".$orders[$i]['name']."'", "src='".($_SESSION['constants']['CURRENT_DOMEN']."public/images/products/".$orders[$i]['image'])."'");
							
						div();
						form("action=''", "method='POST'", "class='product__form'");
							div("class='product__form-price'");
								if ($orders[$i]['discount'] != 0)
								{
									$originalPrice = $orders[$i]['price'];
									$orders[$i]['price'] = $orders[$i]['price'] - ($orders[$i]['price'] * ($orders[$i]['discount'] / 100));
								}
								p("");
									echo $orders[$i]['price']."₽";
								p();
									
								
							div();
							if ($orders[$i]['basket_count'] > 0)
								{
									input("value='".$orders[$i]['basket_count']." шт.'", "readonly", "name='countOrder'");
								}
							input("type='hidden'", "value='".$orders[$i]['product_id']."'", "name='product_id'");
							if ($orders[$i]['status_name'] == "order")
							{
								$status = "заказ";
							}
							else if ($orders[$i]['status_name'] == "paed")
							{

								$status = "оплачено";
							}
							input("class='product__status'", "value='".$status."'", "readonly");
							button("type='submit'", "name='buy'", "class='button'");
								p("");
									echo "Оформить";
								p();
							button();

							button("type='submit'", "name='delete'", "class='button'");
								p("");
									echo "Удалить";
								p();
							button();
						form();
					div();
						$i++;
			}
		}
		public function showProducts($products)
		{
			$i = 0;
			$category_id = '';

			while(isset($products[$i]))
			{	

					if ($products[$i]['category_id'] != $category_id)
					{
						h1("id='".$products[$i]['category_name']."'");

							echo $products[$i]['category_name'];
						h1();
					}
					
					$category_id = $products[$i]['category_id'];

					div("class='product'");
						h2("");
							echo $products[$i]['name'];
						h2();
						div("class='product__image'");

							
							
							img("alt='".$products[$i]['name']."'", "src='".($_SESSION['constants']['CURRENT_DOMEN']."public/images/products/".$products[$i]['image'])."'");
							
						div();
						form("action=''", "method='POST'", "class='product__form'");
							div("class='product__form-price'");
								if ($products[$i]['discount'] != 0)
								{
									$originalPrice = $products[$i]['price'];
									$products[$i]['price'] = $products[$i]['price'] - ($products[$i]['price'] * ($products[$i]['discount'] / 100));
									div("class='product__form-discount'");
										echo $products[$i]['discount']."%";
									div();
								}
								p("");
									echo $products[$i]['price']."₽";
								p();
									if (isset($originalPrice))
									{
										p("");
											strike("");
												echo $originalPrice."₽";
											strike();
										p();
										unset($originalPrice);
									}
								if ($products[$i]['count'] > 0)
								{
									input("type='number'", "min='1'", "max='".$products[$i]['count']."'", "name='countProduct'", "value='1'");
								}
							div();
							input("type='hidden'", "value='".$products[$i]['product_id']."'", "name='product_id'");
							input("type='checkbox'", "class='product__description-hide'", "id='description_$i'");
							label("for='description_$i'", "class='product__description-link'");
								echo "Описание";
							label();
							div("class='product__description'");
								echo $products[$i]['description'];
							div();
							button("type='submit'", "name='buy'", "class='button'");
								p("");
									echo "Заказать";
								p();
							button();
						form();
					div();
				
				$i++;
			}
		}
		public function showComments($comments, $myUUID)
		{

			$i = 0;
		while(true) {
			form("action=''", "method='POST'");
			
			if (!isset($comments[$i]))
			{

				break;
			}
			

			$comment_uuid = $comments[$i]['comment_uuid'];
			$user_uuid =  $comments[$i]["user_uuid"];
			$user_image = $comments[$i]["image"];

			if ($comments['author_uuid'] == $myUUID || $_SESSION['user_right'] == 'journalist' || $_SESSION['user_right'] == 'journalist_seller')
			{
				
				div("class='removeBan'");
					input("type='image'", "name='removeBan'", "class='removeBan__image'", "src='".$_SESSION['constants']['CURRENT_DOMEN']."public/images/system/allow.svg"."'");
				div();
			}
			div("class='comment'", "id='$comment_uuid'");

			if ($user_uuid == $myUUID)
			{
				div("class='comment__edit'");
					input("type='image'", "name='beginEdit'", "src='http://localhost/NetJokers/public/images/system/edit.svg'");
				div();
			}
				input("type='checkbox'", "id='openLink_$i'", "class='openLink'");
				div("class='linkOfComment'");
					p(""); 
						echo $_SERVER['REQUEST_URI']."#".$comment_uuid;
					p();
					label("class='linkOfComment__close'", "for='closeLink'");
					label();

				div();
				div("class='comment__link'");
					label("for='openLink_$i'");
						img("src='http://localhost/NetJokers/public/images/system/comment_link.svg'");
					label();
				div();
				div("class='comment-content'");

					
					$this->markdown->setSafeMode(true);
					if (isset($comments[$i]['question']))
					{

						h1("");
							echo $this->markdown->text($comments[$i]['question']);
						h1();
					}
					
						$content = $this->formattingPath($comments[$i]['content']);

						echo $this->markdown->text($content);
					
					input("type='hidden'", "name='contentComment'", "value='".strip_tags($this->markdown->text($comments[$i]['content']))."'");
					input("type='hidden'", "name='contentOriginComment'", "value='".$comments[$i]['content']."'");
				div();
				div("class='comment__who'");
				
					a("href='http://localhost/NetJokers/profile/$user_uuid'", "style='background-image: url(\"http://localhost/NetJokers/public/images/users/$user_image\")'");
						
					a();
					p("");
						echo $comments[$i]['name'];
					p();

				div();
				div("class='comment__likes'");
					input("type='image'", "src='http://localhost/NetJokers/public/images/system/comment_heart.svg'", "name='likeComment'");
					div("class='comment__likes-count'");
						if ($comments[$i]['likes'] > 100) $comments[$i]['likes'] = "100+";
						echo $comments[$i]['likes'];
					div();
				div();
				div("class='comment__dateTime'");
					p("");
						echo date('H:i m.d.y', strtotime($comments[$i]['datetime']));
					p();
					input("type='image'", "name='getReply'", "src='http://localhost/NetJokers/public/images/system/reply.svg'");
					
				div();

			input("type='hidden'", "value='$comment_uuid'", "name='commentUUID'");
			input("type='hidden'", "value='$user_uuid'", "name='userUUID'");
			div();
			if ($comments['author_uuid'] == $myUUID || $_SESSION['user_right'] == 'journalist' || $_SESSION['user_right'] == 'journalist_seller')
			{
				
				div("class='ban'");
					input("type='image'", "name='ban'", "class='ban__image'", "src='".$_SESSION['constants']['CURRENT_DOMEN']."public/images/system/ban.svg"."'");
				div();
			}
			form();
			$i++;
		}
		
		return $i;
		}

		public function createFile($path, $content)
		{
			$file = fopen($path, "w");
			fwrite($file, $content);
		}

		public function writeJSON($path, $content)
		{
			
			$json = json_decode(file_get_contents($path), true);
			foreach ($content as $key => $val) {
				
				$json[$key] = $val;
			}

			file_put_contents($path, json_encode($json));

			$this->redirect($_SESSION['page']);
		}
		public function readJSON($path, ...$keys)
		{
			$content = [];
			foreach ($keys as $val) {
				
				$json = json_decode(file_get_contents($path), true);
				$content[$val] = $json[$val];
			}
			return $content;
		}

		public function arrayLinksToString($tagsArray, $categoriesArray, $stringCategoriesTags)
		{
			$links = [];

			if (isset($stringCategoriesTags))
			{
				$links = explode(" ", $stringCategoriesTags);
			}
			if (isset($tagsArray) && isset($categoriesArray))
			{

				$links = array_merge($links, $categoriesArray);
				$links = array_merge($links, $tagsArray);
			}
			else if (isset($tagsArray) && !isset($categoriesArray))
			{
				$links = array_merge($links, $tagsArray);
			}
			else if (isset($categoriesArray) && !isset($tagsArray))
			{
				$links = array_merge($links, $categoriesArray);
			}

			foreach ($links as $key => $val) {
				
				if (strpos($val, ",") !== false)
				{

					unset($links[$key]);
					$links = array_merge(explode(",", $val), $links);
				}

			}

			$links = array_unique($links);
			$_SESSION['tags_news_maker'] = implode(",", $links);
			return $links;
		}
		public function myTempFilesAsOption($name)
		{
			$dir = "public/images/news/";
			$mainJSON = "who.json";
			$myArticles = [];
			$myFiles = [];

			if (is_dir($dir))
			{
				if ($dh = opendir($dir))
				{
					while (($file = readdir($dh)) !== false)
					{
						
						if (strpos($file, "temp_") !== false)
						{
							
							if (file_exists($dir.$file."/".$mainJSON))
							{

								$json = json_decode(file_get_contents($dir.$file."/".$mainJSON), true);
								
								if ($json['name'] == $name) {

									$myArticles[] = $json['title'];
									$myFiles[] = $dir.$file."/".$mainJSON;
								}
							}
						}
					}

					for ($i = 0; $i < count($myArticles); $i++)
					{
						option("value='".$myFiles[$i]."'");
							echo $this->validationDateFromDB($myArticles[$i]);
						option();
					}
				}
			}
		}
		public function myArticleAsOption($articles, $keyValue, $keyContent)
		{
			for($i = 0; $i < count($articles); $i++) {
				
				option("value='".$articles[$i][$keyValue]."'");
					echo $this->validationDateFromDB($articles[$i][$keyContent]);
				option();
			}
			
		}
		public function filesShow($pathToDir, $dirName)
		{

			$dir = opendir($pathToDir);
				
			$pathToDir = str_replace('.', $_SESSION['constants']['CURRENT_DOMEN'], $pathToDir);
			$i = 0;
				while($multimedia = readdir($dir)) 
				{

						if ($multimedia == "." || $multimedia == "..")
						{
							continue;
						}
						$i++;
						if ($i == 1)
						{
							div("class='myImages'");
						}
						

					div("class='myImages__oneImage'");
						
					if (!preg_match("/\.(mp4|mov|avi|mkv|wma|flv|webm)$/", $multimedia))
					{
						img("class='myImages__oneImage-image'", "src='$pathToDir/$multimedia'");
					}
					else
					{

						video("class='myImages__oneImage-image'");
							source("src='$pathToDir/$multimedia'");
						video();
					}
						form("action=''", "method='POST'");
							input("readonly", "value='@MyImages/$dirName/$multimedia'", "name='pathToFile'");
							
							input("type='submit'", "value='Удалить'", "name='deleteFile'");
						form();
					div();
					
					if ($i == 3)
					{
						div();
						$i = 0;
					}		
				}
							
			
			
			
		}

		public function showTable($colums, $titles, $data, $keys)
		{
			$countData = count($data);
			$rows = ($countData * count($data[0])) / $colums;
			$k = 0;
			$indexData = 0;

			table("");
			tr("");
				for($i = 0; $i < $colums; $i++)
				{
					th("");
						echo $titles[$i];
					th();
				}
			tr();
			for($i = 0; $i < $rows; $i++)
			{
				tr("");
				for($j = 0; $j < $colums; $j++)
				{
					td("");
						echo $data[$indexData][$keys[$k]];
					td();
					$k++;
					
					if ($k == $colums)
					{
						$k = 0;
					}
				}
				$indexData++;
					if ($indexData > ($countData - 1))
						$indexData = 0;
				tr();
			}
			table();
		}

		public function graphicData($data, $whichYear, $whichMonth)
		{
			$jsDataForChart = '';
			foreach ($data as $year =>$nullVal) {
				if ($whichYear != $year)
					continue;
				foreach ($data[$year] as $month => $noVal) {
					if ($whichMonth != $month)
						continue;
					foreach ($data[$year][$month] as $day => $value) {

						$jsDataForChart .= "["."'".(date('D', strtotime($day.".".$month.".".$year)))."(".$day.")"."', ".$data[$year][$month][$day]."],";
					}
				}
			}
			return $jsDataForChart;
		}

		
	}
?>