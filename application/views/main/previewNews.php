<?php 
	
	ini_set("display_errors", 1);

	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	$_SESSION['body_news_maker'] = $_POST['content'];
 ?>
<div class="article">
	<div class="article__title">
		<?=$_POST['title'];  ?>

	</div>
	<div class="article__content">
		<?=$this->markdown->text(str_replace('@MyImages', $_SESSION['constants']['CURRENT_DOMEN']."public/images/users", $_POST['content'])); ?>
	</div>
	<div class="article__tags">
		<p>
		<?php

			$links = $this->arrayLinksToString($_POST['tags'], $_POST['categories'], $_POST['categories_tags']);
			
			$this->showTagsAsLinks($links, "  ");  
		

		?>
		</p>
	</div>
</div>