<?php
/**
 * Created by PhpStorm.
 * User: xiongfei
 * Date: 14-11-6
 * Time: 下午2:12
 */

if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
ini_set("display_errors", 1);
error_reporting(E_ALL);


require_once DISCUZ_ROOT.'./source/plugin/mrbear_cityactive/activeController.php';

$response = array(
    'status' => 0,
    'data' => '',
    'msg' => ''
);
$postData = $_GET;
$activeObj = new active();
if (isset($postData['act'])) {
    if ($postData['act'] == 'reg') {
        $activeObj->targetRoot = DISCUZ_ROOT.'./data/attachment/cityactive/';
        $saveRes = $activeObj->saveActive($postData);
        if ($saveRes['status']) {
            $response['status'] = 1;
            $response['data'] = $saveRes['activeId'];
        } else {
            $response['msg'] = $saveRes['msg'];
        }
        echo json_encode($response);
    } elseif ($postData['act'] == 'praise') {
        if (isset($postData['eid']) && isset($postData['uid']) && isset($postData['iscancel'])) {
            $cancelRes = $activeObj->praiseEvent(intval($postData['eid']), intval($postData['uid']), intval($postData['iscancel']));
            if ($cancelRes) {
                $response['status'] = 1;
            }
        }
        echo json_encode($response);
    } elseif ($postData['act'] == 'apply') {
        if (isset($postData['eid']) && isset($postData['uid']) && isset($postData['isapply'])) {
            $applyRes = $activeObj->applyEvent(intval($postData['eid']), intval($postData['uid']), $postData['real_name'], $postData['user_phone'], $postData['other_info'], intval($postData['isapply']));
            if ($applyRes) {
                $response['status'] = 1;
            }
        }
        echo json_encode($response);
    }

}

