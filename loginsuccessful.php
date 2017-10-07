<?php
/*require_once '/u/ssp0929/SQLDB-login/openDatabase.php';

if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== "on") {
    header('HTTP/1.1 403 Forbidden: TLS Required');
    // Optionally output an error page here
    exit(1);
}

$verifyPerson = $database->prepare(<<<'SQL'
    SELECT
        PERSON.PASSWORD,
        PERSON.PERSON_ID,
        CONCAT(PERSON.FORENAME, ' ', PERSON.SURNAME) AS username
    FROM
        PERSON
    WHERE
        PERSON.EMAIL_ADDRESS = :email;
SQL
);

$verifyPerson->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
$verifyPerson->execute();

$row = $verifyPerson->fetch(PDO::FETCH_ASSOC);
$hash = $row["PASSWORD"];
$pid = $row["PERSON_ID"];
$username = $row["username"];

$verifyPass = password_verify($_POST['password'], $hash);

*/?>
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

<?php if($verifyPass == true) {
    session_start();
    $_SESSION['userID'] = $pid;
    $_SESSION['username'] = $username;
?>
<div id="nav">
    <a href="indexloggedin.php">Home</a>
    <a href="bid.php">Bid</a>
    <a href="list.php">List</a>
</div>
    <?php
}
else {
?>
<div id="nav">
    <a href="index.php">Home</a>
    <a href="youmustbeloggedin.php">Bid</a>
    <a href="youmustbeloggedin.php">List</a>
</div>
    <?php
}
?>

<div id="content">
    <?php if($verifyPass == true) {
        ?>
        <p>You have successfully logged in.</p>
        <form action="indexloggedin.php" method="post">
            <input type="hidden" name="pid" value="<?= htmlspecialchars($pid) ?>"/>
            <input type="submit" value="proceed to dashboard"/>
        </form>
        <?php
    }
    else {
        ?>
        <p>Login failed, incorrect information supplied.</p>
        <form action="registration.php">
            <input type="submit" value="try again"/>
        </form>
        <?php
    }
    $verifyPerson->closeCursor();
    ?>
</div>

<div id="footer">
    <p>Copyright ©2016, Acme Auctions, Inc. </p>
    <p>Developed by BevoTech Co.</p>
</div>

</body>
</html>