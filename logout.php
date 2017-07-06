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
	<title>Logout</title>
  <?php include('header.php'); ?>
</head>
<body>
	<?php if(isset($_SESSION['username'])) { ?>		
		<form method="POST" action="index.php">
			<div id="logout_btn_wrap">
			<input id="logout_button" type="submit" name="logout" value="Logout">
			</div>
		</form>
	<?php } ?>
	<?php include('footer.php'); ?>
</body>
</html>