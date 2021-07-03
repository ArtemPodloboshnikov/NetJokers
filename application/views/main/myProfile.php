<?php 
	
	ini_set("display_errors", 1);

	error_reporting(E_ERROR | E_WARNING | E_PARSE);

	$deleteFileListener($_POST['deleteFile'], $_POST['pathToFile']);
	
	require 'application/views/common/mainHeader.php';
 ?>
<div class="mainProfile myProfile">
	
	<div class="mainProfile__name">
		<input name="name" value="<?=$data[0]['name']; ?>" placeholder="name">
	</div>
	<div class="mainProfile__password">
		<input type="password" name="password" placeholder="password">
	</div>
	<div class="mainProfile__repeatPassword">
		<input type="password" name="repeatPassword" placeholder="repeat password">
	</div>
	<div class="mainProfile__currentPassword">
		<input type="password" name="currentPassword" placeholder="*current password">
	</div>
	

		<?php 

			$this->filesShow("./public/images/users/".$_SESSION['user_dir'], $_SESSION['user_dir']);

		 ?>
</div>