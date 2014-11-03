<?php
/**
 * Created by PhpStorm.
 * User: xiongfei
 * Date: 14-11-3
 * Time: 上午10:52
 */
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

$sql = <<<EOF

CREATE TABLE IF NOT EXISTS `mrbear_diaobao_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `rate` float NOT NULL,
  `day_max` int(11) NOT NULL DEFAULT '0',
  `event_max` int(11) NOT NULL DEFAULT '0',
  `score_max` int(11) NOT NULL,
  `score_type` int(11) NOT NULL DEFAULT '0',
  `item_score` varchar(45) NOT NULL DEFAULT '0',
  `add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;


CREATE TABLE IF NOT EXISTS `mrbear_diaobao_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(90) NOT NULL,
  `remain_score` int(11) NOT NULL DEFAULT '0',
  `total_score` int(11) NOT NULL DEFAULT '0',
  `last_time` datetime NOT NULL,
  `day_num` int(11) NOT NULL DEFAULT '0',
  `total_num` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `event_user` (`event_id`,`user_id`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS  `mrbear_diaobao_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(120) NOT NULL,
  `score_type` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `source` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

EOF;

runquery($sql);

DB::query( "REPLACE INTO ".DB::table("common_credit_rule")." VALUES (NULL, '".$installlang['awardSign']."', 'mrbear_award', '4', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '');"
);

$finish = TRUE;