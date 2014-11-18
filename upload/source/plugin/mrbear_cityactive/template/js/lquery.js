/**
 + ---------------------------------------- +
 + js基本框架 v1.0
 + Author: luzhichao
 + QQ: 190135180
 + Mail: luzhichao@shiqutech.com\190135180@qq.com
 + ---------------------------------------- +
 + Date: 2012-09-07
 + ---------------------------------------- +
 **/

/**
 * 静态方法集
 * @name _LZC
 * @ignore
 */
var _LZC = {
    /**
     * 元素选择器
     * @name _LZC#$
     * @param {string} sArg		#id/.clssName/tagName
     * @param {object} context	可选，上下文
     * @function
     * @return element 为id时返回元素
     * @return elements 为className|tagName时返回元素集
     */
    $: function (sArg, context)
    {
        switch(sArg.charAt(0))
        {
            case "#":
                return document.getElementById(sArg.substring(1));
                break;
            case ".":
                var reg = new RegExp("(^|\\s)"+ sArg.substring(1) +"(\\s|$)"),
                    arr = [],
                    aEl = _LZC.$("*", context),
                    i;
                for(i = 0; i < aEl.length; i++) reg.test(aEl[i].className) && arr.push(aEl[i]);
                return arr;
                break;
            default:
                return (context || document).getElementsByTagName(sArg);
                break;
        }
    },
    /**
     * 判断目标元素是否包含指定的className
     * @name _LZC#hasClass
     * @param {object} element		目标元素
     * @param {string} className	要检测的className
     * @function
     * @return boolean
     */
    hasClass: function (element, className)
    {
        _LZCreturn(element);
        return new RegExp("(^|\\s)" + className + "(\\s|$)").test(element.className)
    },
    /**
     * 给目标元素添加className
     * @name Calendar#addClass
     * @param {object} element		目标元素
     * @param {string} className	要添加的className
     * @function
     */
    addClass: function (element, className)
    {
        _LZCreturn(element);
        var arr = element.className.split(/\s+/);
        this.hasClass(element, className) || arr.push(className);
        element.className = arr.join(" ").replace(/(^\s*)|(\s*$)/, "")
    },
    /**
     * 删除目标元素className
     * @name _LZC#removeClass
     * @param {object} element		目标元素
     * @param {string} className	要删除的className
     * @function
     */
    removeClass: function (element, className)
    {
        _LZCreturn(element);
        element.className = element.className.replace(new RegExp("" + className + "", "g"), "").split(/\s+/).join(" ")
    },
    /**
     * 目标元素添加style
     * @name _LZC#getCss
     * @param {object} element		目标元素
     * @param {string} attr	        样式属性
     * @param {string} value	    样式值
     * @function
     */
    getCss: function (element, attr, value)
    {
        _LZCreturn(element);
        if(arguments.length == 2)
        {
            var style = element.style,
                currentStyle = element.currentStyle;
            if(typeof attr === 'string')return currentStyle ? currentStyle[attr] : getComputedStyle(element, false)[attr];
            for(var propName in attr)propName == 'opacity' ? (style.filter = "alpha(opacity=" + attr[propName] + ")", style.opacity = attr[propName] / 100) : style[propName] = attr[propName];
        }
        else if(arguments.length == 3)
        {
            switch(attr)
            {
                case "width":
                case "height":
                case "paddingTop":
                case "paddingRight":
                case "paddingBottom":
                case "paddingLeft":
                case "top":
                case "right":
                case "bottom":
                case "left":
                case "marginTop":
                case "marginRigth":
                case "marginBottom":
                case "marginLeft":
                    value == '' ? element.style[attr] = "" : element.style[attr] = value + "px";
                    break;
                case "opacity":
                    element.style.filter = "alpha(opacity=" + value + ")";
                    element.style.opacity = value / 100;
                    break;
                default:
                    element.style[attr] = value;
            }
        }
    },
    /**
     * 目标元素添加style
     * @name _LZC#setCss
     * @param {object} element		目标元素
     * @param {object} json	        设置样式
     * @function
     */
    setCss: function (element,json)
    {
        _LZCreturn(element);
        for(var propName in json)_LZC.getCss(element, propName, json[propName])
    },
    /**
     * 阻止事件冒泡和默认事件
     * @name _LZC#halt
     * @param {event} e
     * @function
     */
    halt: function (e)
    {
        e = e || event;
        e.preventDefault  ? e.preventDefault()  : e.returnValue  = !1;
        e.stopPropagation ? e.stopPropagation() : e.cancelBubble = !0
    },
    /**
     * 获取目标元素属性
     * @name _LZC#attr
     * @param {object} element		目标元素
     * @param {string} attr 		属性名称
     * @param {string} value	    属性值
     * @function
     */
    attr: function (element, attr, value)
    {
        _LZCreturn(element);
        if(arguments.length == 2) {
            return element.attributes[attr] ? element.attributes[attr].nodeValue : undefined
        }else if(arguments.length == 3) {
            element.setAttribute(attr, value)
        }
    },
    /**
     * 删除目标元素属性
     * @name _LZC#removeAttr
     * @param {object} element		目标元素
     * @param {string} attr 		属性名称
     * @function
     */
    removeAttr: function (element, attr)
    {
        _LZCreturn(element);
        if(arguments.length == 2)element.removeAttribute(attr);
    },
    /**
     * 获取目标元素针对浏览器Left位置
     * @name _LZC#_offsetLeft
     * @param {object} element		目标元素
     * @function
     */
    _offsetLeft: function (element)
    {
        _LZCreturn(element);
        return element.getBoundingClientRect().left;
    },
    /**
     * 获取目标元素针对浏览器Top位置
     * @name _LZC#_offsetTop
     * @param {object} element		目标元素
     * @function
     */
    _offsetTop: function (element)
    {
        _LZCreturn(element);
        return element.getBoundingClientRect().top + (document.body.scrollTop || document.documentElement.scrollTop);
    },
    /**
     * 获取目标元高
     * @name _LZC#height
     * @param {object} element		目标元素
     * @function
     */
    height: function (element)
    {
        _LZCreturn(element);
        return element.offsetHeight;
    },
    /**
     * 获取目标元宽
     * @name _LZC#height
     * @param {object} element		目标元素
     * @function
     */
    width: function (element)
    {
        _LZCreturn(element);
        return element.offsetWidth;
    }
};
/**
 * 判断元素是否存在
 * @name _LZCmyEvent
 * @param {object} element		目标元素
 * @function
 */
var _LZCreturn = function (element)
{
    if(!element)return;
}
/**
 * 给目标元素绑定事件
 * @name _LZCmyEvent
 * @ignore
 */
var _LZCmyEvent = (function ()
{
    var _fid    = 1,
        _guid   = 1,
        _time   = (new Date).getTime(),
        _nEid   = '{$eid}' + _time,
        _nFid   = '{$fid}' + _time,
        _DOM    = document.addEventListener,
        _create = function (guid)
        {
            return function (event)
            {
                event    = api.fix(event || window.event);
                var i    = 0,
                    type = (event || (event = document.event)).type,
                    elem = _cache[guid].elem,
                    data = arguments;
                events = _cache[guid].events[type];
                for (;i<events.length;i++)
                {
                    if (events[i].apply(elem, data) === null) event.preventDefault();
                };
            };
        },
        _cache = {};

    var api = {
        /**
         * 事件绑定
         * @name    _LZCmyEvent#bind
         * @param   {object}     元素
         * @param   {String}     事件名
         * @param   {Function}   要绑定的函数
         */
        bind: function (elem, type, callback)
        {
            _LZCreturn(elem);
            var guid = elem[_nEid] || (elem[_nEid] = _guid ++);
            if(!_cache[guid])
            {
                _cache[guid] = {
                    elem: elem,
                    listener: _create(guid),
                    events: {}
                };
            }
            if(type && !_cache[guid].events[type])
            {
                _cache[guid].events[type] = [];
                api.add(elem, type, _cache[guid].listener);
            };
            if(callback)
            {
                if (!callback[_nFid]) callback[_nFid] = _fid ++;
                _cache[guid].events[type].push(callback);
            }
            else
            {
                return _cache[guid];
            }
        },
        /**
         * 事件卸载
         * @name    _LZCmyEvent#unbind
         * @param   {object}     元素
         * @param   {String}     事件名
         * @param   {Function}   要卸载的函数
         */
        unbind: function (elem, type, callback)
        {
            _LZCreturn(elem);
            var events, i, list,
                guid    = elem[_nEid],
                handler = _cache[guid];

            if(!handler)return;
            events = handler.events;
            if(callback)
            {
                list = events[type];
                if (!list) return;
                for(i = 0; i < list.length; i ++)
                {
                    list[i][_nFid] === callback[_nFid] && list.splice(i--, 1);
                };
                if(list.length === 0)return api.unbind(elem, type);
            }
            else if(type)
            {
                delete events[type];
                api.remove(elem, type, handler.listener);
            }
            else
            {
                for(i in events)
                {
                    api.remove(elem, i, handler.listener);
                };
                delete _cache[guid];
            }
        },

        /** 原生事件绑定接口 **/
        add: _DOM ? function (elem, type, listener)
        {
            elem.addEventListener(type, listener, false);
        }
            :
            function (elem, type, listener)
            {
                elem.attachEvent('on' + type, listener);
            },

        /** 原生事件卸载接口 **/
        remove: _DOM ? function (elem, type, listener)
        {
            elem.removeEventListener(type, listener, false);
        }
            :
            function (elem, type, listener)
            {
                elem.detachEvent('on' + type, listener);
            },

        /** 修正 **/
        fix: function (event)
        {
            if (_DOM) return event;
            var name,
                newEvent = {};
            for (name in event) newEvent[name] = event[name];
            return newEvent;
        }
    };
    return api;
})();
/**
 * 回调函数执行
 * @name _LZCFUN
 * @ignore
 */
var _LZCFUN = {
    /**
     * 编译json
     * @name _LZCFUN#extend
     * @param {string} destination		属性
     * @param {function} source 		函数
     * @function
     */
    extend: function (destination, source)
    {
        for (var propName in source) destination[propName] = source[propName];
        return destination
    },
    /**
     * 编译funEnd
     * @name _LZCFUN#funEnd
     * @param {fnEnd} source 		函数
     * @function
     */
    funEnd: function (fnEnd)
    {
        /** 函数转换 **/
        fnEnd = _LZCFUN.extend(
            {
                callback: function() {}
            }, fnEnd);
        fnEnd.callback();
    }
};

/**
 * DOM插入
 * @name _LZCDOM
 * @ignore
 */
