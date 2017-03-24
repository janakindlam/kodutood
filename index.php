<!DOCTYPE html>
	<head>
		
		<meta charset="utf-8">
		<title> praktikum </title>
		<link rel="stylesheet" href="style.css">


	</head>
	<body>
	
		<div class="lingid">
			<a href="kiri.html" target="frame">Esimene kodutöö</a>
		</div>
		
		<iframe name="frame">
		</iframe/>
		
		
		<button onclick="setTimeout(myFunction, 3000);"> Proovi </button>
		
		<script>
		function myFunction() {
			alert('Hello');
		}
		</script>
	<?php	
	echo 'Current PHP version: ' . phpversion();
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	?>
	</body>
</html>


