/**
 * 首页焦点图
 * @name J_focusMap
 * @ignore
 */


if(_LZC.$('.J_focusMap')[0])
{
    var oJfocus = _LZC.$('.J_focusMap')[0]
    var oJimg   = _LZC.$('.J_img', oJfocus)[0];
    var aImgLi  = _LZC.$('li', oJimg);
    var aTabLi  = _LZC.$('li', _LZC.$('.J_tab', oJfocus)[0]);
    var oSpan	= _LZC.$('a', _LZC.$('.J_txt', oJfocus)[0])[0];//xiewulong20130311
    var timer   = null;
    var iNow    = 0;
    /* 计算UL宽度 */
    _LZC.getCss(oJimg, {width : aImgLi[0].offsetWidth * aImgLi.length + 'px'});

    for(var len=aTabLi.length,i=0;i<len;i++)
    {
        aTabLi[i].index = i
        _LZCmyEvent.bind(aTabLi[i], 'click', function ()
        {
            iNow = this.index;
            tab(iNow);
        });
    }

    /* 关闭定时器 */
    _LZCmyEvent.bind(oJfocus, 'mouseover', function ()
    {
        clearInterval(timer);
    });

    /* 开启定时器 */
    _LZCmyEvent.bind(oJfocus, 'mouseout', function ()
    {
        timer = setInterval(function (){
            iNow > aTabLi.length-2 ? iNow = 0 : iNow ++;
            tab(iNow);
        },4000);
    });


    /* 自动播放 */
    timer = setInterval(function (){
        iNow > aTabLi.length-2 ? iNow = 0 : iNow ++;
        tab(iNow);
    },4000);

    /* 切换函数 */
    function tab(iNow)
    {
        /* 切换选中状态 */
        for(var len=aTabLi.length,i=0;i<len;i++)_LZC.removeClass(aTabLi[i], 'hover');
        _LZC.addClass(aTabLi[iNow], 'hover');

        /* 切换标题 sunfei修改 */
        var html	=	_LZC.$('img' , _LZC.$('a', aImgLi[iNow])[0])[0].getAttribute('_title');//xiewulong20130311
        var ahref	=	_LZC.$('img' , _LZC.$('a', aImgLi[iNow])[0])[0].parentNode.getAttribute('href');//xiewulong20130311

        $("#otitle").html(html);
        $("#otitle").attr("href", ahref);

        /* 焦点图运动 */
        _LZCMOTION.animate(oJimg, {left : -aImgLi[0].offsetWidth * iNow})
    }
}

/**
 * 首页筛选
 * @name J_filterBox
 * @ignore
 */
if(_LZC.$('.J_filterBox')[0])
{

    var oJfilterBox = _LZC.$('.J_filterBox')[0];
    var aCode       = _LZC.$('code', oJfilterBox);
    var aJfilter    = _LZC.$('.J_filter');

    /* 复选框 */
    var oJcheckbox  = _LZC.$('.J_checkbox')[0];
    var aCheckbox   = _LZC.$('code', oJcheckbox);


    /* 切换筛选条件 */
    for(var len=aCode.length,i=0;i<len;i++)
    {
        aCode[i].index = i;
        _LZCmyEvent.bind(aCode[i], 'click', function ()
        {
            var labelBlueLen = $("#checkedcond div.labelBlue").length;
            var checkboxLen = 0;
            var JfilterLen = 0;

            /*
             for (var i = 0; i < $(".J_checkbox code").length; i++) {
             if($(".J_checkbox code").eq(i).children('em').hasClass('hove'))checkboxLen+=1;
             };

             for (var i = 0; i < $(".J_filterBox").next('div').children("div.J_filter").length; i++) {
             if($(".J_filterBox").next('div').children("div.J_filter").eq(i).get(0).style.display == 'block')JfilterLen+=1;
             };
             */

            /* 切换选中状态 */
            for(var len=aCode.length,i=0;i<len;i++)_LZC.removeClass(aCode[i], 'hove'),_LZC.getCss(aJfilter[i], {display : 'none'});

            _LZC.hasClass(this, 'sy') ? _LZC.addClass(this, 'hove1') : _LZC.addClass(this, 'hove');

            _LZC.addClass(this, 'hv');//xiewulong20130306

            _LZC.getCss(aJfilter[this.index], {display : 'block'});

            if(labelBlueLen == 0 && checkboxLen == 0 && JfilterLen != 0){
                $(".J_filterBox").next('div').children("div.J_filter").hide();
            }
        });

        //$(aCode[i]).hover(function(){if($(this).hasClass('hove')||$(this).hasClass('hove1'))$(this).addClass('hv');},function(){$(this).removeClass('hv');});//xiewulong20130306
        navHeight();
    }

    /* 复选筛选条件 */
    for(var len=aCheckbox.length,i=0;i<len;i++)
    {
        aCheckbox[i].index = i;
        _LZCmyEvent.bind(aCheckbox[i], 'click', function (){
            _LZC.hasClass(_LZC.$('em',this)[0], 'hove') ? _LZC.removeClass(_LZC.$('em',this)[0], 'hove') : _LZC.addClass(_LZC.$('em',this)[0], 'hove');
        });
    }

    /* 删除已选条件 */
    var aJdelLabel = _LZC.$('.J_delLabel');
    for(var len=aJdelLabel.length,i=0;i<len;i++)
    {
        _LZCmyEvent.bind(aJdelLabel[i], 'click', function (){
            this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode)
        });
    }
}

