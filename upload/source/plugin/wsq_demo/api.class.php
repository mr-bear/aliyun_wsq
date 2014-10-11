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

	function forumdisplay_threadStyle() {
		global $_G;
		$return = array();
		foreach($GLOBALS['threadlist'] as $thread) {
			if(!$thread['displayorder']) {
				$return[$thread['tid']] = array(
				    'id' => 'style1',
				    'var' => array(
					'uid' => $_G['uid'],
					'username' => $_G['username'],
					'hookname' => 'threadStyle/'.$thread['tid']
				    )
				);
				break;
			}
		}
		return $return;
	}

	function forumdisplay_topBar() {
		require_once DISCUZ_ROOT.'./source/plugin/wechat/wechat.lib.class.php';

		$return = array();
		$return[] = array(
		    'name' => 'TopBar1',
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
		$return = array();
		foreach($GLOBALS['postlist'] as $post) {
			$return[$post['pid']] = '[postBottom/'.$post['pid'].']';
		}
		return $return;
	}

	function viewthread_authorInfo() {
		$return = array();
		foreach($GLOBALS['postlist'] as $post) {
			$return[$post['authorid']] = '[authorInfo/'.$post['authorid'].']';
		}
		return $return;
	}

	function viewthread_threadTop() {
		return '[threadTop]';
	}

	function viewthread_threadBottom() {

//        var_dump($GLOBALS['postlist']);
//        echo 111;
//		return json_encode($GLOBALS['postlist']);
        return '[theadBottom]';
	}

	function viewthread_topBar() {
		return '[topBar]';
	}

	//profile

	function profile_authorInfo() {
		return '[authorInfo]';
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

}

?>
