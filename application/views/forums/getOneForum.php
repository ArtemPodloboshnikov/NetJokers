<?php 
	
	
	ini_set("display_errors", 1);

	error_reporting(E_ERROR | E_WARNING | E_PARSE);

	$_SESSION['page'] = $_SESSION['constants']['CURRENT_DOMEN'].'forums/'.$forum['forum_id'];

	$path = 'images/users/'.$_SESSION['user_dir'];

	$params = [

 		'columnIdentifierForLike' => 'comment_uuid',
 		'buttonLoad' => $_POST['load'],
 		'loadFile' => $_FILES['file'],
 		'path' => $path,
 		'question' => $_POST['question'],
 		'commentText' => $_POST['commentText'],
 		'currentURL' => $_SERVER['REQUEST_URI'],
 		'buttonInsert' => $_POST['insertComment'],
 		'buttonDelete' => $_POST['deleteComment'],
 		'arrayWithComments' => $forum,
 		'contentComment' => $_POST['contentComment'],
 		'UUIDComment' => $_POST['commentUUID'],
 		'contentOriginComment' => $_POST['contentOriginComment'],
 		'columnIdentifierForLike' => 'comment_uuid',
 		'columnIdentifierForBan' => 'forum_id',
 		'tableBan' => 'forums',
 		'page_id' => $forum['forum_id'],
 		'userUUID' => $_POST['userUUID'],
 		'buttonBan' => $_POST['ban_x'],
 		'buttonRemoveBan' => $_POST['removeBan_x'],
 		'junctionTable' => 'forums_comments',
 		'reply' => $_POST['getReply_x'],
 		'edit' => $_POST['beginEdit_x'],
 		'like' => $_POST['likeComment_x']
 	];

 	$functions = [

 		'redirect' => function($url){ $this->redirect($url); },
 		'showComments' => function($comments, $user_uuid){ return $this->showComments($comments, $user_uuid); }
 	];
 	$answer = $formHandler($params, $functions);
 ?>

<div class="cover" style="background-image: url('http://localhost/NetJokers/public/images/forums/<?=$forum['cover']; ?>')">
	
	<?php  require 'application/views/common/navicon.php'; ?>
	<a class="cover__author" href='profile/<?=$forum["author_uuid"]; ?>' style="background-image: url('../../../NetJokers/public/images/users/<?=$forum['author_image']; ?>');" aria-label="<?=$forum['author_name'];  ?>"></a>
	
	<div class="cover__Advanced-setting">
		<label for="settingsGo">
			<img src="../../../NetJokers/public/images/system/additionalSettings.svg">
		</label>
		<input type="checkbox" class="hidden-advanced-setting-go" id='settingsGo'>
		<ul class="hidden-advanced-setting">
			<li>Вопросы</li>
			<hr>
			<li>Описание</li>
		</ul>
	</div>


</div>
<div class="showComments">
	

	<?php 

		if (isset($forum[0]['name']))
		{
			$this->showComments($forum, $_SESSION['user_uuid']);
		}
		else 
		{
			$this->showQuestions($forum);
		}

	?>

</div>
<?php 

	

	require 'application/views/common/formComment.php'; 
		
	


?>