<?php

if (version_compare(phpversion(), "5.3.0", ">=")  == 1)
  error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
else
  error_reporting(E_ALL & ~E_NOTICE); 

require_once('classes/CMySQL.php'); // including service class to work with database

$sCode = '';
$iItemId = (int)$_GET['id'];
if ($iItemId) { // View item output
    $aItemInfo = $GLOBALS['MySQL']->getRow("SELECT * FROM `s155_items` WHERE `id` = '{$iItemId}'"); // getting info about item from database
    $sCode .= '<h1>'.$aItemInfo['title'].'</h1>';
    $sCode .= '<h3>'.date('F j, Y', $aItemInfo['when']).'</h3>';
    $sCode .= '<h2>Description:</h2>';
    $sCode .= '<h3>'.$aItemInfo['description'].'</h3>';

    // draw voting element
    $iIconSize = 64;
    $iMax = 5;
    $iRate = $aItemInfo['rate'];
    $iRateCnt = $aItemInfo['rate_count'];
    $fRateAvg = ($iRate && $iRateCnt) ? $iRate / $iRateCnt : 0;
    $iWidth = $iIconSize*$iMax;
    $iActiveWidth = round($fRateAvg*($iMax ? $iWidth/$iMax : 0));

    $sVot = '';
    for ($i=1 ; $i<=$iMax ; $i++) {
        $sVot .= '<a href="#" id="'.$i.'"><img class="votes_button" src="images/empty.gif" alt="" /></a>';
    }

    $sVoting = <<<EOS
<div class="votes_main">
    <div class="votes_gray" style="width:{$iWidth}px;">
        <div class="votes_buttons" id="{$iItemId}" cnt="{$iRateCnt}" val="{$fRateAvg}">
            {$sVot}
        </div>
        <div class="votes_active" style="width:{$iActiveWidth}px;"></div>
    </div>
    <span><b>{$iRateCnt}</b> votes</span>
</div>
EOS;

    $sCode .= $sVoting;
    $sCode .= '<h3><a href="'.$_SERVER['PHP_SELF'].'">back</a></h3>';
} else {
    $sCode .= '<h1>List of items:</h1>';

    $aItems = $GLOBALS['MySQL']->getAll("SELECT * FROM `s155_items` ORDER by `when` ASC"); // taking info about all items from database
    foreach ($aItems as $i => $aItemInfo) {
        $sCode .= '<h2><a href="'.$_SERVER['PHP_SELF'].'?id='.$aItemInfo['id'].'">'.$aItemInfo['title'].' item</a></h2>';
    }
}

?>
<!DOCTYPE html>
<html lang="en" >
    <head>
        <meta charset="utf-8" />
        <title>Creating own rate system | Script Tutorials</title>

        <link href="css/main.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="js/jquery-1.5.2.min.js"></script>
        <script type="text/javascript" src="js/script.js"></script>
    </head>
    <body>
        <div class="container">
            <?= $sCode ?>
        </div>
        <footer>
            <h2>Creating own rate system</h2>
            <a href="http://www.script-tutorials.com/how-to-create-own-voting-system/" class="stuts">Back to original tutorial on <span>Script Tutorials</span></a>
        </footer>
    </body>
</html>