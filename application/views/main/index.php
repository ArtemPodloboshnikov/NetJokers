<?php 

	$_SESSION['page'] = $_SESSION['constants']['CURRENT_DOMEN'];
	//debug($news);
	require 'application/views/common/mainHeader.php';

 ?>
<div class="backgroundMain">
<div class="breakNews">

	<input class="breakNews__hidden-controls" type="radio" name="control" id="slide1" checked>
	<input class="breakNews__hidden-controls" type="radio" name="control" id="slide2">
	<input class="breakNews__hidden-controls" type="radio" name="control" id="slide3">
	
	<?php $this->showSlides($news, "news", ["slide1", "slide2", "slide3"]); ?>
	<div class="breakNews__navigation">
		
		<label class="breakNews__navigation-slide1" for="slide1">
			<div class="breakNews__navigation-slide1Checked"></div>
		</label>
		<label class="breakNews__navigation-slide2" for="slide2">
			<div class="breakNews__navigation-slide2Checked"></div>
		</label>
		<label class="breakNews__navigation-slide3" for="slide3">
			<div class="breakNews__navigation-slide3Checked"></div>
		</label>
		

	</div>

</div>

<div class="separate-Advantages">
	<h1>
		Наши преимущества
	</h1>
</div>
<div class="advantages">
	<div class="advantages__advantage">
		<div class="advantages__advantage-title">
			<h1>
				Низкая цена
			</h1>
		</div>
		<div class="advantages__advantage-text">
			<p>
				Для нас цена не имеет особого значения, потому она такая низкая. Задача владельцов данного портала – создание площадки для широкого круга пользователей, желающих изучать сферу информационной безопасности
			</p>
		</div>
	</div>
	<div class="advantages__advantage">
		<div class="advantages__advantage-title">
			<h1>
				Обратная связь
			</h1>
		</div>
		<div class="advantages__advantage-text">
			<p>
				У нас есть множество форумов. Ты всегда можешь связаться с админами. Задать вопросы под видео-уроками. У нас есть свой канал в Riot
			</p>
		</div>
	</div>
	<div class="advantages__advantage">
		<div class="advantages__advantage-title">
			<h1>
				Возможность заработать
			</h1>
		</div>
		<div class="advantages__advantage-text">
			<p>
				Ты можешь стать редактором и писать статьи для сайта. А можешь предложить свой товар и стать поставщиком. Если же ты хочешь зарабатывать знаниями, которые ты здесь получаешь, то можешь отметить у себя в профиле "Ищу работу", сделать резюме, оставить контакты и с тобой обязательно кто-то свяжется
			</p>
		</div>
	</div>
	<div class="want">
		<div class="want__background">
			
		</div>
		<p>
			Хочу
		</p>
	</div>

	<div class="whoWeAre">
	<div class="emploer-1">
		<p>Lorem ipsum, dolor, sit amet consectetur adipisicing elit. Aspernatur fugit praesentium animi cupiditate, dolorem, similique quo dolor quis eos accusantium facere nostrum quasi at maiores distinctio eius modi obcaecati, suscipit? Lorem ipsum dolor, sit, amet consectetur adipisicing elit. Quae ipsum nisi illo eligendi optio iste est aliquid magni delectus impedit, odio recusandae similique vitae at consectetur earum labore doloremque explicabo. Lorem ipsum dolor sit amet consectetur adipisicing, elit. Quam odio blanditiis, debitis similique nesciunt, voluptatem consequatur officiis officia adipisci! Expedita veniam beatae, porro vel, aliquid fuga aspernatur accusantium eos alias.
		</p>
		<div class="emploer-1__image">
		</div>
		<img class="emploer-1__icon" src="<?=$_SESSION['constants']['CURRENT_DOMEN']; ?>public/images/system/hacker_mask.svg" alt="">
	</div>
	<div class="emploer-2">
		<div class="emploer-2__image">
		</div>
		<img class="emploer-2__icon" src="<?=$_SESSION['constants']['CURRENT_DOMEN']; ?>public/images/system/computer.svg" alt="">
		<p>Lorem ipsum, dolor, sit amet consectetur adipisicing elit. Aspernatur fugit praesentium animi cupiditate, dolorem, similique quo dolor quis eos accusantium facere nostrum quasi at maiores distinctio eius modi obcaecati, suscipit? Lorem, ipsum dolor, sit amet consectetur adipisicing elit. Provident expedita obcaecati repudiandae, distinctio alias blanditiis officia, esse sint nihil. Sed minima aliquid quidem saepe, eius. Consequatur corporis maiores tempora, similique?
		</p>
	</div>
	</div>

</div>

<div class="registration">
	<div class="registration__image">
		<h3>Зарегистрируйся в</h3>
		<h1>Клик</h1>
		<img src="http://localhost/NetJokers/public/images/system/click.svg">
	</div>
	<form class="registration__form" method="POST">
		<div class="registration__form-InputWrapper">
			<input type="text" class="registration__form-InputData" placeholder="name">
		</div>
		<div class="registration__form-InputWrapper">
			<input type="password" class="registration__form-InputData" placeholder="password">
		</div>
		<div class="registration__form-InputWrapper">
			<input type="password" class="registration__form-InputData" placeholder="repeat password">
		</div>
		<div class="registration__form-InputWrapper">
			<input class="registration__form-InputData" placeholder="email">
		</div>
		<div class="registration__form-enter">
			<button type="submit" formaction="<?=$_SESSION['constants']['CURRENT_DOMEN']; ?>subscription" class="preview registration__form-enterInput" name="insertComment"><p>Отправить</p></button>
		</div>
	</form>


</div>
</div>
<div class="footer">
	
	<img src="../../../NetJokers/public/images/system/footerLogo.svg" class="footer__logo">

</div>