<?php
/**
 * Created by PhpStorm.
 * User: xiongfei
 * Date: 14-11-3
 * Time: 下午1:50
 */

if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}

$type = (isset($_GET['t']) && in_array($_GET['t'], array('s', 'u'))) ? $_GET['t'] : 's';
$eventId = (isset($_GET['eid']) && is_numeric($_GET['eid'])) ? intval($_GET['eid']) : '';


$totalData = array();
switch ($type) {
    case 's':
        $totalData = getTotalData($eventId);
        break;
    case 'u':
        $totalData = getUserData($eventId);
        break;
    default:
        break;
}


$url = ADMINSCRIPT.'?action=plugins&operation=config&do='.$pluginid.'&identifier=mrbear_award&pmod=admin&t=';
$totalUrl = $url.'s';
$userUrl = $url.'u';

function getTotalData($eventId = '')
{
    if (!is_numeric($eventId)) {
        return array();
    }
    $queryCon = 'SELECT date(add_time) add_time,sum(case when score_type = 1 then score end) jq,sum(case when score_type = 2 then score end) gx,sum(case when score_type = 3 then score end) ww,count(case when source = 0 then id end) pc_count,count(case when source = 1 then id end) mobile_count FROM '.DB::table('mrbear_diaobao_log').' where event_id = '.$eventId.' group by date(add_time) order by add_time desc;';
    $totalRes = DB::fetch_all($queryCon);

    $queryCon = 'SELECT date(add_time) add_time,count(distinct user_id) u_count FROM '.DB::table('mrbear_diaobao_log').' where event_id = '.$eventId.' group by date(add_time) order by add_time desc;';
    $userTotalRes = DB::fetch_all($queryCon);

    $queryCon = 'SELECT date(add_time) add_time,count(1) count FROM '.DB::table('mrbear_diaobao_user').' where event_id = '.$eventId.' group by date(add_time);';
    $activeUserRes = DB::fetch_all($queryCon);

    if (empty($totalRes) || empty($userTotalRes) || empty($activeUserRes)) {
        return array();
    }

    $res = array();

    foreach ($totalRes as &$itemTotal) {
        if (is_null($itemTotal['jq'])) {
            $itemTotal['jq'] = 0;
        }
        if (is_null($itemTotal['ww'])) {
            $itemTotal['ww'] = 0;
        } if (is_null($itemTotal['gx'])) {
            $itemTotal['gx'] = 0;
        }
        $res[$itemTotal['add_time']] = $itemTotal;
        $res[$itemTotal['add_time']]['new_user'] = 0;
    }
    foreach ($userTotalRes as $itemUTotal) {
        if (isset($res[$itemUTotal['add_time']])) {
            $res[$itemUTotal['add_time']]['u_count'] = $itemUTotal['u_count'];
        }
    }
    foreach ($activeUserRes as $itemActive) {
        if (isset($res[$itemActive['add_time']])) {
            $res[$itemActive['add_time']]['new_user'] = $itemActive['count'];
        }
    }
    return $res;

}

function getUserData($eventId)
{
    if (!is_numeric($eventId)) {
        return array();
    }
    $queryCon = '
                SELECT
                    user_id,
                    sum(case
                        when score_type = 1 then score
                    end) jq,
                    sum(case
                        when score_type = 2 then score
                    end) gx,
                    sum(case
                        when score_type = 3 then score
                    end) ww
                FROM
                    '.DB::table('mrbear_diaobao_log').'
                where event_id = '.$eventId.'
                group by user_id
                ';
    $userLogRes =  DB::fetch_all($queryCon);

    $queryCon = '
                SELECT
                    user_id,user_name,last_time,day_num,total_num,add_time
                from
                    '.DB::table('mrbear_diaobao_user').'
                where event_id = '.$eventId;
    $userInfoRes =  DB::fetch_all($queryCon);

    $userRes = array();

    if (empty($userInfoRes) || empty($userLogRes)) {
        return $userRes;
    }
    foreach ($userInfoRes as $itemUser) {
        $userRes[$itemUser['user_id']] = $itemUser;
    }
    foreach ($userLogRes as $itemLog) {
        if (isset($userRes[$itemLog['user_id']])) {
            $userRes[$itemLog['user_id']]['jq'] = is_null($itemLog['jq']) ? 0 : $itemLog['jq'];
            $userRes[$itemLog['user_id']]['ww'] = is_null($itemLog['ww']) ? 0 : $itemLog['ww'];
            $userRes[$itemLog['user_id']]['gx'] = is_null($itemLog['gx']) ? 0 : $itemLog['gx'];
        }
    }
    return $userRes;

}

include_once template('mrbear_award:admin');

