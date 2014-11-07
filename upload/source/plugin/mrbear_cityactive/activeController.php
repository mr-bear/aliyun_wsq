<?php
/**
 * Created by PhpStorm.
 * User: xiongfei
 * Date: 14-11-6
 * Time: 下午2:26
 */
class active{

    private $_activeTypeList = array(
        '10' => array('1001', '1002', '1003', '1004'),
        '11' => array('1101', '1102', '1103', '1104', '1105'),
        '12' => array(),
        '13' => array(),
        '14' => array('1401', '1402', '1403', '1404', '1405', '1406', '1407'),
        '15' => array(),
        '16' => array(),
        '17' => array(),
        '18' => array('1801', '1802', '1803'),
        '99' => array(),
    );

    private $_repeatTypeList = array(0, 1, 2, 3); //0 same day 1 several days 2 every week 3 user-defined


    private $_necessaryParams = array('type', 'title', 'repeat_type', 'begin_date', 'begin_time', 'end_date', 'end_time', 'repeat_time', 'coordinate', 'loc_id', 'city', 'street_address', 'desc', 'fee', 'fee_detail', 'tags', 'files');

    private $_targetHeight = 260;
    private $_targetWidth = 175;
    private $_uid;
    private $_uname;
    public $targetRoot;

    public function __construct()
    {
        global $_G;
        $this->_uid = $_G['uid'];
        $this->_uname = $_G['username'];
    }


    public function saveActive($postData)
    {
        $response = array(
            'status' => 0,
            'activeId' => 0,
            'msg' => '',
        );
//        var_dump($postData);
        $inParams = array_keys($postData);
        $checkParms = $this->_checkNecessaryParams($inParams);
        if ($checkParms) {
            $type = intval($postData['type']);
            $subType = (isset($postData['subtype'])) ? intval($postData['subtype']) : 0;
            $title = trim($postData['title']);
            $repeatType = intval($postData['repeat_type']);
            $beginTime = date('Y-m-d H:i:s', strtotime($postData['begin_date'].' '.$postData['begin_time']));
            $endTime = date('Y-m-d H:i:s', strtotime($postData['end_date'].' '.$postData['end_time']));
            $repeatTime = $postData['repeat_time'];
            $coordinateArr = explode(',', $postData['coordinate']);
            $loc_id = intval($postData['loc_id']);
            $city = trim($postData['city']);
            $address = trim($postData['street_address']); //todo length
            $desc = trim($postData['desc']);
            $fee = intval($postData['fee']);
            $feeDetail = $postData['fee_detail'];
            $tags = trim($postData['tags']);
            $files = trim($postData['files']);

            $checkActiveType = $this->_checkActiveType($type, $subType);
            $checkRepeatType = $this->_checkRepeatType($repeatType);
            //check
            if ($this->_uid == 0
                || $this->_uname == ''
                || strlen($title) > 90
                || $title == ''
                || !$checkActiveType
                || !$checkRepeatType
                || count($coordinateArr) != 2
                || !$loc_id
                || $city == ''
                || $desc == ''
                || strlen($desc) > 12000
                || !in_array($fee, array(0, 1))
                || $files == ''
                || strlen($tags) > 90
            ) {
                $response['msg'] = '请正确填写各项内容';
                return $response;
            }

            //save image and get root
            $filesArr = explode(',', $files);
            $filesCount = count($filesArr);
            $imgLists = array();
            if ($filesCount && ($filesCount % 2 == 0)) {
                for ($i=0; $i<$filesCount; $i+=2) {
                    if ($filesArr[$i] == 'data:image/jpeg;base64') {
                        $itemFile = $filesArr[$i].','.$filesArr[$i+1];
                        $itemFileRes = $this->saveImage($itemFile);
                        if ($itemFileRes['status']) {
                            $imgLists[] = $itemFileRes['data'];
                        }
                    }

                }

            } else {
                $response['msg'] = '请正确上传图片';
                return $response;
            }

            if (empty($imgLists) || count($imgLists) > 3) {
                //del image
                $this->delImage($this->targetRoot, $imgLists);
                $response['msg'] = '请正确上传图片';
                return $response;
            }
//            var_dump($imgLists);

            //save data into db
            $saveData = array(
                'uid' => $this->_uid,
                'uname' => $this->_uname,
                'type' => $type,
                'subtype' => $subType,
                'title' => $title,
                'repeat_type' => $repeatType,
                'begin_time' => $beginTime,
                'end_time' => $endTime,
                'repeat_time' => $repeatTime,
                'coordinate' => $postData['coordinate'],
                'loc_id' => $loc_id,
                'city' => $city,
                'street_address' => $address,
                'desc' => $desc,
                'fee' => $fee,
                'fee_detail' => $feeDetail,
                'tags' => $tags,
            );
            $saveDataRes = $this->_insertActive($saveData);
            if ($saveDataRes) {
                //save img
                $position = 1;
                foreach ($imgLists as $itemImg) {
                    $saveImgData = array(
                        'uid' => $this->_uid,
                        'uname' => $this->_uname,
                        'event_id' => $saveDataRes,
                        'img_root' => $itemImg,
                        'position' => $position,
                    );
                    $this->_insertImage($saveImgData);
                    $position++;
                }
                $response['status'] = 1;
                $response['activeId'] = $saveDataRes;
                return $response;
            } else {
                $this->delImage($this->targetRoot, $imgLists);
                $response['msg'] = '提交失败,请稍后重试';
                return $response;
            }

        } else {
            $response['msg'] = '提交失败,请稍后重试';
            return $response;
        }
    }

