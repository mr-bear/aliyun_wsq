<?php
/**
 * Created by PhpStorm.
 * User: xiongfei
 * Date: 14-10-28
 * Time: 下午3:44
 */

if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
error_reporting(E_ALL);

require_once DISCUZ_ROOT.'./source/plugin/mrbear_award/awardController.php';
$fid = $_GET['fid'];
$uid = $_GET['uid'];


$response = array(
    'status' => 0,
    'data' => array(),
    'msg' => ''
);

$awardObj = new award();

$userId = $awardObj->_userId;
$intervalTime = $awardObj->_config['interval'];
$cookieLastTime = $_COOKIE['lastAwardTime'];
$checkInterval = ((time()-$cookieLastTime) >= $intervalTime*60) ? true : false;

//check config
$checkStatus = $awardObj->checkEventStatus();
$checkTime = $awardObj->checkEventTime();
$checkGroup = $awardObj->checkUserLevel();
$checkForums = $awardObj->checkForums($fid);
$checkBlack = $awardObj->checkBlackList();
if (!$userId
    || $userId != $uid
    || !$checkInterval
    || !$checkStatus
    || !$checkTime
    || !$checkGroup
    || !$checkForums
    || !$checkBlack) {
    //return
    $response['status'] = 99;
    echo json_encode($response);
    die();
}

$awardRes = $awardObj->getAward();
if ($awardRes['status'] == 0) {
    //award then set cookie
    setcookie('lastAwardTime', time());
}

$response['status'] = $awardRes['status'];
$response['data'] = $awardRes['data'];
echo json_encode($response);
die();
//var_dump($response);

//var_dump($_G['cache']['plugin']['mrbear_award']);


