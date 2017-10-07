<?php
/* session_start();

if(!isset($_SESSION['userID'])){ //if login in session is not set
    header("Location: youmustbeloggedin.php");
}

require_once '/u/ssp0929/SQLDB-login/openDatabase.php';

$insertAuctionStmt = $database->prepare(<<<'SQL'
        UPDATE
            AUCTION
        SET
            CLOSE_TIME = :closeTime,
            ITEM_CATEGORY = :itemCategory,
            ITEM_CAPTION = :itemCaption,
            ITEM_DESCRIPTION = :itemDescription
        WHERE
            AUCTION.AUCTION_ID = :id;
SQL
);

$insertAuctionStmt->bindValue(':id', $_POST['auctionid'], PDO::PARAM_INT);
$insertAuctionStmt->bindValue(':closeTime', $_POST['auctionclose'], PDO::PARAM_STR);
$insertAuctionStmt->bindValue(':itemCategory', $_POST['category'], PDO::PARAM_INT);
$insertAuctionStmt->bindValue(':itemCaption', $_POST['itemname'], PDO::PARAM_STR);
$insertAuctionStmt->bindValue(':itemDescription', $_POST['itemdescription'], PDO::PARAM_STR);
$insertAuctionStmt->execute();
$insertAuctionStmt->closeCursor();

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

<div id="nav">
    <a href="indexloggedin.php">Home</a>
    <a href="bid.php">Bid</a>
    <a href="list.php">List</a>
</div>

<div id="content">
    <p>You have successfully updated a listing.</p>
    <form action="indexloggedin.php">
        <input type="submit" value="return to dashboard"/>
    </form>
</div>

<div id="footer">
    <p>Copyright ©2016, Acme Auctions, Inc. and BevoTech Co.</p>
    <p>Logged in as <?= $_SESSION['username']?>. <a href="index.php">Log out?</a></p>
</div>

</body>
</html>