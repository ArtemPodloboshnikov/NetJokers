<?php 
	ini_set("display_errors", 1);

error_reporting(E_ERROR | E_WARNING | E_PARSE);
	
	$_SESSION['page'] = $_SESSION['constants']['CURRENT_DOMEN'].'shop';

	if (isset($_POST['buy']))
	{

		if (!isset($_POST['countProduct']))
		{

			$_POST['countProduct'] = 0;	
		}
		$_SESSION['order'] = $newOrder($_SESSION['user_uuid'], $_POST['product_id'], $_POST['countProduct']);
		$this->redirect($_SERVER['REQUEST_URI']);
	}
	if (!$_SESSION['order'])
	{
		//debug($products);
	}
 ?>
<div class="mainShop">
	

	<?=$this->showProducts($products); ?>

</div>
<div class="shopCategories">
	<div class="shopCategories__shadow"></div>
	<div class="shopCategories__categories-links">
		
		<?=$this->showProductAsLinks($products); ?>
			
	</div>
</div>	