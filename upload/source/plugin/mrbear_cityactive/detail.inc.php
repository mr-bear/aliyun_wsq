<?php
/**
 * Created by PhpStorm.
 * User: xiongfei
 * Date: 14-11-10
 * Time: 上午10:08
 */

if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
//ini_set("display_errors", 1);
//error_reporting(E_ALL);
require_once DISCUZ_ROOT.'./source/plugin/mrbear_cityactive/activeController.php';
global $_G;
$activeId = isset($_GET['aid']) ? intval($_GET['aid']) : 0;
$activeData = array();
$activeObj = new active();
$formHash = formhash();
if ($activeId) {
    $originData = getOriginData($activeId);
    if (!empty($originData)) {
        $activeData = $originData[0];
        $activeData['images'] = array();
        //get image
        $imageData = getImage($activeId);
        if (!empty($imageData)) {
            foreach ($imageData as $itemImg) {
                if ($itemImg['position'] == 1) {
                    $activeData['firstImage'] = $_G['siteurl'].'data/attachment/cityactive/'.$itemImg['img_root'];
                }
                $activeData['images'][] = $_G['siteurl'].'data/attachment/cityactive/'.$itemImg['img_root'];
            }
        }

        //get typename
        $typeName = getAcType($activeData['type'], $activeData['subtype']);
        $activeData['typeName'] = $typeName;
        //get active time str
        $timeStr = getActiveTime($activeData['repeat_type'], $activeData['begin_time'], $activeData['end_time'], $activeData['repeat_time']);
        $activeData['timeStr'] = $timeStr;
        //get fee detail
        $activeData['feeArr'] = getFeeDetail($activeData['fee'], $activeData['fee_detail']);
        //coordinate
        $coordinateArr = explode(',', $activeData['coordinate']);
        if (count($coordinateArr) == 2) {
            $activeData['coordinate'] = $coordinateArr[1].','.$coordinateArr[0];
        }
        //
        $userPic = $_G['siteurl'].'/uc_server/avatar.php?uid='.$activeData['uid'].'&size=small';
        $userUrl = $_G['siteurl'].'/home.php?mod=space&uid='.$activeData['uid'].'&do=profile';
        //renqi
        $rankAct = array();
        $rankActData = getRankAct();
        if (!empty($rankActData)) {
            $rankAct = activeStruct($rankActData);

        }
        //relate act
        $relateAct = array();
        $relateActData = getRelateAct($activeData['type'], $activeData['city'], $activeData['id']);
        if (!empty($relateActData)) {
            $relateAct = activeStruct($relateActData);
        }
        //active user
        $activeUserData = $activeObj->queryRelateUser($activeId);

        //is collect
        $isPraise = 1;
        $praiseRes = $activeObj->getPraise($activeId, $_G['uid']);
        if (!empty($praiseRes) && $praiseRes[0]['status'] == 0) {
            $isPraise = 2;
        }
        //is apply
        $isApply = 0;
        $applyRes = $activeObj->getApply($activeId, $_G['uid']);
        if (!empty($applyRes) && $applyRes[0]['status'] == 0) {
            $isApply = 1;
        }
    }
}
//var_dump($rankAct);
//die();
function activeStruct($inData = array())
{
    global $_G;
    if (empty($inData)) {
        return array();
    }
    $res = array();
    $eventIdArr = array();
    foreach ($inData as $itemData) {
        $eventIdArr[] = $itemData['id'];
        $res[$itemData['id']] = $itemData;
        $itemRankTime = getDetailActiveTime($itemData['repeat_type'], $itemData['begin_time'], $itemData['end_time'], $itemData['repeat_time']);
        $res[$itemData['id']]['actTime'] = $itemRankTime;
    }
    //get rank img
    $actImg = getImage($eventIdArr);
    if (!empty($actImg)) {
        foreach ($actImg as $itemImg) {
            if ($itemImg['position'] == 1) {
                $res[$itemImg['event_id']]['image'] = $_G['siteurl'].'data/attachment/cityactive/'.$itemImg['img_root'];
            }
        }
    }
    return $res;
}

function getOriginData($aid)
{
    if (!intval($aid)) {
        return array();
    }
    $queryLogCon = 'select * from '.DB::table('mrbear_cityactive_event').' where id = '.$aid;

    $res = DB::fetch_all($queryLogCon);
    return $res;
}

function getImage($aid)
{
    if ((!is_array($aid) && !intval($aid)) || (is_array($aid) && empty($aid))) {
        return array();
    }
    if (is_array($aid)) {
        $aidStr = implode(',', $aid);
    } else {
        $aidStr = $aid;
    }

    $queryLogCon = 'select * from '.DB::table('mrbear_cityactive_image').' where event_id in ('.$aidStr.')';

    $res = DB::fetch_all($queryLogCon);
    return $res;
}