var _LZCDOM = {
    /**
     * 插入DOM节点
     * @name _LZCDOM#html
     * @param {object} element		  目标元素
     * @param {string} str 		      插入内容
     * @param {string/function} plus  追加或者回调
     * @param {function} callback     回调函数
     * @function
     */
    html: function (element, str, plus, callback)
    {
        _LZCreturn(element);
        if(arguments.length == 1)
        {
            return element.innerHTML;
        }
        else if(arguments.length == 2 || arguments.length == 3)
        {

            if(typeof(plus) == 'function' || !plus)
            {
                element.innerHTML = str;
                if(plus)plus();
            }
            else
            {
                element.innerHTML += str ;
            }
        }
        else if(arguments.length == 4)
        {
            callback();
        }
    },
    /**
     * 尾部插入DOM节点
     * @name _LZCDOM#append
     * @param {object} element		目标元素
     * @param {string} str 		    插入内容
     * @param {function} callback   回调函数
     * @function
     */
    append: function (element, str, callback)
    {
        _LZCreturn(element);
        _LZCDOM.html(element, str, true);
        if(arguments.length == 3)callback();
    },
    /**
     * 前面插入DOM节点
     * @name _LZCDOM#prepend
     * @param {object} element		目标元素
     * @param {string} str 		    插入内容
     * @param {function} callback   回调函数
     * @function
     */
    prepend: function (element, str, callback)
    {
        _LZCreturn(element);
        var storage = _LZCDOM.html(element);
        _LZCDOM.html(element, str, false);
        _LZCDOM.html(element, storage, true);
        if(arguments.length == 3)callback();
    },
    /**
     * 匹配的元素之后插入内容
     * @name _LZCDOM#after
     * @param {object} element		目标元素
     * @param {string} str 		    插入内容
     * @param {function} callback   回调函数
     * @function
     */
    after: function (element, str, callback)
    {
        _LZCreturn(element);
        var oHtml  = str.replace(/<[^>]*>(.*)<[^>]*>/g,'$1');
        var oLabel = str.match(/<[^\s|>]+/g)[0].substring(1);
        if(/\s[^>]+/g.test(str))
        {
            var oPro   = str.match(/\s[^>]+/g)[0].substring(1).replace(/\=/g,':').split(/\s/);
            oPro   = (new Function('return{'+oPro+'}'))();
        }
        var insertedNode = document.createElement(oLabel);
        _LZCDOM.html(insertedNode, oHtml, false);

        if(/\s[^>]+/g.test(str))for(var propName in oPro)_LZC.attr(insertedNode, propName, oPro[propName]);

        element.parentNode.insertBefore(insertedNode,element.nextSibling);
        if(arguments.length == 3)callback();
    },
    /**
     * 匹配的元素之前插入内容
     * @name _LZCDOM#before
     * @param {object} element		目标元素
     * @param {string} str 		    插入内容
     * @param {function} callback   回调函数
     * @function
     */
    before: function (element, str, callback)
    {
        _LZCreturn(element);
        var oHtml  = str.replace(/<[^>]*>(.*)<[^>]*>/g,'$1');
        var oLabel = str.match(/<[^\s|>]+/g)[0].substring(1);
        if(/\s[^>]+/g.test(str))
        {
            var oPro   = str.match(/\s[^>]+/g)[0].substring(1).replace(/\=/g,':').split(/\s/);
            oPro   = (new Function('return{'+oPro+'}'))();
        }

        var insertedNode = document.createElement(oLabel);
        _LZCDOM.html(insertedNode, oHtml, false);

        if(/\s[^>]+/g.test(str))for(var propName in oPro)_LZC.attr(insertedNode, propName, oPro[propName]);

        element.parentNode.insertBefore(insertedNode,element.previousSibling);
        if(arguments.length == 3)callback();
    },
    /**
     * 删除指定元素
     * @name _LZCDOM#remove
     * @param {object} element		目标元素
     * @param {function} callback   回调函数
     * @function
     */
    remove: function (element, callback)
    {
        _LZCreturn(element);
        element.parentNode.removeChild(element);
        if(arguments.length == 2)callback();
    }
};
/**
 * 运动
 * @name _LZCMOTION
 * @ignore
 */
_LZCMOTION = {
    /**
     * 运动框架
     * @name _LZCMOTION#animate
     * @param {object} element		目标元素
     * @param {object} json			运动属性
     * @param {function} fnEnd      回调函数
     * @function
     */
    animate: function (element, json, fnEnd)
    {
        _LZCreturn(element);
        clearInterval(element.timer);
        element.iSpeed = 0;
        fnEnd = _LZCFUN.extend({
            type: "buffer",
            callback: function() {}
        }, fnEnd);
        element.timer = setInterval(function(){
            var iCur = 0,
                iStop = true;
            for(var propName in json){
                if(_LZC.getCss(element, propName)=='auto')
                {
                    iCur = parseFloat(element.offsetHeight);
                }
                else
                {
                    iCur = parseFloat(_LZC.getCss(element, propName));
                }
                propName == 'opacity' && (iCur = Math.round(iCur * 100));
                switch(fnEnd.type){
                    case 'buffer':
                        !-[1,] && !window.XMLHttpRequest ? element.iSpeed = (json[propName] - iCur) / 5 : element.iSpeed = (json[propName] - iCur) / 5;
                        element.iSpeed = element.iSpeed > 0 ? Math.ceil(element.iSpeed) : Math.floor(element.iSpeed);
                        json[propName] == iCur || (iStop = false, _LZC.getCss(element, propName, iCur + element.iSpeed));
                        break;
                    case 'elasticity':
                        element.iSpeed += (json[propName] - iCur) / 1;
                        element.iSpeed *= 0.75;
                        Math.abs(json[propName] - iCur) <= 1 &&  Math.abs(element.iSpeed) <= 1 ? _LZC.getCss(element, propName, json[propName]) : _LZC.getCss(element, propName, json[propName]) || (iStop = false, _LZC.getCss(element, propName, iCur + element.iSpeed));
                        break;
                    case 'accelerate':
                        element.iSpeed = element.iSpeed + 5;
                        iCur >= json[propName] ? _LZC.getCss(element, propName, json[propName]) : _LZC.getCss(element, propName, json[propName]) || (iStop = false, lzc.css(element, propName, iCur + element.iSpeed));
                        break;
                }
            }
            if(iStop){
                clearInterval(element.timer);
                element.timer = null;
                element.iSpeed = 0;
                fnEnd.callback();
            }
        },30);
    }
};
/**
 * 效果
 * @name _LZCEFFECT
 * @ignore
 */
_LZCEFFECT = {
    /**
     * 显示指定元素
     * @name _LZCEFFECT#show
     * @param {object} element		目标元素
     * @param {function} callback   回调函数
     * @function
     */
    show: function (element, callback)
    {
        _LZCreturn(element);
        _LZC.setCss(element, {display:'block'});
        if(arguments.length == 2)callback();
    },
    /**
     * 隐藏指定元素
     * @name _LZCEFFECT#hide
     * @param {object} element		目标元素
     * @param {function} callback   回调函数
     * @function
     */
    hide: function (element, callback)
    {
        _LZCreturn(element);
        _LZC.setCss(element, {display:'none'});
        if(arguments.length == 2)callback();
    },
    /**
     * 指定元素运动高度
     * @name _LZCEFFECT#slideDown
     * @param {object} element		目标元素
     * @param {function} callback   回调函数
     * @function
     */
    slideDown: function (element, callback)
    {
        _LZCreturn(element);
        var height = parseInt(_LZC.getCss(element, 'height'));
        _LZC.setCss(element, {height:0, display:'block'});
        _LZCMOTION.animate(element,{height:height},{
            callback : function ()
            {
                callback();
            }
        });
    },
    /**
     * 指定元素运动高度
     * @name _LZCEFFECT#slideUp
     * @param {object} element		目标元素
     * @param {function} callback   回调函数
     * @function
     */
    slideUp: function (element, callback)
    {
        _LZCreturn(element);
        _LZC.setCss(element, {display:'block'});
        _LZCMOTION.animate(element,{height:0},{
            callback : function ()
            {
                _LZC.setCss(element, {display:'none'});
                callback();
            }
        });
    }
};


/***************************************************************************************************************************/
/******************************************************** 错误闪红原型 *******************************************************/
/***************************************************************************************************************************/


/**
 * 错误闪红提示
 * @name _LZCERROR
 * @ignore
 */
function _LZCERROR() {
    this._init.apply(this, arguments)
}
/**
 * 闪红原型
 * @name _LZCERROR
 * @param {object} element	   目标元素
 * @param {boolean} border	   闪红边框
 * @param {function} callback  回调函数
 * @function
 */
_LZCERROR.prototype = {
    _init: function (element, border, callback)
    {
        var _this      = this;
        this.element   = element;
        this.border    = border;
        this.callback  = callback;
        this._error();
    },
    /**
     * 错误闪红
     * @name _LZCERROR#_error
     * @function
     */
    _error: function ()
    {
        var _this  = this;
        this.timer = null;
        this.i     = 0;

        this.timer = setInterval(function(){
            _this.i ++;
            if(_this.border != true)
            {
                _this.i == 6 ? (clearInterval(_this.timer),(typeof(_this.callback) == 'function' ? _this.callback() : '')) : (_this.i%2==0 ? _LZC.setCss(_this.element, {background:'#ffd4d4'}) : _LZC.setCss(_this.element, {background:''}));
            }
            else if(_this.border == true)
            {
                _this.i == 6 ? (clearInterval(_this.timer),_this.callback()) : (_this.i%2==0 ? _LZC.setCss(_this.element, {border:'1px solid #e20000'}) : _LZC.setCss(_this.element, {border:''}));
            }
        },120);
    }
};
/**
 * new闪红原
 * @name lzcError
 * @element, callback 参数
 */
function lzcError(element, border, callback){
    _LZCreturn(element);
    return new _LZCERROR(element, border, callback);
}


/***************************************************************************************************************************/
/******************************************************** 字符限制 **********************************************************/
/***************************************************************************************************************************/


/**
 * 字符限制提示
 * @name _LZCSIZE
 * @ignore
 */
function _LZCSIZE() {
    this._init.apply(this, arguments)
}
/**
 * 字符限制原型
 * @name _LZCSIZE
 * @param {object} element	   目标元素
 * @param {number} size	       限制字数
 * @param {object} tit	       字体变换元素
 * @param {function} callback  回调函数
 * @function
 */
_LZCSIZE.prototype = {
    _init: function (element, size, tit, callback)
    {
        var _this     = this;
        this.element  = element;
        this.size     = size;
        this.tit      = tit;
        this.callback = callback;
        this.tit ? this._character() : this._indentation();
    },
    /**
     * 拆分字符
     * @name _LZCSIZE#_limit
     * @function
     */
    _limit : function (_element)
    {
        this.e   = _element.value;
        e_length = 0;

        if(this.e.replace(/\n*\s*/,'')=='')
        {
            e_length = 0
        }
        else
        {
            e_length = this.e.match(/[^ -~]/g) == null ? this.e.length : this.e.length + this.e.match(/[^ -~]/g).length;
        }
        return e_length
    },
    /**
     * 字符限制
     * @name _LZCSIZE#_character
     * @function
     */
    _character: function ()
    {
        this.e_length = this._limit(this.element);
        this.font_count = Math.floor((this.size - this.e_length) / 2);
        if(this.font_count >= 0)
        {
            _LZCDOM.html(this.tit,'还可以输入<strong class="sou_num">'+this.font_count+'</strong>个字');
            return true
        }else{
            _LZCDOM.html(this.tit,'已经超出<strong class="sou_num" style="color:red">'+Math.abs(this.font_count)+'</strong>个字');
            return false
        }
    },
    /**
     * 字符缩进
     * @name _LZCSIZE#_indentation
     * @function
     */
    _indentation: function ()
    {
        if(this._limit(this.element) > this.size)
        {
            sum = 0;
            for(i=0;i<this.element.value.length;i++)
            {
                sum += this._length(this.element.value.substr(i,1));
                if(sum > this.size)this.element.value = this.element.value.substr(0,i);
            }
        }
    },
    _length: function (_element)
    {
        var iLen = _element;
        var iLimitLength = 0;
        var iLimitLength = iLen.match(/[^ -~]/g) == null ? iLen.length : iLen.length + iLen.match(/[^ -~]/g).length;
        return iLimitLength;
    }
};

