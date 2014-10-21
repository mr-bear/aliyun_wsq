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
        global $_G;

        $currentDate = date('Y-m-d');
        $unixTime = strtotime($currentDate);
        $unixTime = $unixTime - (3600*24*6);
        $sofaData = $this->getSofaData($unixTime);
        $siteUrl = $_G['siteurl'];

        $dom = '<ul class="customImg" style="margin-top:0px;">';
        if (!empty($sofaData)) {
            $domStruct = <<<eof
                    <li style="width:33%">
                        <span style="margin-bottom:23px;display:inline-block;color:#FC0812;font-style:italic;">{#rank#}</span>
                        <a href="{#userurl#}" target="_blank"><img src="{#img#}" width="40" height="40" style="border-radius: 50px;"></i>
                        <span class="cuText f11 c4 br db" style="white-space: nowrap;text-overflow:ellipsis; overflow:hidden;width:60px;margin-left:20px;">{#uname#}</span>
                        </a>
                    </li>

eof;
            $i = 1;
            foreach ($sofaData as $itemValue) {
                $authorId = $itemValue['authorid'];
                $author = $this->pluginIconv($itemValue['author']);
                $userImg = $siteUrl.'uc_server/avatar.php?uid='.$authorId.'&size=small';
                $userUrl = $this->getUserUrl($authorId);

                $itemDom = str_replace('{#rank#}', $i, $domStruct);
                $itemDom = str_replace('{#uname#}', $author, $itemDom);
                $itemDom = str_replace('{#img#}', $userImg, $itemDom);
                $itemDom = str_replace('{#userurl#}', $userUrl, $itemDom);

                $dom .= $itemDom;
                if ($i == 3) {
                    break;
                }
                $i++;
            }
        }
        $dom .= '</ul>';


        $return = array();
        $return[] = array(
            'name' => lang('plugin/mrbear_wsqsofa', 'pluginTitle'),
            'html' => $dom,
            'more' => WeChatHook::getPluginUrl('mrbear_wsqsofa:view', array()),
        );
        return $return;
    }

    function pluginIconv($inData)
    {
        global $_G;
        $charset = $_G['charset'];
        $outData = $inData;
        if ('UTF-8' != $charset) {
            $outData = diconv($inData, $charset, 'UTF-8');
        }
        return $outData;

    }

    function getSofaData($time = '')
    {
        $historyCon = '';
        if ($time != '') {
            $historyCon = ' and dateline>='.$time;
        }
        $queryCon = 'SELECT authorid,author,count(1) count FROM '.DB::table('forum_post').' where position=2 '.$historyCon.' group by authorid order by count desc limit 3';

        $historySofaData = DB::fetch_all($queryCon);
        return $historySofaData;
    }

    function getUserUrl($uid)
    {
        $wsqUrl = 'http://wsq.discuz.qq.com?';
        $params = array(
            'c' => 'index',
            'a' => 'profile',
            'siteid' => 0,
            'f' => 'wx',
            'uid' => $uid,
        );
        global $_G;
        $setting = unserialize($_G['setting']['mobilewechat']);
        $siteId = $setting['wsq_siteid'];
        $params['siteid'] = $siteId;
        return $wsqUrl.http_build_query($params);
    }
}
