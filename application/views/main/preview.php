<?php 

	if (strpos($_SESSION['page'], 'storeroom') !== false)
	{

		require 'application/views/main/previewComment.php';
	}
	elseif (strpos($_SESSION['page'], 'journal') !== false)
	{
		require 'application/views/main/previewNews.php';
	}
 ?>

