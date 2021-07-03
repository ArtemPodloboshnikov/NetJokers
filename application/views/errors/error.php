<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="<?=$_SESSION['constants']['CURRENT_DOMEN']; ?>public/styles/error.css">
	<title><?=$code; ?></title>
</head>
<body>
	<div class="mainError">
	
	<div class="error">
		
		<h1><?=$code; ?></h1>
		<p><?=$codeDescription[$code]; ?></p>
		<img src="<?=$_SESSION['constants']['CURRENT_DOMEN']; ?>public/images/system/logoGrey.svg" alt="NetJokers">
	</div>

</div>
</body>
</html>
