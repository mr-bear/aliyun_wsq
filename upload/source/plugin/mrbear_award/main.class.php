<?php
/**
 * Created by PhpStorm.
 * User: xiongfei
 * Date: 14-10-28
 * Time: 下午3:44
 */
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
class plugin_mrbear_award{

    function plugin_mrbear_award()
    {

    }
}

class plugin_mrbear_award_forum extends plugin_mrbear_award{

    public function viewthread_bottom_output()
    {
        global $_G;
        $siteUrl = $_G['siteurl'];
        $tid = $_G['tid'];
        $fid = $_G['fid'];
        $uid = $_G['uid'];

        $awardPop = '
            <style>
                .jinhua
                {
                    background:url(source/plugin/mrbear_award/template/jf.jpg) no-repeat;
                    width:600px;
                    height:530px;
                    position:fixed;
                    top:100px;
                    left:50%;
                    z-index:4;
                    text-align:center;
                    margin-left:-300px;
                    display: none;

                }
            </style>
            <div class="jinhua">
                <a href="javascript:;" target="_blank"><img src="" width="600px" height="400px"/></a>
                <p style="height:10px;font-family:inherit;margin:10px 0px 10px 0px;font-size:16px;"></p>
                <div class="bdsharebuttonbox" style="margin-left:220px;">
                  <a href="#" class="bds_more" data-cmd="more"></a>
                  <a href="#" class="bds_qzone" data-cmd="qzone" title="'.lang('plugin/mrbear_award', 'shareQQTitle').'"></a>
                  <a href="#" class="bds_tsina" data-cmd="tsina" title="'.lang('plugin/mrbear_award', 'shareSinaTitle').'"></a>
                  <a href="#" class="bds_tqq" data-cmd="tqq" title="'.lang('plugin/mrbear_award', 'shareQQWTitle').'"></a>
                  <a href="#" class="bds_renren" data-cmd="renren" title="'.lang('plugin/mrbear_award', 'shareRRTitle').'"></a>
                  <a href="#" class="bds_weixin" data-cmd="weixin" title="'.lang('plugin/mrbear_award', 'shareWXTitle').'"></a>
                </div>
                <a  href="javascript:;" onclick="closejf();" style="display:block;width:110px;height:52px;margin:0 auto;"></a>
            </div>

            <script src="source/plugin/mrbear_award/template/jquery.js"></script>
            <script>
                var mba = jQuery.noConflict();
                var defaultImg = "source/plugin/mrbear_award/template/default.jpg";
                var shareText = "";
                var sharePic = "";
            </script>
            <script>
                window._bd_share_config={
                    "common":{
                        "bdSnsKey":{},
                        "bdText":"",
                        "bdMini":"2",
                        "bdMiniList":false,
                        "bdPic":"",
                        "bdStyle":"1",
                        "bdSize":"24"},
                    "share":{},
                    "image":{
                        "viewList":["qzone","tsina","tqq","renren","weixin"],
                        "viewText":"'.lang('plugin/mrbear_award', 'shareTitle').'：","viewSize":"24"},
                        "selectShare":{
                            "bdContainerClass":null,
                            "bdSelectMiniList":["qzone","tsina","tqq","renren","weixin"]
                            }
                    };


                mba.ajax({
                    url: "'.$siteUrl.'plugin.php?id=mrbear_award:award",
                    type: "GET",
                    dataType: "json",
                    cache: false,
                    data: {
                        "tid":'.$tid.',
                        "fid":'.$fid.',
                        "uid":'.$uid.'
                    },
                    success:function(data){
                        if (0 == data.status) {
                            var award = data.data;
                            shareText = award.shareText;
                            mba(".jinhua img").attr("src",defaultImg);
                            if (trim(award.scorepic.pic) != \'\' && trim(award.scorepic.pic) != "\'\'") {
                                mba(".jinhua img").attr("src",award.scorepic.pic);
                                sharePic = award.scorepic.pic;
                                if (trim(award.scorepic.url) != \'\' && trim(award.scorepic.url) != "\'\'") {
                                    mba(".jinhua a:first").attr("href",award.scorepic.url);
                                }

                            }
                            mba(".jinhua p").text(award.scoreText);

                            window._bd_share_config.common.bdText = shareText;
                            window._bd_share_config.common.bdPic = sharePic;
                             with(document)0[(getElementsByTagName(\'head\')[0]||body).appendChild(createElement(\'script\')).src=\'http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion=\'+~(-new Date()/36e5)];

                            mba(".jinhua").css("display","block");
                        }
                    }
                });

                function closejf(){
	                mba(".jinhua").css("display","none");
                }

            </script>';
//        echo $awardPop;
        return $awardPop;
    }
}


