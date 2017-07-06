<?php
session_start();

function logout() {
	session_unset();
	session_destroy();
}

if(isset($_POST['logout'])) {
	logout();
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
  <?php include('header.php'); ?>
</head>
<body>
  <div id="description_container">
  		<p id="description">Benvenuti ad ATATAU, una piccola piattaforma per la condivisione dei messaggi. <a href="message.php">Comincia a condividere</a>!</p>
	</div>
	<?php include('footer.php'); ?>
</body>
</html>