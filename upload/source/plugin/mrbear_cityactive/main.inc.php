<?php
/**
 * Created by PhpStorm.
 * User: xiongfei
 * Date: 14-11-6
 * Time: 上午9:52
 */

if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
require_once DISCUZ_ROOT.'./source/plugin/mrbear_cityactive/activeController.php';

$loc_id = isset($_GET['locid']) ? intval($_GET['locid']) : 0;
$fType = isset($_GET['ftype']) ? intval($_GET['ftype']) : 0;
$type = array();
switch ($fType) {
    case '1':
        $type = array(10, 11);
        break;
    case '2':
        $type = array(12, 13);
        break;
    case '3':
        $type = array(14, 15, 16);
        break;
    case '4':
        $type = array(18);
        break;
    case '5':
        $type = array(17, 99);
        break;
    default:
        $type = array();
        break;
}
$feeType = (isset($_GET['fee']) && $_GET['fee'] != '') ? intval($_GET['fee']) : '';
$order = isset($_GET['order']) ? $_GET['order'] : '';
$page = isset($_GET['p']) ? intval($_GET['p']) : 1;

$activeObj = new active();
$eventRes = $activeObj->queryEvent(array(), $loc_id, $type, $feeType, $order, $page-1);
$eventData = $eventRes['data'];
$totalCount = $eventRes['total'];
foreach ($eventData as &$itemEvent) {
    $itemEvent['fee_detail'] = str_replace('==', ' ', $itemEvent['fee_detail']);
}
unset($itemEvent);
//var_dump($eventData);
//die();

//index focusmap
global $_G;
$eventConfig = $_G['cache']['plugin']['mrbear_cityactive'];
$indexFocus = $eventConfig['index_focus'];
$indexFocusArr = explode(PHP_EOL, $indexFocus);
$indexFocusRes = array();
if (!empty($indexFocusArr)) {
    foreach ($indexFocusArr as $itemFocus) {
        $itemFocusSArr = explode('||', $itemFocus);
        if (count($itemFocusSArr) == 3) {
            $indexFocusRes[] = $itemFocusSArr;
        }
    }
}

//Hot citylists
$hotCitysRes = $activeObj->queryHotCity();

//near event
$nearEventRes = $activeObj->queryNearBegin();

//my data

$myData = $activeObj->queryMyTotal();
$mynbCount = $myData['nbCount'];
$mybeginCount = $myData['beginCount'];
$myActiveCount = $myData['activeCount'];
$myPraiseCount = $myData['praiseCount'];

$currentPage = $page;
$totalPage = ceil($totalCount/10);
if ($currentPage && $totalPage && $currentPage<=$totalPage) {
    $prePage = $currentPage - 1;
    $pPrePage = $currentPage - 2;

    $nextPage = (($currentPage + 1) > $totalPage) ? 0 : $currentPage + 1;
    $nNextPage = (($currentPage + 2) > $totalPage) ? 0 : $currentPage + 2;

}

include_once template('mrbear_cityactive:main');