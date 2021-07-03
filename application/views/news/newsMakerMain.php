<?php 

	//debug($getMyNews($_SESSION['user_uuid']));
	if (isset($_POST['load']))
	{
		$loadFile($_FILES['file'], $_POST['content'], $_SESSION['constants']['CURRENT_DOMEN'].$_SESSION['temp_dir_article'], $_SESSION['page']);
	}
 ?>
<div class="newsMaker">
	<form action="" method="POST" enctype="multipart/form-data">
		<input name="title" class="newsMaker__title input" placeholder="Заголовок" value="<?=$_SESSION['title_news_maker']; ?>">
		<div class="loadFileCover">
				<div class="input__file-wrapper">
   					<input name="fileCover" type="file" id="input__file" class="input input__file" multiple>
   					<label for="input__file" class="input__file-button">
      					<span class="input__file-icon-wrapper"><img class="input__file-icon" src="http://localhost/NetJokers/public/images/system/load.svg" width="25"></span>
      					<span class="input__file-separator"></span>
      					<span class="input__file-button-text">	Выберите файл</span>
   					</label>
				</div>
				<button type="submit" formaction="" name="loadCover" class="load"><p>Загрузить</p></button>
			</div>
		<textarea class='commentForm' placeholder="Текст статьи" name="content"><?=$_SESSION['body_news_maker']; ?></textarea>
		<div class="tagsANDcategories">
			
			<input placeholder="#хештег категория" class="input enter_tags_categories" name="categories_tags" value="<?=$_SESSION['tags_news_maker']; ?>">
			<div class="search-news__category">
				<?php $tagsAsCheckbox("categories", "category"); ?>
			</div>
			<div class="search-news__tag">
				<?php $tagsAsCheckbox("tags", "tag"); ?>
			</div>
		</div>
		<div class="newsMaker__buttons">
			<div class="input__file-wrapper">
   				<input name="file" type="file" id="input__file" class="input input__file" multiple>
   				<label for="input__file" class="input__file-button">
      				<span class="input__file-icon-wrapper"><img class="input__file-icon" src="http://localhost/NetJokers/public/images/system/load.svg" width="25"></span>
      				<span class="input__file-separator"></span>
      				<span class="input__file-button-text">Выберите файл</span>
   				</label>
			</div>
			<button type="submit" formaction="" name="load" class="load"><p>Загрузить</p></button>
			<button type="submit" class="preview" formaction="" name="saveArticle">
				<p>Сохранить</p>
			</button>
			<button type="submit" class="preview" formaction="<?=$_SESSION['constants']['CURRENT_DOMEN']; ?>preview">
				<p>Предпросмотр</p>
			</button>
			<button class="send publish" type="submit" name="publishArticle">
				<p>Выложить</p>
			</button>
		</div>
		<div class="myArticles">
		<div class="search">
			<div class="search__enter search__enter_full">
  				<select name='newsTitle'>
  					<option value="" disabled selected>Мои статьи</option>
  					<?=$this->myArticleAsOption($getMyNews($_SESSION['user_uuid']), 'new_id','title'); ?>
  				</select>
  			</div>
		</div>
		<button name="openMyArticle" type="submit" class="preview" formaction="">
			<p>Открыть</p>
		</button>
		</div>
		<br>
		<br>
		<br>
	</form>
</div>