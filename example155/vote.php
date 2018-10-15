<?php

if (version_compare(phpversion(), "5.3.0", ">=")  == 1)
  error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
else
  error_reporting(E_ALL & ~E_NOTICE); 

require_once('classes/CMySQL.php');

$iItemId = (int)$_POST['id'];
$iVote = (int)$_POST['vote'];
$sIp = getVisitorIP();


$iOldId = $GLOBALS['MySQL']->getOne("SELECT `item_id` FROM `s155_items_vote_track` WHERE `item_id` = '{$iItemId}' AND `ip` = '{$sIp}' AND (`date` >= NOW() - INTERVAL 7 DAY) LIMIT 1");
if (! $iOldId) {
    $GLOBALS['MySQL']->res("INSERT INTO `s155_items_vote_track` SET `item_id` = '{$iItemId}', `ip` = '{$sIp}', `date` = NOW()");
    $GLOBALS['MySQL']->res("UPDATE `s155_items` SET `rate` = `rate` + {$iVote}, `rate_count` = `rate_count` + 1 WHERE `id` = '{$iItemId}'");
    echo 1;
}

function getVisitorIP() {
    $ip = "0.0.0.0";
    if( ( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) && ( !empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) ) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif( ( isset( $_SERVER['HTTP_CLIENT_IP'])) && (!empty($_SERVER['HTTP_CLIENT_IP'] ) ) ) {
        $ip = explode(".",$_SERVER['HTTP_CLIENT_IP']);
        $ip = $ip[3].".".$ip[2].".".$ip[1].".".$ip[0];
    } elseif((!isset( $_SERVER['HTTP_X_FORWARDED_FOR'])) || (empty($_SERVER['HTTP_X_FORWARDED_FOR']))) {
        if ((!isset( $_SERVER['HTTP_CLIENT_IP'])) && (empty($_SERVER['HTTP_CLIENT_IP']))) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
    }
    return $ip;
}

?>