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
ini_set("display_errors", 1);
error_reporting(E_ALL);

require_once DISCUZ_ROOT.'./source/plugin/mrbear_award/awardController.php';

$fid = isset($_GET['fid']) ? $_GET['fid'] : 0;
$uid = isset($_GET['uid']) ? $_GET['uid'] : 0;
$source = (isset($_GET['source']) && in_array($_GET['source'], array(0, 1))) ? $_GET['source'] : 0;
$fid = intval($fid);
$uid = intval($uid);
$source = intval($source);

$response = array(
    'status' => 0,
    'data' => array(),
    'msg' => ''
);

$awardObj = new award();
$awardObj->source = $source;

$userId = $awardObj->_userId;
$intervalTime = $awardObj->_config['interval'];
$cookieLastTime = $_COOKIE['lastAwardTime'];
$checkInterval = ((time()-$cookieLastTime) >= $intervalTime*60) ? true : false;

//check config
$checkTerminal = $awardObj->checkTerminal();
$checkStatus = $awardObj->checkEventStatus();
$checkTime = $awardObj->checkEventTime();
$checkGroup = $awardObj->checkUserLevel();
$checkForums = $awardObj->checkForums($fid);
$checkBlack = $awardObj->checkBlackList();

if (!$userId
    || $userId != $uid
    || !$checkTerminal
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

$response = award::pluginIconv($response);
echo json_encode($response);
die();
//var_dump($response);

//var_dump($_G['cache']['plugin']['mrbear_award']);


