<?php

error_reporting(E_ALL);
ini_set('display_errors','On');

session_start();

if(!isset($_SESSION['username']))
{
  header("Location: board.php");
  exit();
}


function get_posts() {
	$dbpath = __DIR__ . '/mydb.sqlite';
	$dbh = new SQLite3($dbpath);
      
    // Select query to retrieve the list of messages
    $stmt = $dbh->prepare('SELECT * from posts ORDER BY created DESC');
    $result = $stmt->execute();
	
	if($result == false) {
		return [];
	}

    // Listing the messages into a table based on the Result Set
    $posts = [];
	while ($post = $result->fetchArray(SQLITE3_ASSOC)) {
		$posts[] = $post;
    }



	return $posts;
}
 $conteggio = "";
$conteggio2 ="";

function conteggio(){

    $dbpath = __DIR__ . '/mydb.sqlite';
    $dbh = new SQLite3($dbpath);


$res = $dbh->query("SELECT count (*) as count from posts");

$row = $res->fetchArray();
$numRows = $row['count'];


    return $numRows;
}

function conta (){

    $dbpath = __DIR__ . '/mydb.sqlite';
    $dbh = new SQLite3($dbpath);


    $res = $dbh->query("SELECT count (*) as count from posts WHERE author == ('" . $_SESSION['username']. "') ");

    $row = $res->fetchArray();
    $num = $row['count'];


    return $num;
}

function create_post() 
{
	if (empty($_POST["message"]))
	{
		return 1;
	}
		
	$postedby = $_SESSION['username'];  // user di sessione
	$message = $_POST["message"];  // input mex

	// Connect with the database
	$dbpath = __DIR__ . "/mydb.sqlite";
	$dbh = new SQLite3($dbpath);
	$stmt = $dbh->prepare("INSERT into posts(content, created, author) values('" . $message . "', datetime() ,'" . $postedby . "')");
	$result = $stmt->execute();
	if($result == false) {
		return 2;
	}
	
	return 0;
}
//$post_modificare = "";
$stmt2 = "";
$stmtstring ="";


function modifica() 
{   
	$newmessage = $_POST["newmessage"];  // Get the message
    

	if (empty($_POST["newmessage"]))
	{
		return 1;
	}

	$dbpath = __DIR__ . "/mydb.sqlite";
	$dbh = new SQLite3($dbpath);

	$stmt = $dbh->prepare("UPDATE posts SET content = ('" . $newmessage .  "') WHERE author == ('" . $_SESSION['username']. "') ");
	//$stmt = $dbh->prepare("UPDATE posts SET content = ('" . $newmessage .  "') WHERE content == ('" . $post_modificare. "')");

    $numRows = conteggio();


    //$stmt = $dbh -> prepare ("SELECT content FROM posts WHERE content  LIKE '%wee%' AND author == 'jasmin' ");

   // $stmt = $dbh->prepare("SELECT content FROM posts WHERE content  LIKE ''%('" . $newmessage .  "')%'' AND author == ('" . $_SESSION['username']. "')  ");
    //$stmtstring = serialize($stmt);

    $result = $stmt->execute();

   // $a = $result ->fetchArray(SQLITE3_ASSOC);



    /* for ($i= 0; $i >= $numRows; $i++ ){
        // $stmt2 = $dbh->prepare ("UPDATE posts SET content = ('". $newmessage . "') WHERE content == ('". $stmtstring . "')");
        //scommenta
     }*/


	//AGGIIUSTARE QUERY



	return 0;
	
	
}

 //function get_value(){
	 
 // $dbpath = __DIR__ . "/mydb.sqlite";
	// $dbh = new SQLite3($dbpath);
	
	// $stmt = $dbh->prepare("SELECT content From posts WHERE  ");
	// $post_modificare = $stmt->execute();
	// return  $post_modificare;
 //document.getElementById("post_selezionato").innerHTML = ( '" . $post_modificare . "') ;
 // }
 
$errormsg = "";
$infmsg = "";

if (isset($_POST["create_post"])) {
	$error = create_post();
	
	switch($error) {
		case 0:
			$infmsg = "Messaggio pubblicato!";		
			break;
		case 1:
			$errormsg = "Devi scrivere qualcosa.";
			break;
		case 2:
			$errormsg = "Impossibile pubblicare il messaggio. Riprova più tardi.";
			break;
	}
}

if (isset ($_POST["modifica"])){
	
	$error = modifica();
	switch($error) {
		case 0:
			$infmsg = "Modifica effettuata ";		
	    break;
		case 1:
			$errormsg = "Impossibile modificare";
			break;
		case 2:
			$errormsg = "entrato in due";
			break;
		;}
}


?>
<html>
<head>
  <?php include('header.php'); ?>
  
  
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"  ></script>  
   <script type="text/javascript" src="https://netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min.js" ></script>   
  
   
  
		
</head>
	<body>
		<div id="welcome_container">
			<div id="welcome">
				<span id="welcome_message">È bello rivederti, <?php echo $_SESSION['fullname']  ; ?>!</span>
                <span id="welcome_message">Fino ad oggi hai pubblicato <?php echo $num = conta()  ; ?> posts, continua così!</span>
			</div>
		</div>  
		<br>
		<br>
<form action="message.php" method="POST">
		<fieldset>
			<textarea name="message" rows="4" cols="40" id="message_area" placeholder="Scrivi un messaggio..."></textarea>
			<input type="submit" name="create_post" value="Pubblica" id="message_submit" />
			<span style="color:red"><?php echo $errormsg;?></span>
			<span style="color:green"><?php echo $infmsg;?></span>
		</fieldset>
	</form>
		<br>
		<br>
		<table id="message_table">
	  <?php
		$posts = get_posts();
		
		foreach($posts as $p) {
			echo '<tr id="message_table_row">';
			echo '<td id="username">'. $p['author'] .'</td>';
			echo '<td>'. $p['content'] .'</td>';
			echo '<td>'. $p['created'] .'</td>';
					   echo '<td>' . '<a name="fb_share" type="button_count" href="http://www.facebook.com/sharer.php">
            Condividi</a>'     .'</td>'; // tasto condividi
			
			
			if ($p['author'] == ($_SESSION['username'])) {
				
			  echo '<td>' .
			  //'<input type="button"  class="btn btn-primary btn-lg" style="font-size: 15px;" value="modifica" ">' 
			  '<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal" id="modifica_mex"> Modifica
			  </button><br>'.'</td>';
				
			//echo '<td>' .$post_modificare = '<input type="button"  class="btn btn-primary btn-lg" style="font-size: 15px;" value="modifica" "> ' .'</td>';
				}
			
			echo '</tr>';
		}

	  ?>
	</table>
	<?php include('footer.php'); ?>
	
	
	 <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    
                </div>
                <div class="modal-body"> 
				
				<form action="message.php" method="POST">
				
		<fieldset>
			<textarea name="newmessage" rows="4" cols="40" id="message_area" placeholder="Riscrivi" ></textarea>
			<input type="submit" name="modifica" value="Salva" id="message_submit"  />
			
		</fieldset>
	            </form>
                    
               </div>
               
            </div>
        </div>
    </div>
	
	
</body>
</html>