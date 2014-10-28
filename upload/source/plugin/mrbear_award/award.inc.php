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


$awardData = array(
    'pic' => '',
    'text' => '',
);
$response = array(
    'status' => 0,
    'data' => $awardData,
    'msg' => ''
);

$awardObj = new award();

$userId = $awardObj->_userId;
$checkTime = $awardObj->checkEventTime();
$checkGroup = $awardObj->checkUserLevel();
$checkBlack = $awardObj->checkBlackList();
if (!$userId || !$checkTime || !$checkGroup || !$checkBlack) {
    //return
    $response['status'] = 1;
    echo json_encode($response);
    die();
}


var_dump($_G['cache']['plugin']['mrbear_award']);


