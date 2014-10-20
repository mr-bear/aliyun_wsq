<?php

if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
global $_G;
//var_dump($_G);
$isHistory = (isset($_GET['h']) && $_GET['h'] == 1) ? true : false;

$rankTitle = ($isHistory) ? '历史排名' : '7天排名';

$currentTime = date('Y-m-d');
$unixTime = strtotime($currentTime);
$unixTime = $unixTime - (3600*24*7);
$rankTime = ($isHistory) ? '' : $unixTime;

$siteUrl = $_G['siteurl'];
$uid = $_G['uid'];
$uname = $_G['username'];

$sofaData = getSofaData($rankTime);

$dom = '';
if (!empty($sofaData)) {
    $domStruct = <<<EOF
    <dd _uid="9166708">
        <span class="rbCon wot db">
            <span class="rknums rknum{#rank#} br f11 c2 db">{#rank#}</span>

            <img src="{#uimg#}" class="rbImg brBig db">
            {#uname#}
        </span>
        <span class="rbNum db" style="display:inline">{#num#}</span>
    </dd>
EOF;
    $i = 1;
    foreach ($sofaData as $itemValue) {
        $authorId = $itemValue['authorid'];
        $author = $itemValue['author'];
        $historyCount = $itemValue['count'];
        $userImg = $siteUrl.'uc_server/avatar.php?uid='.$authorId.'&size=small';

        $itemDom = str_replace('{#rank#}', $i, $domStruct);
        $itemDom = str_replace('{#uname#}', $author, $itemDom);
        $itemDom = str_replace('{#uimg#}', $userImg, $itemDom);
        $itemDom = str_replace('{#num#}', $historyCount, $itemDom);
        $dom .= $itemDom;
        $i++;
    }
}

//origin data
function getSofaData($time = '')
{
    $historyCon = '';
    if ($time != '') {
        $historyCon = ' and dateline>='.$time;
    }
    $queryCon = 'SELECT authorid,author,count(1) count FROM '.DB::table('forum_post').' where position=2 '.$historyCon.' group by authorid order by count desc limit 10';

    $historySofaData = DB::fetch_all($queryCon);
    return $historySofaData;
}


?>
<html>
<!--    <link rel="stylesheet" href="http://dzqun.gtimg.cn/c/1413637796=/quan/style/style.css,/quan/style/profile.css" onload="g_ts.css_end = new Date();" onerror="g_ts.css_end = new Date();">-->
<link rel="stylesheet" href="http://121.199.30.154/wsq_t/upload/source/plugin/mrbear_wsqsofa/style.css"">
<script type="text/javascript" src="http://wsq.discuz.qq.com/cdn/discuz/js/openjs.js"></script>
<script>
    var menu = new Array();
    menu.push({name:"7天排名", pluginid:'mrbear_wsqsofa:view', param:""});
    menu.push({name:"历史排名", pluginid:'mrbear_wsqsofa:view', param:"h=1"});
    WSQ.initBtmBar(menu);
    WSQ.showBtmBar();
    WSQ.initPlugin({name:'1111'});

    var initWx = {
        'img': 'http://www.discuz.net/static/image/common/logo.png',
        'desc': 'initWxParam',
        'title': 'shareTitle',
        'pluginid':'wsq_demo:view',
        'param': 'a=1&b=2'
    };
    WSQ.initShareWx(initWx);
</script>

<body style="zoom: 1; padding-bottom: 55px;">
<div class="warp">
    <div class="rankBox">
        <dl>
            <dt class="pr">
<!--                还有10个帖子没有评论-->
<!--                <span style="background-color: #ffa903;display: inline-block;right: 50px">-->
<!--                    点我抢-->
<!--                </span>-->

                <span class="rbName f14 c9 db" style="width: 70%">还有10个帖子没有评论</span>
                <span style="background-color: #ffa903;display: inline-block;color: #fff;">
                    点我开抢喽！
                </span>

            </dt>
        </dl>
        <dl>
            <dt class="pr">
                <span class="honorBg brSmall pa">
                    <i class="iconRank db cf f10 c2"></i>
                </span>
                <span class="rbName f14 c9 db"><?php echo $rankTitle ?></span><span class="rbNum f14 c9 db" style="text-align:left;">沙发数</span>
            </dt>

            <?php echo $dom; ?>

        </dl>
    </div>
</div>

</body></html>

