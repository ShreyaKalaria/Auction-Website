<?php
require_once '/u/ssp0929/SQLDB-login/openDatabase.php';

$closeAuction = $database->prepare(<<<'SQL'
      SELECT
          AUCTION.AUCTION_ID as AID
      FROM
          AUCTION
      WHERE
          AUCTION.STATUS = 1 AND AUCTION.CLOSE_TIME <= CURRENT_TIMESTAMP();
SQL
);

$closeAuction->execute();

foreach($closeAuction->fetchAll() as $c){
    $iterate = $database->prepare(<<<'SQL'
      UPDATE
          AUCTION
      SET
          AUCTION.STATUS = 3,
          AUCTION.WINNER = (SELECT BID.BIDDER FROM BID WHERE BID.AUCTION = :currentAID ORDER BY BID.AMOUNT DESC LIMIT 1)
      WHERE
          AUCTION.AUCTION_ID = :currentAID;
SQL
);

    $iterate->bindValue(':currentAID', $c['AID'], PDO::PARAM_INT);
    $iterate->execute();
    $iterate->closeCursor();
}

$closeAuction->closeCursor();

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
</div>

<div id="content">
    <p>Cron job simulated.</p>
    <form action="index.php">
        <input type="submit" value="return to index"/>
    </form>
</div>

<div id="footer">
    <p>Copyright ©2016, Acme Auctions, Inc.</p>
    <p>Developed by BevoTech Co.</p>
</div>

</body>
</html>
