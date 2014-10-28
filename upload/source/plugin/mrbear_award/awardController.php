<?php
/**
 * Created by PhpStorm.
 * User: xiongfei
 * Date: 14-10-28
 * Time: 下午3:51
 */
if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class award {
    const PLUGIN_ID = 'mrbear_award';
    private $_config = array();
    private $_eventId = 0;
    private $_userId = 0;
    private $_userName = '';
    private $_userGroup = 0;

    public function __construct()
    {
        global $_G;
        $this->_config = $_G['cache']['plugin'][self::PLUGIN_ID];
        $this->_eventId = $this->_config['id'];
        $this->_userId = $_G['uid'];
        $this->_userName = $_G['username'];
        $this->_userGroup = $_G['groupid'];
    }

    /**
     * query user info
     * @return array
     */
    public function getUserInfo()
    {
        if (!intval($this->_userId)) {
            return array();
        }
        $queryCon = 'select * from '.DB::table('mrbear_diaobao_user').' where event_id = '.$this->_eventId.' and user_id = '.$this->_userId;
        $userInfo = DB::fetch_all($queryCon);
        return $userInfo;
    }

    /**
     * insert into user
     * @return int
     */
    public function insertUser()
    {
        if (!intval($this->_userId)) {
            return array();
        }
        $insertData = array(
            'event_id' => $this->_eventId,
            'user_id' => $this->_userId,
            'user_name' => $this->_userName,
            'last_time' => '',
        );
        return DB::insert(DB::table('mrbear_diaobao_user'), $insertData);
    }

    public function getAward()
    {
        $awardInfo = array(
            'status' => 0,
            'data' => array(),
        );
        $rateConfig = $this->_config['rate'];
        $rand = rand(0, 1);
        if (!empty($rateConfig) && $rand > $rateConfig)
        {
            //check day max

        } else {
            //no award
            $awardInfo['status'] = 1;
        }

    }

    public function checkEventTime()
    {
        $checkTimeRes = false;
        $startTime = strtotime($this->_config['start_time']);
        $endTime = strtotime($this->_config['end_time']);
        $currentTime = time();
        if (!empty($startTime) && !empty($endTime)) {
            if ($currentTime>$startTime && $currentTime<$endTime) {
                $checkTimeRes = true;
            }
        }
        return $checkTimeRes;
    }

    public function checkUserLevel()
    {
        $checkGroupRes = false;
        $userLevelConfig = $this->_config['user_level'];
        $userLevelConfig = unserialize($userLevelConfig);

        if (!empty($userLevelConfig)) {
            if ($this->_userGroup && in_array($this->_userGroup, $userLevelConfig)) {
                $checkGroupRes = true;
            }
        } else {
            $checkGroupRes = true;
        }
        return $checkGroupRes;
    }

    public function checkBlackList()
    {
        $checkBlackRes = false;
        $blackConfig = $this->_config['black_lists'];

        $blackList = explode(PHP_EOL, $blackConfig);

        if (!empty($blackList)) {
            if (!in_array($this->_userId, $blackList)) {
                $checkBlackRes = true;
            }

        } else {
            $checkBlackRes = true;
        }
        return $checkBlackRes;
    }

    public function __get($name)
    {

        return $this->$name;
    }
}