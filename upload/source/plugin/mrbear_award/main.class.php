<?php
/**
 * Created by PhpStorm.
 * User: xiongfei
 * Date: 14-10-28
 * Time: 下午3:44
 */

class plugin_mrbear_award{

    function plugin_mrbear_award()
    {

    }
}

class plugin_mrbear_award_forum extends plugin_mrbear_award{

    public function viewthread_bottom()
    {
        global $_G;
        $awardPop = '
            <style>
                .jinhua
                {
                    background:url(source/plugin/mrbear_award/template/jf.jpg) no-repeat;
                    width:667px;
                    height:498px;
                    position:fixed;
                    top:50px;
                    left:50%;
                    z-index:4;
                    text-align:center;
                    margin-left:-333px;
                    display:none;
                }
            </style>
            <div class="jinhua">
                  <img src="" width="667px" height="400px"/>
             </div>

            <script type="text/javascript" src="http://mat1.gtimg.com/2014/index/jquery_1.5.2.js"></script>
            <script>
                $.ajax({
                    url: "http://121.199.30.154/wsq_t/upload/plugin.php?id=mrbear_award:award",
                    type: "GET",
                    dataType: "json",
                    data: "t=0",
                    success:function(data){
                        console.log(data);
                        if (0 == data.status) {
                            $(".jinhua").css("display","block");
                        }
                    }
                });

                function closejf(){
	                $(".jinhua").css("display","none");
                }

            </script>';
        return $awardPop;
    }
}


