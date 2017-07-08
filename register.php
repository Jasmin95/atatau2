<?php

error_reporting(E_ALL);
ini_set('display_errors','On');

session_start();


if(isset($_SESSION['username']))
{
    $dispusername = $_POST["username"];
    $dispfullname = $_POST["fullname"];
    $dispemail = $_POST["email"];
}

if(!isset($_SESSION['info']))
{
	$_SESSION['info'] = "";
}


$emptyuser = "";
$emptypass = "";
$repass = "";
$emptyname = "";
$emptyemail = "";
$infomsg = "";

$dispusername = "";
$dispemail = "";
$dispfullname = "";



// Visualizzazione del messaggio di info sul tag HTML
if(isset($_SESSION['info']) && $_SESSION['info'] != "")
{
  $infomsg = $_SESSION['info'];
  $_SESSION['info'] = "";
}

?>
<!DOCTYPE html>
<html>
<head>
  <title>Message Board</title>
  <?php include('header.php'); ?>

    <script src="js/register.js"></script>
</head>
<body>
<form id="form-registrazione" method="POST">
<table id="register_table">
  <tr>
    <td width="116"><div align="right">Username</div></td>
    <td width="177"><input name="username" value="<?php echo $dispusername; ?>" type="text" /></td>
    <td nowrap><span class="error"><?php echo $emptyuser;?></span></td>
  </tr>
  <tr>
    <td><div align="right">Password</div></td>
    <td><input name="password" type="password" /></td>
    <td nowrap><span class="error"><?php echo $emptypass;?></span></td>
  </tr>
  <tr>
    <td><div align="right">Retype Password</div></td>
    <td><input name="repassword" type="password" /></td>
    <td nowrap><span class="error"><?php echo $repass;?></span></td>
  </tr>
  <tr>
    <td width="116"><div align="right">Fullname</div></td>
    <td width="177"><input name="fullname" value="<?php echo $dispfullname; ?>" type="text" /></td>
    <td nowrap><span class="error"><?php echo $emptyname;?></span></td>
  </tr>
  <tr>
    <td width="116"><div align="right">Email</div></td>
    <td width="177"><input name="email" value="<?php echo $dispemail; ?>" type="text" /></td>
    <td nowrap><span class="error"><?php echo $emptyemail;?></span></td>
  </tr>
  <tr>
	<td><a href="board.php">Accedi</a></td>
	<td align="center"><input name="newuser" type="submit" value="Register" /></td>
    <td nowrap><span class="error"><?php echo $infomsg;?></span></td>
  </tr>
</table>
</form>
<?php include('footer.php'); ?>
</body>
</html>