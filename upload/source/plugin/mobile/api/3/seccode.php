<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: seccode.php 34314 2014-02-20 01:04:24Z nemohou $
 */
//note secure(��֤��ȫ) @ Discuz! X3.x

if(!defined('IN_MOBILE_API')) {
	exit('Access Denied');
}

$_GET['idhash'] = $_GET['sechash'];
$_GET['mod'] = 'seccode';
include_once 'misc.php';

class mobile_api {

	//note ����ģ��ִ��ǰ��Ҫ���еĴ���
	function common() {		
	}

	//note ����ģ�����ǰ���еĴ���
	function output() {}

}

?>