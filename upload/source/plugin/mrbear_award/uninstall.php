<?php
/**
 * Created by PhpStorm.
 * User: xiongfei
 * Date: 14-11-3
 * Time: 上午10:55
 */
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

$sql = <<<EOF

DROP TABLE mrbear_diaobao_config;
DROP TABLE mrbear_diaobao_user;
DROP TABLE mrbear_diaobao_log;

EOF;

runquery($sql);
$finish = TRUE;