<?php

// Using these variable to prefil the entered data in case the givin data has some error


// This is to validate whether the Mandatory fields are filled are not
if (empty($_POST["username"])) {
    $emptyuser = "* Username is required";
} else if (empty($_POST["password"])) {
    $emptypass = "* Password is required";
} else if (empty($_POST["repassword"])) {
    $repass = "* Retype Password is required";
} else if (empty($_POST["fullname"])) {
    $emptyname = "* Full Name is required";
} else if (empty($_POST["email"])) {
    $emptyemail = "* Email is required";
} else if ($_POST["password"] != $_POST["repassword"]) {
    $repass = "* Password does not match";  // If the enter passsword does not match with Reentered Password
} else {
// Getting the values given as a input for Registration
    $username = ($_POST["username"]);
    $password = md5($_POST["password"]);
    $fullname = $_POST["fullname"];
    $email = $_POST["email"];

    $dbpath = '../mydb.sqlite';
    $dbh = new SQLite3($dbpath);

// Query to validate if the given username already exists or not
    $stmt = $dbh->prepare("SELECT * FROM users WHERE username='" . $username . "'");
    $execquery = $stmt->execute();
    if ($execquery == false) {
        $_SESSION['info'] = "Unable to process the query, Please try again";
    } else {
        $acc = $execquery->fetchArray(SQLITE3_ASSOC);

        if ($acc != false) {
            $_SESSION['info'] = "Username already exists";
        } else {
// Else Proceed with the insertion of record
// Inserting the record to the table users
//$stmt = $dbh->prepare("INSERT into users values('" . $username . "','" . $password . "')");
            $stmt = $dbh->prepare("INSERT into users values('" . $username . "','" . $password . "','" . $fullname . "','" . $email . "')");
            $res = $stmt->execute();

            if ($res == false) {
                $_SESSION['info'] = "Impossibile creare account";
                echo("qualcosa non va");
            } else {
                $_SESSION['info'] = "New User created successfully";
                echo("YEah funge!");
                session_write_close();
                exit();
            }
        }
    }
}

?>