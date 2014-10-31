<?php
/**
 * Created by PhpStorm.
 * User: xiongfei
 * Date: 14-10-28
 * Time: 下午3:51
 */
if (!defined('IN_DISCUZ')) {
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
     * @param $userId
     * @param $eventId
     * @return array
     */
    public function getUserInfo($userId, $eventId)
    {
        if (!intval($userId)) {
            return array('status'=>1,'data'=>'');
        }
        $queryCon = 'select * from '.DB::table('mrbear_diaobao_user').' where event_id = '.$eventId.' and user_id = '.$userId;
        $userInfo = DB::fetch_all($queryCon);
        return array('status'=>0,'data'=>$userInfo);
    }

    /**
     * update user info
     * @param $eventId
     * @param $userId
     * @param array $data
     * @return array|bool|void|
     */
    public function updateUserInfo($eventId, $userId, $data = array())
    {
        if (!intval($userId) || !is_array($data) || empty($data)) {
            return array();
        }
        return DB::update('mrbear_diaobao_user', $data, 'user_id = '.$userId.' and event_id = '.$eventId);
    }

    /**
     * @param $userId
     * @param $eventId
     * @param $userName
     * @return array|int
     */
    public function insertUser($userId, $eventId, $userName)
    {
        if (!intval($userId)) {
            return array();
        }
        $insertData = array(
            'event_id' => $eventId,
            'user_id' => $userId,
            'user_name' => $userName,
            'last_time' => '',
        );
        return DB::insert('mrbear_diaobao_user', $insertData);
    }

    /**
     * add log
     * @param $data
     * @return array|int
     */
    public function insertLog($data)
    {
        if (!is_array($data) || empty($data)) {
            return array();
        }
        return DB::insert('mrbear_diaobao_log', $data);
    }

    /**
     * add creadits
     * @param $userId
     * @param $type
     * @param $score
     * @return array|int|string
     */
    public function updateUserCredits($userId, $type, $score)
    {
        if (!intval($userId) || !in_array($type, array(1, 2, 3))) {
            return array();
        }
        $where = ' where uid = '.$userId;
        $sql = '';
        switch ($type) {
            case 1:
                //update common_member_count 1=extcredits2 2=extcredits3 3=extcredits1
                $sql = 'update '.DB::table('common_member_count').' set extcredits2 = extcredits2+'.$score.$where;
                break;
            case 2:
                $sql = 'update '.DB::table('common_member_count').' set extcredits3 = extcredits3+'.$score.$where;
                break;
            case 3:
                $sql = 'update '.DB::table('common_member_count').' set extcredits1 = extcredits1+'.$score.$where;
                break;
            default:
                break;
        }
        if ($sql != '') {
            return DB::query($sql);
        } else {
            return array();
        }
    }

    /**
     * insert into credits rule log
     * @param $userId
     * @param $type
     * @param $num
     * @return array|int|string
     */
    public function upCreditsRuleLog($userId, $type, $num)
    {
        if (!intval($userId)) {
            return array();
        }
        $creType = '';
        $upCon = '';
        switch ($type) {
            case 1:
                $creType = 'extcredits2';
                $upCon = ' total = total + 1,cyclenum = cyclenum + 1, extcredits2 = extcredits2 + '.$num;
                break;
            case 2:
                $creType = 'extcredits3';
                $upCon = ' total = total + 1,cyclenum = cyclenum + 1, extcredits3 = extcredits3 + '.$num;
                break;
            case 3:
                $creType = 'extcredits1';
                $upCon = ' total = total + 1,cyclenum = cyclenum + 1, extcredits1 = extcredits1 + '.$num;
                break;
            default:
                return array();
                break;
        }
        $queryCon = 'select rid from '.DB::table('common_credit_rule').' where action = \''.self::PLUGIN_ID.'\'';
        $ridRes = DB::fetch_all($queryCon);

        if (!empty($ridRes)) {
            $rid = $ridRes[0]['rid'];
            $queryLogCon = 'select * from '.DB::table('common_credit_rule_log').' where uid = '.$userId.' and rid = '.$rid;
            $logRes = DB::fetch_all($queryLogCon);
            if (empty($logRes)) {
                //insert
                $insertCon = 'insert into '.DB::table('common_credit_rule_log').'(uid,rid,total,cyclenum,'.$creType.',dateline) values ('.$userId.','.$rid.',1,1,'.$num.','.time().')';
                $upRes = DB::query($insertCon);
            } else {
                //update
                $updateCon = 'update '.DB::table('common_credit_rule_log').' set '.$upCon.' where uid = '.$userId.' and rid = '.$rid;
                $upRes = DB::query($updateCon);
            }
            return $upRes;
        } else {
            return array();
        }
    }

    /**
     * replace score text
     * @param $num
     * @param $type
     * @return mixed
     */
    public function getScoreText($num, $type)
    {
        $typeNaeme = '';
        switch ($type) {
            case 1:
                $typeNaeme = '金钱';
                break;
            case 2:
                $typeNaeme = '贡献';
                break;
            case 3:
                $typeNaeme = '威望';
                break;
            default:
                break;
        }
        $scoreText = $this->_config['score_text'];
        $scoreText = str_replace('{#num#}', $num, $scoreText);
        $scoreText = str_replace('{#type#}', $typeNaeme, $scoreText);
        return $scoreText;

    }

    /**
     * get award backgroud-pic
     * @return string
     */
    public function getAwardPic()
    {
        $picArr = explode(PHP_EOL, $this->_config['score_pic']);
        $picUrlArr = explode(PHP_EOL, $this->_config['pic_url']);
        $randPic = '';
        $randUrl = '';
        if (!empty($picArr)) {
            $randKey = array_rand($picArr, 1);
            $randPic = $picArr[$randKey];

            if (isset($picUrlArr[$randKey])) {
                $httpPos = strpos($picUrlArr[$randKey], 'http');
                if ($httpPos == 0) {
                    $randUrl = $picUrlArr[$randKey];
                }

            }
        }
        return array('pic'=>$randPic,'url'=>$randUrl);
    }

    /**
     * get award
     */
    public function getAward()
    {
        $awardInfo = array(
            'status' => 1,
            'data' => array(),
        );
        $rateConfig = $this->_config['rate'];
        $dayMaxConfig = $this->_config['day_max'];
        $eventMaxConfig = $this->_config['event_max'];
        $scoreMaxConfig = $this->_config['score_max'];
        $itemScoreConfig = $this->_config['item_score'];
        $scoreType = $this->_config['score_type'];
        $timeIntervalConfig = intval($this->_config['interval']);

        $rand = mt_rand(0, 100)/100;
        if (!empty($rateConfig) && $rand < $rateConfig)
        {
            $userInfo = $this->getUserInfo($this->_userId, $this->_eventId);

            if ($userInfo['status'] == 0) {
                $remainScore = 0;
                $totalScore = 0;
                $dayNum = 0;
                $totalNum = 0;
                $lastTime = '';
                //insert user info if not exists
                if (empty($userInfo['data'])) {
                    $this->insertUser($this->_userId, $this->_eventId, $this->_userName);
                } else {
                    $remainScore = $userInfo['data'][0]['remain_score'];
                    $totalScore = $userInfo['data'][0]['total_score'];
                    $dayNum = $userInfo['data'][0]['day_num'];
                    $totalNum = $userInfo['data'][0]['total_num'];
                    $lastTime = $userInfo['data'][0]['last_time'];

                    $intvalTime = time() - strtotime($lastTime);
                    if ($timeIntervalConfig > 0 && $intvalTime < $timeIntervalConfig * 60) {
                        $awardInfo['status'] = 4;
                        return $awardInfo;
                    }
                }
                $currentDate = date('Y-m-d');
                $lastDate = date('Y-m-d', strtotime($lastTime));
                if ($currentDate != $lastDate) {
                    $dayNum = 0;
                }

                //check day max ..
                $totalScoreCheck = ($scoreMaxConfig == 0 || $totalScore < $scoreMaxConfig) ? true : false;
                $totalNumCheck = ($eventMaxConfig == 0 || $totalNum < $eventMaxConfig) ? true : false;
                $dayNumCheck = ($dayMaxConfig == 0 || $dayNum < $dayMaxConfig) ? true : false;
                if ($totalScoreCheck && $totalNumCheck && $dayNumCheck) {
                    //get item score
                    $itemScore = $this->_getItemScore($itemScoreConfig);
                    //todo if itemscore is 0
                    //update user info
                    $upUserData = array(
                        'remain_score' => $remainScore+$itemScore,
                        'total_score' => $totalScore+$itemScore,
                        'last_time' => date('Y-m-d H:i:s'),
                        'day_num' => $dayNum+1,
                        'total_num' => $totalNum+1,
                    );
                    $this->updateUserInfo($this->_eventId, $this->_userId, $upUserData);
                    //add score
                    $upRes = $this->updateUserCredits($this->_userId, $scoreType, $itemScore);

                    if (!empty($upRes)) {
                        //add log
                        $logData = array(
                            'event_id' => $this->_eventId,
                            'user_id' => $this->_userId,
                            'user_name' => $this->_userName,
                            'score_type' => $scoreType,
                            'score' => $itemScore,
                            'source' => 0, //todo 0 pc 1 mobile
                        );
                        $this->insertLog($logData);
                        //add rule log
                        $this->upCreditsRuleLog($this->_userId, $scoreType, $itemScore);

                        $awardInfo['status'] = 0;
                        $awardInfo['data'] = array(
                            'itemScore' => $itemScore,
                            'scoreType' => $scoreType,
                            'scoreText' => $this->getScoreText($itemScore, $scoreType),
                            'scorepic' => $this->getAwardPic(),
                            'shareText' => $this->_config['share_text'],
                        );
                    } else {
                        $awardInfo['status'] = 3;
                    }
                } else {
                    $awardInfo['status'] = 2;
                }

            }
        }
        return $awardInfo;
    }


    public function checkEventStatus()
    {
        $status = $this->_config['status'];
        return $status;
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

    public function checkForums($fid)
    {
        $checkForumsRes = false;
        $forumsConfig = $this->_config['board_lists'];
        $forumsConfig = unserialize($forumsConfig);
//        var_dump($forumsConfig);
        if (!empty($forumsConfig)) {
            if ($fid && in_array($fid, $forumsConfig)) {
                $checkForumsRes = true;
            }
        } else {
            $checkForumsRes = true;
        }
        return $checkForumsRes;
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

    /**
     * get item score
     * @param $scoreConfig
     * @return int
     */
    private function _getItemScore($scoreConfig)
    {
        $itemScore = 0;
        if (empty($scoreConfig)) {
            return $itemScore;
        }
        if (strpos($scoreConfig, '-')) {
            $configArr = explode('-', $scoreConfig);
            $count = count($configArr);
            if ($count == 2 && intval($configArr[1]) > $configArr[0]) {
                $itemScore = mt_rand($configArr[0], $configArr[1]);
            }
        } elseif (strpos($scoreConfig, ',')) {
            $configArr = explode(',', $scoreConfig);
            $randKey = array_rand($configArr, 1);
            $itemScore = intval($configArr[$randKey]);
        } else {
            $itemScore = intval($scoreConfig);
        }
        return $itemScore;

    }

    public function __get($name)
    {

        return $this->$name;
    }
}