/**
 * 选择列表样式
 * @name J_tabBoxList
 * @ignore
 */
if(_LZC.$('.J_tabBoxList')[0])
{
    var oJtabBoxList	= _LZC.$('.J_tabBoxList')[0];
    var aSpan			= _LZC.$('span', oJtabBoxList);
    var aJtabList		= _LZC.$('.J_tabList');

    for(var len=aSpan.length,i=0;i<len;i++)
    {
        aSpan[i].index = i;
        _LZCmyEvent.bind(aSpan[i], 'click', function (){
            for(var len=aSpan.length,i=0;i<len;i++)
            {
                _LZC.removeClass(aSpan[i], 'fallsh');
                _LZC.removeClass(aSpan[i], 'listh');
                _LZC.getCss(aJtabList[i], {display:'none'});
            }
            this.index == 0 ? (_LZC.addClass(this, 'fallsh'),_LZC.getCss(aJtabList[1], {display:'block'})) : (_LZC.addClass(this, 'listh'),_LZC.getCss(aJtabList[0], {display:'block'}));
            navHeight();
        });
    }
}

/**
 * 城市选择
 * @name J_city
 * @ignore
 */
if(_LZC.$('.J_city')[0])
{
    var oJcity 		 = _LZC.$('.J_city')[0];
    var oJcitySpan	 = _LZC.$('span', oJcity)[0];
    var oJcityList 	 = _LZC.$('.J_cityList')[0];
    var oJcityListLi = _LZC.$('li', oJcityList);
    var oJclose		 = _LZC.$('.J_close')[0];

    _LZCmyEvent.bind(oJcity, 'click', function ()
    {
        _LZC.getCss(oJcityList, {display : 'block', top : this.offsetTop + 30 + 'px', left : this.offsetLeft + 'px'});
    })

    /* 选择城市 */
    for(var len=oJcityListLi.length,i=0;i<len;i++)
    {
        oJcityListLi[i].index = i;
        _LZCmyEvent.bind(oJcityListLi[i], 'click', function ()
        {
            for(var len=oJcityListLi.length,i=0;i<len;i++)_LZC.removeClass(oJcityListLi[i], 'hove');
            _LZC.addClass(this, 'hove');
            oJcitySpan.innerHTML = this.innerHTML;
        });
    }

    /* 关闭城市列表 */
    _LZCmyEvent.bind(oJclose, 'click', function (e)
    {
        var oEvent = e || event;
        _LZC.getCss(oJcityList, {display : 'none'});
        oEvent.cancelBubble = true;
    });
}

/* 判断IE6 */
var iE6 = !-[1,] && !window.XMLHttpRequest || navigator.userAgent.indexOf("MSIE 7.0") > 0;

var oSwitch = true;

/**
 * iE6瀑布流鼠标经过
 * @name waterfall
 * @ignore
 */
if(iE6)
{
    $('.indexConter .leftBox .waterfallBox li dfn.C .con').hover(function()
        {
            var index = $('.indexConter .leftBox .waterfallBox li dfn.C .con').index(this);
            $('.indexConter .leftBox .waterfallBox li dfn.C .con .js').eq(index).show();
        },
        function()
        {
            var index = $('.indexConter .leftBox .waterfallBox li dfn.C .con').index(this);
            $('.indexConter .leftBox .waterfallBox li dfn.C .con .js').eq(index).hide();
        });

    $('.searchConter .leftBox .searchList dfn.C .waterfallBox li dfn.C .con').hover(function()
        {
            var index = $('.searchConter .leftBox .searchList dfn.C .waterfallBox li dfn.C .con').index(this);
            $('.searchConter .leftBox .searchList dfn.C .waterfallBox li dfn.C .con .js').eq(index).show();
        },
        function()
        {
            var index = $('.searchConter .leftBox .searchList dfn.C .waterfallBox li dfn.C .con').index(this);
            $('.searchConter .leftBox .searchList dfn.C .waterfallBox li dfn.C .con .js').eq(index).hide();
        });
}