function getAcType($type, $subType = '')
{
    $pType = '';
    switch ($type) {
        case '10':
            $pType = '音乐';
            break;
        case '11':
            $pType = '戏剧';
            break;
        case '12':
            $pType = '展览';
            break;
        case '13':
            $pType = '讲座';
            break;
        case '14':
            $pType = '聚会';
            break;
        case '15':
            $pType = '运动';
            break;
        case '16':
            $pType = '旅行';
            break;
        case '17':
            $pType = '公益';
            break;
        case '18':
            $pType = '电影';
            break;
        default:
            $pType = '其他';
            break;
    }
    $sType = '';
    switch ($subType) {
        case '1101':
            $sType = '话剧';
            break;
        case '1102':
            $sType = '音乐剧';
            break;
        case '1103':
            $sType = '舞剧';
            break;
        case '1104':
            $sType = '歌剧';
            break;
        case '1105':
            $sType = '戏曲';
            break;
        case '1001':
            $sType = '小型现场';
            break;
        case '1002':
            $sType = '音乐会';
            break;
        case '1003':
            $sType = '演唱会';
            break;
        case '1004':
            $sType = '音乐节';
            break;
        case '1401':
            $sType = '生活';
            break;
        case '1402':
            $sType = '集市';
            break;
        case '1403':
            $sType = '摄影';
            break;
        case '1404':
            $sType = '外语';
            break;
        case '1405':
            $sType = '桌游';
            break;
        case '1406':
            $sType = '夜店';
            break;
        case '1407':
            $sType = '交友';
            break;
        case '1801':
            $sType = '主题放映';
            break;
        case '1802':
            $sType = '影展';
            break;
        case '1803':
            $sType = '影院活动';
            break;
        default:
            break;
    }
    $typeName = $pType;
    if ($sType != '') {
        $typeName .= '-'.$sType;
    }
    return $typeName;
}

function getActiveTime($repeatType, $beginTime, $endTime, $repeatTime)
{
    $activeTimeStr = '';
    $beginTime = date('Y-m-d H:i', strtotime($beginTime));
    $endTime = date('Y-m-d H:i', strtotime($endTime));
    if ($repeatType == 0) {
        $activeTimeStr = $beginTime.'至'.$endTime;
    } elseif ($repeatType == 1) {
        $beginDate = date('Y-m-d', strtotime($beginTime));
        $endDate = date('Y-m-d', strtotime($endTime));
        $beginTime = date('H:i:s', strtotime($beginTime));
        $endTime = date('H:i:s', strtotime($endTime));
        $activeTimeStr = $beginDate.'至'.$endDate.'每天'.$beginTime.'至'.$endTime;
    } elseif ($repeatType == 2) {
        $beginDate = date('Y-m-d', strtotime($beginTime));
        $endDate = date('Y-m-d', strtotime($endTime));
        $beginTime = date('H:i:s', strtotime($beginTime));
        $endTime = date('H:i:s', strtotime($endTime));
        $activeTimeStr = $beginDate.'至'.$endDate.'每周'.$repeatTime.$beginTime.'至'.$endTime;
    } else {
        $activeTimeStr = $repeatTime;
    }
    return $activeTimeStr;
}

function getDetailActiveTime($repeatType, $beginTime, $endTime, $repeatTime)
{
    $activeTimeStr = '';
    $beginTime = date('Y-m-d H:i', strtotime($beginTime));
    $endTime = date('Y-m-d H:i', strtotime($endTime));
    if ($repeatType == 0) {
        $activeTimeStr = $beginTime.'~'.$endTime;
    } elseif ($repeatType == 1) {
        $activeTimeStr = $beginTime.'~'.$endTime;
    } elseif ($repeatType == 2) {
        $activeTimeStr = $beginTime.'~'.$endTime;
    } else {
        $timeArr = explode('~', $repeatTime);
        if (!empty($timeArr)) {
            $activeTimeStr = $timeArr[0] .' ~ '.$timeArr[count($timeArr)-1];
        }
    }
    return $activeTimeStr;
}

function getFeeDetail($feeType, $detail)
{
    $feeDetail = array();
    if ($feeType == 0) {
        $feeDetail[] = '免费';
    } elseif ($feeType == 1) {
        $detail = str_replace('==', '--', $detail);
        $feeDetail = explode('||', $detail);
        foreach ($feeDetail as &$itemFee) {
            $itemFee .= '元';
        }
    } else {
        $feeDetail[] = '咨询主办方';
    }
    return $feeDetail;
}

function getRankAct()
{
    $queryCon = 'select id,title,type,subtype,repeat_type,begin_time,end_time,repeat_time,city,street_address,tags from '.DB::table('mrbear_cityactive_event').' where status = 1 order by active_count desc limit 5';
    $res = DB::fetch_all($queryCon);
    return $res;
}

function getRelateAct($type, $loc, $selfId)
{
    $queryCon = 'select id,title,repeat_type,begin_time,end_time,repeat_time,city,street_address,tags from '.DB::table('mrbear_cityactive_event').' where type = '.intval($type).' and city=\''.$loc.'\' and status=1 and id <> '.$selfId.' limit 6';
    $res = DB::fetch_all($queryCon);
    return $res;
}

//die();
include_once template('mrbear_cityactive:detail');