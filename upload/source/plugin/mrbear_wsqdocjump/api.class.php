<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: install.php 34718 2014-07-14 08:56:39Z nemohou $
 */

if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class mrbear_wsqdocjump_api
{

    function forumdisplay_sideBar()
    {
        return '[forumdisplay_sideBar]';
    }

	function viewthread_sideBar()
    {

        $randUrl = $this->getRandArticel();
        return '<a href="'.$randUrl.'" style="background-color:#FFF;color:#FFA500;-webkit-border-radius:1px;display:block;
        font-size:16px;height:25px;line-height:25px;white-space:normal;text-overflow:ellipsis;overflow:hidden;text-decoration:none;">['.lang('plugin/mrbear_wsqdocjump', 'rand').']</a>';
	}


	function viewthread_threadBottom()
    {


        $adjoinArticle = $this->getAdjoinArticle();

        $domStruct = '<a href="{url}"
        style="background-color:#FFF;color:#575757;-webkit-border-radius:1px;display:block;
        font-size:16px;height:25px;line-height:25px;white-space:normal;padding:0 11px;text-overflow:ellipsis;overflow:hidden;text-decoration:none;">{title}</a>';
        $adjoinArticleDom = '';
        if (!empty($adjoinArticle)) {
            if (isset($adjoinArticle['pre'])) {
                $preTitle = lang('plugin/mrbear_wsqdocjump', 'pre').':'.$adjoinArticle['pre']['subject'];
                $preUrl = $this->getUrl($adjoinArticle['pre']['tid']);
                $adjoinArticleDom .= str_replace('{title}', $preTitle, str_replace('{url}', $preUrl, $domStruct));
            }

            if (isset($adjoinArticle['next'])) {
                $nextTitle = lang('plugin/mrbear_wsqdocjump', 'next').':'.$adjoinArticle['next']['subject'];
                $nextUrl = $this->getUrl($adjoinArticle['next']['tid']);
                $adjoinArticleDom .= str_replace('{title}', $nextTitle, str_replace('{url}', $nextUrl, $domStruct));
            }
        }
        $adjoinArticleDom = '<div  style="display:block;border-top:1px solid #d8d8d8;border-bottom:1px solid #d8d8d8">'.$adjoinArticleDom.'';

        global $_G;
        $positionImg = $_G['siteurl'].'./source/plugin/mrbear_wsqdocjump/rand1.jpg';
        $randUrl = $this->getRandArticel();

        $randDom = '<a href="'.$randUrl.'" style="background-color:#FFF;color:#FFA500;-webkit-border-radius:1px;display:block;
        font-size:16px;height:25px;line-height:25px;white-space:normal;padding:0 11px;text-overflow:ellipsis;overflow:hidden;text-decoration:none;">·'.lang('plugin/mrbear_wsqdocjump', 'randDetail').'</a>';

        $adjoinArticleDom .= $randDom.'</div>';
        return $adjoinArticleDom;
	}


    function pluginIconv($inData)
    {
        global $_G;
        $charset = $_G['charset'];
        $outData = $inData;
        if ('UTF-8' != $charset) {
            $outData = diconv($inData, $charset, 'UTF-8');
        }
        return $outData;
    }

    function getAdjoinArticle()
    {
        global $_G;
        $tid = $_G['forum_thread']['tid'];
        $fid = $_G['forum_thread']['fid'];
        $lastPost = $_G['forum_thread']['lastpost'];
        $lastPostTime = strtotime($lastPost);

        $adjoinArticle = array();
        //pre
        $queryPreCon = 'SELECT * FROM '.DB::table('forum_thread').' WHERE fid='.$fid.' and closed=0 and displayorder>=0 and lastpost>'.$lastPostTime.' and tid <> '.$tid.' having lastpost =  min(lastpost) order by lastpost desc LIMIT 1';

        $preThreadInfo = DB::fetch_all($queryPreCon);

        if (!empty($preThreadInfo)) {
            $preTid = $preThreadInfo[0]['tid'];
            $preSubject = $this->pluginIconv($preThreadInfo[0]['subject']);
            $adjoinArticle['pre'] = array('tid'=>$preTid,'subject'=>$preSubject);
        }

        //next
        $querynextCon = 'SELECT * FROM '.DB::table('forum_thread').' WHERE fid='.$fid.' and closed=0
         and displayorder>=0 and lastpost<'.$lastPostTime.' and tid <> '.$tid.' order by lastpost desc LIMIT 1';
        $nextThreadInfo = DB::fetch_all($querynextCon);
        if (!empty($nextThreadInfo)) {
            $nextTid = $nextThreadInfo[0]['tid'];
            $nextSubject = $this->pluginIconv($nextThreadInfo[0]['subject']);
            $adjoinArticle['next'] = array('tid'=>$nextTid,'subject'=>$nextSubject);
        }
        return $adjoinArticle;

    }


    function getRandArticel()
    {
        $queryCon = 'SELECT * FROM '.DB::table('forum_thread').' where  closed = 0
        and displayorder >= 0 order by rand() limit 1';
        $randArticle = DB::fetch_all($queryCon);
        $randUrl = '';
        if(!empty($randArticle)){
            $tid = $randArticle[0]['tid'];
            $fid = $randArticle[0]['fid'];
            $randUrl = $this->getUrl($tid);
        }
        return $randUrl;
    }

    function getUrl($tid)
    {
        $wsqUrl = 'http://wsq.discuz.qq.com?';
        $params = array(
            'c' => 'index',
            'a' => 'viewthread',
            'siteid' => 0,
            'f' => 'wx',
            '_bpage' => 1,
            'tid' => $tid,
        );
        global $_G;
        $setting = unserialize($_G['setting']['mobilewechat']);
        $siteId = $setting['wsq_siteid'];
        $params['siteid'] = $siteId;
        return $wsqUrl.http_build_query($params);
    }
}

?>
