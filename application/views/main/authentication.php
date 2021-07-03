<?php 

	if (isset($_POST['enter']))
	{
		//$_POST['password'] = hash("sha256", $_POST['password']);
		
		if ($userAuthentication($_POST['name'], $_POST['password']))
		{
			if (!isset($_SESSION['page']))
			{

				$_SESSION['page'] = $_SESSION['constants']['CURRENT_DOMEN'];
			}
			$page = $_SESSION['page'];
			unset($_SESSION['page']);
			$this->redirect($page);	
		}
		
	}

 ?>
<div class="window">
	<img src="http://localhost/NetJokers/public/images/system/diamonds_auth.svg" class='diamonds'>
	<img src="http://localhost/NetJokers/public/images/system/clubs_auth.svg" class='clubs'>
	<img src="http://localhost/NetJokers/public/images/system/heart_auth.svg" class='heart'>
	<img src="http://localhost/NetJokers/public/images/system/spades_auth.svg" class='spades'>
	<form action="" method="POST">
		<input name="name" class="input" placeholder="имя">
		<input name="password" type="password" class="input" placeholder="пароль">
		<button name="enter" type="submit" class='preview'><p>Войти</p></button>
	</form>
</div>