/* 绝对定位隐藏显示 */
function getScroll(id){
    var obj     = document.getElementById(id);
    if(obj)
    {
        window.onscroll = function()
        {
            if(getScrollTop() > 0)
            {
                if(iE6)
                {
                    positionFixed(obj);
                }
                else
                {
                    obj.style.top = 0;
                    obj.style.position = 'fixed';
                }
            }
            else
            {
                oSwitch = true;
                obj.style.position = '';
                if(iE6)
                {
                    obj.style.top = '0px';
                    obj.style.setExpression("top", "eval(" + 0 + ') + "px"');
                }
            }

        }
    }
}

/* 判断IE6 */
function positionFixed(obj)
{
    if(obj)
    {
        if(oSwitch)
        {
            oSwitch = false;
            document.documentElement.style.textOverflow = "ellipsis";
            obj.style.setExpression("top", "eval(documentElement.scrollTop + " + 0 + ') + "px"');
            var oJclose		 = _LZC.$('.J_close')[0];
            oJclose.click();
        }
    }
}

/* 获取滚动条Top */
function getScrollTop(){
    return document.documentElement.scrollTop || document.body.scrollTop;
}

/* 调用左侧滚动 */
getScroll('menuBox');

/**
 * 标签页
 * @name J_labelRimg
 * @ignore
 */

if(_LZC.$('.J_js')[0])
{
    var oJjs                = _LZC.$('.J_js');
    var oActivityList       = _LZC.$('.activityList');
    var oActivityListPackUp = _LZC.$('.activityListPackUp');

    for(var len=oJjs.length,i=0;i<len;i++)
    {
        oJjs[i].index = i;
        _LZCmyEvent.bind(oJjs[i], 'click', function (e)
        {
            if(_LZC.hasClass(this, 'unfold'))
            {
                _LZC.getCss(oActivityList[this.index], {display:'none'});
                _LZC.getCss(oActivityListPackUp[this.index], {display:'block'});
                _LZC.removeClass(this, 'unfold');
                _LZC.addClass(this, 'packup');
            }
            else
            {
                _LZC.getCss(oActivityList[this.index], {display:'block'});
                _LZC.getCss(oActivityListPackUp[this.index], {display:'none'});
                _LZC.removeClass(this, 'packup');
                _LZC.addClass(this, 'unfold');
            }
        });
    }
}

if(_LZC.$('.J_labelRimg')[0])
{
    var oJlabelRimg   = _LZC.$('.J_labelRimg')[0];
    var oJlabelRimgUl = _LZC.$('ul',oJlabelRimg)[0];
    var aJlabelRimgLi = _LZC.$('li',oJlabelRimg);
    var oJlabelRtab   = _LZC.$('.J_labelRtab')[0]
    var oJlabelRtabUl = _LZC.$('ul',oJlabelRtab)[0];
    var aJlabelRtabLi = _LZC.$('li',oJlabelRtab);
    var oJleft        = _LZC.$('.J_left')[0]
    var oJright       = _LZC.$('.J_right')[0]
    var iNow          = 0;

    /* 计算ul宽度 */
    _LZC.getCss(oJlabelRimgUl, {width : aJlabelRimgLi[0].offsetWidth * aJlabelRimgLi.length + 'px'});
    _LZC.getCss(oJlabelRtabUl, {width : (aJlabelRtabLi[0].offsetWidth + 9) * aJlabelRtabLi.length + 'px'});

    /* 点击切换 */
    for(var len=aJlabelRtabLi.length,i=0;i<len;i++)
    {
        aJlabelRtabLi[i].index = i;
        _LZCmyEvent.bind(aJlabelRtabLi[i], 'click', function (e)
        {
            iNow = this.index;
            tabR(iNow);
        });
    }

    /* 点击左边 */
    _LZCmyEvent.bind(oJleft, 'click', function (e)
    {
        oJlabelRtabUl.insertBefore(aJlabelRtabLi[aJlabelRtabLi.length - 1], oJlabelRtabUl.firstChild);
        _LZC.getCss(oJlabelRtabUl, {left:'-69px'})
        _LZCMOTION.animate(oJlabelRtabUl, {left : 0})
    });

    /* 点击右边 */
    _LZCmyEvent.bind(oJright, 'click', function (e)
    {
        _LZCMOTION.animate(oJlabelRtabUl, {left : '-69'},
            {
                callback : function ()
                {
                    oJlabelRtabUl.appendChild(aJlabelRtabLi[0]);
                    _LZC.getCss(oJlabelRtabUl, {left:'0'});
                }
            });
    });

    /* 切换函数 */
    function tabR(iNow)
    {
        /* 焦点图运动 */
        _LZCMOTION.animate(oJlabelRimgUl, {left : -aJlabelRimgLi[0].offsetWidth * iNow})
    }
}

