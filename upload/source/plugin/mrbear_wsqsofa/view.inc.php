<?php

if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
global $_G;
//var_dump($_G);
$isHistory = (isset($_GET['h']) && $_GET['h'] == 1) ? true : false;

//init
$historyRankTitle = lang('plugin/mrbear_wsqsofa', 'historyRankTitle');
$sevenRankTitle = lang('plugin/mrbear_wsqsofa', 'sevenRankTitle');
$rankTitle = ($isHistory) ? $historyRankTitle : $sevenRankTitle;
$myRankTitle = ($isHistory) ? lang('plugin/mrbear_wsqsofa', 'myHisRankTitle') : lang('plugin/mrbear_wsqsofa', 'mySevRankTitle');
$rankUrlTitle = lang('plugin/mrbear_wsqsofa', 'pluginTitle');
$sofaCounTitle = lang('plugin/mrbear_wsqsofa', 'ranCount');
$myCountTitle = lang('plugin/mrbear_wsqsofa', 'mySofa');
$noRank = lang('plugin/mrbear_wsqsofa', 'noRank');

$myRank = 0;
$mySofaCount = 0;

$currentDate = date('Y-m-d');
$unixTime = strtotime($currentDate);
$unixTime = $unixTime - (3600*24*6);
$rankTime = ($isHistory) ? '' : $unixTime;

$siteUrl = $_G['siteurl'];
$uid = $_G['uid'];
$uname = $_G['username'];
//init end

//get rankData
$sofaData = getSofaData($rankTime);

$dom = '';
if (!empty($sofaData)) {
    $domStruct = <<<EOF
    <dd {#myStyle#}>
        <span class="rbCon wot db">
            <span class="rknums rknum{#rank#} br f11 c2 db">{#rank#}</span>

            <a href="{#userurl#}" target="_blank"><img src="{#uimg#}" class="rbImg brBig db">
            {#uname#}
            </a>
        </span>
        <span class="rbNum db" style="display:inline">{#num#}</span>
    </dd>
EOF;
    $i = 1;
    foreach ($sofaData as $itemValue) {
        $authorId = $itemValue['authorid'];
        $author = pluginIconv($itemValue['author']);
        $historyCount = $itemValue['count'];

        if ($i <= 10) {
            $userImg = $siteUrl.'uc_server/avatar.php?uid='.$authorId.'&size=small';
            $userUrl = getUserUrl($authorId);
            $itemDom = str_replace('{#rank#}', $i, $domStruct);
            $itemDom = str_replace('{#uname#}', $author, $itemDom);
            $itemDom = str_replace('{#uimg#}', $userImg, $itemDom);
            $itemDom = str_replace('{#num#}', $historyCount, $itemDom);
            $itemDom = str_replace('{#userurl#}', $userUrl, $itemDom);

            if ($authorId == $uid) {
                $itemDom = str_replace('{#myStyle#}', 'style="background-color:#e5e5e5"', $itemDom);
            } else {
                $itemDom = str_replace('{#myStyle#}', '', $itemDom);
            }
            $dom .= $itemDom;
        }
        if ($authorId == $uid) {
            $myRank = $i;
            $mySofaCount = $itemValue['count'];
        }
        $i++;
    }
}

//header
$threadCount = 0;
$threadCountData = getThreadCount();
if (!empty($threadCountData)) {
    $threadCount = $threadCountData[0]['count'];
}

$randTid = 0;
$noPostData = getNoPost();
$noPostCount = 0;
if (!empty($noPostData)) {
    $noPostCount = count($noPostData);
    $ranKey = rand(0, $noPostCount-1);
    $randTid = $noPostData[$ranKey]['tid'];
}
$randUrl = getUrl($randTid);

$headTitle = lang('plugin/mrbear_wsqsofa', 'title').':'.$threadCount.lang('plugin/mrbear_wsqsofa', 'noRepTitle').':'.$noPostCount;


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

function getUserUrl($uid)
{
    $wsqUrl = 'http://wsq.discuz.qq.com?';
    $params = array(
        'c' => 'index',
        'a' => 'profile',
        'siteid' => 0,
        'f' => 'wx',
        'uid' => $uid,
    );
    global $_G;
    $setting = unserialize($_G['setting']['mobilewechat']);
    $siteId = $setting['wsq_siteid'];
    $params['siteid'] = $siteId;
    return $wsqUrl.http_build_query($params);
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

function getSofaData($time = '')
{
    $historyCon = '';
    if ($time != '') {
        $historyCon = ' and dateline>='.$time;
    }
    $queryCon = 'SELECT authorid,author,count(1) count FROM '.DB::table('forum_post').' where position=2 '.$historyCon.' group by authorid order by count desc';

    $historySofaData = DB::fetch_all($queryCon);
    return $historySofaData;
}

function getThreadCount()
{
    $queryCon = 'SELECT count(1) count FROM '.DB::table('forum_thread');
    $threadCount = DB::fetch_all($queryCon);
    return $threadCount;

}

function getNoPost()
{
    $queryCon = 'SELECT tid,count(1) count FROM '.DB::table('forum_post').' group by tid having count=1';
    $noPostData = DB::fetch_all($queryCon);
    return $noPostData;
}


?>
<html>
<link rel="stylesheet" href="<?php echo $siteUrl.'/source/plugin/mrbear_wsqsofa/style.css'?>">
<script type="text/javascript" src="http://wsq.discuz.qq.com/cdn/discuz/js/openjs.js"></script>
<script>
    var menu = new Array();
    menu.push({name:"<?php echo $sevenRankTitle;?>", pluginid:'mrbear_wsqsofa:view', param:""});
    menu.push({name:"<?php echo $historyRankTitle;?>", pluginid:'mrbear_wsqsofa:view', param:"h=1"});
    WSQ.initBtmBar(menu);
    WSQ.showBtmBar();
    WSQ.initPlugin({name:"<?php echo $headTitle;?>"});

    var initWx = {
        'img': 'http://www.discuz.net/static/image/common/logo.png',
        'desc': 'initWxParam',
        'title': 'shareTitle',
        'pluginid':'mrbear_wsqsofa:view',
        'param': ''
    };
    WSQ.initShareWx(initWx);
</script>

<body style="zoom: 1; padding-bottom: 55px;height: 100%;">
<div class="warp">
    <div class="rankBox">
        <dl>
            <dt class="pr">
                <span class="rbName f14 c9 db" style="width: 83%">
                    <?php echo $myCountTitle;?>:
                    <em style="color:#ff6035;font-size:20;margin-right: 10px"><?php echo $mySofaCount;?></em>

                    <?php if ($myRank) { ?>
                        <?php echo $rankTitle;?>:
                        <em style="color:#ff6035;font-size:20;"><?php echo $myRank;?></em>
                    <?php } else { ?>
                        <?php echo $noRank; ?>
                    <?php } ?>
                </span>

                <span style="background-color: #ffa903;display: inline-block;color: #fff;">
                    <a href="<?php if($randTid){echo $randUrl;}else{echo 'javascript:;';} ?>" target="_blank" style="color: #fff;">
                        <?php echo $rankUrlTitle;?>
                    </a>
                </span>

            </dt>
        </dl>
        <dl>
            <dt class="pr">
                <span class="honorBg brSmall pa">
                    <i class="iconRank db cf f10 c2"></i>
                </span>
                <span class="rbName f14 c9 db">
                    <?php echo $rankTitle ?></span><span class="rbNum f14 c9 db" style="text-align:left;"><?php echo $sofaCounTitle;?>
                </span>
            </dt>

            <?php echo $dom; ?>

        </dl>
    </div>
</div>

</body></html>