    /**
     * save image/zoom image
     * @param $imgData
     * @return array
     */
    public function saveImage($imgData)
    {
        $response = array(
            'status' => 0,
            'data' => ''
        );

//        $imgInfo = getimagesize("data:image/jpeg;base64," . $imgData);
        $imgInfo = getimagesize($imgData);

        if ($imgInfo) {
            $width = $imgInfo[0];
            $height = $imgInfo[1];
            $mime = $imgInfo['mime'];
            $imgstr = preg_replace('/data:image\/jpeg;base64,/', '', $imgData);
            $imgName = time().'.jpg';
            $file = $this->targetRoot.'u'.$this->_uid.'/';
            $imgRoot = $file.$imgName;

            if ($mime != 'image/jpeg') {
                return $response;
            }

            if (!file_exists($file) || !filesize($file)) {
                dmkdir($file);
            }

            if (1==2 && function_exists('imagecreatefromstring') && function_exists('imagecreatetruecolor') && function_exists('imagecopy') && function_exists('imagecreatetruecolor') && function_exists('imagecopyresampled') && function_exists('imagejpeg') && function_exists('imagedestroy')) {
                $dstScale = $this->_targetHeight/$this->_targetWidth; //目标图像长宽比
                $srcScale = $height/$width; // 原图长宽比

                if ($srcScale >= $dstScale) {
                    // 过高
                    $w = intval($width);
                    $h = intval($dstScale*$w);
                    $x = 0;
                    $y = ($height - $h)/3;
                } else {
                    // 过宽
                    $h = intval($height);
                    $w = intval($h/$dstScale);
                    $x = ($width - $w)/2;
                    $y = 0;
                }
                // 剪裁
                $source = imagecreatefromstring(base64_decode($imgstr));
                $croped = imagecreatetruecolor($w, $h);
                imagecopy($croped, $source, 0, 0, $x, $y, $width, $height);
                // 缩放
                $scale = $this->_targetWidth/$w;
                $target = imagecreatetruecolor($this->_targetWidth, $this->_targetHeight);
                $final_w = intval($w*$scale);
                $final_h = intval($h*$scale);
                imagecopyresampled($target, $croped, 0, 0, 0, 0, $final_w, $final_h, $w, $h);

                imagejpeg($target, $imgRoot, 100);
                imagedestroy($target);
                if (file_exists($imgRoot)) {
                    $response['status'] = 1;
                    $response['data'] = 'u'.$this->_uid.'/'.$imgName;
                }

            } else {
                file_put_contents($imgRoot, base64_decode($imgstr));
                if (file_exists($imgRoot)) {
                    $response['status'] = 1;
                    $response['data'] = 'u'.$this->_uid.'/'.$imgName;
                }

            }
        }

        return $response;
    }

    /**
     * @param $imgRoot
     * @param array $imgData
     * @return bool
     */
    public function delImage($imgRoot, $imgData = array())
    {
        if (!is_array($imgData) || empty($imgData)) {
            return false;
        }

        foreach ($imgData as $itemImg) {
            if (file_exists($imgRoot.$itemImg)) {
                unlink($imgRoot.$itemImg);
            }
        }
        return true;
    }

    /**
     * check the legality of in params
     * @param array $inParams
     * @return bool
     */
    private function _checkNecessaryParams($inParams = array())
    {
        $diffArr = array_diff($this->_necessaryParams, $inParams);
        if (!empty($diffArr)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * check the legality of the type of Activities
     * @param $type
     * @param $subType
     * @return bool
     */
    private function _checkActiveType($type, $subType)
    {
        if (!isset($this->_activeTypeList[$type])) {
            return false;
        } else {
            $subList = $this->_activeTypeList[$type];
            if (!empty($subList) && !in_array($subType, $subList)) {
                return false;
            }
        }
        return true;

    }

    /**
     * check the legality of the repeat type
     * @param $type
     * @return bool
     */
    private function _checkRepeatType($type)
    {
        if (in_array($type, $this->_repeatTypeList)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * creat a new event
     * @param $data
     * @return int
     */
    private function _insertActive($data)
    {
        $insertData = array(
            'uid' => $data['uid'],
            'uname' => $data['uname'],
            'type' => $data['type'],
            'subtype' => $data['subtype'],
            'title' => $data['title'],
            'repeat_type' => $data['repeat_type'],
            'begin_time' => $data['begin_time'],
            'end_time' => $data['end_time'],
            'repeat_time' => $data['repeat_time'],
            'coordinate' => $data['coordinate'],
            'loc_id' => $data['loc_id'],
            'city' => $data['city'],
            'street_address' => $data['street_address'],
            'desc' => $data['desc'],
            'fee' => $data['fee'],
            'fee_detail' => $data['fee_detail'],
            'tags' => $data['tags'],
            'add_time' => date('Y-m-d H:i:s'),
        );
        return DB::insert('mrbear_cityactive_event', $insertData, true);
    }

    /**
     * insert image data into db
     * @param $data
     * @return int
     */
    private function _insertImage($data)
    {
        $insertData = array(
            'uid' => $data['uid'],
            'uname' => $data['uname'],
            'event_id' => $data['event_id'],
            'img_root' => $data['img_root'],
            'position' => $data['position'],
            'add_time' => date('Y-m-d H:i:s'),
        );

        return DB::insert('mrbear_cityactive_image', $insertData, true);
    }
}