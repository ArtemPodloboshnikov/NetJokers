<?php ini_set("display_errors", 1);

error_reporting(E_ERROR | E_WARNING | E_PARSE); 

	$_SESSION['page'] = $_SESSION['constants']['CURRENT_DOMEN']."news";	
	require 'application/views/common/mainHeader.php';

?>


<form action="" method="POST">
<div class="search-news">
		
		<div class="search-news__category">
		<div class="search">
			<div class="search__enter search__enter_full">
  				<select name='searchCategory[]' multiple>
  					<option value="" disabled>Search by category</option>
  					<?=$tagsAsOption('category'); ?>
  				</select>
  			</div>
  			
		</div>
		</div>
		<div class="search-news__tag">
		<div class="search">
			<div class="search__enter search__enter_full">
  				<select name='searchTag[]' multiple>
  					<option value="" disabled>Search by category</option>
  					<?=$tagsAsOption(); ?>
  				</select>
  			</div>
  			
		</div>
		</div>
		<div class="search-news__input">
		<div class="search">
  			
  			<div class="search__enter">
  				<input name="searchText">
  			</div>
  			<div class="search__magnifier">
  				<input type="image" src="http://localhost/NetJokers/public/images/system/search.svg" name="searchByInput">
  			</div>
  		</div>	
  		</div>
	

</div>
</form>
<div class="content">	
	<?php 

		if(isset($_POST['searchByInput_x']))
		{

			$news = $start_search($_POST['searchText'], $_POST['searchTag'], $_POST['searchCategory'], ['title', 'cover', 'new_id as id', 'body'], 'tags_category_id', 'title', 'news');
		}
		

		$this->showBlock($forums, 'forums', 3);
		
		

	 ?>
	
</div>	