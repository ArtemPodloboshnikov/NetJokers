<div style="width: 100%; min-height:100%; display: grid; justify-items: center; align-items: center; background-color: grey;">
	<div class="comment">
		<div class="comment__link">
			<label>
				<img src="http://localhost/NetJokers/public/images/system/comment_link.svg">
			</label>
		</div>
		<div class="comment-content">
		<?php
			use application\lib\Markdown;
			$mackdown = new Markdown();
			//var_dump($_POST['commentText']);
			$mackdown->setSafeMode(true);
			echo $mackdown->text(trim($_POST['commentText']));  


		?>
		</div>
		<div class="comment__who">
			<a href="http://localhost/NetJokers/profile/<?php echo  $_SESSION['user_uuid']; ?>" style="background-image: url('http://localhost/NetJokers/public/images/users/<?php echo $_SESSION['user_image']; ?>')">
			</a>
			<p><?=$_SESSION['user_name']; ?></p>
		</div>
		<div class="comment__likes">
			<input type='image' src="http://localhost/NetJokers/public/images/system/comment_heart.svg">
			<div class="comment__likes-count">
				0
			</div>
		</div>
		<div class="comment__dateTime">
			<p><?php echo date("H:i m.d.y"); ?></p>
			<input type="image" src="http://localhost/NetJokers/public/images/system/reply.svg">
		</div>
	</div>
</div>