/**
 * new字符限制
 * @name lzcLimitSize
 * @element, size, tit, callback 参数
 */
function lzcLimitSize(element, size, tit, callback){
    _LZCreturn(element);
    return new _LZCSIZE(element, size, tit, callback);
}

/***************************************************************************************************************************/
/******************************************************** 全选/全不选 ********************************************************/
/***************************************************************************************************************************/

/**
 * 全选、全不选
 * @name _LZCcheckAll
 * @ignore
 */
function _LZCcheckAll() {
    this._init.apply(this, arguments)
}
/**
 * 全选、全不选
 * @name _LZCcheckAll
 * @param {object} element	目标元素
 * @param {function} callback  回调函数
 * @function
 */
_LZCcheckAll.prototype = {
    _init: function (element, callback)
    {
        var _this     = this;
        this.element  = element;
        this.callback = callback;
        this.check();
    },
    check: function ()
    {
        var _this = this;
        this.isCheckAll = function()
        {
            for(var len=this.element.length,i=1,n=0;i<len;i++)this.element[i].checked && n++;
            this.element[0].checked = n == this.element.length - 1;
            if(typeof(this.callback) == 'function')this.callback();
        };
        /** 全选 **/
        _LZCmyEvent.bind(this.element[0], 'click', function ()
        {
            for(var len=_this.element.length,i=1;i<len;i++)_this.element[i].checked = this.checked;
            _this.isCheckAll()
        });
        /** 根据复选个数更新全选框状态 **/
        for (var i=1;i<this.element.length; i++){
            _LZCmyEvent.bind(this.element[i], 'click', function ()
            {
                _this.isCheckAll();
            });
        }
    }
}
/**
 * new全选、全不选
 * @name checkAll
 * @element, callback 参数
 */
function checkAll(element, callback){
    _LZCreturn(element);
    return new _LZCcheckAll(element, callback);
}

/***************************************************************************************************************************/
/******************************************************** 模拟下拉列表 ********************************************************/
/***************************************************************************************************************************/

/**
 * 模拟下拉列表
 * @name _LZCSelect
 * @ignore
 */
function _LZCSelect() {
    this._init.apply(this, arguments)
}
/**
 * 模拟下拉列表
 * @name _LZCSelect
 * @param {object} element	   目标元素
 * @param {object} diselem	   显示元素
 * @param {string} list 	   列表行
 * @param {function} callback  回调函数
 * @function
 */
_LZCSelect.prototype = {
    _init: function (element, elementName, diselem, list, callback, callback1)
    {
        var _this         = this;
        this.element      = element;
        this.elementName  = elementName;
        this.diselem      = diselem;
        this.list         = list;
        this.callback     = callback;
        this.callback1    = callback1;
        this.disSelect();
    },
    disSelect: function ()
    {
        /** 点击显示隐藏列表 **/
        var _this = this;
        this.element.onclick = function (e)
        {
            var oEvent  = e || event;

            /* 清除左侧蓝边 */
            if(_LZC.$('.J_listBlue')[0] && /J_HandleBtn/.test(this.className))
            {
                var aJlistBlue = _LZC.$('.J_listBlue');
                for(var len=aJlistBlue.length,i=0;i<len;i++)_LZC.removeClass(aJlistBlue[i], 'listening_xwl_edge_on');
            }
            /* 清除复选框 */
            if(_LZC.$('.notCheckbox')[0] && /J_HandleBtn/.test(this.className))
            {
                var aNotCheckbox = _LZC.$('.notCheckbox');
                for(var len=aNotCheckbox.length,i=0;i<len;i++)aNotCheckbox[i].checked = false;
            }

            if(_LZC.getCss(_this.diselem, 'display') == 'block')
            {

                _LZC.getCss(_this.diselem, 'display', 'none');
            }
            else
            {
                /* 清除相同下拉列表 */
                if(_LZC.$('.J_HandleList')[0])
                {
                    var aList = _LZC.$('.J_HandleList');
                    for(var len=aList.length,i=0;i<len;i++)_LZC.getCss(aList[i], 'display', 'none');
                }

                if(typeof(_this.callback1) == 'function')_this.callback1();
                _LZC.getCss(_this.diselem, 'display', 'block');

                /* 设置蓝边 */
                _LZC.hasClass(this,'J_HandleBtn') && (_LZC.addClass(this.parentNode.parentNode.parentNode.parentNode.parentNode, 'listening_xwl_edge_on'));


                _this.selectList();
            }
            /** 阻止冒泡 **/

            oEvent.cancelBubble = true;
            _LZC.halt(e);
        };

        /** 点击document隐藏列表 **/
        _LZCmyEvent.bind(document, 'click', function ()
        {
            if(_LZC.$('.J_HandleList')[0])
            {
                var aJHandleList = _LZC.$('.J_HandleList');
                for(var len=aJHandleList.length,i=0;i<len;i++)
                {
                    if(aJHandleList[i].style.display == 'block')
                    {
                        _LZC.hasClass(_this.diselem.parentNode.parentNode.parentNode.parentNode.parentNode, 'listening_xwl_edge_on') && (_LZC.removeClass(_this.diselem.parentNode.parentNode.parentNode.parentNode.parentNode, 'listening_xwl_edge_on'));
                    }
                }
            }
            _LZC.getCss(_this.diselem, 'display', 'none');
        });
    },
    selectList: function ()
    {
        var _this = this;
        this.aList = _LZC.$(this.list, this.diselem);
        for(var len = this.aList.length, i = 0; i < len; i ++)
        {
            _LZCmyEvent.unbind(this.aList[i], 'click');
            _LZCmyEvent.bind(this.aList[i], 'click', function ()
            {
                _this.elementName.innerHTML = this.innerHTML;
                if(typeof(_this.callback) == 'function')_this.callback(this.innerHTML, this);
            });
        }
    }
}
/**
 * new下拉列表
 * @name lzcSelect
 * @element, diselem, callback 参数
 */
function lzcSelect(element, elementName, diselem, list, callback, callback1){
    _LZCreturn(element);
    return new _LZCSelect(element, elementName, diselem, list, callback, callback1);
}


/***************************************************************************************************************************/
/******************************************************** 删除提示框 ********************************************************/
/***************************************************************************************************************************/

/**
 * 删除提示框
 * @name _LZCdelAlert
 * @ignore
 */
function _LZCdelAlert() {
    this._init.apply(this, arguments)
}
/**
 * 删除提示框原型
 * @name _LZCdelAlert
 * @param {object} element	   目标元素
 * @param {string} con		   删除内容
 * @param {object} e 		   event
 * @param {function} callback  回调函数
 * @function
 */
_LZCdelAlert.prototype = {
    _init: function (element, con, e, callback)
    {
        var _this     = this;
        this.element  = element;
        this.con      = con;
        this.e        = e || event;
        this.callback = callback;
        if(!_LZC.$('.alertChoose')[0])this.setAleft();
    },
    /**
     * 设置弹窗
     * @name _LZCdelAlert#setAleft
     * @function
     */
    setAleft: function ()
    {
        this.disX = _LZC._offsetLeft(this.element);
        this.disY = _LZC._offsetTop(this.element);

        /** 创建 **/
        this.choose       = document.createElement('div');
        this.chooseFrame  = document.createElement('div');
        this.chooseTop    = document.createElement('div');
        this.chooseBox    = document.createElement('div');
        this.chooseCon    = document.createElement('div');
        this.chooseButF   = document.createElement('div');
        this.chooseBut    = document.createElement('div');
        this.chooseBtn    = document.createElement('div');
        this.chooseCancel = document.createElement('div');
        this.chooseA      = document.createElement('a');
        this.chooseBottom = document.createElement('div');

        /** 设置class **/
        this.choose.className = 'alertChoose';
        //this.choose.id        = this.id;

        this.choose.style.left       = this.disX+'px';
        this.choose.style.top        = this.disY+'px';
        this.chooseFrame.className   = 'alertChooseFrame';
        this.chooseTop.className     = 'alertChooseTop';
        this.chooseBox.className     = 'alertChooseBox';
        this.chooseCon.className     = 'alertChooseCon';
        this.chooseButF.className    = 'alertChooseButF';
        this.chooseBut.className     = 'alertChooseBut';
        this.chooseBtn.className     = 'ChooseBtn';
        this.chooseBtn.innerHTML     = '确认';
        this.chooseCancel.className  = 'ChooseCancel';
        this.chooseBottom.className  = 'alertChooseBottom';
        this.chooseA.id              = 'Cancel';
        this.chooseA.href            = 'javascript:;';
        this.chooseA.innerHTML       = '取消';

        /** 插入 **/
        this.chooseCancel.appendChild(this.chooseA);
        this.chooseBut.appendChild(this.chooseBtn);
        this.chooseBut.appendChild(this.chooseCancel);
        this.chooseButF.appendChild(this.chooseBut);
        this.chooseBox.appendChild(this.chooseCon);
        this.chooseBox.appendChild(this.chooseButF);
        this.chooseFrame.appendChild(this.chooseTop);
        this.chooseFrame.appendChild(this.chooseBox);
        this.chooseFrame.appendChild(this.chooseBottom);
        this.choose.appendChild(this.chooseFrame);
        document.body.appendChild(this.choose);
        _LZCDOM.html(this.chooseCon,this.con);

        this.choose.style.marginLeft = -this.chooseFrame.offsetWidth / 2 + this.element.offsetWidth / 2 + 'px';
        this.setAleftanimate();
    },
    /**
     * 弹窗显示效果
     * @name _LZCdelAlert#setAleft
     * @function
     */
    setAleftanimate: function ()
    {
        var _this = this;
        if(!-[1,] && !window.XMLHttpRequest)
        {
            setTimeout(function(){
                if(parseInt(_this.choose.style.top)-parseInt(_this.chooseFrame.offsetHeight) < 0)
                {
                    _LZCMOTION.animate(_this.choose,{height:_this.chooseFrame.offsetHeight},{callback:function(){_this.setAleftBtn();}});
                }
                else
                {
                    _LZCMOTION.animate(_this.choose,{height:_this.chooseFrame.offsetHeight,marginTop:-_this.chooseFrame.offsetHeight},{callback:function(){_this.setAleftBtn();}})
                }
            },30)
        }
        else
        {

            if((parseInt(this.choose.style.left)+parseInt(this.chooseFrame.offsetWidth)) > document.documentElement.clientWidth)
            {
                this.choose.style.marginLeft  = '';
                this.choose.style.left  = document.documentElement.clientWidth - this.chooseFrame.offsetWidth - 10 + 'px';
            }
            if(parseInt(this.choose.style.top)-parseInt(this.chooseFrame.offsetHeight) < 0)
            {
                this.choose.style.top = _LZC._offsetTop(_this.element) + _this.element.offsetHeight + 'px';
                _LZCMOTION.animate(this.choose,{height:this.chooseFrame.offsetHeight},{callback:function(){_this.setAleftBtn();}});
            }
            else
            {
                _LZCMOTION.animate(this.choose,{height:this.chooseFrame.offsetHeight,marginTop:-this.chooseFrame.offsetHeight},{callback:function(){_this.setAleftBtn();}})
            }
        }
    },
    /**
     * 弹窗按钮事件
     * @name _LZCdelAlert#setAleftBtn
     * @function
     */
    setAleftBtn: function ()
    {
        var _this = this;
        _LZCmyEvent.bind(this.chooseBtn, 'mouseover', function ()
        {
            _LZC.addClass(this, 'ChooseBtn_h');
        });

        _LZCmyEvent.bind(this.chooseBtn, 'mouseout', function ()
        {
            _LZC.removeClass(this, 'ChooseBtn_h');
        });

        _LZCmyEvent.bind(this.chooseBtn, 'mousedown', function ()
        {
            _LZC.addClass(this, 'ChooseBtn_d');
        });

        _LZCmyEvent.bind(this.chooseBtn, 'mouseup', function ()
        {
            _LZC.removeClass(this, 'ChooseBtn_d');
        });

        _LZCmyEvent.bind(this.chooseBtn, 'click', function ()
        {
            _this.delAleft('determine');
        });

        _LZCmyEvent.bind(this.chooseA, 'click', function ()
        {
            _this.delAleft('cancel');
        });
    },
    /**
     * 删除弹窗
     * @name _LZCdelAlert#delAleft
     * @param {string} cancel  取消判断
     * @function
     */
    delAleft: function (cancel)
    {
        var _this = this;
        _LZCMOTION.animate(this.choose,{height:0,marginTop:0},{
            callback: function ()
            {
                _this.callback(cancel);
                document.body.removeChild(_this.choose);
            }
        })
    }
}
/**
 * new删除提示框
 * @name lzcdelalert
 * @element, con, e, callback 参数
 */
