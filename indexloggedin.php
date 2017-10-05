<?php
session_start();

if(!isset($_SESSION['userID'])){ //if login in session is not set
    header("Location: youmustbeloggedin.php");
}

# This function reads your DATABASE_URL config var and returns a connection
# string suitable for pg_connect. Put this in your app.
$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$host = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);
$port = "5432";

$dsn = "pgsql:host=$host;dbname=$db;user=$username;port=$port;password=$password";

if($db){
    echo "Connected <br />".$db;
}else {
    echo "Not connected";
}

/*$user = $database->prepare(<<<'SQL'
    SELECT
        CONCAT(PERSON.FORENAME, ' ', PERSON.SURNAME) AS CURRENTUSER
    FROM
        PERSON
    WHERE
        PERSON.PERSON_ID = :id;
SQL
);

$user->bindValue(':id', $_SESSION['userID'], PDO::PARAM_INT);
$user->execute();*/

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

<?php
foreach ($user->fetchAll() as $u) {
    ?>
    <div id="content">
        <h2>Welcome back, <?= htmlspecialchars($u['CURRENTUSER']) ?>!</h2>
        <p>See items you are listing <a href="listupdateandcancel.php">here.</a></p>
        <p>See items you are bidding on <a href="itemsbiddingon.php">here.</a></p>
        <p>See items you have won <a href="itemswon.php">here.</a></p>
        <p>I'm done here, <a href="index.php">log me out.</a></p>
    </div>
    <?php
}
?>

<div id="footer">
    <p>Copyright ©2016, Acme Auctions, Inc. and BevoTech Co.</p>
    <p>Logged in as <?= $_SESSION['username']?>. <a href="index.php">Log out?</a></p>
</div>

</body>
</html>
