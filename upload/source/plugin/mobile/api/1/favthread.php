<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: favthread.php 34314 2014-02-20 01:04:24Z nemohou $
 */
//note ���forum >> favthread(�ղ�����) @ Discuz! X2.5

if(!defined('IN_MOBILE_API')) {
	exit('Access Denied');
}

$_GET['mod'] = 'spacecp';
$_GET['ac'] = 'favorite';
$_GET['type'] = 'thread';
include_once 'home.php';

class mobile_api {

	//note ����ģ��ִ��ǰ��Ҫ���еĴ���
	function common() {
	}

	//note ����ģ�����ǰ���еĴ���
	function output() {
		$variable = array();
		mobile_core::result(mobile_core::variable($variable));
	}

}

?>