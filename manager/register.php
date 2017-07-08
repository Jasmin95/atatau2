<?php

// Prendo i dati e li verifico
if (empty($_POST["username"])) {
    $emptyuser = "* Inserire Username ";
} else if (empty($_POST["password"])) {
    $emptypass = "* Inserire Password";
} else if (empty($_POST["repassword"])) {
    $repass = "* Ri inserire  Password";
} else if (empty($_POST["fullname"])) {
    $emptyname = "* Inserire il Fullname";
} else if (empty($_POST["email"])) {
    $emptyemail = "* Inserire email";
} else if ($_POST["password"] != $_POST["repassword"]) {
    $repass = "* Le password non coindicono";
} else {

// memorizzo in variabili

    $username = ($_POST["username"]);
    $password = md5($_POST["password"]);
    $fullname = $_POST["fullname"];
    $email = $_POST["email"];

    $dbpath = '../mydb.sqlite';
    $dbh = new SQLite3($dbpath);

// verifico se l utente esite già
    $stmt = $dbh->prepare("SELECT * FROM users WHERE username='" . $username . "'");
    $execquery = $stmt->execute();
    if ($execquery == false) {
        $_SESSION['info'] = "Riprova, la query non è andata a abuon fine";
    } else {
        $acc = $execquery->fetchArray(SQLITE3_ASSOC);

        if ($acc != false) {
            $_SESSION['info'] = "Username già esistente";
        } else {

// Else inserisco

            $stmt = $dbh->prepare("INSERT into users values('" . $username . "','" . $password . "','" . $fullname . "','" . $email . "')");
            $res = $stmt->execute();

            if ($res == false) {
                $_SESSION['info'] = "Impossibile creare account";
                echo("qualcosa non va");
            } else {
                $_SESSION['info'] = "Nuovo utente creato con successo";
                echo("Registrazione andata a buon fine!");
                session_write_close();
                exit();
            }
        }
    }
}

?>