<?php ini_set("display_errors", 1);

error_reporting(E_ERROR | E_WARNING | E_PARSE); ?>
<div class="mainSearch">
	<a class="mainSearch__mask" href="http://localhost/NetJokers">
		<img src="../../../NetJokers/public/images/system/logoGrey.svg">
		
	</a>
	
	<div class="mainSearch__searchInput">
		<form action="http://localhost/NetJokers/search" method="POST">
		<div class="mainSearch__searchInput-input">	
		<div class="search">
  				
  			<div class="search__enter">
  				<input name="searchText">
  			</div>
  			<div class="search__magnifier">
  				<input type="image" src="http://localhost/NetJokers/public/images/system/search.svg" name="searchByInput">
  			</div>
  				
  		</div>
  		</div>
  		<div class="mainSearch__searchInput-category">
		<div class="search">
			<div class="search__enter search__enter_full">
  				<select name='searchCategory[]' multiple>
  					<option value="" disabled class="disabledOption">Search by category</option>
  					<?=$tagsAsOption('category'); ?>
  				</select>
  			</div>
  			
		</div>
		</div>
		<div class="mainSearch__searchInput-tag">
		<div class="search">
			<div class="search__enter search__enter_full">
  				<select name='searchTag[]' multiple>
  					<option value="" disabled>Search by tag</option>
  					<?=$tagsAsOption(); ?>
  				</select>
  			</div>
  			
		</div>
		</div>


		</form>
	</div>
	
	<div class="mainSearch__resultSearch">	

		<?php 	
			//var_dump($_POST['searchByInput_x']);
			if (!empty($search))
			{
				$this->showBlock($search, 'news', 1);
			}
			if (isset($_POST['searchByInput_x'])){
				
				//var_dump($_POST['searchCategory']);
				$search = $start_search($_POST['searchText'], $_POST['searchTag'], $_POST['searchCategory'], ['title', 'cover', 'new_id', 'body'], 'tags_category_id', 'title', 'news');
				
				$this->showBlock($search, 'news', 1);
			}

		 ?>

	</div>
	<div class="mainSearch__allCategory">
		
		<?php 

			$this->showTagsAsLinks($categoryAll, "<br><br>");


		 ?>

	</div>
	<div class="mainSearch__allTags">
		
		<?php 

			$this->showTagsAsLinks($tagsAll, "<br><br>");


		 ?>

	</div>
</div>