<?php
session_start();

if(!isset($_SESSION['userID'])){ //if login in session is not set
    header("Location: youmustbeloggedin.php");
}

require_once '/u/ssp0929/SQLDB-login/openDatabase.php';

$auctionQuery = $database->prepare(<<<'SQL'
    SELECT
        ITEM_CATEGORY.NAME as ITEM_CATEGORY,
        AUCTION_STATUS.NAME as STATUS,
        AUCTION.STATUS,
        AUCTION.ITEM_CAPTION,
        AUCTION.AUCTION_ID as AID,
        CONCAT(PERSON.FORENAME, ' ', PERSON.SURNAME) AS SELLER,
        AUCTION.SELLER as SELLER_ID,
        AUCTION.WINNER,
        AUCTION.OPEN_TIME,
        AUCTION.CLOSE_TIME,
        AUCTION.ITEM_PHOTO,
        AUCTION.PURCHASED,
        MAX(BID.AMOUNT) as BIDAMOUNT
    FROM
        AUCTION
    JOIN
        ITEM_CATEGORY ON AUCTION.ITEM_CATEGORY = ITEM_CATEGORY.ITEM_CATEGORY_ID
    JOIN
        PERSON ON AUCTION.SELLER = PERSON.PERSON_ID
    JOIN
        AUCTION_STATUS ON AUCTION.STATUS = AUCTION_STATUS.AUCTION_STATUS_ID
    JOIN
        BID ON AUCTION.AUCTION_ID = BID.AUCTION
    WHERE
        PERSON.PERSON_ID = :id
    GROUP BY
        BID.AUCTION;
SQL
);

$auctionQuery->bindValue(':id', $_SESSION['userID'], PDO::PARAM_INT);
$auctionQuery->execute();

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
    <?php
    foreach ($auctionQuery->fetchAll() as $auction) {
        if($auction['STATUS'] == 1) {
            ?>
            <div class="card">
                <img src="showthephoto.php?id=<?= htmlspecialchars($auction['AID']) ?>" alt="Photo Error"/>
                <dfn><?= htmlspecialchars($auction['ITEM_CAPTION']) ?></dfn>
                <ul>
                    <li>Seller: <?= htmlspecialchars($auction['SELLER']) ?></li>
                    <li>Current Bid: $<?= htmlspecialchars($auction['BIDAMOUNT']) ?></li>
                    <li>Close Time: <?= htmlspecialchars($auction['CLOSE_TIME']) ?></li>
                </ul>
                <form action="updatelisting.php" method="post">
                    <input type="hidden" name="auctionid" value="<?= htmlspecialchars($auction['AID']) ?>"/>
                    <input type="submit" value="update listing"/>
                </form>
                <form action="cancellistconfirmation.php" method="post">
                    <input type="hidden" name="auctionid" value="<?= htmlspecialchars($auction['AID']) ?>"/>
                    <input type="submit" value="cancel listing"/>
                </form>
            </div>
            <?php
        }
        else if($auction['STATUS'] == 3 and $auction['WINNER'] != $auction['SELLER_ID'] and $auction['PURCHASED'] != 1) {
            ?>
            <div class="card">
                <img src="showthephoto.php?id=<?= htmlspecialchars($auction['AID']) ?>" alt="Photo Error"/>
                <dfn><?= htmlspecialchars($auction['ITEM_CAPTION']) ?></dfn>
                <ul>
                    <li>Seller: <?= htmlspecialchars($auction['SELLER']) ?></li>
                    <li>Final Bid: $<?= htmlspecialchars($auction['BIDAMOUNT']) ?></li>
                    <li>Winner: <?= htmlspecialchars($auction['WINNER']) ?></li>
                    <li>Close Time: <?= htmlspecialchars($auction['CLOSE_TIME']) ?></li>
                </ul>
                <p>Your auction has been won by bidder number <?= htmlspecialchars($auction['WINNER']) ?>!</p>
            </div>
            <?php
        }
        else if($auction['STATUS'] == 3 and $auction['WINNER'] != $auction['SELLER_ID'] and $auction['PURCHASED'] == 1){
            ?>
            <div class="card">
                <img src="showthephoto.php?id=<?= htmlspecialchars($auction['AID']) ?>" alt="Photo Error"/>
                <dfn><?= htmlspecialchars($auction['ITEM_CAPTION']) ?></dfn>
                <ul>
                    <li>Seller: <?= htmlspecialchars($auction['SELLER']) ?></li>
                    <li>Final Bid: $<?= htmlspecialchars($auction['BIDAMOUNT']) ?></li>
                    <li>Winner: <?= htmlspecialchars($auction['WINNER']) ?></li>
                    <li>Close Time: <?= htmlspecialchars($auction['CLOSE_TIME']) ?></li>
                </ul>
                <p>Your auction has been won by bidder number <?= htmlspecialchars($auction['WINNER']) ?>!</p>
                <p>Buyer has sent payment.</p>
            </div>
            <?php
        }
            else{
            ?>
            <div class="card">
                <img src="showthephoto.php?id=<?= htmlspecialchars($auction['AID']) ?>" alt="Photo Error"/>
                <dfn><?= htmlspecialchars($auction['ITEM_CAPTION']) ?></dfn>
                <ul>
                    <li>Seller: <?= htmlspecialchars($auction['SELLER']) ?></li>
                    <li>Final Bid: $<?= htmlspecialchars($auction['BIDAMOUNT']) ?></li>
                    <li>Close Time: <?= htmlspecialchars($auction['CLOSE_TIME']) ?></li>
                </ul>
                <p>Nobody has bid on your auction. No sale.</p>
            </div>
    <?php
        }
    }
    $auctionQuery->closeCursor();
    ?>
</div>

<div id="footer">
    <p>Copyright ©2016, Acme Auctions, Inc. and BevoTech Co.</p>
    <p>Logged in as <?= $_SESSION['username']?>. <a href="index.php">Log out?</a></p>
</div>

</body>
</html>