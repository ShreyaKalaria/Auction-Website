<?php
session_start();

if(!isset($_SESSION['userID'])){ //if login in session is not set
    header("Location: youmustbeloggedin.php");
}

require_once '/u/ssp0929/SQLDB-login/openDatabase.php';

$newIdQuery = $database->prepare('SELECT NEXT_SEQ_VALUE(:seqGenName);');
$newIdQuery->bindValue(':seqGenName', 'AUCTION', PDO::PARAM_STR);
$newIdQuery->execute();
$newAuctionId = $newIdQuery->fetchColumn(0);

$newBidIdQuery = $database->prepare('SELECT NEXT_SEQ_VALUE(:seqGenName2);');
$newBidIdQuery->bindValue(':seqGenName2', 'BID', PDO::PARAM_STR);
$newBidIdQuery->execute();
$newBidId = $newBidIdQuery->fetchColumn(0);

$insertAuctionStmt = $database->prepare(<<<'SQL'
        INSERT
            AUCTION (AUCTION_ID, STATUS, SELLER, OPEN_TIME, CLOSE_TIME, ITEM_CATEGORY,
            ITEM_CAPTION, ITEM_DESCRIPTION, ITEM_PHOTO, WINNER, PURCHASED)
        VALUES
            (:auctionID, 1, :pid, :openTime, :closeTime, :itemCategory, :itemCaption,
            :itemDescription, :itemPhoto, NULL, NULL);

        INSERT
            BID (BID_ID, BIDDER, AUCTION, AMOUNT)
        VALUES
            (:bidID, :pid, :auctionID, :bidAmount);
SQL
);

$insertAuctionStmt->bindValue(':pid', $_SESSION['userID'], PDO::PARAM_INT);
$insertAuctionStmt->bindValue(':auctionID', $newAuctionId, PDO::PARAM_INT);
$insertAuctionStmt->bindValue(':openTime', $_SERVER['REQUEST TIME'], PDO::PARAM_STR);
$insertAuctionStmt->bindValue(':closeTime', $_POST['auctionclose'], PDO::PARAM_STR);
$insertAuctionStmt->bindValue(':itemCategory', $_POST['category'], PDO::PARAM_INT);
$insertAuctionStmt->bindValue(':itemCaption', $_POST['itemname'], PDO::PARAM_STR);
$insertAuctionStmt->bindValue(':itemDescription', $_POST['itemdescription'], PDO::PARAM_STR);
$photoFile = fopen($_FILES['itemphoto']['tmp_name'], 'rb');
$insertAuctionStmt->bindValue(':itemPhoto', $photoFile, PDO::PARAM_LOB);
$insertAuctionStmt->bindValue(':bidID', $newBidId, PDO::PARAM_INT);
$insertAuctionStmt->bindValue(':bidAmount', $_POST['startingbid'], PDO::PARAM_STR);
$insertAuctionStmt->execute();
$insertAuctionStmt->closeCursor();

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
    <p>You have successfully created a listing.</p>
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