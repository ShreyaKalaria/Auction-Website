<?php
/* require_once '/u/ssp0929/SQLDB-login/openDatabase.php';

$auctionQuery = $database->prepare(<<<'SQL'
    SELECT
        AUCTION.ITEM_PHOTO
    FROM
        AUCTION
    WHERE
        AUCTION.AUCTION_ID = :id;
SQL
);

$auctionQuery->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
$auctionQuery->execute();
$photoContents = $auctionQuery->fetchColumn(0);

//This is a really dumb workaround LOL, but it will almost always work
if (strlen($photoContents) < 2) {
    $photoContents = file_get_contents('nophoto.jpg');
}

header('Content-Type: image/jpeg');
header('Content-Length: '.strlen($photoContents));
echo $photoContents; */