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
	class News extends Model
	{

		public function getNews()
		{

			return $this->db->row("SELECT new_id as id, title, body, cover FROM news ORDER BY new_id DESC");
		
		}
		public function getNew($addition)
		{
			$params = [

				'new_id' => $addition
			];

		
			$title_new = $this->db->row("SELECT title FROM news WHERE new_id = :new_id", $params);
			$title_new = $title_new[0]['title'];

			$checkComments = $this->db->row("SELECT COUNT(*) as count FROM news INNER JOIN news_comments ON news_comments.page_id = news.new_id INNER JOIN comments ON comments.comment_uuid = news_comments.comment_uuid WHERE news.title = '$title_new'");
			
			//debug($checkComments[0]['count']);
			if ($checkComments[0]['count'] == 0)
			{
				$checkMakeFirstComment = $this->db->row("SELECT comment_uuid FROM comments WHERE content = 'Сделай первый комментарий!'");

				if (empty($checkMakeFirstComment))
				{
					
					$this->db->query("INSERT INTO comments (content, user_uuid, datetime, comment_uuid, new_title) VALUES ('Сделай первый комментарий!', '".$_SESSION['constants']['UUID_SITE']."', now(), ".$_SESSION['constants']['UUID_START_COMMENT'].", $title_new)");
				}

				$this->db->query("INSERT INTO news_comments (comment_uuid, page_id) VALUES ('".$checkMakeFirstComment[0]['comment_uuid']."', :new_id)", $params);
			}
			else if ($checkComments[0]['count'] > 1)
			{
				$checkMakeFirstComment = $this->db->row("SELECT comments.comment_uuid FROM comments INNER JOIN news_comments ON news_comments.comment_uuid = comments.comment_uuid INNER JOIN news ON news.new_id = news_comments.page_id WHERE comments.content = 'Сделай первый комментарий!'");

				if (!empty($checkMakeFirstComment))
				{
				
					$this->db->query("DELETE FROM news_comments WHERE page_id = :new_id AND comment_uuid = '".$checkMakeFirstComment[0]['comment_uuid']."'", $params);
				}
			}
			
		
			
			
			
			

			$result = $this->db->row("SELECT news.new_id as new_id, news.title as title, news.date as new_date, news.body as content, news.cover as new_cover, news.user_uuid as author_uuid, news.ban as ban, users.image as author_image, users.name as author_name, coalesce(array_length(news.likes, 1), 0) as new_likes, coalesce(array_length(news.views, 1), 0) as new_views FROM news INNER JOIN news_comments ON news_comments.page_id = news.new_id INNER JOIN users ON users.user_uuid = news.user_uuid WHERE news.new_id = :new_id GROUP BY news.new_id, users.image, users.name", $params);

			$result[0]['ban'] = DbArrayToPhpArray($result[0]['ban']);

			$result[0]['new_id'] = $addition;

			if ($result[0]['new_views'] > 10000) {

				$result[0]['new_views'] = "10000+";
			}
			if ($result[0]['new_likes'] > 10000) {

				$result[0]['new_likes'] = "10000+";
			}

			$idsTag = DbArrayToPhpArray($this->db->row("SELECT tags_category_id FROM news WHERE new_id=:new_id", $params)[0]['tags_category_id']);

			$comments = $this->db->row("(SELECT users.name, users.image, coalesce(array_length(comments.likes, 1), 0) as likes, comments.user_uuid, comments.comment_uuid, comments.content, comments.datetime FROM comments INNER JOIN users ON users.user_uuid = comments.user_uuid INNER JOIN news_comments ON news_comments.comment_uuid = comments.comment_uuid INNER JOIN news ON news.new_id = news_comments.page_id WHERE news.new_id = :new_id GROUP BY comments.user_uuid, comments.comment_uuid, users.name, users.image) ORDER BY comments.datetime ASC", $params);

			//debug($comments);
			$this->getArrayWithTag($result[0], $idsTag);
			
			$result[0] = array_merge($result[0], $comments);
			
			return $result[0];
		}
		public function getMyNews($user_uuid)
		{

			$params = [

				'user_uuid' => $user_uuid
			];

			$myNews = $this->db->row("SELECT title, new_id FROM news WHERE user_uuid = :user_uuid", $params);
			return $myNews;
		}

		public function counterViews($ip, $title)
		{

			$params = [

				'ip' => $ip,
				'title' => $title
			];

			$existsIP = $this->db->row("SELECT views FROM news WHERE :ip = any(views) AND title = :title", $params);
			
			if (empty($existsIP))
			{
				$this->db->query("UPDATE news SET views = (SELECT array_append(views, :ip)) WHERE title = :title", $params);
			}

			return true;
		}
		
		public function makeNewArticle($title, $body, $tags_category, $cover)
		{
			//rename($_SESSION['temp_dir_article'], str_replace("temp_", "", $_SESSION['temp_dir_article']));
			$tags_category_sql = "";
			foreach ($tags_category as $val) {
				
				$tags_category_sql .= "name='".$val."' OR ";
			}
			$tags_category_sql = substr($tags_category_sql, 0, count($tags_category_sql) - 4);
			$tags_category_ids = $this->db->row("SELECT tags_category_id FROM tags_category WHERE ".$tags_category_sql);
			$tags_category_ids = PhpArrayToDbArray($tags_category_ids, "tags_category_id");

			$params = [

				'user_uuid' => $_SESSION['user_uuid'],
				'body' => $body,
				'tags_category_ids' => $tags_category_ids,
				'title' => $title,
				'cover' => $cover
			];
			//$this->db->query("INSERT INTO news (body, user_uuid, title, tags_category_id, cover) VALUES (:body, :user_uuid, :title, :tags_category_ids, '')", $params);
			$act = "Пользователь ".$_SESSION['user_name']."(".$_SESSION['user_right'].") выложил статью '".$title;
			if (count($act) > 99)
			{
				$act = substr($act, 0, 99);
			}
			//debug($act);
			$params = [

				'user_uuid' => $_SESSION['user_uuid'],
				'action' => $act."'"
			];
			//debug($params['action']);
			$this->db->query("INSERT INTO history (action, user_uuid, date) VALUES (:action, :user_uuid, now())", $params);
		}
		
	}


?>