function lzcdelalert(element, con, e, callback){
    _LZCreturn(element);
    return new _LZCdelAlert(element, con, e, callback);
}

/***************************************************************************************************************************/
/****************************************************** 众趣页面回到顶部 *****************************************************/
/***************************************************************************************************************************/

/**
 * 众趣页面按钮
 * @name _LZCBtn
 * @ignore
 */

function _LZCTopLoad() {
    this._init.apply(this, arguments)
}

/**
 * 众趣页面按钮
 * @name _LZCgoTop
 * @function
 */

_LZCTopLoad.prototype = {
    _init : function (str, dis, online, color)
    {
        var _this   = this;
        this.str    = str;
        this.dis    = dis;
        this.online = online;
        this.color  = color;
        this._Variable();
    },
    /**
     * 申请变量
     * @name _Variable
     * @function
     */
    _Variable : function ()
    {
        this.oTopLoad     = _LZC.$('.topLoad')[0];
        this.oTopLoadSpan = _LZC.$('span',this.oTopLoad)[0];
        this.oTopLoadEm   = _LZC.$('em',this.oTopLoad)[0];
        this.timer        = null;

        _LZC.getCss(this.oTopLoad, 'display', 'block');

        this._topDis();
    },
    /**
     * 显示头部文件
     * @name _topDis
     * @function
     */
    _topDis : function ()
    {
        var _this = this;
        var oTop  = null;

        this.dis ? _LZC.getCss(this.oTopLoadEm, 'display', 'none') : _LZC.getCss(this.oTopLoadEm, 'display', 'block');

        /**插入提示语言**/
        _LZCDOM.html(this.oTopLoadSpan, this.str);

        /**显示提示**/
        _LZC.getCss(this.oTopLoad.parentNode, 'display', 'block');
        this.oTopLoad.parentNode.style.left = '50%';
        this.oTopLoad.parentNode.style.marginLeft = -this.oTopLoad.parentNode.offsetWidth / 2 +'px';
        if(this.color == 'green')
        {
            _LZC.addClass(this.oTopLoad ,'topload_green');
        }
        else if(this.color == 'red')
        {
            _LZC.addClass(this.oTopLoad ,'topload_red');
        }
        _LZC.getCss(this.oTopLoad.parentNode, 'display', 'none');
        _LZC.getCss(this.oTopLoad.parentNode, 'display', 'block');

        /**判断是否一直显示提示**/
        if(!this.online){
            clearInterval(this.timer);
            this.timer = setTimeout(function(){
                _LZC.getCss(_this.oTopLoad.parentNode, 'display', 'none');
            },3000);
        }
    }
}

/**
 * 头部操作提示
 * @name btn
 */
function topLoad(str, dis, online, color){
    return new _LZCTopLoad(str, dis, online, color);
}

/***************************************************************************************************************************/
/****************************************************** 众趣页面回到顶部 *****************************************************/
/***************************************************************************************************************************/

/**
 * 众趣页面按钮
 * @name _LZCBtn
 * @ignore
 */

function _LZCBtn() {
    this._init.apply(this, arguments)
}

/**
 * 众趣页面按钮
 * @name _LZCgoTop
 * @function
 */

_LZCBtn.prototype = {
    _init : function ()
    {
        var _this = this;
        this._Variable();
    },
    /**
     * 申请变量
     * @name _Variable
     * @function
     */
    _Variable : function ()
    {
        this.kDel   = _LZC.$('.k_del');
        this.kAdd   = _LZC.$('.k_add');
        this.aFirst = _LZC.$('.afirst');
        this.aTwo   = _LZC.$('.atwo');
        this.aThree = _LZC.$('.athree');
        this.aLast  = _LZC.$('.alast');
        this.aBtnh  = _LZC.$('.btnh');
        this.aBtn1  = _LZC.$('.btnl');
        this._mouse();
    },
    /**
     * 按钮鼠标事件
     * @name _mouse
     * @function
     */
    _mouse : function ()
    {
        /**绿色按钮**/
        for(var len=this.kDel.length,i=0;i<len;i++)
        {
            /**鼠标经过**/
            _LZCmyEvent.bind(this.kDel[i], 'mouseover', function ()
            {
                _LZC.addClass(this,'k_hover1');
            });

            /**鼠标离开**/
            _LZCmyEvent.bind(this.kDel[i], 'mouseout', function ()
            {
                _LZC.removeClass(this,'k_hover1');
                _LZC.removeClass(this,'k_active1');
            });

            /**鼠标按下**/
            _LZCmyEvent.bind(this.kDel[i], 'mousedown', function ()
            {
                _LZC.addClass(this,'k_active1');
            });

            /**鼠标抬起**/
            _LZCmyEvent.bind(this.kDel[i], 'mouseup', function ()
            {
                _LZC.removeClass(this,'k_active1');
            });
        }

        /**灰色按钮**/
        for(var len=this.kAdd.length,i=0;i<len;i++)
        {
            /**鼠标经过**/
            _LZCmyEvent.bind(this.kAdd[i], 'mouseover', function ()
            {
                _LZC.addClass(this,'k_hover');
            });

            /**鼠标离开**/
            _LZCmyEvent.bind(this.kAdd[i], 'mouseout', function ()
            {
                _LZC.removeClass(this,'k_hover');
                _LZC.removeClass(this,'k_active');
            });

            /**鼠标按下**/
            _LZCmyEvent.bind(this.kAdd[i], 'mousedown', function ()
            {
                _LZC.addClass(this,'k_active');
            });

            /**鼠标抬起**/
            _LZCmyEvent.bind(this.kAdd[i], 'mouseup', function ()
            {
                _LZC.removeClass(this,'k_active');
            });
        }

        /**弹窗@AT按钮**/
        for(var len=this.aFirst.length,i=0;i<len;i++)
        {
            /**鼠标经过**/
            _LZCmyEvent.bind(this.aFirst[i], 'mouseover', function ()
            {
                _LZC.addClass(this,'hover_first');
            });

            /**鼠标离开**/
            _LZCmyEvent.bind(this.aFirst[i], 'mouseout', function ()
            {
                _LZC.removeClass(this,'hover_first');
                _LZC.removeClass(this,'active_first');
            });

            /**鼠标按下**/
            _LZCmyEvent.bind(this.aFirst[i], 'mousedown', function ()
            {
                _LZC.addClass(this,'active_first');
            });

            /**鼠标抬起**/
            _LZCmyEvent.bind(this.aFirst[i], 'mouseup', function ()
            {
                _LZC.removeClass(this,'active_first');
            });
        }

        /**弹窗私信按钮**/
        for(var len=this.aTwo.length,i=0;i<len;i++)
        {
            /**鼠标经过**/
            _LZCmyEvent.bind(this.aTwo[i], 'mouseover', function ()
            {
                _LZC.addClass(this,'hover_two');
            });

            /**鼠标离开**/
            _LZCmyEvent.bind(this.aTwo[i], 'mouseout', function ()
            {
                _LZC.removeClass(this,'hover_two');
                _LZC.removeClass(this,'active_two');
            });

            /**鼠标按下**/
            _LZCmyEvent.bind(this.aTwo[i], 'mousedown', function ()
            {
                _LZC.addClass(this,'active_two');
            });

            /**鼠标抬起**/
            _LZCmyEvent.bind(this.aTwo[i], 'mouseup', function ()
            {
                _LZC.removeClass(this,'active_two');
            });
        }

        /**弹窗KOL按钮**/
        for(var len=this.aThree.length,i=0;i<len;i++)
        {
            /**鼠标经过**/
            _LZCmyEvent.bind(this.aThree[i], 'mouseover', function ()
            {
                _LZC.addClass(this,'hover_three');
            });

            /**鼠标离开**/
            _LZCmyEvent.bind(this.aThree[i], 'mouseout', function ()
            {
                _LZC.removeClass(this,'hover_three');
                _LZC.removeClass(this,'active_three');
            });

            /**鼠标按下**/
            _LZCmyEvent.bind(this.aThree[i], 'mousedown', function ()
            {
                _LZC.addClass(this,'active_three');
            });

            /**鼠标抬起**/
            _LZCmyEvent.bind(this.aThree[i], 'mouseup', function ()
            {
                _LZC.removeClass(this,'active_three');
            });
        }

        /**弹窗关注按钮**/
        for(var len=this.aLast.length,i=0;i<len;i++)
        {
            /**鼠标经过**/
            _LZCmyEvent.bind(this.aLast[i], 'mouseover', function ()
            {
                _LZC.addClass(this,'hover_last');
            });

            /**鼠标离开**/
            _LZCmyEvent.bind(this.aLast[i], 'mouseout', function ()
            {
                _LZC.removeClass(this,'hover_last');
                _LZC.removeClass(this,'active_last');
            });

            /**鼠标按下**/
            _LZCmyEvent.bind(this.aLast[i], 'mousedown', function ()
            {
                _LZC.addClass(this,'active_last');
            });

            /**鼠标抬起**/
            _LZCmyEvent.bind(this.aLast[i], 'mouseup', function ()
            {
                _LZC.removeClass(this,'active_last');
            });
        }

        /**弹窗绿色按钮**/
        for(var len=this.aBtnh.length,i=0;i<len;i++)
        {
            /**鼠标经过**/
            _LZCmyEvent.bind(this.aBtnh[i], 'mouseover', function ()
            {
                _LZC.addClass(this,'btnh_hover');
            });

            /**鼠标离开**/
            _LZCmyEvent.bind(this.aBtnh[i], 'mouseout', function ()
            {
                _LZC.removeClass(this,'btnh_hover');
                _LZC.removeClass(this,'btnh_active');
            });

            /**鼠标按下**/
            _LZCmyEvent.bind(this.aBtnh[i], 'mousedown', function ()
            {
                _LZC.addClass(this,'btnh_active');
            });

            /**鼠标抬起**/
            _LZCmyEvent.bind(this.aBtnh[i], 'mouseup', function ()
            {
                _LZC.removeClass(this,'btnh_active');
            });
        }

        /** 小按钮 **/
        for(var len=this.aBtn1.length,i=0;i<len;i++)
        {
            /**鼠标经过**/
            _LZCmyEvent.bind(this.aBtn1[i], 'mouseover', function ()
            {
                _LZC.addClass(this,'btnl_hover');
            });

            /**鼠标离开**/
            _LZCmyEvent.bind(this.aBtn1[i], 'mouseout', function ()
            {
                _LZC.removeClass(this,'btnl_hover');
                _LZC.removeClass(this,'btnl_active');
            });

            /**鼠标按下**/
            _LZCmyEvent.bind(this.aBtn1[i], 'mousedown', function ()
            {
                _LZC.addClass(this,'btnl_active');
            });

            /**鼠标抬起**/
            _LZCmyEvent.bind(this.aBtn1[i], 'mouseup', function ()
            {
                _LZC.removeClass(this,'btnl_active');
            });
        }
    }
}

