<div class="header">
  <div class="menu">
  
    <img class="header__logo" src="http://localhost/NetJokers/public/images/system/logoGrey.svg" alt="NetJokers">
    <a class="menu__button" href="news">
      <img class="menu__button-image_one" src="http://localhost/NetJokers/public/images/system/spades.svg">
      <p>Новости</p>
      <img class="menu__button-news" src="http://localhost/NetJokers/public/images/system/news.svg">
      <img class="menu__button-image_two" src="http://localhost/NetJokers/public/images/system/spades.svg">
    </a>
  
  
    <a class="menu__button" href="news/show">
      <img class="menu__button-image_one" src="http://localhost/NetJokers/public/images/system/diamonds.svg">
      <p>Поиск</p>
      <img class="menu__button-chat" src="http://localhost/NetJokers/public/images/system/chat.svg">
      <img class="menu__button-image_two" src="http://localhost/NetJokers/public/images/system/diamonds.svg">
    </a>
    
    
  
    <a class="menu__button" href="forums">
      <img class="menu__button-image_one" src="http://localhost/NetJokers/public/images/system/clubs.svg">
      <p>Форум</p>
      <img class="menu__button-forum" src="http://localhost/NetJokers/public/images/system/forum.svg">
      <img class="menu__button-image_two" src="http://localhost/NetJokers/public/images/system/clubs.svg">
    </a>
  
    <a class="menu__button" href="shop">
      <img class="menu__button-image_one" src="http://localhost/NetJokers/public/images/system/heart.svg">
      <p>Магазин</p>
      <img class="menu__button-cart" src="http://localhost/NetJokers/public/images/system/cart.svg">
      <img class="menu__button-image_two" src="http://localhost/NetJokers/public/images/system/heart.svg">
    </a>

    <?php require 'application/views/common/navicon.php'; ?>
  
    <div class="ourVk">
      <a href="https://vk.com/netjokers"><img src="http://localhost/NetJokers/public/images/system/vk_main.svg" alt="vk"></a>
   </div>
  </div>

<?php 

      if ($_SESSION['page'] == $_SESSION['constants']['CURRENT_DOMEN'])
      {

          div("class='slogan header__indent_top'");
            div("class='slogan-1'");
              h1("");
                echo "Хочешь стать";
              h1();
            div();
            div("class='slogan-2'");
              h1("");
                echo "хакером?";
              h1();
            div();
            div("class='slogan-3'");
              h1("");
                echo "тогда ты зашёл туда, куда нужно!";
              h1();
            div();
          div();
      }
      if (strpos($_SESSION['page'], "profile") !== false)
      {
        div("class='mainProfile__image'");
            img("class='mainProfile__image-profileImage'", "src='http://localhost/NetJokers/public/images/users/".$data[0]['image']."'");
            form("method='POST'", "enctype='multipart/form-data'");
                div("class='input__file-wrapper'");
                    input("name='file'", "type='file'", "id='input__file'", "class='input input__file'");
                    label("for='input__file'", "class='input__file-button'");
                        span("class='input__file-icon-wrapper'");
                            img("class='input__file-icon'", "src='http://localhost/NetJokers/public/images/system/load.svg'", "width='25'");
                        span();
                        span("class='input__file-separator'");
                        span();
                        span("class='input__file-button-text'");
                            echo "Выберите файл";
                        span();
                    label();
                div();
                button("type='submit'", "formaction=''", "name='loadNewImage'", "class='load'");
                    p("");
                        echo "Загрузить";
                    p();
                button();
            form();
        div();
      }

   ?>
	 
	</div>