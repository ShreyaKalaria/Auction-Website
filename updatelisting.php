<?php
/* session_start();

if(!isset($_SESSION['userID'])){ //if login in session is not set
    header("Location: youmustbeloggedin.php");
}

require_once '/u/ssp0929/SQLDB-login/openDatabase.php';

$auctionQuery = $database->prepare(<<<'SQL'
    SELECT
        ITEM_CATEGORY.NAME as CATEGORY_NAME,
        ITEM_CATEGORY_ID as CATEGORY_ID
    FROM
        ITEM_CATEGORY;
SQL
);
$auctionQuery->execute();

$query = $database->prepare(<<<'SQL'
    SELECT
        AUCTION.ITEM_DESCRIPTION as DESCR,
        AUCTION.ITEM_CAPTION,
        AUCTION.CLOSE_TIME,
        ITEM_CATEGORY.NAME as CATEGORY_NAME,
        ITEM_CATEGORY_ID as CATEGORY_ID
    FROM
        AUCTION
    JOIN
        ITEM_CATEGORY ON ITEM_CATEGORY.ITEM_CATEGORY_ID = AUCTION.ITEM_CATEGORY
    WHERE
        AUCTION.AUCTION_ID = :auctionId;
SQL
);
$query->bindValue(':auctionId', $_POST['auctionid'], PDO::PARAM_INT);
$query->execute();

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
    <?php
    foreach ($query->fetchAll() as $q) {
        ?>
        <h2>Update Item</h2>
        <form action="updatelistingsuccessful.php" method="post">
            <fieldset>
                <legend>Item Information</legend>
                <input type="hidden" name="auctionid" value="<?= htmlspecialchars($_POST['auctionid']) ?>"/>
                <input type="text" name="itemname" placeholder="<?= htmlspecialchars($q['ITEM_CAPTION']) ?>" maxlength="78" required=""/>
                <br/><textarea rows="6" cols="40" name="itemdescription" placeholder="<?= htmlspecialchars($q['DESCR']) ?>"
                               maxlength="998" required=""></textarea>
                <br/><select name="category" required="">
                    <option value="<?= htmlspecialchars($q['CATEGORY_ID']) ?>" label="<?= htmlspecialchars($q['CATEGORY_NAME']) ?>"></option>
                    <?php
                    foreach ($auctionQuery->fetchAll() as $cat) {
                        ?>
                        <option value="<?= htmlspecialchars($cat['CATEGORY_ID']) ?>">
                            <?= htmlspecialchars($cat['CATEGORY_NAME']) ?></option>
                        <?php
                    }
                    $auctionQuery->closeCursor();
                    $date = date("Y-m-d");
                    $time = date("H:i");
                    ?>
                </select>
                <br/>Previous Closing Date - <?= $q['CLOSE_TIME'] ?>
                <br/><input type="datetime-local" name="auctionclose" min="<?= $date.'T'.$time ?>"
                            max="<?= $maxdate.'T'.$time ?>" value="<?= $date.'T'.$time ?>" required=""/>
            </fieldset>
            <input type="submit" value="create listing"/>
        </form>
        <?php
    }
    ?>
</div>

<div id="footer">
    <p>Copyright ©2016, Acme Auctions, Inc. and BevoTech Co.</p>
    <p>Logged in as <?= $_SESSION['username']?>. <a href="index.php">Log out?</a></p>
</div>

</body>
</html>