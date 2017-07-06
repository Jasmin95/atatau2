<?php
error_reporting(E_ALL);
ini_set('display_errors','On');

//Start session
session_start();

// Initial declaration of all the session variables that are used
if(isset($_SESSION['username']))
{
	header('Location: index.php');
	exit();
}

// Variable declaration
$emptyuser = "";
$emptypass = "";
$infomsg = "";

// Actions to be performed when Login button is clicked
if (isset($_POST["login"]))
{
    // This is to validate whether the Mandatory fields are filled are not
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
   else //blocco connessione database
   {
		// Retrieving the valid login credentials and stored in a variable
		$username = $_POST["username"];
		$password = md5($_POST["password"]);  // md5 methodology is used for password encryption
	  
		$dbpath = __DIR__ . '/mydb.sqlite';
		
        $dbh = new SQLite3($dbpath);
		
        // Validating the login credentials by sending a database query
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
					// Assign values to the session variables
					$_SESSION['username'] = $username;
					$_SESSION['fullname'] = $acc['fullname'];
					$_SESSION['status'] = "Active";
					session_write_close();
					// Call the next page that is Message Board page
					header("location: message.php");
					exit();
				}
				else {
					$_SESSION['info'] = "Account o password errati";
				}
			}
			else {  // Counter would remain 0 if it is invalid login
				$_SESSION['info'] = "Account o password errati";
			}
        }
    }
}

// Various informations are passed from different pages, all the messages are verified here and displayed according on the html tag
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
