<?php

use Herrera\Pdo\PdoServiceProvider;
use Silex\Application;

$dbopts = parse_url(getenv('DATABASE_URL'));
$app->register(new Herrera\Pdo\PdoServiceProvider(),
               array(
                   'pdo.dsn' => 'pgsql:dbname='.ltrim($dbopts["path"],'/').';host='.$dbopts["host"] . ';port=' . $dbopts["port"],
                   'pdo.username' => $dbopts["user"],
                   'pdo.password' => $dbopts["pass"]
               )
);

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
    <a href="index.php">Home</a>
    <a href="youmustbeloggedin.php">Bid</a>
    <a href="youmustbeloggedin.php">List</a>
</div>

<div id="content">
    <h2>Register</h2>
    <form action="registrationsuccessful.php" method="post">
        <fieldset>
            <legend>Full Name</legend>
            <input type="text" name="firstname" placeholder="First" required=""/>
            <input type="text" name="lastname" placeholder="Last" required=""/>
        </fieldset>
        <fieldset>
            <legend>Login Information</legend>
            <input type="email" name="email" placeholder="Email Address" required=""/>
            <input type="password" name="password" placeholder="Password" required=""/>
        </fieldset>
        <br/><input type="submit" value="sign up"/>
    </form>
    <hr/>
    <h2>Login</h2>
    <form action="loginsuccessful.php" method="post">
        <fieldset>
            <legend>Login Information</legend>
            <input type="email" name="email" placeholder="Email Address" required=""/>
            <input type="password" name="password" placeholder="Password" required=""/>
        </fieldset>
        <br/><input type="submit" value="login"/>
    </form>
</div>

<div id="footer">
    <p>Copyright ©2016, Acme Auctions, Inc.</p>
    <p>Developed by BevoTech Co.</p>
</div>

</body>
</html>