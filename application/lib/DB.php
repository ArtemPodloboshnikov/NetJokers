<?php 
	
	namespace application\lib;
	
	use PDO;
	
	/**
	 * Class connect with database through PDO and also serves for processings data for the database 
	 * 
	 * @package  application\lib
	 * @category DataBase
	 */
	class DB
	{
		/** @var PDO $db Contains object of PDO */
		private $db;

		public function __construct(){

			$config = require 'application/config/db.php';
			$this->db = new PDO('pgsql:host='.$config['host'].';dbname='.$config['dbName'], $config['userName'], $config['password']);

		}

		/**
		 * Makes a request
		 * 
		 * @param  string 		$sql 	Sql query
		 * @param  array  		$params Data for substitution
		 * @return PDOStatement $query 
		 */
		public function query($sql, $params = [])
		{

			$query = $this->db->prepare($sql);
			if (!empty($params))
			{
				foreach ($params as $key => $val) 
				{
					$query->bindValue(':'.$key, $val);
				}
				
			}
			$query->execute();
			
			return $query;
		}

		/**
		 * Outputs the data from database
		 * 
		 * @param  string $sql 	  Sql query
		 * @param  array  $params Data for substitution
		 * @return array          Data on request
		 */
		public function row($sql, $params = []){

			$result = $this->query($sql, $params);
			$result = $result->fetchAll(PDO::FETCH_ASSOC);
			//$this->validationDateFromDB($result);
			return $result;

		}

		private function validationDateFromDB(&$array)
		{

			$arrayInArray = [];
			foreach ($array as $key => $val) {
				
				if (is_array($val))
				{

					$arrayInArray[] = $val;
				}
				else
				{

					$val = htmlspecialchars($val, ENT_QUOTES, 'UTF-8');
				}
				
			}

			if (!empty($arrayInArray))
			{
				foreach ($arrayInArray as $key => $val) {
					
					$this->validationDateFromDB($val);	
				}
				
			}

			return;
		}
		public function column($sql, $params = []){

			$result = $this->query($sql, $params);
			return $result->fetchColumn();
		}

		public function search($getString, $getTags, $getCategories, $columns, $columnForSearchTags, $columnForSearchString, $category)
		{
			

			if ($category == "all")
			{

				$category = "news";
			}
			
				
				$result = [];
				$tags = [];

				if (isset($getString) && !isset($getCategories) && !isset($getTags))
				{
					$result = $this->searchByString($columns, $category, $columnForSearchString, $getString);
					return $result;
				}
				if (isset($getString) && (isset($getCategories) || isset($getTags)))
				{
					
					$tags = ((isset($getCategories) && isset($getTags))?array_merge($getTags, $getCategories): []);

					$tags = ((isset($getCategories))? $getCategories : $getTags);
					

					$result = $this->searchByTagAndString($columns, $category, $columnForSearchTags, $columnForSearchString, $tags, $getString);

					return $result;
				}
				
				if (isset($getCategories))
				{
					
					$tags = $getCategories;
					
				}
				if (isset($getTags))
				{
					$tags = array_merge($tags, $getTags);

				}
				

				$result = $this->searchByTag($tags);
					
				return $result;
				
				
			
				
					
			
		}
		public function searchByString($columns, $tables, $columnForSearch, $string)
		{

			$columns = implode(", ", $columns);
			//$tables = implode(", ", $tables);
			/*$params = [

				"tables" => $tables,
				"columns" => $columns,
				"columnForSearch" => $columnForSearch,
				"string" => "'%".$string."%'"

			];*/
			//debug("SELECT $columns FROM $tables WHERE $columnForSearch LIKE $string");
			$result =  $this->row("SELECT $columns FROM $tables WHERE $columnForSearch LIKE '%".$string."%'");
			return $result;
		}

		private function arrayIdsToString($ids)
		{
			
			$new_ids = [];
			foreach ($ids as $key => $val) {
				
				$val_key = array_keys($val);
				$new_ids[] = $val[$val_key[0]];
			}
			$new_ids = implode(", ", $new_ids);

			return $new_ids;
		}
		public function searchByTag($columns, $tables, $columnForSearch, $ids)
		{

			$columns = implode(", ", $columns);
			//$tables = implode(", ", $tables);
			if (is_array($ids))
			{
				$ids = $this->arrayIdsToString($ids);
			}
			

			$result = $this->row("SELECT $columns  FROM news WHERE $columnForSearch && ARRAY[$ids]");
			
			return $result;



		}

		public function searchByTagAndString($columns, $tables, $columnForSearchTags, $columnForSearchString, $ids, $string)
		{

			$columns = implode(", ", $columns);
			//$tables = implode(", ", $tables);

			$ids = $this->arrayIdsToString($ids);

			$result = $this->row("SELECT $columns  FROM news WHERE $columnForSearchTags && ARRAY[$ids] AND $columnForSearchString LIKE '%".$string."%'");
			
			return $result;

		}
	}


?>