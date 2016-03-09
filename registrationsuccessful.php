<?php
session_start();

require_once '/u/ssp0929/SQLDB-login/openDatabase.php';

if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== "on") {
    header('HTTP/1.1 403 Forbidden: TLS Required');
    // Optionally output an error page here
    exit(1);
}

$newPid = $database->prepare('SELECT NEXT_SEQ_VALUE(:seqGenName);');
$newPid->bindValue(':seqGenName', 'PERSON', PDO::PARAM_STR);
$newPid->execute();
$pid = $newPid->fetchColumn(0);

$hashedPass = password_hash($_POST['password'], PASSWORD_BCRYPT);

$createPerson = $database->prepare(<<<'SQL'
    INSERT INTO
        PERSON (PERSON_ID, SURNAME, FORENAME, EMAIL_ADDRESS, PASSWORD)
    VALUES
        (:pid, :lastname, :firstname, :email, :pw);
SQL
);

$createPerson->bindValue(':pid', $pid, PDO::PARAM_INT);
$createPerson->bindValue(':lastname', $_POST['lastname'], PDO::PARAM_STR);
$createPerson->bindValue(':firstname', $_POST['firstname'], PDO::PARAM_STR);
$createPerson->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
$createPerson->bindValue(':pw', $hashedPass, PDO::PARAM_STR);
$createPerson->execute();
$createPerson->closeCursor();

$_SESSION['userID'] = $pid;
$_SESSION['username'] = $_POST['firstname']." ".$_POST['lastname'];

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
    <title>Acme Auctions</title>
    <meta charset="utf-8"/>
    <link rel="icon" href="favicon.ico"/>
    <link rel="stylesheet" type="text/css" href="stylesheet.css"/>
</head>
<body>
<div id="header">
    <img src="acmeauctionslogo.png" alt="Acme Auctions Logo" height="74" width="399"/>
</div>

<div id="nav">
    <a href="indexloggedin.php">Home</a>
    <a href="bid.php">Bid</a>
    <a href="list.php">List</a>
</div>

<div id="content">
    <p>You have successfully registered.</p>
    <form action="indexloggedin.php">
        <input type="submit" value="proceed to dashboard"/>
    </form>
</div>

<div id="footer">
    <p>Copyright ©2016, Acme Auctions, Inc.</p>
    <p>Developed by BevoTech Co.</p>
</div>

</body>
</html>