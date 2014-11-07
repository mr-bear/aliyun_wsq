<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: install.php 34718 2014-07-14 08:56:39Z nemohou $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

?>
<script type="text/javascript" src="http://wsq.discuz.qq.com/cdn/discuz/js/openjs.js"></script>
<link rel="stylesheet" href="http://3g.xici.net/css/new.css"/>
<script>
        var menu = new Array();
	menu.push({name:"menu1", pluginid:'wsq_demo:view', param:"a=1&b=2"});
        menu.push({name:"menu2", pluginid:'wsq_demo:view', param:"a=3&b=4"});
        WSQ.initBtmBar(menu);
        WSQ.showBtmBar();
        WSQ.initPlugin({name:'wsq_demo'});

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
    #container {margin:5px;}
    body {height:100%;}
</style>
</head>
    <body>
        <form method="post" action="/" />
        <div class="new_post_page">
            <input type="hidden" name="method" value="doc.reply" />
            <input type="hidden" name="bid" value="1334600" />
            <input type="hidden" name="tid" value="209932661" />
            <div class="textarea"><textarea placeholder="回帖字数限制2000中文字" name="content"></textarea></div>
            <div class="tip"><input type="checkbox" checked id="minifyCheckBox"/>如图片大小超过1M，请帮我压缩后再上传</div>
            <ul class="images">
                <li class="add"><input type="file" id="fileUpload"></li>
            </ul>
            <input type="hidden" id="uploadImages" name="files">
        </div>
        </form>
    </body>
<script src="http://3g.xici.net/js/zepto.min.js"></script>
<script src="http://3g.xici.net/js/zepto.touch.js"></script>
<script src="http://3g.xici.net/js/canvasResize.js"></script>
<script src="http://3g.xici.net/js/XICI.Mobile.post.js"></script>
</html>