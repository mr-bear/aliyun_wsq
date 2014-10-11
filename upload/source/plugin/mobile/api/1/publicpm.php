<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: publicpm.php 34314 2014-02-20 01:04:24Z nemohou $
 */
//note ��Ϣpm >> publicpm(������Ϣ) @ Discuz! X2.5

if(!defined('IN_MOBILE_API')) {
	exit('Access Denied');
}

$_GET['mod'] = 'space';
$_GET['do'] = 'pm';
$_GET['filter'] = 'announcepm';
include_once 'home.php';

class mobile_api {

	//note ����ģ��ִ��ǰ��Ҫ���еĴ���
	function common() {
	}

	//note ����ģ�����ǰ���еĴ���
	function output() {
		global $_G;
		$variable = array(
			'list' => mobile_core::getvalues($GLOBALS['grouppms'], array('/^\d+$/'), array('id', 'authorid', 'author', 'dateline', 'message')),
			'count' => count($GLOBALS['grouppms']),
			'perpage' => $GLOBALS['perpage'],
			'page' => $GLOBALS['page'],
		);
		mobile_core::result(mobile_core::variable($variable));
	}

}

?>