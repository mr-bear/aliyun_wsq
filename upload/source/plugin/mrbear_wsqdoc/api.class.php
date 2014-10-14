<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: install.php 34718 2014-07-14 08:56:39Z nemohou $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class mrbear_wsqdoc_api {

	function viewthread_postBottom() {
        //done
        global $_G;
        require_once DISCUZ_ROOT.'./source/function/function_misc.php';
        $positionImg = $_G['siteurl'].'./source/plugin/mrbear_wsqdoc/1.jpg';

		$return = array();
		foreach($GLOBALS['postlist'] as $post) {
            $userIp = $post['useip'];
            $mobileType = intval($post['mobiletype']);
            //convert ip to position
            $convertRes = convertip($userIp);
            if(is_string($convertRes)){
                $convertRes = str_replace('-','',$convertRes);
            }else{
                $convertRes = '';
            }
            switch($mobileType){
                case 1:
                    $sourceName = lang('plugin/mrbear_wsqdoc', 'ios');
                    break;
                case 2:
                    $sourceName = lang('plugin/mrbear_wsqdoc', 'android');
                    break;
                case 3:
                    $sourceName = lang('plugin/mrbear_wsqdoc', 'windowsphone');
                    break;
                case 5:
                    $sourceName = lang('plugin/mrbear_wsqdoc', 'wsq');
                    break;
                default:
                    $sourceName = lang('plugin/mrbear_wsqdoc', 'pc');
                    break;
            }

            $posImgStyle = '<span style="background: url('.$positionImg.');width:15px;height:14px;margin-bottom:-3px;display:inline-block;"></span>';
            $postionStyle = '<span style="line-height:24px;color:#bbb;font-size:11px;">'.$convertRes.'</span>';
            $sourceStyle = '<span style="line-height:24px;margin-left:5px;color:#bbb;font-size:11px;">['.lang('plugin/mrbear_wsqdoc', 'source').'<em style="color:#2d64b3;font-style: normal">'.$sourceName.'</em>]</span>';
			$return[$post['pid']] = $posImgStyle.$postionStyle.$sourceStyle;
		}
		return $return;
	}


	function viewthread_threadBottom() {
        global $_G;
        $positionImg = $_G['siteurl'].'./source/plugin/mrbear_wsqdoc/board_guess.gif';
        $wsqConfig = $_G['cache']['plugin']['mrbear_wsqdoc'];
        $ruleType = (isset($wsqConfig['rule']))?intval($wsqConfig['rule']):0;
        $days = (isset($wsqConfig['day']) && intval($wsqConfig['day'])) ?intval($wsqConfig['day']):3;
        $rule = $this->switchRule($ruleType);
        $current = Date('Y-m-d H:i:s');
        $hotTime = strtotime($current) - 86400*$days;

        $threadlist = C::t('forum_thread')->fetch_all_by_dateline($hotTime,0,3,$rule,'DESC');
        $liStr = '';
        $res = '';
        if(!empty($threadlist)){
            foreach($threadlist as $itemValue){
                $subject = $this->pluginIconv($itemValue['subject']);
                $liStr .= '<li style="line-height:22px;height:22px;font-size:12px;color:#b8b9ba;text-align:left;">·<a href="">'.$subject.'</a></li>';
            }

            $spanStyle = '<span style="background-color:#f1f2f4;border-top:1px solid #ececec;border-bottom:1px solid #ececec;padding:10px;position:relative;display:block;">';
            $spanTitle = '<span style="display: block;font-size:14px;color:#fff;font-weight:700;background:url('.$positionImg.') no-repeat;line-height:24px;height:24px;margin-left:-10px;margin-top:-10px;">'.lang('plugin/mrbear_wsqdoc', 'docrec').'</span>';
            $contentStyle = '<ul style="width: 340px;">'.$liStr.'</ul>';
            $res = $spanStyle.$spanTitle.$contentStyle.'</span>';
        }

        return $res;
	}


    function pluginIconv($inData){
        global $_G;
        $charset = $_G['charset'];
        $outData = $inData;
        if('UTF-8' != $charset){
            $outData = diconv($inData,$charset,'UTF-8');
        }
        return $outData;

    }

    function switchRule($ruleType){
        $ruleType = intval($ruleType);
        $rule = '';
        switch($ruleType){
            case 1:
                $rule = 'heats';
                break;
            case 2:
                $rule = 'views';
                break;
            case 3:
                $rule = 'replies';
                break;
            default:
                $rule = 'views';
                break;
        }
        return $rule;
    }
}

?>
