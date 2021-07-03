<?php 

	$_SESSION['page'] = $_SESSION['constants']['CURRENT_DOMEN'].'storeroom';
 ?>
<div class="shopMaker">
	<form action="" method="POST">
		<input name="title" class="shopMaker__title input" placeholder="Заголовок">
		<textarea class='commentForm' placeholder="Текст статьи" name="content"></textarea>
		<div class="tagsANDcategories">
			
			<input placeholder="#хештег, категория" class="input enter_tags_categories" name="categories_tags">
			<div class="search-news__category">
		<div class="search">
			<div class="search__enter search__enter_full">
  				<select name='categories[]' multiple>
  					<option value="" disabled>Категории</option>
  					<?=$tagsAsOption('category'); ?>
  				</select>
  			</div>
  			
		</div>
		</div>
		<div class="search-news__tag">
		<div class="search">
			<div class="search__enter search__enter_full">
  				<select name='tags[]' multiple>
  					<option value="" disabled>Теги</option>
  					<?=$tagsAsOption('tag'); ?>
  				</select>
  			</div>
  			
		</div>
		</div>
		</div>
		<div class="shopMaker__buttons">
			<button type="submit" class="preview" formaction="<?=$_SESSION['constants']['CURRENT_DOMEN']; ?>preview">
				<p>Предпросмотр</p>
			</button>
			<button class="send" type="submit">
				<p>Выложить</p>
			</button>
		</div>
		<div class="search-news__tag">
		<div class="search">
			<div class="search__enter search__enter_full">
  				<select name='newsTitle[]' multiple>
  					<option value="" disabled>Мои продукты</option>
  					<?=$this->myWorks($getMyProducts($_SESSION['user_uuid']), 'title'); ?>
  				</select>
  			</div>
		</div>
		</div>
		<br>
		<br>
		<br>
	</form>
</div>