/**
 * 众趣页面按钮
 * @name btn
 */
function btn(){
    return new _LZCBtn();
}

/***************************************************************************************************************************/
/****************************************************** 众趣页面回到顶部 *****************************************************/
/***************************************************************************************************************************/

/**
 * 众趣回到顶部
 * @name _LZCgoTop
 * @ignore
 */

function _LZCgoTop() {
    this._init.apply(this, arguments)
}

/**
 * 众趣回到顶部
 * @name _LZCgoTop
 * @function
 */

_LZCgoTop.prototype = {
    _init : function ()
    {
        var _this = this;
        this._Variable();
    },
    /**
     * 申请变量
     * @name _Variable
     * @function
     */
    _Variable : function ()
    {
        this.oScrollTop  = _LZC.$('.scrollTop');
        this.oBoxScroll  = _LZC.$('.boxScroll');
        this.ogotopTimer = null;
        this._Scroll();
    },
    /**
     * 滚动条事件
     * @name _Scroll
     * @function
     */
    _Scroll : function ()
    {
        var _this = this;
        for(var len=this.oBoxScroll.length,i=0;i<len;i++)
        {
            this.oBoxScroll[i].index = i;
            this.scrollUpload = _LZC.$('.upload',this.oBoxScroll[i]);
            /** 滚动添加事件 **/
            _LZCmyEvent.bind(this.oBoxScroll[i], 'scroll', function ()
            {
                if(this.scrollUpload)
                {
                    if(this.offsetHeight + this.scrollTop >= this.scrollHeight)
                    {
                        if(_LZC.getCss(_LZC.$('.upload_two')[this.index], 'display') != 'none')_LZC.getCss(_this.scrollUpload[0], 'display', 'block');
                    }
                    else
                    {
                        _LZC.getCss(_this.scrollUpload[0], 'display', 'none');
                    }
                }
                /** 判断是否显示回到顶部按钮 **/
                this.scrollTop > 20 ? _LZC.getCss(_this.oScrollTop[this.index], 'display', 'block') : _LZC.getCss(_this.oScrollTop[this.index], 'display', 'none');
            });
        }
        this._ScrollTop();
    },
    /**
     * 回到顶部
     * @name _ScrollTop
     * @function
     */
    _ScrollTop : function ()
    {
        var _this = this;
        for(var len=this.oScrollTop.length,i=0;i<len;i++)
        {
            this.oScrollTop[i].index = i;
            _LZC.attr(this.oScrollTop[i], 'title', '回到顶部');

            /** 添加回到顶部事件 **/
            _LZCmyEvent.bind(this.oScrollTop[i], 'click', function ()
            {
                var _thisS = this;
                this.timer = setInterval(sMove,10);
                function sMove(){
                    _this._setScrollTop(_thisS.index, _this._getScrollTop(_thisS.index) / 5);
                    if(_this._getScrollTop(_thisS.index) < 1)clearInterval(_thisS.timer);
                }
            });
        }
    },
    /**
     * 获取滚动条TOP
     * @name _getScrollTop
     * @function
     */
    _getScrollTop : function (index)
    {
        return this.oBoxScroll[index].scrollTop;
    },
    /**
     * 设置滚动条TOP
     * @name _setScrollTop
     * @function
     */
    _setScrollTop : function (index, value)
    {
        this.oBoxScroll[index].scrollTop = value;
    }
}

/**
 * 滚动条回到顶部或加载
 * @name scrollTop
 */
function scrollTop(){
    return new _LZCgoTop();
}

/***************************************************************************************************************************/
/****************************************************** 众趣页面宽度计算 *****************************************************/
/***************************************************************************************************************************/

/**
 * 众趣页面宽度计算
 * @name _LZCWidth
 * @ignore
 */

function _LZCWidth() {
    this._init.apply(this, arguments)
}

/**
 * 众趣页面宽度计算
 * @name _LZCWidth
 * @function
 */

_LZCWidth.prototype = {
    _init: function ()
    {
        var _this = this;
        this._Variable();
    },
    /**
     * 申请变量
     * @name _Variable
     * @function
     */
    _Variable : function ()
    {
        /**基本变量**/
        this.oFrame     = _LZC.$('.frame');
        this.oMiddle    = _LZC.$('.middle')[0];
        this.oRight     = _LZC.$('.right')[0];
        this.oHeader    = _LZC.$('.header')[0];
        this.oMain      = _LZC.$('.main',this.oRight)[0];
        this.oBoxScroll = _LZC.$('.boxScroll');
        this.width      = document.documentElement.clientWidth;

        /**基本变量高**/
        this.oBoxCon    = _LZC.$('.box_con')[0];
        this.height     = document.documentElement.clientHeight;

        /**滚动条变量**/
        this.oBoxScroll =  _LZC.$('.boxScroll');
        this.oFAddBox   =  _LZC.$('.fAddBox');
        this.oBoxBottom =  _LZC.$('.boxBottom')[0];

        this._Width();
    },
    /**
     * 设置页面栏目宽度
     * @name _LZCWidth#_Width
     * @function
     */
    _Width : function ()
    {
        if(this.width <= 1358)
        {
            /**初始化最小宽**/
            _LZC.getCss(this.oRight, 'width', '1204');
            _LZC.getCss(this.oHeader, 'width', '1356');
            _LZC.getCss(this.oMiddle, 'width', '1356');

            for(var len=this.oFrame.length,i=0;i<len;i++)_LZC.getCss(this.oFrame[i], 'width', '');
            if(!this.oFrame[0])_LZC.getCss(this.oBoxCon, 'height', this.height - 197);
        }
        else
        {
            /**初始化宽**/
            _LZC.getCss(this.oRight, 'width', '');
            _LZC.getCss(this.oHeader, 'width', '');
            _LZC.getCss(this.oMiddle, 'width', '');

            /**判断边框个数**/
            if(this.oFrame.length == 3)
            {
                for(var len=this.oFrame.length,i=0;i<len;i++)_LZC.getCss(this.oFrame[i], 'width', parseInt(390+(this.oMain.offsetWidth-1206)/3));
            }
            else if(this.oFrame.length == 2)
            {
                /**判断两列宽度**/
                if(_LZC.$('#lW'))
                {
                    _LZC.getCss(this.oFrame[1], 'width', parseInt(792+(this.oMain.offsetWidth-1206)/2));
                    _LZC.getCss(this.oFrame[0], 'width', parseInt(390+(this.oMain.offsetWidth-1206)/2));
                }
                else
                {
                    if(_LZC.$('.J_width')[0])
                    {
                        _LZC.getCss(this.oFrame[0], 'width', parseInt(590+(this.oMain.offsetWidth-1206)/2));
                        _LZC.getCss(this.oFrame[1], 'width', parseInt(590+(this.oMain.offsetWidth-1206)/2));
                    }
                    else
                    {
                        _LZC.getCss(this.oFrame[0], 'width', parseInt(792+(this.oMain.offsetWidth-1206)/2));
                        _LZC.getCss(this.oFrame[1], 'width', parseInt(390+(this.oMain.offsetWidth-1206)/2));
                    }
                }
            }
            else
            {
                /**判断一列宽度**/
                if(this.oFrame[0]){
                    _LZC.getCss(this.oFrame[0], 'width', parseInt(1194+(this.oMain.offsetWidth-1206)));
                }else{
                    _LZC.getCss(this.oBoxCon, 'height', this.height - 182);
                }
            }
        }
        /**滚动条高度**/
        this._ScrollHeight();
    },
    /**
     * 设置滚动条高度
     * @name _LZCWidth#_ScrollHeight
     * @function
     */
    _ScrollHeight : function ()
    {
        /**滚动条高度**/
        if(this.oFrame[0].offsetHeight >= 100)
        {
            for(var len=this.oBoxScroll.length,i=0;i<len;i++)
            {
                if(this.oBoxBottom)
                {
                    _LZC.getCss(this.oBoxScroll[i], 'height', this.oFrame[0].offsetHeight - this.oFAddBox[i].offsetHeight - this.oBoxBottom.offsetHeight - 34);
                }
                else
                {
                    _LZC.getCss(this.oBoxScroll[i], 'height', this.oFrame[0].offsetHeight - this.oFAddBox[i].offsetHeight - 34);
                }
            }
        }
    }
}
/**
 * 计算栏目宽度
 * @name iWidth
 */
function iWidth(){
    return new _LZCWidth();
}


/***************************************************************************************************************************/
/******************************************************** 众趣基本弹窗 ********************************************************/
/***************************************************************************************************************************/

/**
 * 众趣基本弹窗
 * @name _LZCAlert
 * @ignore
 */
function _LZCAlert() {
    this._init.apply(this, arguments)
}
/**
 * 众趣基本弹窗
 * @name _LZCAlert
 * @param {string} id		   弹窗ID
 * @param {object} fnEnd 	   json基本功能
 * @param {function} callback  回调函数
 * @function
 */
