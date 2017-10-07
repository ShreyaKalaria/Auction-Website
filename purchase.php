<?php
/* session_start();

if(!isset($_SESSION['userID'])){ //if login in session is not set
    header("Location: youmustbeloggedin.php");
}


if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== "on") {
    header('Location: https://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']);
    exit(1);
}


require_once '/u/ssp0929/SQLDB-login/openDatabase.php';

$auctionQuery = $database->prepare(<<<'SQL'
    SELECT
        ITEM_CATEGORY.NAME as ITEM_CATEGORY,
        AUCTION.ITEM_DESCRIPTION as DESCR,
        AUCTION_STATUS.NAME as STATUS,
        AUCTION.ITEM_CAPTION,
        AUCTION.AUCTION_ID as AID,
        CONCAT(PERSON.FORENAME, ' ', PERSON.SURNAME) AS SELLER,
        AUCTION.OPEN_TIME,
        AUCTION.CLOSE_TIME,
        AUCTION.ITEM_PHOTO
    FROM
        AUCTION
    JOIN
        ITEM_CATEGORY ON AUCTION.ITEM_CATEGORY = ITEM_CATEGORY.ITEM_CATEGORY_ID
    JOIN
        PERSON ON AUCTION.SELLER = PERSON.PERSON_ID
    JOIN
        AUCTION_STATUS ON AUCTION.STATUS = AUCTION_STATUS.AUCTION_STATUS_ID
    WHERE
        AUCTION.AUCTION_ID = :auctionId;
SQL
);
$auctionQuery->bindValue(':auctionId', $_POST['id'], PDO::PARAM_INT);
$auctionQuery->execute();

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
    <h2>Purchase Details</h2>
    <form action="purchasesuccessful.php" method="post">
        <fieldset>
            <legend>Name On Card</legend>
            <input type="text" name="firstname" placeholder="First Name" required=""/>
            <input type="text" name="lastname" placeholder="Last Name" required=""/>
        </fieldset>
        <fieldset>
            <legend>Credit Card Information</legend>
            <input type="number" max="9999999999999999" name="CCnumber" placeholder="Credit Card Number" required=""/>
            <input type="number" max="999" name="CCsecuritycode" placeholder="Security Code" required=""/>
        </fieldset>
        <fieldset>
            <legend>Billing & Shipping</legend>
            <input type="text" name="baddress" placeholder="Billing Address" required=""/>
            <input type="text" name="saddress" placeholder="Shipping Address" required=""/>
        </fieldset>
        <?php
        foreach ($auctionQuery->fetchAll() as $auction) {
        ?>
        <input type="hidden" name="id" value="<?= htmlspecialchars($auction['AID']) ?>"/>
            <?php
        }
        $auctionQuery->closeCursor();
        ?>
        <input type="submit" value="submit"/>
    </form>
</div>

<div id="footer">
    <p>Copyright ©2016, Acme Auctions, Inc. and BevoTech Co.</p>
    <p>Logged in as <?= $_SESSION['username']?>. <a href="index.php">Log out?</a></p>
</div>

</body>
</html>