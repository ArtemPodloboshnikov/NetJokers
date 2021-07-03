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
	class Shop extends Model
	{

		public function getProducts()
		{

			$result = $this->db->row("SELECT products.*, categories_products.name as category_name  FROM products INNER JOIN categories_products ON categories_products.category_id = products.category_id ORDER BY category_name ASC");

			return $result;

		}
		public function getBasket($user_uuid)
		{

			$result = $this->db->row("SELECT products.name, products.price, products.discount, products.image, products.product_id, users.name as user_name, basket_status.name as status_name, basket.count as basket_count FROM products INNER JOIN basket ON basket.product_id = products.product_id INNER JOIN users ON users.user_uuid = basket.user_uuid INNER JOIN basket_status ON basket_status.status_id = basket.status_id WHERE users.user_uuid = '$user_uuid'");
			return $result;
		}
		public function newOrder($user_uuid, $product_id, $count)
		{
			$idOrderStatus = $this->db->row("SELECT status_id FROM basket_status WHERE name='order'");
			//debug($idOrderStatus);
			if ($count != 0)
			{
				$params = [


					'product_id' => $product_id
				];
				$currentCountOfProduct = $this->db->row("SELECT count FROM products WHERE product_id = :product_id", $params);
				$params = [

					'count' => $count,
					'product_id' => $product_id
				];

				if (($currentCountOfProduct[0]['count'] - $count) >= 0)
				{
					$this->db->query("UPDATE products SET count = (SELECT count - :count FROM products WHERE product_id = :product_id) WHERE product_id = :product_id", $params);
				}
				else
				{

					return false;
				}
			}
			$params = [

				'user_uuid' => $user_uuid,
				'product_id' => (integer)$product_id,
				'count' => (integer)$count
			];
			//debug($params);
			$this->db->query("INSERT INTO basket (user_uuid, product_id, status_id, count) VALUES (:user_uuid, :product_id, ".$idOrderStatus[0]['status_id'].", :count)", $params);

			return true;
		}

		public function deleteOrder($user_uuid, $product_id, $count)
		{
			if ($count != 0)
			{
				$count = (integer)str_replace(' шт.', '', $count);
			}
			$params = [

				'product_id' => $product_id,
				'count' => $count	
			];
			//debug($params);
			if ($count != 0)
			{


				$this->db->query("UPDATE products SET count = ((SELECT count FROM products WHERE product_id = :product_id) + :count) WHERE product_id = :product_id", $params);
			}
			
			$params = [

				'user_uuid' => $user_uuid,
				'product_id' => $product_id,
				'count' => $count	
			];

			$this->db->query("DELETE FROM basket WHERE user_uuid = :user_uuid AND product_id = :product_id AND count = :count", $params);
		}

		public function getMyProducts($user_uuid)
		{

			$params = [

				'user_uuid' => $user_uuid
			];

			$myNews = $this->db->row("SELECT products.name, products.price, products.discount, products.count, products.image FROM products INNER JOIN basket ON basket.product_id = products.product_id INNER JOIN users.user_uuid = basket.user_uuid WHERE users.user_uuid = :user_uuid", $params);
			return $myNews;
		}
	}


?>