<?php
/**
 * Created by PhpStorm.
 * User: xiongfei
 * Date: 14-11-6
 * Time: 上午9:52
 */

if (!defined('IN_DISCUZ')) {

    exit('Access Denied');

}
$formHash = formhash();
include_once template('mrbear_cityactive:reg');