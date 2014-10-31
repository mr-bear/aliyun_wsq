<?php
/**
 * Created by PhpStorm.
 * User: xiongfei
 * Date: 14-10-31
 * Time: 下午3:16
 */
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class mobileplugin_mrbear_award{


}

class mobileplugin_mrbear_award_forum extends mobileplugin_mrbear_award{


    function viewthread_mobile_award(){
        $awardInfo = $this->award();
        echo $awardInfo;

    }


    public function award()
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
                    background:url(source/plugin/mrbear_award/template/mobile_jf.jpg) no-repeat;
                    width:210px;
                    height:226px;
                    position:absolute;
                    top:50%;
                    left:50%;
                    z-index:4;
                    text-align:center;
                    margin:-113px 0 0 -105px;
                    display: none;

                }
            </style>
            <div class="jinhua">
                <a href="javascript:;" target="_blank"><img src="" width="210px" height="140px"/></a>
                <p style="height:10px;font-family:inherit;margin:10px 0px 10px 0px;font-size:10px;"></p>
                <div class="bdsharebuttonbox" style="left:50%;margin-left:-80px;position:absolute;">
                  <a href="#" class="bds_more" data-cmd="more"></a>
                  <a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a>
                  <a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a>
                  <a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a>
                  <a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a>
                  <a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a>
                </div>
                <a  href="javascript:;" onclick="closejf();" style="display:block;width:110px;height:52px;margin:0 auto;"></a>
            </div>

            <script src="http://imgs.xici.net/_js/jquery-1.7.2.min.js"></script>

            <script>
                var mba = jQuery.noConflict();
                var defaultImg = "http://gtms04.alicdn.com/tps/i4/TB1CufqGFXXXXb3XFXXXK5zTVXX-520-280.png";
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
                        "bdSize":"10"},
                    "share":{},
                    "image":{
                        "viewList":["qzone","tsina","tqq","renren","weixin"],
                        "viewText":"分享到：","viewSize":"10"},
                        "selectShare":{
                            "bdContainerClass":null,
                            "bdSelectMiniList":["qzone","tsina","tqq","renren","weixin"]
                            }
                    };


                mba.ajax({
                    url: "http://121.199.30.154/wsq_t/upload/plugin.php?id=mrbear_award:award",
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
                            if (mba.trim(award.scorepic.pic) != \'\' && mba.trim(award.scorepic.pic) != "\'\'") {
                                mba(".jinhua img").attr("src",award.scorepic.pic);
                                sharePic = award.scorepic.pic;
                                if (mba.trim(award.scorepic.url) != \'\' && mba.trim(award.scorepic.url) != "\'\'") {
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
        return $awardPop;
    }
}
