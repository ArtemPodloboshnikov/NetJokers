
<div class="mainTitle">
	<form action="" method="POST">
		<input name="title" class="mainTitle__title input" placeholder="Заголовок">
		<div class="search">
			<div class="search__enter search__enter_full">
  				<select name='newsTitle'>
  					<option value="" disabled selected>Мои статьи</option>
  					<?=$this->myTempFilesAsOption($_SESSION['user_name']); ?>
  				</select>
  			</div>
		</div>
		<button class="send" type="submit" name="next">
			<p>Продолжить</p>
		</button>
	</form>
</div>