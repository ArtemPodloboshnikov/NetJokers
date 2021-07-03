<?php 
	ini_set("display_errors", 1);

	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	
	
	$_SESSION['page'] = $_SESSION['constants']['CURRENT_DOMEN'].'news/'.$new['new_id'];
	$path = $_SERVER['DOCUMENT_ROOT'].'/NetJokers/public/images/users/'.$_SESSION['user_dir'];
 	
 	if (!isset($_SESSION['view'])) {

 		//debug($_SERVER['REMOTE_ADDR']);
 		$_SESSION['view'] = $counterViews($_SERVER['REMOTE_ADDR'], $new['title']);
 	}
 	//unset($_SESSION['view']);
 	if (isset($_POST['likeNew_x']))
 	{

 		$likeToggle($new['title'], 'title', $_SESSION['user_uuid'], 'news');
 		$this->redirect($_SERVER['REQUEST_URI']);
 	}
 	$params = [

 		'buttonLoad' => $_POST['load'],
 		'loadFile' => $_FILES['file'],
 		'path' => $_SESSION['constants']['CURRENT_DOMEN']."public/images/users/".$_SESSION['user_dir'],
 		'question' => null,
 		'commentText' => $_POST['commentText'],
 		'currentURL' => $_SERVER['REQUEST_URI'],
 		'buttonInsert' => $_POST['insertComment'],
 		'buttonDelete' => $_POST['deleteComment'],
 		'arrayWithComments' => $new,
 		'contentComment' => $_POST['contentComment'],
 		'UUIDComment' => $_POST['commentUUID'],
 		'contentOriginComment' => $_POST['contentOriginComment'],
 		'columnIdentifierForLike' => 'comment_uuid',
 		'columnIdentifierForBan' => 'new_id',
 		'tableBan' => 'news',
 		'page_id' => $new['new_id'],
 		'userUUID' => $_POST['userUUID'],
 		'buttonBan' => $_POST['ban_x'],
 		'buttonRemoveBan' => $_POST['removeBan_x'],
 		'junctionTable' => 'news_comments',
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
<div class="cover" style="background-image: url('http://localhost/NetJokers/public/images/news/<?=$new['new_cover']; ?>')">
	
	<?php require 'application/views/common/navicon.php'; ?>
	<a class="cover__author" href='<?=$_SESSION['constants']['CURRENT_DOMEN']; ?>profile/<?=$new["author_uuid"]; ?>' style="background-image: url('../../../NetJokers/public/images/users/<?=$new['author_image']; ?>');" aria-label="<?=$new['author_name'];  ?>"></a>
	<div class="cover__comments">
		<div class="cover__comments-count">
			<?php 

				if ($answer['endIndexOfComment'] > 10000)
				{ 
					$countComment = "10000+";
				}
				else
				{
					$countComment = $answer['endIndexOfComment'];
				}
				
				echo $countComment; 
			?>
		</div>
		<img src="../../../NetJokers/public/images/system/comment_new.svg">
	</div>
	<div class="cover__likes">
		<div class="cover__likes-count">
			<?=$new['new_likes']; ?>
		</div>
		<form action="" method='POST'>
			<input type='image' src="../../../NetJokers/public/images/system/heart_new.svg" name='likeNew'>
		</form>
	</div>
	<div class="cover__views">
		<div class="cover__views-count">
			<?=$new['new_views']; ?>
		</div>
		<img src="../../../NetJokers/public/images/system/eye.svg">
	</div>
	<div class="cover__date">
		<?=date("d.m.y", strtotime($new['new_date'])); ?>
	</div>
</div>
<div class="article">
	<div class="article__title">
		<h1><?=$new['title'];  ?></h1>
	</div>
	<div class="article__content">
		
		<?=$new['content'];  ?>

	</div>
	<div class="article__tags">
		<p>
		<?php $this->showTagsAsLinks($new['tags'], "  "); ?>
		</p>
	</div>
</div>
<div class="showComments">
	
	<?php 

		
		echo $answer['comments'];

	 ?>
</div>
<?php 
	
	$ban = false;

	foreach ($new['ban'] as $key => $val) {
						
		if ($val == $_SESSION['user_uuid'])
		{
			$ban = true;
		}
	}
	if (!$ban)
	{

		require 'application/views/common/createComment.php'; 
	}
	else
	{
		require 'application/views/common/youWasBanned.php';
	}


?>