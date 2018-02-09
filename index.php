<?php
/*session_start();
session_unset();
session_destroy();
*/
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
        <h2>Welcome to Acme Auctions</h2>
        <p>Here you can bid on timed listings and create some listings of your own.</p>
        <p>Sign up now to access all of our site's features.</p>
        <div class="card-invis">
            <form action="termsandconditions.php">
                <input type="submit" value="sign up"/>
            </form>
            <form action="registration.php">
                <input type="submit" value="login"/>
            </form>
        </div>
        <p>
            <a href="indexloggedin.php">Simulate Login</a>
            NOTE: This website was directly ported over to Heroku
            without refactoring SQL statements to accomodate for PostgresQL syntax.
            Additionally, the back end setup although initialized is completely empty
            and I don't have access to the old MySQL data to port the tables over.
        </p>
        <p>
            As such, I've decided to just go ahead and
            create a full refactor of the website on a separate repository.
        </p>
    </div>

    <div id="footer">
        <p>Copyright ©2017, Acme Auctions, Inc. and BevoTech Co.</p>
        <p><a href="cronjob.php">NOTE: Nonfunctioning since code was ported. Simulate cron job to close expired auctions.</a></p>
    </div>

  </body>
</html>
