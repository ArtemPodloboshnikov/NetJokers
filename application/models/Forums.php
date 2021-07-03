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
	class Forums extends Model
	{

		public function getForums()
		{

			return $this->db->row("SELECT forum_id as id, name as title, description as body, cover FROM forums ORDER BY forum_id DESC");
			
			
			
			
			
		}
		public function getForum($addition)
		{
			

			
			if (is_array($addition))
			{
				$params = [

					'forum_id' => ((integer)$addition[0]),
					'question_uuid' => $addition[1]
				];

				$result[0] = $this->db->row("SELECT comments.question, comments.datetime, comments.content, coalesce(array_length(comments.likes, 1), 0) as likes, comments.comment_uuid as comment_uuid, users.image, users.name, comments.user_uuid FROM comments INNER JOIN users ON users.user_uuid = comments.user_uuid INNER JOIN forums_comments ON forums_comments.comment_uuid = comments.comment_uuid WHERE forums_comments.page_id = '".((integer)$addition[0])."' ORDER BY datetime ASC");

				$result_addition = $this->db->row("SELECT cover, users.name as author_name, users.user_uuid as author_uuid, users.image as author_image FROM forums INNER JOIN users ON users.user_uuid = forums.user_uuid WHERE forums.forum_id = '".((integer)$addition[0])."'");

				$result[0] = array_merge($result[0], $result_addition[0]);

				$result[0]['forum_id'] = (integer)$addition[0];

				$result[0]['name'] = $result[0][0]['question'];
			//	$result_addition = $this->db->row("SELECT ");
			}
			else
			{

			$params = [

				'forum_id' => $addition
			];

			$result = $this->db->row("SELECT forums.user_uuid as user_uuid, forums.cover as cover, forums.description as description, forums.name as name, users.image as author_image, users.name as author_name, users.user_uuid as author_uuid FROM forums INNER JOIN users ON users.user_uuid = forums.user_uuid WHERE forums.forum_id=:forum_id", $params);

			$result_addition = $this->db->row("SELECT comments.question, comments.comment_uuid FROM forums INNER JOIN forums_comments ON forums_comments.page_id = forums.forum_id INNER JOIN comments ON comments.comment_uuid = forums_comments.comment_uuid  WHERE forums.forum_id=:forum_id", $params);

			$result[0] = array_merge($result[0], $result_addition);
		
			$result[0]['forum_id'] = $addition;
			
			$tagIds = $this->db->row("SELECT tags_category_id FROM forum WHERE forum_id=:forum_id", $params);
			if ($tagIds == NULL)
			{
				$idsTag = [];
			}
			else
			{
				$idsTag = DbArrayToPhpArray($tagIds[0]['tags_category_id']);
			}
			

			//$comments = $this->db->row("(SELECT users.name, users.image, coalesce(array_length(comments.likes, 1), 0) as likes, comments.user_uuid, comments.comment_uuid, comments.content, comments.datetime FROM comments INNER JOIN users ON users.user_uuid = comments.user_uuid WHERE comments.new_title = '$title_new' GROUP BY comments.user_uuid, comments.comment_uuid, users.name, users.image, comments.serial_number) ORDER BY comments.serial_number ASC");

			//debug($comments);
			$this->getArrayWithTag($result[0], $idsTag);
			
			//$result[0] = array_merge($result[0], $comments);
			}
			return $result[0];
		}

		
		
	}


?>