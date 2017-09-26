<?php
session_start();
session_unset();
session_destroy();

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
        <p class="light-text">Hello grader. Specific instructions how to test cron job + purchase. Copy and paste this somewhere for easy reference.
        <br/><br/>
        Test User 1:<br/>
        email: (CREATE YOUR OWN AND REMEMBER!)<br/>
        password: (CREATE YOUR OWN AND REMEMBER!)<br/><br/>

        Test User 2:<br/>
        email: (CREATE YOUR OWN AND REMEMBER!)<br/>
        password: (CREATE YOUR OWN AND REMEMBER!)<br/><br/>

        Step 1: Create listing with Test User 1 with a date that will expire in a short period of time. Log out.<br/>
        Step 2: Bid on listing with Test User 2. Log out.<br/>
        Step 3: Simulate the close auction cron job.<br/>
        Step 4: Log in normally as Test User 2<br/>
        Step 5: Proceed to test purchase functionality in the items won tab.</p>
    </div>

    <div id="footer">
        <p>Copyright ©2016, Acme Auctions, Inc. and BevoTech Co.</p>
        <p><a href="cronjob.php">Simulate cron job to close expired auctions.</a></p>
    </div>

  </body>
</html>
