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

class wsq_demo_api {

	//forumdisplay

	function forumdisplay_sideBar() {
		return '[sideBar]';
	}

	function forumdisplay_threadBottom() {
		$return = array();
		foreach($GLOBALS['threadlist'] as $thread) {
			$return[$thread['tid']] = '[threadBottom/'.$thread['tid'].']';
		}
		return $return;
	}

	function forumdisplay_authorInfo() {
		$return = array();
		foreach($GLOBALS['threadlist'] as $thread) {
			$return[$thread['authorid']] = '[authorInfo/'.$thread['authorid'].']';
		}
		return $return;
	}

	function forumdisplay_threadStyleTemplate() {
		$return = array();
		$return['style1'] = <<<EOF
<div class="topicBox threadList" tid="<%= Variables.forum_threadlist[i].tid %>" style="background:#FFFF00">
	[threadStyleTemplate/style1]
	<div class="topicCon">
		<p class="personImgDate">
		    <span class="perImg db">
			<img src="<%= Variables.forum_threadlist[i].avatar %>" onerror="javascript:this.src='../cdn/discuz/images/personImg.jpg'" class="bImg" uid="<%= Variables.forum_threadlist[i].authorid %>">
			<span class="timeT">
			    <%= Variables.forum_threadlist[i].author %>
			    <% if(Variables.forum_threadlist[i].authorLv) { %><em><img src="../cdn/discuz/images/rankInco1.png" class="crown" /><%= Variables.forum_threadlist[i].authorLv %></em><% } %>
			    <% if(Variables.forum_threadlist[i].hook_author_info) { %>
				<em><%== stripCode(Variables.forum_threadlist[i].hook_author_info) %></em>
			    <% } %>
			    <i><%= Variables.forum_threadlist[i].dateline %></i>
			</span>
		    </span>
		    <span class="perDate db" tid="<%= Variables.forum_threadlist[i].tid %>" fid="<%= Variables.forum.fid %>">
			<a href="javascript:;" class="incoA db"></a>
		    </span>
		    <span class="perPop" tid="<%= Variables.forum_threadlist[i].tid %>" style="display:none"></span>
		 </p>
		<div class="detailCon">
		    <span class="replyShare db fr">
			<a class="topicadminMsg" tid="<%= Variables.forum_threadlist[i].tid %>"></a>
			<a href="javascript:;" class="incoRBtn" tid="<%= Variables.forum_threadlist[i].tid %>"><i class="incoR"></i><%= Variables.forum_threadlist[i].replies == 0 ? "Reply" : Variables.forum_threadlist[i].replies%></a>
		    </span>
		    <% if(Variables.forum_threadlist[i].hook_thread_bottom) { %>
			<span class="fl tl"><%== stripCode(Variables.forum_threadlist[i].hook_thread_bottom) %></span>
		    <% } %>
		</div>
	</div>
	<!-- ģ����� -->
	[{hookname}] CurrentUser = {username}({uid})
</div>
EOF;
		return $return;
	}

	// function forumdisplay_threadStyle() {
	// 	global $_G;
	// 	$return = array();
	// 	foreach($GLOBALS['threadlist'] as $thread) {
	// 		if(!$thread['displayorder']) {
	// 			$return[$thread['tid']] = array(
	// 			    'id' => 'style1',
	// 			    'var' => array(
	// 				'uid' => $_G['uid'],
	// 				'username' => $_G['username'],
	// 				'hookname' => 'threadStyle/'.$thread['tid']
	// 			    )
	// 			);
	// 			break;
	// 		}
	// 	}
	// 	return $return;
	// }

	function forumdisplay_topBar() {
		require_once DISCUZ_ROOT.'./source/plugin/wechat/wechat.lib.class.php';

		$return = array();
		$return[] = array(
		    'name' => '测试',
		    'html' => '[topBar/TopBar1]',
		    'more' => WeChatHook::getPluginUrl('wsq_demo:view', array('a' => 1, 'b' => 2)),
		);
		return $return;
	}

	//viewthread

	function viewthread_sideBar() {

		return '[sideBar]';
	}

	function viewthread_postBottom() {
        //done
        global $_G;
        require_once DISCUZ_ROOT.'./source/function/function_misc.php';
        $positionImg = $_G['siteurl'].'./source/plugin/wsq_demo/1.jpg';

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
                    $sourceName = 'iphone客户端';
                    break;
                case 2:
                    $sourceName = 'android客户端';
                    break;
                case 3:
                    $sourceName = 'windowsphone客户端';
                    break;
                case 5:
                    $sourceName = '微社区';
                    break;
                default:
                    $sourceName = 'pc端';
                    break;
            }

            $posImgStyle = '<span style="background: url('.$positionImg.');width:15px;height:14px;margin-bottom:-3px;display:inline-block;"></span>';
            $postionStyle = '<span style="line-height:24px;color:#bbb;font-size:11px;">'.$convertRes.'</span>';
            $sourceStyle = '<span style="line-height:24px;margin-left:5px;color:#bbb;font-size:11px;">[来自<em style="color:#2d64b3;font-style: normal">'.$sourceName.'</em>]</span>';
			$return[$post['pid']] = $posImgStyle.$postionStyle.$sourceStyle;
		}
		return $return;
	}

	function viewthread_authorInfo() {
		$return = array();
        $style = <<<EOF
            <span class="gBg1 brSmall fb f8 c2" style="font-style:normal;">LV1</span>
EOF;
		foreach($GLOBALS['postlist'] as $post) {
            $itemStars = $post['stars'];
            $style = '';
			$return[$post['authorid']] = $style;
		}
		return $return;
	}

	function viewthread_threadTop() {
		return '[threadTop]';
	}

	function viewthread_threadBottom() {
        $current = Date('Y-m-d H:i:s');
        $days = 3; // need set
        $rule = 'replies';
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
            $spanTitle = '<span style="display: block;font-size:14px;color:#fff;font-weight:700;background:url(http://imgs.xici.net/_img/board/board_guess.gif) no-repeat;line-height:24px;height:24px;margin-left:-10px;margin-top:-10px;">热帖推荐</span>';
            $contentStyle = '<ul style="width: 340px;">'.$liStr.'</ul>';
            $res = $spanStyle.$spanTitle.$contentStyle.'</span>';
        }

        return $res;
	}

	function viewthread_topBar() {

        return json_encode($GLOBALS['postlist']);

	}

	//profile

	function profile_authorInfo() {
		return '[profile_authorInfo]';
	}

	function profile_extraInfo() {
		$return = array();
		$return[] = array(
		    'name' => '[extraInfo/extraInfo1]',
		    'value' => '<b>value</b>',
		);
		$return[] = array(
		    'name' => '[extraInfo/extraInfo2]',
		    'link' => 'asdasd',
		);
		return $return;
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
}

?>
