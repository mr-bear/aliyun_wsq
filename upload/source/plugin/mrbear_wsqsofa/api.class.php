<?php
/**
 * Created by PhpStorm.
 * User: xiongfei
 * Date: 14-10-17
 * Time: 下午2:24
 */

if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class mrbear_wsqsofa_api
{
    function forumdisplay_topBar()
    {
        require_once DISCUZ_ROOT.'./source/plugin/wechat/wechat.lib.class.php';

        $return = array();
        $return[] = array(
            'name' => '抢沙发',
            'html' => '[topBar/TopBar1]',
            'more' => WeChatHook::getPluginUrl('mrbear_wsqsofa:view', array()),
        );
        return $return;
    }

}
