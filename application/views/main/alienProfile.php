<?php 

	debug($data);
 ?>
<div class="mainProfile">
	<div class="mainProfile__mainAlienImage">
	<div class="mainProfile__alienImage">
		<img src="http://localhost/NetJokers/public/images/users/<?=$data[0]['image']; ?>" alt="<?=$data[0]['name']; ?>">
	</div>
	</div>
	<div class="mainProfile__alienDescription">
		<p>
			<?=$this->validationDateFromDB($data[0]['description']); ?>
		</p>
	</div>
	<div class="mainProfile__alienSocialNetworks">
		<p>
			<?=$this->markdown($data[0]['contacts']); ?>
		</p>
	</div>
</div>