var alertSwitch = true;
_LZCAlert.prototype = {
    _init: function (id, fnEnd, callback)
    {
        var _this     = this;
        this.bian     = 16;
        this.id       = id;
        this.callback = callback;
        this.property(fnEnd);
        this.width    = this.fnEnd.width;
        this.height   = this.fnEnd.height;
        this.sl       = this.fnEnd.left;
        this.st       = this.fnEnd.top;
        this.title    = this.fnEnd.title;
        this.eq       = this.fnEnd.eq;
        this.content  = this.fnEnd.content;
        this.choose   = this.fnEnd.choose;
        this.fixed    = this.fnEnd.fixed;
        this.close    = this.fnEnd.close;
        this.url      = this.fnEnd.url;
        this.create();
    },
    property : function(fnEnd){
        this.fnEnd = {};
        _LZCFUN.extend(this.fnEnd, fnEnd || {});
    },
    /**
     * 创建弹窗
     * @name _LZCAlert#create
     * @function
     */
    create: function ()
    {
        this.box   = document.createElement('div');
        this.angle = document.createElement('div');
        this.LT    = document.createElement('span');
        this.RT    = document.createElement('span');
        this.LB    = document.createElement('span');
        this.RB    = document.createElement('span');
        this.T     = document.createElement('span');
        this.B     = document.createElement('span');
        this.L     = document.createElement('span');
        this.R     = document.createElement('span');
        this.Clos  = document.createElement('span');
        this.can   = document.createElement('div');
        this.bg    = document.createElement('div');

        /** 是否拖动 **/
        if(this.fixed == 'fixed')
        {
            this.drag       = document.createElement('div');
            this.alertTitle = document.createElement('div');
            this.dragImg    = document.createElement('img');
        }

        /** 设置弹窗 **/
        this.setAleft();
    },
    /**
     * 设置弹窗
     * @name _LZCAlert#setAleft
     * @function
     */
    setAleft: function ()
    {
        this.box.className   = 'alert';
        this.box.id          = this.id;
        this.LT.className    = 'LT';
        this.RT.className    = 'RT';
        this.LB.className    = 'LB';
        this.RB.className    = 'RB';
        this.T.className     = 'T';
        this.B.className     = 'B';
        this.L.className     = 'L';
        this.R.className     = 'R';
        this.Clos.className  = 'close';
        this.Clos.id         = this.id+'close';
        this.can.className   =  'C';
        this.bg.className    =  'alertbg';
        this.bg.style.height = '100%';

        /** 是否拖动 **/
        if(this.fixed == 'fixed')
        {
            this.drag.className       = 'drag';
            this.alertTitle.className = 'alert_title';
            this.alertTitle.innerHTML = this.title;
            this.dragImg.src          = static_host + 'images/alertnew/san.jpg'
        }

        /** 插入 **/
        this.appendAlert();
    },
    /**
     * 插入弹窗
     * @name _LZCAlert#setAleft
     * @function
     */
    appendAlert: function ()
    {
        this.angle.appendChild(this.LT);
        this.angle.appendChild(this.RT);
        this.angle.appendChild(this.LB);
        this.angle.appendChild(this.RB);
        this.angle.appendChild(this.T);
        this.angle.appendChild(this.B);
        this.angle.appendChild(this.L);
        this.angle.appendChild(this.R);
        this.angle.appendChild(this.Clos);
        this.box.appendChild(this.angle);
        this.box.appendChild(this.can);

        /** 是否拖动 **/
        if(this.fixed == 'fixed')
        {
            this.drag.appendChild(this.dragImg);
            this.can.appendChild(this.drag);
            this.can.appendChild(this.alertTitle);
        }
        document.body.appendChild(this.box);

        /** 判断背景是否存在 **/
        if(_LZC.$('.alertbg')[0] == undefined)
        {
            document.body.appendChild(this.bg);
        }
        else
        {
            _LZC.$('.alertbg')[0].style.zIndex = 100;
        }
        this.can.innerHTML   += '<div class="st_laoding">正在加载,请稍候...</div>';
        /** 显示弹窗 **/
        this.animateShow()
    },
    /**
     * 拖动
     * @name _LZCAlert#setAleftBtn
     * @function
     */
    _fixed: function ()
    {
        var _this = this;
        !-[1,] && !window.XMLHttpRequest ? _LZC.getCss(this.box,'position','absolute') : _LZC.getCss(this.box,'position','fixed');
        /** 拖动 **/
        var oDrag = _LZC.$('.drag', _LZC.$('#'+this.id));
        oDrag[0].onmousedown = function(e)
        {
            var _thisE  = this;
            this.oEvent = e || event;
            this.X      = this.oEvent.clientX - _this.box.offsetLeft;
            this.Y      = this.oEvent.clientY - _this.box.offsetTop;
            document.onmousemove = function(e)
            {
                this.oEvent = e || event;
                this.L      = this.oEvent.clientX - _thisE.X;
                this.T      = this.oEvent.clientY - _thisE.Y;
                this.maxL   = document.documentElement.clientWidth - _this.box.offsetWidth;
                this.maxT   = document.documentElement.clientHeight - _this.box.offsetHeight;

                /** 拖动边界 **/
                this.L <= 0 && (this.L = 0);
                this.T <= 0 && (this.T = 0);
                this.L >= this.maxL && (this.L = this.maxL);
                this.T >= this.maxT && (this.T = this.maxT);

                _this.box.style.left   = this.L + 'px';
                _this.box.style.top    = this.T + 'px';
                _this.box.style.margin = 0;
                return false;
            }
            document.onmouseup = function(){
                document.onmouseup   = null;
                document.onmousemove = null;
                _this.drag.releaseCapture && _this.drag.releaseCapture()
            };
            this.setCapture && this.setCapture();
            return false;
        }
    },
    /**
     * 插入弹窗内容
     * @name _LZCAlert#appendConent
     * @function
     */
    appendConent: function ()
    {
        var _this = this;
        if(typeof this.content == 'string' && !this.url){
            _LZC.getCss(_LZC.$('.st_laoding',_LZC.$('#'+this.id))[0], 'display', 'none');
            this.can.innerHTML += this.content;
            //非ajax
            this._fixed();
            if(typeof(alertCallBack) == 'function')alertCallBack();
            if(typeof(cardCallBack) == 'function')cardCallBack();
            alertSwitch = true;
        }
        else
        {
            var alertTimer = null;
            alertTimer = setInterval(function(){
                if(_this.url() != false)
                {
                    clearInterval(alertTimer);
                    _LZC.getCss(_LZC.$('.st_laoding',_LZC.$('#'+_this.id))[0], 'display', 'none');
                    _this.can.innerHTML += _this.url();
                    //ajax
                    _this._fixed();
                    if(typeof(alertCallBack) == 'function')alertCallBack();
                    if(typeof(cardCallBack) == 'function')cardCallBack();
                    alertSwitch = true;
                }
            },30);
        }
    },
    /**
     * 弹窗运动
     * @name _LZCAlert#animateShow
     * @function
     */
    animateShow: function ()
    {
        var _this = this;

        /** 设置宽高 **/
        switch(this.width){
            case undefined:
                break;
            default:
                if(this.width != ''){
                    _LZC.setCss(this.box, {width:this.width,marginLeft:-(this.width / 2)});
                    _LZC.getCss(this.can, 'width', this.width - this.bian);
                    _LZC.getCss(this.T, 'width', this.width - this.bian);
                    _LZC.getCss(this.B, 'width', this.width - this.bian);
                }
        }
        switch(this.height){
            case undefined:
                break;
            default:
                if(this.height != ''){
                    _LZC.setCss(this.box, {height:this.height,marginTop:-(this.height / 2)});
                    _LZC.getCss(this.can, 'height', this.height - this.bian);
                    _LZC.getCss(this.L, 'height', this.height - this.bian);
                    _LZC.getCss(this.R, 'height', this.height - this.bian);
                }
        }
        switch(this.sl){
            case undefined:
                break;
            default:
                if(this.sl != '')_LZC.setCss(this.box, {left:this.sl,marginLeft:0});
        }
        switch(this.st){
            case undefined:
                break;
            default:
                if(this.st != '')_LZC.setCss(this.box, {top:this.st,marginTop:0});
        }

        /** 显示弹窗 **/
        _LZC.getCss(this.box,'marginTop',-(this.height / 2 + 50));

        /** 判断TOP显示位置 **/
        this.st == '' ? this.mTop = -(this.height / 2) : this.mTop = this.st;

        /** 弹窗透明度 **/
        _LZC.getCss(this.box, 'opacity', 0);

        /** 展开弹窗 **/
        $(this.box).animate({marginTop:this.mTop,opacity:1},function(){
            _LZC.getCss(_this.Clos,'display','block');
            _LZC.getCss(_this.box,'overflow','visible');
            var style = _LZC.attr(_this.box,'style').replace('alpha(opacity=100)','');
            _LZC.attr(_this.box, 'style', style);

            $(_this.Clos).animate({right:-20},function(){
                _this.appendConent();
                _this.animateHide();
            });
        });
    },
    /**
     * 关闭弹窗
     * @name _LZCAlert#animateHide

     * @function
     */
    animateHide: function ()
    {
        var _this = this;

        /** 点击关闭按钮 **/
        _LZCmyEvent.bind(this.Clos, 'click', function ()
        {
            $(_this.Clos).animate({right:0},function(){
                _LZC.getCss(_this.Clos,'display','none');
                _LZC.getCss(_this.box,'overflow','hidden');

                $(_this.box).animate({marginTop:-(_this.height / 2 + 50),opacity:0},function(){
                    _this.removeAlert();
                });
            });
        });
    },
    /**
     * 删除弹窗DOM
     * @name _LZCAlert#removeAlert
     * @function
     */
    removeAlert: function ()
    {
        var _this = this;

        /** 删除DOM **/
        document.body.removeChild(this.box);
        if(_LZC.$('.C').length == 0)
        {
            document.body.removeChild(this.bg);
        }
        else
        {
            _LZC.$('.alertbg')[0].style.zIndex = '';
        }
        alertSwitch = true;
        if(typeof(this.callback)=='function')this.callback();
    }
}
/**
 * new众趣基础弹出窗
 * @name lzcalert
 * @id, fnEnd 参数
 */
function lzcalert(id, fnEnd, callback){
    return new _LZCAlert(id, fnEnd, callback);
}


/***************************************************************************************************************************/
/******************************************************** 滚动条加载 ********************************************************/
/***************************************************************************************************************************/

/**
 * 滚动条加载
 * @name _LZCScroll
 * @ignore
 */
var scrollLoad = true;
function _LZCScroll() {
    this._init.apply(this, arguments)
}
/**
 * 滚动条加载原型
 * @name _LZCScroll
 * @param {object} element	    目标元素
 * @param {object} diselem	    显示元素
 * @param {function} callback   回调函数
 * @param {function} callback1  回到顶部回调函数
 * @function
 */
_LZCScroll.prototype = {
    _init: function (element, diselem, callback, callback1)
    {
        var _this      = this;
        this.element   = element;
        this.diselem   = diselem;
        this.callback  = callback;
        this.callback1 = callback1;
        this._scroll();
    },
    /**
     * 底部加载
     * @name _LZCScroll#_scroll
     * @function
     */
    _scroll: function ()
    {
        var _this = this;

        _LZCmyEvent.bind(this.element, 'scroll');
        _LZCmyEvent.bind(this.element, 'scroll', function ()
        {
            if(this == window)
            {
                if(document.documentElement.clientHeight + (document.documentElement.scrollTop || document.body.scrollTop) >= document.body.scrollHeight && scrollLoad)
                {
                    scrollLoad = false;
                    _this.callback();
                }

                /** 显示回到顶部按钮 **/
                (document.documentElement.scrollTop || document.body.scrollTop) > 50? (_LZC.getCss(_this.diselem, 'display', 'block'),_this._goTopScroll()) : _LZC.getCss(_this.diselem, 'display', 'none');
            }
            else
            {
                if(this.offsetHeight + this.scrollTop >= this.scrollHeight && scrollLoad == true)
                {
                    scrollLoad = false;
                    _this.callback();
                }
                /** 显示回到顶部按钮 **/
                if(!_LZC.$('#J_datdCars'))
                {
                    this.scrollTop > 50 ? (_LZC.getCss(_this.diselem, 'display', 'block'),_this._goTopScroll()) : _LZC.getCss(_this.diselem, 'display', 'none');
                }
            }
        });
    },
    /**
     * 回到顶部
     * @name _LZCScroll#_goTopScroll
     * @function
     */
    _goTopScroll: function ()
    {
        var _this = this;
        _LZCmyEvent.unbind(this.diselem, 'click');
        _LZCmyEvent.bind(this.diselem, 'click', function ()
        {
            _this.timer = setInterval(function (){
                _this._sMoveScrollTop();
            },10);
        });
    },
    /**
     * TOP距离
     * @name _LZCScroll#_getScrollTop
     * @function
     */
    _getScrollTop: function ()
    {
        if(this.element == window)
        {
            return (document.documentElement.scrollTop || document.body.scrollTop);
        }
        else
        {
            return this.element.scrollTop;
        }
    },
    /**
     * 设置TOP距离
     * @name _LZCScroll#_setScrollTop
     * @function
     */
    _setScrollTop: function (value)
    {
        if(this.element == window)
        {
            document.documentElement.scrollTop = value;
            document.body.scrollTop = value;
        }
        else
        {
            this.element.scrollTop = value;
        }
    },
    /**
     * 回到顶部TOP0
     * @name _LZCScroll#_sMoveScrollTop
     * @function
     */
    _sMoveScrollTop: function ()
    {
        var _this = this;
        this._setScrollTop(this._getScrollTop() / 5);
        if(this._getScrollTop() < 1)
        {
            clearInterval(_this.timer);
            _this.callback1();
        }
    }
}
/**
 * new滚动条加载
 * @name lzcScroll
 * @element, diselem, callback, callback1 参数
 */
