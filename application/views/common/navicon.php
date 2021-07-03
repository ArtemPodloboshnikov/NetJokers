<input type="checkbox" id="hmt" class="hidden-menu-ticker">
	<label class="navicon" for="hmt">
 		<span class="first"></span>
  		<span class="second"></span>
  		<span class="third"></span>
	</label>
	
	<ul class="hidden-menu">
		<form action="" method="POST" class="hidden-menu__form">
  		<li class="hidden-menu__account">
  			<div class="account-image">
  				<a class="account-icon" href="<?=$_SESSION['constants']['CURRENT_DOMEN']; ?>profile/<?=$_SESSION['user_uuid']; ?>">
            <img src="<?=$_SESSION['constants']['CURRENT_DOMEN']; ?>public/images/users/<?=$_SESSION['user_image']; ?>" alt="<?=(isset($_SESSION['user_name']))?$_SESSION['user_name']: '¯\_(ツ)_/¯'; ?>">
          </a>
  			</div>
  		</li>
  		<li class="hidden-menu__search">
  			<div class="search">
  				
  					<div class="search__enter">
  						<input name="searchText">
  					</div>
  					<div class="search__magnifier">
  						<input type="image" src="http://localhost/NetJokers/public/images/system/search.svg" name="searchByInput">
  					</div>
  				
  			</div>
  		</li>
  		<li class="hidden-menu__result-search">
  			<div class="resultOfSearch">
  				<?php 
  				/*
  					if(isset($_POST['searchByInput'])){

  						$result = $this->model->getResultOfSearch($_POST['searchText']);
  						debug($result);
  							
  							a("class='resultOfSearch__result'", "href='news/'");

  							a();
  						
  						
  					}*/
  					

  				 ?>
  			</div>
  		</li> 
  		</form> 
	</ul>
  