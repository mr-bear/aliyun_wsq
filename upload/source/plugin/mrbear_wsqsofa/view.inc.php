<?php

if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

?>
<script type="text/javascript" src="http://wsq.discuz.qq.com/cdn/discuz/js/openjs.js"></script>
<script>
    var menu = new Array();
    menu.push({name:"menu1", pluginid:'wsq_demo:view', param:"a=1&b=2"});
    menu.push({name:"menu2", pluginid:'wsq_demo:view', param:"a=3&b=4"});
    WSQ.initBtmBar(menu);
    WSQ.showBtmBar();
    WSQ.initPlugin({name:''});

    var initWx = {
        'img': 'http://www.discuz.net/static/image/common/logo.png',
        'desc': 'initWxParam',
        'title': 'shareTitle',
        'pluginid':'wsq_demo:view',
        'param': 'a=1&b=2'
    };
    WSQ.initShareWx(initWx);
</script>
<style type="text/css">
    div {display: block;}
    .mod-lists {margin: 0px 10px 0 0px;background: #fafafa;}
    .hd {margin-bottom: 0;display: -webkit-box;}
    .hd h2 {-webkit-box-flex: 1;margin: 0;padding: 0;font-size: 18px;}
    .bars {display: -webkit-box;}
    .on {color: #299DE7;background: url("http://mu5.bdstatic.com/st/img/app/home/24/tab_indicator.png") bottom center no-repeat;background-size: 19px 10px;padding: 18px 0 12px 0;font-size: 16px;-webkit-box-flex: 1;text-align: center;position: relative;z-index: 2;}
    i {font-style: normal;}
    .gap-line {position: absolute;right: 0;top: 20px;height: 18px;width: 1px;border-left: 1px solid #eee}
    .bar {padding: 18px 0 12px 0;font-size: 16px;-webkit-box-flex: 1;text-align: center;color: #999;position: relative;z-index: 2;}



</style>
</head>
<body>

<div class="mod-lists ">
    <div class="hd" >
        <h2>音乐榜单</h2>
    </div>
    <div class="bars">
        <div class="on">热歌榜<i></i><span class="gap-line"> </span></div>
        <div class="bar">新歌榜<i></i></div>
    </div>


</div>


</body>
