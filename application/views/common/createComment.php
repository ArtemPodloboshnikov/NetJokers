<div class="createComment">
	<form method='POST' enctype="multipart/form-data">
		<div class="commentForm__hint">
			<p>>Цитата</p>
			<p>![Альтернативный текст](адрес картинки)</p>
			<p>[Текст ссылки](адрес ссылки)</p>
			<p>`Код`</p>
			<p>``Код с (`)``</p>
			<p>```Многострочный код```</p>
			<p>_Текст под наклоном_</p>
			<p>__Жирный текст__</p>
			<p>~~Зачёркнутый текст~~</p>
			<p>#h1, ##h2 и т.д</p>
			<p>\Экранирование</p>
			<p><a href="https://texterra.ru/blog/ischerpyvayushchaya-shpargalka-po-sintaksisu-razmetki-markdown-na-zametku-avtoram-veb-razrabotchikam.html">Markdown</a></p>
		</div>
		<textarea class="commentForm" name="commentText" placeholder="Напиши свой комментарий"><?php 

				if(isset($_SESSION['commentText']))
				{

					echo trim($_SESSION['commentText']);
					unset($_SESSION['commentText']);
				}


			 ?></textarea>
			
			
		

		<div class="commentForm__action"> 
			<div class="input__wrapper">
   				<input name="file" type="file" id="input__file" class="input input__file" accept="image/jpeg, image/png, image/svg+xml">
   				<label for="input__file" class="input__file-button">
      				<span class="input__file-icon-wrapper"><img class="input__file-icon" src="http://localhost/NetJokers/public/images/system/load.svg" width="25"></span>
      				<span class="input__file-separator"></span>
      				<span class="input__file-button-text">Выберите файл</span>
   				</label>
			</div>
  			<button type="submit" formaction="" name="load" class="load"><p>Загрузить</p></button>
			<button type="submit" formaction="http://localhost/NetJokers/preview" class="preview"><p>Предпросмотр</p></button>
			<button type="submit" formaction="" class="preview" name="deleteComment"><p>Удалить</p></button>
			<button type="submit" formaction="" class="preview" name="insertComment"><p>Отправить</p></button>
		</div>
	</form>
	
</div>