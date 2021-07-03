<?php 
	
	$_SESSION['page'] = $_SESSION['constants']['CURRENT_DOMEN']."profile/".$data[0]['user_uuid'];

	if ($_SESSION['user_uuid'] != $data[0]['user_uuid'])
	{

		require 'application/views/main/alienProfile.php';
	}
	else
	{
		require 'application/views/main/myProfile.php';
	}
 ?>