/**
 * 个人资料页
 * @name J_labelRimg
 * @ignore
 */

if(_LZC.$('.J_navs')[0])
{
    var oJnavs    = _LZC.$('.J_navs')[0];
    var aJnavsH3  = _LZC.$('h3', oJnavs);
    var aJnavsp   = _LZC.$('p', oJnavs);
    var aJnavsDfn = _LZC.$('dfn', oJnavs);

    /* 点击显示下拉列表 */
    for(var len=aJnavsH3.length,i=0;i<len;i++)
    {
        aJnavsH3[i].index = i;
        _LZCmyEvent.bind(aJnavsH3[i], 'click', function (e)
        {


            if(_LZC.hasClass(_LZC.$('a', this)[0], 'on'))
            {
                for(var len=aJnavsH3.length,i=0;i<len;i++)
                {
                    _LZC.removeClass(_LZC.$('a', aJnavsH3[i])[0], 'on');
                    _LZC.removeClass(aJnavsp[i], 'on');
                }
            }
            else
            {
                for(var len=aJnavsH3.length,i=0;i<len;i++)
                {
                    _LZC.removeClass(_LZC.$('a', aJnavsH3[i])[0], 'on');
                    _LZC.removeClass(aJnavsp[i], 'on');
                }
                _LZC.addClass(_LZC.$('a', aJnavsH3[this.index])[0], 'on');
                _LZC.addClass(aJnavsp[this.index], 'on');
            }
        });
    }

    /* 点击菜单 */
    for(var len=aJnavsDfn.length,i=0;i<len;i++)
    {
        _LZCmyEvent.bind(aJnavsDfn[i], 'click', function (e)
        {
            for(var len=aJnavsDfn.length,i=0;i<len;i++)_LZC.removeClass(_LZC.$('a', aJnavsDfn[i])[0], 'on');
            _LZC.addClass(_LZC.$('a', this)[0], 'on');
        });
    }
}

/**
 * 头像滚动
 * @name J_avatar
 * @ignore
 */

if(_LZC.$('.J_avatar')[0])
{
    var oJavatar     = _LZC.$('.J_avatar')[0];
    var oJprev       = _LZC.$('.J_prev')[0];
    var oJnext       = _LZC.$('.J_next')[0];
    var aJavatarP    = _LZC.$('p', oJavatar)[0];
    var aJavatarSpan = _LZC.$('span', oJavatar);

    /* 点击左边 */
    _LZCmyEvent.bind(oJprev, 'click', function (e)
    {
        aJavatarP.insertBefore(aJavatarSpan[aJavatarSpan.length - 1], aJavatarSpan.firstChild);
        _LZC.getCss(oJavatar, {left:'-90px'})
        _LZCMOTION.animate(oJavatar, {left : 0})
    });

    /* 点击右边 */
    _LZCmyEvent.bind(oJnext, 'click', function (e)
    {
        _LZCMOTION.animate(oJavatar, {left : '-90'},
            {
                callback : function ()
                {
                    aJavatarP.appendChild(aJavatarSpan[0]);
                    _LZC.getCss(oJavatar, {left:'0'});
                }
            });
    });
}

/**
 * 首页右侧高度
 * @name navHeight
 * @ignore
 */

function navHeight()
{
    if(_LZC.$('.J_navHeight')[0])
    {
        _LZC.getCss(_LZC.$('.J_navHeight')[0], {height:(document.documentElement.scrollHeight)+'px'});
    }
}
navHeight();

/* add 2013-03-30  for yile */
$('.J_filterBox code').click(function(){
    var i_index = $('.J_filterBox code').index(this);
    $('.J_filter').eq(i_index).show().siblings().hide();

    if ($("#checkedcond").html() != '') {
        $('#nowcond').show();
    }
});
