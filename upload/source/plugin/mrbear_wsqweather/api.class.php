<?php
/**
 * Created by PhpStorm.
 * User: xiongfei
 * Date: 14-10-23
 * Time: 上午9:50
 */

if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

require_once DISCUZ_ROOT.'./source/plugin/wechat/wechat.lib.class.php';
require_once DISCUZ_ROOT.'./source/function/function_misc.php';

class mrbear_wsqweather_api
{
    private $_localCityIdUrl = 'http://61.4.185.48:81/g/';
    private $_weatherUrl = 'http://m.weather.com.cn/atad/';


    public function forumdisplay_topBar()
    {
        global $_G;

        $test = @file_get_contents("http://toy1.weather.com.cn/search?cityname=nanjing&callback=success_jsonpCallback&_=1414046172686");

        $clientIp = $_G['clientip'];
        $localCityData = $this->getIpLookup($clientIp);
//        $location = convertip($_G['clientip']);
//        list(,$city) = explode('-',$location);
//
        $cityId= 0;
        $weatherData = $this->getWeather($cityId);

        $return = array();
        $return[] = array(
            'name' => '实时天气',
            'html' => json_encode($test),
            'more' => WeChatHook::getPluginUrl('mrbear_wsqweather:view', array()),
        );
        return $return;
    }

    public function getWeather($cityId)
    {
        $suffix = $cityId.'.html';
        $weatherUrl = $this->_weatherUrl.$suffix;
        $curlWeather = WeChatClient::get($weatherUrl);
        return $curlWeather;
    }

    public function getIpLookup($ip = '')
    {
        //http://ip.taobao.com/service/getIpInfo.php?ip=218.94.7.115
        //101190101
        $res = @file_get_contents('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=' . $ip);
        if (empty($res)) {
            return false;
        }
        $jsonMatches = array();
        preg_match('#\{.+?\}#', $res, $jsonMatches);
        if (!isset($jsonMatches[0])) {
            return false;
        }
        $json = json_decode($jsonMatches[0], true);
        if (isset($json['ret']) && $json['ret'] == 1) {
            $json['ip'] = $ip;
            return $json;
        } else {
            return false;
        }
    }
}