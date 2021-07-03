<?php 
	
	ini_set("display_errors", 1);

	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	
	$_SESSION['page'] = $_SESSION['constants']['CURRENT_DOMEN'].'basket';

	if (isset($_POST['delete']))
	{
		if (!isset($_POST['countOrder']))
		{
			$_POST['countOrder'] = 0;
		}
		$deleteOrder($_SESSION['user_uuid'], $_POST['product_id'], $_POST['countOrder']);

		$this->redirect($_SERVER['REQUEST_URI']);
	}
 ?>
<div class="mainBasket">
	
	<?=$this->showOrders($basket);  ?>

</div>