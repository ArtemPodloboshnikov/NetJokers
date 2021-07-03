<?php 
	
	namespace application\core;

	use application\lib\DB;

	/**
	 * Base class of model
	 * 
	 * @package application\core
	 * @category Model
	 */
	abstract class Model
	{
		/** @var DB $db Contains object of class DB */
		public $db;

		public function __construct()
		{

			$this->db = new DB();
		}

		public function getArrayWithTag(&$array, $idsTags)
		{

			$ids = implode(",", $idsTags);
			$params = [

				'ids' => $ids
			];
			
			$new_tags = $this->getTags("WHERE tags_category_id IN(".$ids.")");
	
			
			$array['tags'] = $new_tags;
		}
		
		public function getTags($condition, $params = [])
		{

			$tags = $this->db->row("SELECT name FROM tags_category ".$condition, $params);
			$new_tags = [];
			foreach ($tags as $key => $val) {
				
				$new_tags[] = $val["name"];
			}
			return $new_tags;
		}
		public function tagsAsOption($what = 'tag')
		{

			if ($what != 'tag')
			{
				$what = 'NOT';
			}
			else
			{
				$what = '';
			}
			$tags = $this->getTags("WHERE name $what LIKE '#%' ORDER BY name ASC");
			
			foreach ($tags as $key => $val) {
				
				option("");
					echo $val;
				option();
			}
			

		}

		public function tagsAsCheckbox($name, $what = 'tag')
		{

			if ($what != 'tag')
			{
				$what = 'NOT';
			}
			else
			{
				$what = '';
			}
			$tags = $this->getTags("WHERE name $what LIKE '#%' ORDER BY name ASC");
			
			foreach ($tags as $key => $val) {
				
					input("type='checkbox'", "name='$name"."[]'", "value='$val'", "class='custom-checkbox'", "id='$val'");
				label("for='$val'");
					echo " ".$val;
				label();
			}
			

		}
		public function removeBan($user_uuid, $id, $columnId, $table)
		{
			$params = [

				'user_uuid' => $user_uuid,
				'id' => $id
			];
			$isBan = $this->db->row("SELECT ban FROM $table WHERE :user_uuid = any(ban) AND $columnId = :id", $params);
			//debug($columnId);
			if (!empty($isBan))
			{

				$this->db->query("UPDATE $table SET ban = array_remove(ban, :user_uuid) WHERE $columnId = :id", $params);
			}
		}
		public function setBan($user_uuid, $id, $columnId, $table)
		{

			$params = [

				'user_uuid' => $user_uuid,
				'id' => $id
			];

			$isBan = $this->db->row("SELECT ban FROM $table WHERE :user_uuid = any(ban) AND $columnId = :id", $params);
			if (empty($isBan))
			{

				$this->db->query("UPDATE $table SET ban =array_append(ban, :user_uuid) WHERE $columnId = :id", $params);

			}
		}
		public function deleteFile($pathToFile)
		{
			$pathToFile = str_replace("@MyImages", "users", $pathToFile);
			$pathToFile = explode("/", $pathToFile);
			//echo $pathToFile[count($pathToFile) - 2]."/".$pathToFile[count($pathToFile) - 1];
			unlink("./public/images/".$pathToFile[count($pathToFile) - 3]."/".$pathToFile[count($pathToFile) - 2]."/".$pathToFile[count($pathToFile) - 1]);
			
		}

		public function deleteFileListener($button, $pathToFile)
		{
			if (isset($button))
			{
				$this->deleteFile($pathToFile);

			}
		}
		public function search($getString, $getTags, $getCategories, $columns, $columnForSearchTags, $columnForSearchString, $category)
		{

			
			if ($getTags != NULL)
			{

				$tags = "'".implode("', '", $getTags)."'";
				$idsTags = $this->db->row("SELECT tags_category_id FROM tags_category WHERE name IN ($tags)");

				$getTags = $idsTags;
			}
			if ($getCategories != NULL)
			{
				
				$categories = "'".implode("', '", $getCategories)."'";
			
				$idsCategories = $this->db->row("SELECT tags_category_id FROM tags_category WHERE name IN ($categories)");

				$getCategories = $idsCategories;
			}

			

			
			return $this->db->search($getString, $getTags, $getCategories, $columns, $columnForSearchTags, $columnForSearchString, $category);

		}

		public function likeToggle($id, $columnId, $user_uuid, $table)
		{

			$params = [

				'id' => $id, 
				'user_uuid' => $user_uuid
			];

			$isLike = $this->db->row("SELECT likes FROM $table WHERE :user_uuid = any(likes) AND $columnId = :id", $params);
			//debug($comment_uuid);
			if (!empty($isLike))
			{
				$this->db->query("UPDATE $table SET likes = (SELECT array_remove(likes, :user_uuid)) WHERE $columnId = :id", $params);
			}
			else
			{
				$this->db->query("UPDATE $table SET likes = (SELECT array_append(likes, :user_uuid)) WHERE $columnId = :id", $params );
			}
			
		}
		public function updateComment($content, $comment_uuid)
		{

			$params = [

				'content' => $content,
				'comment_uuid' => $comment_uuid
			];
			$this->db->query("UPDATE comments SET content = :content WHERE comment_uuid = :comment_uuid", $params);
		}
		public function insertComment($content, $user_uuid, $pageID, $junctionTable, $question)
		{


			$params = [

				'content' => $content,
				'user_uuid' => $user_uuid,
				'question' => $question
			];
			$this->db->query("INSERT INTO comments (comment_uuid, content, user_uuid, datetime, question) VALUES (uuid_generate_v4(), :content, :user_uuid, now(), :question)", $params);
			$endUUID = $this->db->row("SELECT comment_uuid FROM comments ORDER BY datetime DESC LIMIT 1");
			$params = [

				'page_id' => $pageID
			];
			$endUUID = $endUUID[0]['comment_uuid'];

			$this->db->query("INSERT INTO $junctionTable (comment_uuid, page_id) VALUES ('$endUUID', $pageID)");
		}

		public function deleteComment($comment_uuid, $junctionTable)
		{
			$params = [

				'comment_uuid' => $comment_uuid
			];
			$this->db->query("DELETE FROM comments WHERE comment_uuid = :comment_uuid", $params);
		}

		public function loadFile($loadFile, $text, $path, $url)
		{
			if ($loadFile['error'] == UPLOAD_ERR_OK)
			{

    		$file_name = basename($loadFile['name']);
			$types = array('image/svg+xml', 'image/png', 'image/jpeg');
    		if (in_array($loadFile['type'], $types) && $loadFile['size'] <= 1024000){
    			if (!move_uploaded_file(str_replace("\\", "/", $loadFile['tmp_name']), $path."/".$file_name))
 				{

 					$_SESSION['commentText'] = 'Файл не был загружен: '.str_replace("\\", "/", $loadFile['tmp_name'])." ".$path."/".$file_name;

 				}
 				else
 				{
 					if (strpos($url, 'journal') !== false)
 					{
 						$_SESSION['body_news_maker'] .= " ".$text."![Alt text](@TempArticle/".$loadFile['name'].")";
 					}
 					else
 					{

 						$_SESSION['commentText'] = $text."![Alt text](@MyImages/".$loadFile['name'].")";
 					}
 				//echo 'Загрузка удачна';		
 				}
 			}
 			else
 			{
 				$_SESSION['commentText'] = $text.'Файл не был загружен из-за размера: '.$loadFile['size'];
 			}
    		}
    		else
    		{
    			$_SESSION['commentText'] = $text.'Файл не был загружен, ошибка: '.$loadFile['error'];
    		}
    		debug($_SESSION['commentText']);
    		header("Location: ".$url);
		}
		public function formHandler($params, $functions)
		{

	extract($params);		
	extract($functions);		
 	
// Обработка запроса
if(isset($buttonLoad))
{	
 	
 	$this->loadFile($loadFile, $commentText, $path, $currentURL);
	
}

 if (isset($buttonBan))
 {

 	$this->setBan($userUUID, $page_id, $columnIdentifierForBan, $tableBan);
 	$redirect($currentURL);
 }
 if (isset($buttonRemoveBan)){

 	$this->removeBan($userUUID, $page_id, $columnIdentifierForBan, $tableBan);
 	$redirect($currentURL);
 }
if (isset($buttonInsert) && $commentText != "")
{
	$commentText = trim($commentText);

	if (isset($_SESSION["commentUUID"]))
	{
		$this->updateComment($commentText, $_SESSION["commentUUID"]);
		
		
	}
	else
	{
		if (trim($question) == '') $question = null;
		$this->insertComment($commentText, $_SESSION['user_uuid'], $page_id, $junctionTable, $question);
	}

	$redirect($currentURL);
}
if (isset($buttonDelete) && isset($_SESSION["commentUUID"]))
{

	$this->deleteComment($_SESSION['commentUUID'], $junctionTable);
	$redirect($currentURL);
}
if (isset($_SESSION["commentUUID"]))unset($_SESSION["commentUUID"]);

	ob_start();
	$endIndexOfComment = $showComments($arrayWithComments, $_SESSION['user_uuid']);
	$comments = ob_get_clean();

	$answer = [

		'endIndexOfComment' => $endIndexOfComment,
		'comments' => $comments
	];
	
	

		if (isset($reply))
		{
		
			$_SESSION['commentText'] = '
			>['.$contentComment.']('.$_SERVER['REQUEST_URI'].'#'.$UUIDComment.')';
		}	
		if (isset($edit))
		{
			$_SESSION['commentText'] = $contentOriginComment;
			$_SESSION["commentUUID"] = $UUIDComment;
		}
		if (isset($like))
		{
			//debug($_POST["commentUUID_".$i]);
			$this->likeToggle($UUIDComment, $columnIdentifierForLike, $_SESSION['user_uuid'], 'comments');
			$redirect($currentURL);
		}
		
	
		return $answer;
		}

	}


?>