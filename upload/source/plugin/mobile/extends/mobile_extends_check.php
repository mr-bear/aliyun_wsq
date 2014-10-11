<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: mobile_extends_check.php 33590 2013-07-12 06:39:08Z andyzheng $
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
//$variable = array();
class mobile_api {

	var $variable = array();

	//note ����ģ��ִ��ǰ��Ҫ���еĴ���
	function common() {
		//global $variable;

		//note��ȡ�Ѿ����õ���չ����ģ��
//		$extendlist = array();
//		foreach(C::t('#mobile#mobile_extendmodule')->fetch_all_used() as $module) {
//			unset($module['mid'], $module['available'], $module['modulefile'], $module['displayorder']);
//			$extendlist[] = $module;
//		}

		$this->variable = array(
			'extends' => array(
				'extendversion' => '1',
				'extendlist' => array(
					array(
						'identifier' => 'dz_newthread',
						'name' => lang('plugin/mobile', 'mobile_extend_newthread'),
						'icon' => '0',
						'islogin' => '0',
						'iconright' => '0',
						'redirect' => '',
					),
					array(
						'identifier' => 'dz_newreply',
						'name' => lang('plugin/mobile', 'mobile_extend_newreply'),
						'icon' => '0',
						'islogin' => '0',
						'iconright' => '0',
						'redirect' => '',
					),
					array(
						'identifier' => 'dz_digest',
						'name' => lang('plugin/mobile', 'mobile_extend_digest'),
						'icon' => '0',
						'islogin' => '0',
						'iconright' => '0',
						'redirect' => '',
					),
					array(
						'identifier' => 'dz_newpic',
						'name' => lang('plugin/mobile', 'mobile_extend_newpic'),
						'icon' => '0',
						'islogin' => '0',
						'iconright' => '0',
						'redirect' => '',
					),
				),
			)
		);
//		$this->variable = array(
//			'extends' => array(
//				'extendversion' => '1',
//				'extendlist' => $extendlist,
//			),
//		);
	}

	//note ����ģ�����ǰ���еĴ���
	function output() {
		//global $variable;
		mobile_core::result(mobile_core::variable($this->variable));
	}
}
?>