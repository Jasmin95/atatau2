<?php
error_reporting(E_ALL);
ini_set('display_errors','On');


session_start();


if(isset($_SESSION['username']))
{
	header('Location: index.php');
	exit();
}


$emptyuser = "";
$emptypass = "";
$infomsg = "";


if (isset($_POST["login"]))
{

   if (empty($_POST["username"]) || empty($_POST["password"]))
   {
      if (empty($_POST["username"]))
      {
        $emptyuser = "* Devi inserire un username"; 
      }
      if (empty($_POST["password"]))
      {
        $emptypass = "* Devi inserire una password";  
      }
   }
   else //connessione database
   {

		$username = $_POST["username"];
		$password = md5($_POST["password"]);
	  
		$dbpath = __DIR__ . '/mydb.sqlite';
		
        $dbh = new SQLite3($dbpath);


        $stmt = $dbh->prepare("SELECT * FROM users WHERE username='". $username ."'");
        $execquery = $stmt->execute();

        if($execquery == false)
        {
            $_SESSION['info'] = "Oops, qualcosa non va. Riprova più tardi.";
        }
        else
        {
			$acc = $execquery->fetchArray(SQLITE3_ASSOC);
			if ($acc)
			{
				if($acc['password'] == $password)
				{
					// Assegno le varibili alle variabili di sessione
					$_SESSION['username'] = $username;
					$_SESSION['fullname'] = $acc['fullname'];
					$_SESSION['status'] = "Active";
					session_write_close();
					// login andato -> vado alla prossima pagina
					header("location: message.php");
					exit();
				}
				else {
					$_SESSION['info'] = "Account o password errati";
				}
			}
			else {
				$_SESSION['info'] = "Account o password errati";
			}
        }
    }
}

// Vengono diffuse varie informazioni da diverse pagine, tutti i messaggi vengono verificati qui e mostrati in base al tag html
if(isset($_SESSION['info']))
{
  $infomsg = $_SESSION['info'];
  unset($_SESSION['info']);
}

?>
<!DOCTYPE html>
<html>
	<head>
		<?php include('header.php'); ?>
	</head>
	<body>
	<form action="board.php" method="POST">
	<div id="tabble_container">
			<table id="login_table">
		  		<tr>
					<td><div align="right">Username</div></td>
					<td><input name="username" type="text" /></td>
					<td nowrap><span class="error" "><?php echo $emptyuser;?></span></td>
		  		</tr>
		  		<tr>
					<td><div align="right">Password</div></td>
					<td><input name="password" type="password" /></td>
					<td nowrap><span class="error"><?php echo $emptypass;?></span></td>
		  		</tr>
		  		<tr>
					<td style="text-align:right"><a href="register.php">Registrati qui</a></td>
					<td align="center"><input name="login" type="submit" value="Login" /></td>
					<td nowrap><span class="error"><?php echo $infomsg;?></span></td>
		  		</tr>
			</table>
			</div>
	</form>
	<?php include('footer.php'); ?>
</body>
</html>