function lzcScroll(element, diselem, callback, callback1){
    _LZCreturn(element);
    return new _LZCScroll(element, diselem, callback, callback1);
}

/***************************************************************************************************************************/
/******************************************************** 图片预加载 ********************************************************/
/***************************************************************************************************************************/

/**
 * 图片预加载
 * @name _LZCnewImg
 * @ignore
 */
function _LZCnewImg() {
    this._init.apply(this, arguments)
}
/**
 * 模拟下拉列表
 * @name _LZCnewImg
 * @param {string}   url 	   图片地址
 * @param {function} callback  回调函数
 * @param {function} errorcall 错误回调
 * @function
 */
_LZCnewImg.prototype = {
    _init: function (url, callback, errorcall)
    {
        var _this      = this;
        this.url       = url;
        this.callback  = callback;
        this.errorcall = errorcall;
        this._newImg();
    },
    _newImg: function ()
    {
        var _this    = this;
        this.img     = new Image();
        this.img.src = this.url;
        if(this.img.complete)
        {
            this.callback(this.img.width, this.img.height, this.src);
        }
        else
        {
            this.img.onload = function ()
            {
                _this.callback(this.width, this.height, this.src);
                _this.img.onload = null;
            };
            this.img.onerror = function ()
            {
                _this.errorcall();
            }
        };

    }
}
/**
 * newImg
 * @name lzcNewImg
 * @url, callback 参数
 */
function lzcNewImg(url, callback, errorcall){
    return new _LZCnewImg(url, callback, errorcall);
}


/***************************************************************************************************************************/
/******************************************************** 选项卡 ************************************************************/
/***************************************************************************************************************************/


/**
 * 选项卡
 * @name _LZCTab
 * @ignore
 */
function _LZCTab() {
    this._init.apply(this, arguments)
}
/**
 * 选项卡原型
 * @name _LZCTab
 * @param {object}   tabBtn	   选项卡按钮
 * @param {string}   setClass  选中样式
 * @param {tabBtn/string} tab  显示样式
 * @param {function} callback  回调函数
 * @function
 */
_LZCTab.prototype = {
    _init: function (tabBtn, setClass, tab, callback)
    {
        var _this     = this;
        this.tabBtn   = tabBtn;
        this.setClass = setClass;
        this.tab      = tab;
        this.callback = callback;
        this._tab();
    },
    _tab: function ()
    {
        var _this = this;
        for(var len = this.tabBtn.length, i = 0; i < len; i++)
        {
            this.tabBtn[i].index = i;
            _LZCmyEvent.unbind(this.tabBtn[i], 'click');
            _LZCmyEvent.bind(this.tabBtn[i], 'click', function ()
            {
                for(var len = _this.tabBtn.length, i = 0; i < len; i++)
                {
                    _LZC.removeClass(_this.tabBtn[i], _this.setClass);
                    if(typeof(_this.tab) != 'string')_LZC.getCss(_this.tab[i], 'display', 'none');
                }
                _LZC.addClass(this, _this.setClass);
                typeof(_this.tab) != 'string' ? _LZC.getCss(_this.tab[this.index], 'display', 'block') : _this.callback();
            });
        }
    }
}
/**
 * 选项卡
 * @name lzcTab
 * @tabBtn, tab, callback 参数
 */
function lzcTab(tabBtn, setClass, tab, callback){
    return new _LZCTab(tabBtn, setClass, tab, callback);
}

/***************************************************************************************************************************/
/******************************************************** input输入类型 *****************************************************/
/***************************************************************************************************************************/

/**
 * input输入类型
 * @name _LZCInput
 * @ignore
 */
function _LZCInput() {
    this._init.apply(this, arguments)
}
/**
 * input原型
 * @name _LZCInput
 * @param {object} element	目标元素
 * @param {string} type     输入类型
 * @param {function} callback 回调函数
 * @function
 */
_LZCInput.prototype = {
    _init: function (element, type, callback)
    {
        var _this     = this;
        this.element  = element;
        this.type     = type;
        this.callback = callback;
        this._input();
    },
    _input: function ()
    {
        var _this = this;
        switch(this.type)
        {
            case "mail":
                this.re = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
                break;
            case "ch":
                this.re = /[^\u4e00-\u9fa5]/g;
                break;
            case "en":
                this.re = /[^a-zA-Z]/g;
                break;
            case "number":
                this.re = /[^0-9]/g;
                break;
            default:
                this.re = /[^a-zA-Z0-9\u4e00-\u9fa5]/g;
                break;
        }

        _LZCmyEvent.bind(this.element, 'keyup', function ()
        {
            _this.type == 'mail' ? (_this.re.test(this.value) ? _this.callback(true) : _this.callback(false)) : this.value = this.value.replace(_this.re,'');
        });
    }
}
/**
 * input输入类型
 * @name lzcInput
 * @tabBtn, tab, callback 参数
 */
function lzcInput(element, type, callback){
    _LZCreturn(element);
    return new _LZCInput(element, type, callback);
}

/***************************************************************************************************************************/
/************************************************** 文本框根据输入内容自适应高度 ***********************************************/
/***************************************************************************************************************************/

/**
 * Textarea自适应高
 * @name _LZCTextarea
 * @ignore
 */
function _LZCTextarea() {
    this._init.apply(this, arguments)
}
/**
 * textarea原型
 * @name _LZCTextarea
 * @param {object} element	 目标元素
 * @param {string} maxHeight 输入高度
 * @function
 */
_LZCTextarea.prototype = {
    _init: function (element, maxHeight)
    {
        var _this      = this;
        this.element   = element;
        this.maxHeight = maxHeight;
        this._event();
    },
    /**
     * textarea处理高度
     * @name _LZCTextarea#_textarea
     * @param {object} element	 目标元素
     * @param {string} maxHeight 输入高度
     * @function
     */
    _textarea: function (element, maxHeight)
    {
        var _this = this;
        var height,style = _this.style;
        element.style.height =  '20px';

        if(element.scrollHeight > 20)
            maxHeight && element.scrollHeight > maxHeight ? height = maxHeight : (height = element.scrollHeight,_LZC.getCss(element,'overflowY','hidden')),_LZC.setCss(element,{height:height,overflowY:'auto'});
        else
            _LZC.getCss(element,'overflowY','hidden');

        if(arguments.length == 3)_this.timer = setInterval(function(){
            _this._textarea(_this.element, _this.maxHeight);
        },0);
    },
    /**
     * textarea基本事件
     * @name _LZCTextarea#_event
     * @function
     */
    _event: function ()
    {
        var _this = this;

        /** 光标离开 **/
        _LZCmyEvent.bind(this.element, 'blur', function ()
        {
            clearInterval(_this.timer);
            _this._textarea(_this.element, _this.maxHeight);
        });

        /** 键盘抬起 **/
        _LZCmyEvent.bind(this.element, 'keyup', function ()
        {
            clearInterval(_this.timer);
            _this._textarea(_this.element, _this.maxHeight);
        });

        /** 鼠标右键 **/
        _LZCmyEvent.bind(this.element, 'contextmenu', function ()
        {
            _this._textarea(_this.element, _this.maxHeight, 'stick');
        });
    }
}
/**
 * Textarea自适应高
 * @name autoTextarea
 * @element, maxHeight 参数
 */
function autoTextarea(element, maxHeight){
    _LZCreturn(element);
    return new _LZCTextarea(element, maxHeight);
}

/***************************************************************************************************************************/
/************************************************** 根据光标位置插入指定文本 **************************************************/
/***************************************************************************************************************************/

/**
 * 光标位置插入文本
 * @name _LZCinsertAdd
 * @ignore
 */
function _LZCinsertAdd() {
    this._init.apply(this, arguments)
}
/**
 * _LZCinsertAdd原型
 * @name _LZCTextarea
 * @param {object} element	 目标元素
 * @param {string} textVal   插入文本
 * @function
 */
_LZCinsertAdd.prototype = {
    _init: function (element, textVal, selected)
    {
        var _this     = this;
        this.element  = element;
        this.textVal  = textVal;
        this.selected = selected;
        this._insertAdd();
    },
    /**
     * 文字插入位置
     * @name insertAdd
     * @function
     */
    _insertAdd : function ()
    {
        this.txt = this.textVal;
        /** 浏览器判断 **/
        if(document.selection)
        {
            this.element.focus();
            var range  = document.selection.createRange();
            if(this.element.value.indexOf("#" + this.txt + "#") == -1)
                this.selected ? range.text = '#' + this.txt + '#' : range.text = this.txt;
        }
        else if(window.getSelection && this.element.selectionStart > -1)
        {
            this.start = this.element.selectionStart;
            this.end   = this.element.selectionEnd;
            this.sizeReplace(this.start);

            /** 插入文本设置光标位置 **/
            if(this.element.value.indexOf("#" + this.txt + "#") == -1)
                this.element.value = this.sizeReplace + (this.selected ? '#' + this.txt + '#' : this.txt) + this.element.value.slice(this.end);
            /** 设置光标位置 **/
            if(!this.selected)
            {
                this.element.setSelectionRange(this.sizeReplace.length + this.txt.length,this.sizeReplace.length + this.txt.length);
                this.element.focus();
            }
        }
        if(this.selected)this._selected();
    },

    /**
     * 光选中
     * @name setFocus
     * @function
     */
    _selected : function ()
    {
        this.s_start = this.element.value.indexOf("#" + this.txt + "#");
        if(this.element.createTextRange)
        {
            var range = this.element.createTextRange();
            range.moveStart("character", ++this.s_start);
            range.moveEnd("character", this.s_start + this.txt.length - this.element.value.length);
            range.select();
        }
        else
        {
            this.element.setSelectionRange(this.s_start + 1, this.s_start + this.txt.length + 1);
            this.element.focus();
        }
    },

    /**
     * 光标前文字
     * @name sizeReplace
     * @function
     */
    sizeReplace : function (start)
    {
        this.sizeReplace = this.element.value.substring(0,start);
    }
}
/**
 * 光标位置插入文本
 * @name cursor
 * @element, textVal 参数
 */
function cursor(element, textVal, selected){
    _LZCreturn(element);
    return new _LZCinsertAdd(element, textVal, selected);
}

/***************************************************************************************************************************/
/****************************************************** 输入框@功能 *********************************************************/
/***************************************************************************************************************************/

/**
 * 微博at功能
 * @name _LZCAt
 * @ignore
 */
function _LZCAt() {
    this._init.apply(this, arguments)
}
/**
 * _LZCAt原型
 * @name _LZCAt
 * @param {object} element	 目标元素
 * @param {object} fnEnd	 回调函数
 * @function
 */
