<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<link rel="stylesheet" type="text/css" href="http://localhost/NetJokers/public/styles/main.css">
	<link rel="preload" as="style" href="http://localhost/NetJokers/public/styles/main.css">
	<?php  

		if(isset($css)){

			foreach ($css as $key => $val) {
			

				echo "<link rel='stylesheet' type='text/css' href='http://localhost/NetJokers/public/styles/".$val.".css'>";
			}
		}
		
	?>
	<title><?=$title; ?></title>
</head>
<body>
	<?=$content; ?>
</body>
</html>
