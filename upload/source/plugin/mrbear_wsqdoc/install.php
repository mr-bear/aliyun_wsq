<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}
$pluginid = 'mrbear_wsqdoc';
$hooks = array(

    'viewthread_postBottom',
    'viewthread_threadTop',
    'viewthread_threadBottom',
    'viewthread_topBar',
    'viewthread_authorInfo',

);

$data = array();
foreach($hooks as $hook) {
    $data[] = array(
        $hook => array(
            'plugin' => $pluginid,
            'include' => 'api.class.php',
            'class' => $pluginid.'_api',
            'method' => $hook,
        )
    );
}

require_once DISCUZ_ROOT.'./source/plugin/wechat/wechat.lib.class.php';
$ret = WeChatHook::updateAPIHook($data);
$finish = TRUE;
