<?php 
	
	namespace application\models;

	use application\core\Model;

	/**
	 * Model of main page
	 * 
	 * @property DB $db
	 * 
	 * @package  application\models
	 * @category Model
	 */
	class Main extends Model
	{

		public function getResultOfSearch($request)
		{

			
			$this->db->search($request);
			
			
		}

		public function getSearchResultByAddress($addition)
		{

			$params = [

				'name' => "_".urldecode($addition)
			];

			$id = $this->db->row("SELECT tags_category_id FROM tags_category WHERE name LIKE :name", $params);
			
			return $this->db->searchByTag(['new_id', 'title', 'cover', 'body'], 'news', 'tags_category_id', $id[0]['tags_category_id']);


		}

		

		public function getSearchResultByTagsAndString($string, $ids, $category)
		{
			$id_column = $category."_id";
			$ids = "'".implode("', '", $ids)."'";
			$array_ids = $this->db->row("SELECT tags_category_id FROM tags_category WHERE name IN ($ids)");
			
			return $this->db->searchByTagAndString(['title', 'cover', 'body', $id_column], [$category], 'tags_category_id', 'title', $array_ids, $string, $category);
		}

		public function getDataOfProfile($addition)
		{
		
			$params = [

				'user_uuid' => $addition
			];
			$data = $this->db->row("SELECT * FROM users WHERE user_uuid = :user_uuid", $params);

			return $data;
		}
		public function userAuthentication($name, $password)
		{
			$params = [

				'name' => $name,
				'password' => $password
			];
			$user = $this->db->row("SELECT * FROM users WHERE name = :name AND password = :password", $params);
			if (empty($user))
			{
				return false;
			}
			$user = $user[0];
			$_SESSION['user_name'] = $user['name'];
			$_SESSION['user_uuid'] = $user['user_uuid'];
			$_SESSION['user_image'] = $user['image'];
			$_SESSION['user_dir'] = explode('/', $user['image'])[0];
			$right = $this->db->row("SELECT name FROM users_rights WHERE right_id = ".$user['right_id']);
			$_SESSION['user_right'] = $right[0]['name'];

			return true;
		}

		public function register($name, $password, $repeatPassword, $email)
		{

			$params = [

				'name' => ucfirst(trim($name)),
				'password' => $password,
				'email' => $email
			];

			if ($password == $repeatPassword)
			{

				$this->db->query("INSERT INTO users (name, password, email, image, right_id) VALUES (:name, :password, :email, '".($_SESSION['constants']['CURRENT_DOMEN']."public/images/system/defaultProfileImage.jpg")."', 1)", $params);
			}
		}

		public function deleteFromHistory($id=0)
		{
			if ($id == 0)
			{

				$this->db->query("DELETE FROM history");
			}
			else
			{
				$params = ['id' => $id];
				$this->db->query("DELETE FROM history WHERE history_id=:id", $params);
			}
		}

	}


?>