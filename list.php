<?php
/*session_start();

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
    <h2>List Item</h2>
    <form action="listsuccessful.php" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend>Item Information</legend>
            <input type="text" name="itemname" placeholder="Item Name" maxlength="78" required=""/>
            <input type="number" name="startingbid" min="0" step="0.01" placeholder="Starting Bid" required=""/>
            <br/><textarea rows="6" cols="43" name="itemdescription" placeholder="Item Description"
                           maxlength="998" required=""></textarea>
            <br/>Photo
            <input type="file" name="itemphoto" accept="image/jpeg"/>
            <br/><select name="category" required="">
                <option value="" label="Item Category"></option>
                <?php
                foreach ($auctionQuery->fetchAll() as $cat){
                    ?>
                    <option value="<?= htmlspecialchars($cat['CATEGORY_ID'])?>">
                        <?= htmlspecialchars($cat['CATEGORY_NAME'])?></option>
                    <?php
                }
                $auctionQuery->closeCursor();
                $date = date("Y-m-d");
                $maxdate = date("Y-m-d", strtotime("+1 year"));
                $time = date("H:i");
                ?>
            </select>
            <br/>Auction Closing Date
            <br/><input type="datetime-local" name="auctionclose" min="<?= $date.'T'.$time ?>"
                        max="<?= $maxdate.'T'.$time ?>" value="<?= $date.'T'.$time ?>" required=""/>
        </fieldset>
        <input type="submit" value="create listing"/>
    </form>
</div>

<div id="footer">
    <p>Copyright ©2016, Acme Auctions, Inc. and BevoTech Co.</p>
    <p>Logged in as <?= $_SESSION['username']?>. <a href="index.php">Log out?</a></p>
</div>

</body>
</html>