_LZCAt.prototype = {
    _init: function (element, fnEnd)
    {
        var _this    = this;
        this.element = element;
        this.iNow    = 1;
        this.val     = 0;
        this._mousekey();
    },
    /**
     * IE鼠标文字存储
     * @name _mousekey
     * @function
     */
    _storage : function ()
    {
        if(document.selection)
        {
            var range = document.selection.createRange();
            range.moveStart("character",-this.ieList().end);
            this.val = range.text.length;
        }
    },
    /**
     * 鼠标键盘事件监听
     * @name _mousekey
     * @function
     */
    _mousekey : function ()
    {
        var _this = this;

        /** 鼠标抬起 **/
        $(this.element).click(function()
            //this.element.onclick = function ()
        {
            _this._listSite();
            _this.disList();

            /** IE鼠标文字存储 **/
            _this._storage();
        });

        /**光标选中**/
        $(this.element).focus(function()
            //this.element.onfocus = function ()
        {
            //创建at列表
            _this.List = document.createElement('div');
            _this.Ul = document.createElement('ul');

            //设置元素属性
            _this.List.id = 'atList';

            //插入元素
            _this.List.appendChild(_this.Ul);
            if(!_LZC.$('#atList'))document.body.appendChild(_this.List);
        });

        /**光标离开**/
        $(this.element).blur(function()
            //this.element.onblur = function ()
        {
        });

        /**键盘抬起**/
        $(this.element).keyup(function(e)
            //this.element.onkeyup = function (e)
        {
            var oEvent = e || event;

            //获取下拉列表位置
            _this._listSite();

            //插入数据
            if(oEvent.keyCode == 38 || oEvent.keyCode == 40)return false;


            //显示下拉列表
            _this.disList();

            /** IE鼠标文字存储 **/
            _this._storage();
        });

        /**键盘按下**/
        this.element.onkeydown = function (e)
        {
            var oEvent = e || event;
            if(_LZC.$('#atList'))
            {
                if(_LZC.$('#atList').style.display == 'block' && oEvent.keyCode == 38)
                {
                    _this.iNow == 1 ? _this.iNow = _LZC.$('li',_LZC.$('#atList')).length - 1 : _this.iNow --;
                    _this.opt(_LZC.$('li',_LZC.$('#atList')));
                    return false;
                }
                else if(_LZC.$('#atList').style.display == 'block' && oEvent.keyCode == 40)
                {
                    _this.iNow == _LZC.$('li',_LZC.$('#atList')).length - 1 ? _this.iNow = 1 : _this.iNow ++;
                    _this.opt(_LZC.$('li',_LZC.$('#atList')));
                    return false;
                }

                if(_LZC.$('#atList').style.display == 'block' && oEvent.keyCode == 13)
                {
                    /** 插入列表内容 **/
                    _this.insertAdd(_LZC.$('li',_LZC.$('#atList'))[_this.iNow].innerHTML);
                    return false;
                }
            }
        };
    },

    /**
     * 控制@关联菜单位置
     * @name listSite
     * @function
     */
    _listSite : function ()
    {
        this.replaceHTML             = this.getPosition(this.element).replace(/\</g,'&lt;').replace(/\>/g,'&gt;').replace(/\n/g,'<br>').replace(/\s/g,'&nbsp;');
        this.replaceAt               = this.replaceHTML.match(/@[^@]+|@/g);
        this.replaceAt               = this.replaceAt ? this.replaceAt[this.replaceAt.length-1]+'$' : '';
        this.replaceAt               = new RegExp(this.replaceAt);

        /** 创建插入隐藏DIV获取光标位置 **/
        this.oDiv                     = document.createElement('div');
        this.oDiv.id                  = 'textDisplay';
        if(this.element.scrollHeight > this.element.offsetHeight)
        {
            this.oDiv.style.width     = $(this.element).width()-15 + 'px';
        }
        else
        {
            this.oDiv.style.width     = _LZC.getCss(this.element,'width');
        }
        this.oDiv.style.height        = _LZC.getCss(this.element,'height');

        this.oDiv.style.paddingTop    = _LZC.getCss(this.element,'paddingTop');
        this.oDiv.style.paddingLeft   = _LZC.getCss(this.element,'paddingLeft');
        this.oDiv.style.paddingRight  = _LZC.getCss(this.element,'paddingRight');
        this.oDiv.style.paddingBottom = _LZC.getCss(this.element,'paddingBottom');
        this.oDiv.style.marginTop     = _LZC.getCss(this.element,'marginTop');
        this.oDiv.style.marginLeft    = _LZC.getCss(this.element,'marginLeft');
        this.oDiv.style.marginRight   = _LZC.getCss(this.element,'marginRight');
        this.oDiv.style.marginBottom  = _LZC.getCss(this.element,'marginBottom');
        this.oDiv.style.lineHeight    = _LZC.getCss(this.element,'lineHeight');
        this.oDiv.style.fontSize      = _LZC.getCss(this.element,'fontSize');
        this.oDiv.style.fontFamily    = _LZC.getCss(this.element,'fontFamily');
        if(this.element.getAttribute('at_tag')=='input'){
            this.oDiv.innerHTML       = '<cite>#</cite>';
        }else{
            this.oDiv.innerHTML       = this.replaceHTML.replace(this.replaceAt,'') + '<cite>#</cite>';
            //this.element.value       = this.replaceHTML.replace(this.replaceAt,'');
        }
        this.element.parentNode.appendChild(this.oDiv);

        /** 列表位置 **/
        this.oTextDisplay            = _LZC.$('#textDisplay');
        this.oCite                   = _LZC.$('cite', this.oTextDisplay)[0];
        if(_LZC.$('#atList'))
        {
            this.top = _LZC._offsetTop(this.oCite)   - this.element.scrollTop + 20;

            var left=_LZC._offsetLeft(this.oCite)  + 2;

            left=left>(document.documentElement.clientWidth-200)?(document.documentElement.clientWidth-200):left;

            _LZC.$('#atList').style.left = left  + 'px';
        }
        this.element.parentNode.removeChild(this.oDiv);
    },

    /**
     * 判断光标位置\获取光标前文字
     * @name getPosition
     * @function
     */
    getPosition : function ()
    {
        this.text;

        if(typeof(this.element.selectionStart)=="number")
        {
            this.text = this.element.value.substring(0,this.element.selectionStart);//获取文本框value
        }
        else
        {

            this.rng;
            this.rng  = document.selection.createRange();
            this.rng.moveStart("character",-this.ieList().end);
            this.text = this.rng.text;
            //document.title = this.ieList().end;
        }
        return this.text;
    },
    /**
     * 显示隐藏下拉列表
     * @name disList
     * @function
     */
    disList : function ()
    {


        /** @符号个数 **/
        var len = this.getPosition(this.element).match(/@[^@]+|@/g);

        if(_LZC.$('#atList'))
        {
            if(len)
            {
                if(/[^a-zA-Z0-9\u4e00-\u9fa5@]/g.test(len[len.length-1]))
                {
                    _LZC.$('#atList').style.display = 'none';
                }
                else
                {
                    //_LZC.$('#atList').style.display = 'block';

                    if(_LZC.$('#atList'))
                    {
                        ajaxAt(len, this);
                    }
                }
            }
            else
            {
                _LZC.$('#atList').style.display = 'none';
            }
        }
    },
    /**
     * 菜单选择
     * @name opt
     * @function
     */
    opt : function (aLi)
    {
        for(var len=aLi.length,i=1;i<len;i++)_LZC.removeClass(aLi[i],'hove');
        _LZC.addClass(aLi[this.iNow],'hove');
    },
    /**
     * 鼠标经过微博名称
     * @name mouseover
     * @function
     */
    mouseover : function (aLi,_this)
    {
        _this = _this ? _this : this;
        for(var len=aLi.length,i=1;i<len;i++)
        {
            aLi[i].index = i;
            aLi[i].onmouseover = function ()
            {
                _this.iNow = this.index;
                _this.opt(aLi);
            };

            /** 鼠标点击微博名称 **/
            aLi[i].onclick = function ()
            {
                /** 插入列表内容 **/
                _this.insertAdd(this.innerHTML, _this.val);
            };
        }
    },
    /**
     * 替换@符之后文字
     * @name insertAdd
     * @function
     */
    atReplace : function (start)
    {

        this.aReplace = this.element.value.substring(0,start).match(/@[^@]+|@/g);
        this.aReplace = this.aReplace ? this.aReplace[this.aReplace.length-1]+'$' : '';

        this.aReplace = new RegExp(this.aReplace);
        this.aReplace = this.element.value.substring(0,start).replace(this.aReplace,'@');
    },
    /**
     * 微博名称插入位置
     * @name insertAdd
     * @function
     */
    insertAdd : function (txt, lenv)
    {
        this.txt = txt + ' ';
        /** 隐藏下拉列表 **/
        _LZC.$('#atList').style.display = 'none';
        this.iNow = 1;
        /** 浏览器判断 **/
        if(document.selection)
        {
            this.range = document.selection.createRange();
            this.range.moveStart("character",-this.ieList().end);

            //插入文本&&判断IE鼠标点击
            lenv && lenv > 0 ? this.start = lenv : this.start = this.range.text.length;

            this.atReplace(this.start);
            this.setFocus();

        }
        else if(window.getSelection && this.element.selectionStart>-1)
        {
            this.start = this.element.selectionStart;
            this.end   = this.element.selectionEnd;
            this.atReplace(this.start);
            this.setFocus();
        }
    },
    /**
     * 插入文本设置光标位置
     * @name setFocus
     * @function
     */
    setFocus : function ()
    {
        /** 浏览器判断 **/
        if(document.selection)
        {
            this.element.value = this.aReplace + this.txt + this.element.value.substring(this.start,this.element.value.length);
            this.ofocus = this.element.createTextRange();
            this.ofocus.moveStart('character',(this.aReplace.length+this.txt.length));
            this.ofocus.collapse(true);
            this.ofocus.select();
        }
        else if(window.getSelection&&this.element.selectionStart>-1)
        {
            this.element.value = this.aReplace + this.txt + this.element.value.substring(this.start,this.end) + this.element.value.slice(this.end);
            /** 设置光标位置 **/
            this.element.setSelectionRange(this.aReplace.length + this.txt.length,this.aReplace.length + this.txt.length);
            this.element.focus();
        }
    },
    /**
     * IE菜单位置
     * @name ieList
     * @function
     */
    ieList : function ()
    {
        this.rangeData = {text: "", start: 0, end: 0 };
        this.oS        = document.selection.createRange();
        this.oR        = document.body.createTextRange();
        var i          = 0;
        this.oR.moveToElementText(this.element);

        this.rangeData.text     = this.oS.text;
        this.rangeData.bookmark = this.oS.getBookmark();

        for(var i=0;this.oR.compareEndPoints('StartToStart', this.oS)<0&&this.oS.moveStart("character", -1)!==0;i++)
        {
//			if(this.element.value.charAt(i) == '\n')
//			{
//
//				i++;
//			}
        }

        this.rangeData.start = i;
        this.rangeData.end = this.rangeData.text.length + this.rangeData.start;
        return this.rangeData;
    }
}
/**
 * 微博at功能
 * @name at
 * @element, fnEnd 参数
 */
function at(element, fnEnd){
    _LZCreturn(element);
    return new _LZCAt(element, fnEnd);
}