Do("editable-select", "datePicker", "validate",
    function() {
        function d(j, f, o, g) {
            var h = f || "",
                k = j || "",
                n = o || "",
                l = g || "",
                p = '<select id="' + h + '" name="' + h + '"class="basic-input editable-select ' + n + '" style="width:110px;">';
            p += '<option value="' + (l ? "开始": "结束") + '时间"' + (k ? "": "selected") + ">" + (l ? "开始": "结束") + "时间</option>";
            for (var m = 8; m < 24; m++) {
                var e = [];
                e.push(m < 10 ? "0" + m + ":00": m + ":00");
                e.push(m < 10 ? "0" + m + ":30": m + ":30");
                for (hhmm in e) {
                    if (e[hhmm] == k) {
                        p += '<option value="' + e[hhmm] + '" selected>' + e[hhmm] + "</option>"
                    } else {
                        p += '<option value="' + e[hhmm] + '">' + e[hhmm] + "</option>"
                    }
                }
            }
            for (var m = 0; m < 8; m++) {
                var e = [];
                e.push("0" + m + ":00");
                e.push("0" + m + ":30");
                for (hhmm in e) {
                    if (e[hhmm] == k) {
                        p += '<option value="' + e[hhmm] + '" selected>' + e[hhmm] + "</option>"
                    } else {
                        p += '<option value="' + e[hhmm] + '">' + e[hhmm] + "</option>"
                    }
                }
            }
            p += "</select>";
            return p
        }
        function a(i) {
            i.preventDefault();
            var h = $("#eventDateIntermHook .interm-item").length;
            if (h > 49) {
                return false
            } else {
                if (h == 49) {
                    $("#addEventDaysHook").parent().hide()
                }
            }
            var f = '<div class="inner-item interm-item hide"><input class="basic-input event_calendar interm_day" type="text" size="12"> <input type="hidden" class="editableHook" data-class="intermBeginTime" data-start="true"/> 至&nbsp;&nbsp; <input type="hidden" class="editableHook" data-class="intermEndTime"/> <a href="javascript:void(0);" class="btn-cancel">×</a></div>',
                g = $("#addEventDaysHook").parent();
            if (lowLevelBrowser) {
                $(f).insertBefore(g).show()
            } else {
                $(f).insertBefore(g).slideDown("fast")
            }
            c(g.parent())
        }
        function c(e) {
            e.find(".editableHook").each(function() {
                var j = $(this),
                    i = j.attr("data-time") || "",
                    l = j.attr("data-id") || "",
                    g = j.attr("data-class") || "",
                    k = j.attr("data-start") || "",
                    f = "";
                if (!j.data("beenInited")) {
                    f = d(i, l, g, k);
                    var h = $(f).insertBefore(j);
                    h.editableSelect({
                        bg_iframe: true,
                        item_then_scroll: 20
                    });
                    h.removeClass("intermBeginTime intermEndTime");
                    j.prev().trigger("blur");
                    j.data("beenInited", true)
                }
            });
            e.find(".event_calendar").each(function() {
                var f = $(this);
                if (!f.data("beenCalendared")) {
                    f.datepicker({
                        dateFormat: "yy-mm-dd",
                        dayNamesMin: ["日", "一", "二", "三", "四", "五", "六"],
                        monthNames: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
                        minDate: new Date(),
                        prevText: "<<",
                        nextText: ">>"
                    });
                    f.data("beenCalendared", true)
                }
            })
        }
        function b() {
            var o = $("#repeat_type").val(),
                i = [],
                f = [],
                l = '<div class="inner-item">';
            switch (o) {
                case "1":
                    l += $("#more_begin_day").val();
                    l += " 至 ";
                    l += $("#more_end_day").val();
                    l += " 每天 ";
                    l += $("#more_begin_time").val().match("时间") ? "": $("#more_begin_time").val();
                    l += " 至 ";
                    l += $("#more_end_time").val().match("时间") ? "": $("#more_end_time").val();
                    l += "</div>";
                    if ($("#more_begin_day").val()) {
                        $("#eventContinueDescHook").html(l)
                    }
                    break;
                case "2":
                    $("#week_mon").attr("checked") && (i.push("一"), f.push(1));
                    $("#week_tue").attr("checked") && (i.push("二"), f.push(2));
                    $("#week_wed").attr("checked") && (i.push("三"), f.push(3));
                    $("#week_thu").attr("checked") && (i.push("四"), f.push(4));
                    $("#week_fri").attr("checked") && (i.push("五"), f.push(5));
                    $("#week_sat").attr("checked") && (i.push("六"), f.push(6));
                    $("#week_sun").attr("checked") && (i.push("日"), f.push(7));
                    l += $("#week_begin_day").val();
                    l += " 至 ";
                    l += $("#week_end_day").val();
                    l += " 每" + (i.length == 7 ? "天": "周" + i.join("、")) + " ";
                    l += $("#week_begin_time").val().match("时间") ? "": $("#week_begin_time").val();
                    l += " 至 ";
                    l += $("#week_end_time").val().match("时间") ? "": $("#week_end_time").val();
                    l += "</div>";
                    $("#repeat_time").val(f.join(","));
                    if ($("#week_begin_day").val()) {
                        $("#eventWeekDescHook").html(l)
                    }
                    break;
                case "3":
                    var n = [],
                        m = [],
                        j = [],
                        k = "",
                        e = "",
                        g = "",
                        h = $("#eventDateIntermHook .interm-item");
                    $.each(h,
                        function(q, r) {
                            var p = $(r);
                            k = p.find(".interm_day").val();
                            e = p.find(".intermBeginTime").val().match("时间") ? "": p.find(".intermBeginTime").val();
                            g = p.find(".intermEndTime").val().match("时间") ? "": p.find(".intermEndTime").val();
                            if (k) {
                                m.push(k + " " + e + " 至 " + g)
                            }
                            n.push(k + " " + e + "~" + k + " " + g)
                        });
                    $.each(m,
                        function(p, q) {
                            l = '<div class="inner-item">';
                            l += q;
                            l += "</div>";
                            j.push(l)
                        });
                    $("#eventIntermDescHook").html(j.join(""));
                    $("#repeat_time").val(n.join("||"));
                    break;
                default:
                    return
            }
        }
        $("#addEventDaysHook").click(a);
        $("#eventDateIntermHook").delegate(".btn-cancel", "click",
            function(g) {
                g.preventDefault();
                var f = $("#eventDateIntermHook .interm-item").length - 1;
                if (f <= 49) {
                    $("#addEventDaysHook").parent().show()
                }
                if (lowLevelBrowser) {
                    $(this).parent().remove()
                } else {
                    $(this).parent().slideUp("fast",
                        function() {
                            $(this).remove()
                        })
                }
            });
        $("#eventTimeHook").delegate(".editable-select", "blur",
            function() {
                var e = $(this);
                if (e.val().match("时间")) {
                    e.addClass("hint")
                } else {
                    e.removeClass("hint")
                }
            });
        $("#repeat_type").bind("change",
            function() {
                var f = $(this).val(),
                    e = $(this).parent().next();
                if (!e.children().eq(f).is(":visible")) {
                    if (lowLevelBrowser) {
                        e.children().hide()
                    } else {
                        e.children().slideUp("fast")
                    }
                }
                if (lowLevelBrowser) {
                    e.children().eq(f).show()
                } else {
                    e.children().eq(f).slideDown("fast")
                }
                c(e.children().eq(f))
            });
        $("#repeat_type").trigger("change");
        $("body").click(b)
    });
Do(function() {
    $("#type").bind("change",
        function() {
            var b = $("#type").val();
            var c = "#subtype_" + b;
            var a = "";
            if ($(c).length) {
                a = $(c).html();
                $("#subtype").html(a).removeClass("hide")
            } else {
                $("#subtype").html("").addClass("hide")
            }
        })
});
Do(function(c) {
    $.fn.on = $.fn.on || $.fn.bind;
    var a = document.body;
    var d = {
        editable: true,
        handleParent: true
    };
    function b(e) {
        e = $.extend({},
            d, e);
        var g = $(e.trigger);
        if (!g[0]) {
            return
        }
        var l = g[0].tagName == "INPUT";
        var m = e.event || (l ? "focus": "click");
        var i = e.handleParent;
        var j = $(e.picker);
        var h = false;
        function n() {
            var o = g.offset();
            j.css({
                top: o.top + (e.offsetTop || 0),
                left: o.left + (e.offsetLeft || 0)
            })
        }
        function k() {
            var o = j[0].id || "";
            if (o.indexOf("html") == 0) {
                j = $(j.html()).appendTo(a);
                trigger_id = g[0].id;
                j[0].id = trigger_id + "-picker"
            }
            e.onInit && e.onInit(g, j);
            j.delegate("a", "click",
                function(r) {
                    var p = $(r.target);
                    var q = p.attr("data-value");
                    if (q) {
                        g.val(p.text());
                        r.preventDefault();
                        r.stopPropagation();
                        e.onChange && e.onChange(q, g, j);
                        j.hide()
                    }
                });
            n();
            h = true
        }
        g.on(m,
            function(o) {
                if (!h) {
                    return k()
                }
                if (e.repos) {
                    n()
                }
                if (o.type == "click") {
                    j.toggle()
                } else {
                    j.show()
                }
            });
        if (l) {
            g.on("propertychange",
                function(o) {
                    if (o.originalEvent.propertyname == "value") {
                        o.preventDefault()
                    }
                });
            g.on("input keydown",
                function(p) {
                    var o = p.keyCode;
                    if (o == 9) {
                        return j.hide()
                    }
                    if (o == 39 || o == 40) {
                        j.show().find("a").eq(0).focus()
                    }
                    if (!e.editable) {
                        p.preventDefault()
                    }
                })
        }
        var f = g[0];
        f = f && f.parentNode;
        $(a).click(function(q) {
            var p = q.target;
            var o = true;
            while (p) {
                if (p == j[0]) {
                    o = false;
                    break
                }
                if (i && p == f) {
                    if (h) {
                        return j.show()
                    }
                    return k()
                }
                p = p.parentNode
            }
            if (o) {
                j.hide()
            }
        });
        return [g, j]
    }
    Do.DropInput = b
});
var pinicon = window._pinicon_;

Do(function() {

    var p = $("#loc_id").val();
    var a = $("#city");
    var c = a.val();

    var k = Do.updateCity = function(t, r, q) {
//        alert(1);
        $("#loc_id").val(t);
    };

    var h = Do.DropInput({
        picker: "#html-citypicker",
        pickerClass: "inp_loc_name-picker",
        offsetTop: 36,
        onChange: function(q) {
            if (q == p) {
                return
            }
            p = q;
            $("#loc_id").val(q);
        },
        onInit: function(s, r) {
//            console.log(r);
            var t = r.find("span.tab");
            var q = r.find("div.bd");
            t.click(function(v) {
                var u = t.index(this);
                t.removeClass("on").eq(u).addClass("on");
                q.hide().eq(u).show()
            })
        },
        trigger: a
    });


});
Do(function() {
    var a = /{(.+?)}/g;
    $.substitute = function(c, b) {
        return c.replace(a,
            function(e, d) {
                return typeof b[d] === "undefined" ? "": b[d]
            })
    }
});

Do(function() {
    var g = $("#active_fee");
    var a = $("#addFeeHook");
    var d = $("#tickets_field");
    function i() {
        var j = $("#active_fee .fee_item"),
            k = [];
        j.each(function(l, m) {
            var n = [];
            $(m).find("input").each(function(p, o) {
                if (p == 1 && $.trim(o.value)) {
                    n.push($.trim(o.value))
                } else {
                    if (p == 0) {
                        n.push($.trim(o.value))
                    }
                }
            });
            if (n.length > 1) {
                k.push(n.join("=="))
            }
        });
        $("#fee_detail").val(k.join("||"))
    }
    function f(l, m, k) {
        var j = '<div class="con_item fee_item hide">',
            l = l || "",
            m = m || "";
        j += '<input type="text" class="basic-input fee-name" placeholder="选填" value="' + l + '" maxlength="15"/> ';
        j += '<input type="text" class="basic-input fee-num" value="' + m + '" maxlength="6"/>';
        if (! (k && k == 1)) {
            j += '<a href="javascript:void(0);" class="btn-cancel">×</a>'
        }
        j += "</div>";
        return j
    }
    function e(j) {
        j.preventDefault();
        if (lowLevelBrowser) {
            $(j.target).parent().remove()
        } else {
            $(j.target).parent().slideUp("fast",
                function() {
                    $(this).remove()
                })
        }
        i();
        if ($(".active_fee .fee_item").length < 10) {
            a.show()
        }
    }
    function b(k) {
        var j = a.parent().find(".fee_item").length;
        if (j < 10) {
            if (lowLevelBrowser) {
                $(f()).insertBefore(a).show()
            } else {
                $(f()).insertBefore(a).slideDown("fast")
            }
            if (j == 9) {
                a.hide()
            }
        }
        k.preventDefault()
    }
    function h() {
        var j = $(this).val();
        if (j == 1) {
            d.addClass("hide");
            if (lowLevelBrowser) {
                g.removeClass("hide")
            } else {
                g.slideDown("fast")
            }
        } else {
            if (j == 2) {
                g.hide();
                if (lowLevelBrowser) {
                    d.removeClass("hide")
                } else {
                    d.slideDown("fast")
                }
            } else {
                if (lowLevelBrowser) {
                    g.addClass("hide");
                    d.addClass("hide")
                } else {
                    g.slideUp("fast");
                    d.slideUp("fast")
                }
            }
        }
    }
    $(':input[name="fee"]').click(h);
    $(':input[name="fee"][checked]').trigger("click");
    if ($("#fee_detail").val()) {
        $("#active_fee .fee_item").remove();
        var c = $("#fee_detail").val().split("||");
        $.each(c,
            function(k, m) {
                if (k < 10) {
                    var o = m.split("=="),
                        l = o[0] || "",
                        n = o[1] || "",
                        j = f(l, n, k + 1);
                    $(j).insertBefore(a)
                }
            });
        $("#active_fee .fee_item").removeClass("hide");
        if (c.length > 9) {
            a.hide()
        }
    }
    $("#active_fee").delegate(".btn-cancel", "click", e);
    a.click(b);
    $("#activeFeeHook").delegate("#active_fee input", "change", i)
});

Do("validate", "editable-select",
    function() {
        function k(C, z) {
            var A = $(C).val().split("-");
            var B = $(z).val().split(":");
            return new Date(A[0], A[1] - 1, A[2], B[0], B[1])
        }
        function d(B) {
            var A = $("#repeat_type").val();
            if (B != A) {
                return false
            } else {
                switch (B) {
                    case 0:
                        return ! $.trim($("#one_begin_day").val());
                        break;
                    case 1:
                        return ! $.trim($("#more_begin_day").val());
                        break;
                    case 2:
                        return ! $.trim($("#week_begin_day").val());
                        break;
                    case 3:
                        var z = false;
                        $("#eventDateIntermHook .interm_day").each(function(D, E) {
                            var C = $(E);
                            if (!$.trim(C.val())) {
                                z = true
                            }
                        });
                        return z;
                        break;
                    default:
                        return true
                }
            }
        }
        function i(C) {
            var A = $("#repeat_type").val(),
                B = "",
                z = false;
            if (C != A) {
                return false
            } else {
                switch (C) {
                    case 0:
                        B = $.trim($("#one_begin_time").val());
                        if (!B || B.match("时间")) {
                            z = true
                        }
                        return z;
                        break;
                    case 1:
                        B = $.trim($("#more_begin_time").val());
                        if (!B || B.match("时间")) {
                            z = true
                        }
                        return z;
                        break;
                    case 2:
                        B = $.trim($("#week_begin_time").val());
                        if (!B || B.match("时间")) {
                            z = true
                        }
                        return z;
                        break;
                    case 3:
                        $("#eventDateIntermHook .intermBeginTime").each(function(D, E) {
                            B = $(E).val();
                            if (!B || B.match("时间")) {
                                z = true
                            }
                        });
                        return z;
                        break;
                    default:
                        return true
                }
            }
        }
        function a(D) {
            var B = $("#repeat_type").val(),
                z = /^(\d{1,2}):(\d{1,2})$/,
                C = "",
                A = false;
            if (D != B) {
                return false
            } else {
                switch (D) {
                    case 0:
                        C = $.trim($("#one_begin_time").val());
                        return ! z.test(C);
                        break;
                    case 1:
                        C = $.trim($("#more_begin_time").val());
                        return ! z.test(C);
                        break;
                    case 2:
                        C = $.trim($("#week_begin_time").val());
                        return ! z.test(C);
                        break;
                    case 3:
                        $("#eventDateIntermHook .intermBeginTime").each(function(E, F) {
                            C = $(F).val();
                            if (!z.test(C)) {
                                A = true
                            }
                        });
                        return A;
                        break;
                    default:
                        return true
                }
            }
        }
        function g(A) {
            var z = $("#repeat_type").val();
            if (A != z) {
                return false
            } else {
                switch (A) {
                    case 1:
                        return ! $.trim($("#more_end_day").val());
                        break;
                    case 2:
                        return ! $.trim($("#week_end_day").val());
                        break;
                    default:
                        return true
                }
            }
        }
        function t(C) {
            var A = $("#repeat_type").val(),
                B = "",
                z = false;
            if (C != A) {
                return false
            } else {
                switch (C) {
                    case 0:
                        B = $.trim($("#one_end_time").val());
                        if (!B || B.match("时间")) {
                            z = true
                        }
                        return z;
                        break;
                    case 1:
                        B = $.trim($("#more_end_time").val());
                        if (!B || B.match("时间")) {
                            z = true
                        }
                        return z;
                        break;
                    case 2:
                        B = $.trim($("#week_end_time").val());
                        if (!B || B.match("时间")) {
                            z = true
                        }
                        return z;
                        break;
                    case 3:
                        $("#eventDateIntermHook .intermEndTime").each(function(D, E) {
                            B = $(E).val();
                            if (!B || B.match("时间")) {
                                z = true
                            }
                        });
                        return z;
                        break;
                    default:
                        return true
                }
            }
        }
        function m(D) {
            var B = $("#repeat_type").val(),
                z = /^(\d{1,2}):(\d{1,2})$/,
                C = "",
                A = false;
            if (D != B) {
                return false
            } else {
                switch (D) {
                    case 0:
                        C = $.trim($("#one_end_time").val());
                        return ! z.test(C);
                        break;
                    case 1:
                        C = $.trim($("#more_end_time").val());
                        return ! z.test(C);
                        break;
                    case 2:
                        C = $.trim($("#week_end_time").val());
                        return ! z.test(C);
                        break;
                    case 3:
                        $("#eventDateIntermHook .intermEndTime").each(function(E, F) {
                            C = $(F).val();
                            if (!z.test(C)) {
                                A = true
                            }
                        });
                        return A;
                        break;
                    default:
                        return true
                }
            }
        }
        function o(B) {
            var A = $("#repeat_type").val(),
                z = false;
            if (B != A) {
                return false
            } else {
                switch (B) {
                    case 0:
                        return k("#one_begin_day", "#one_begin_time") > new Date((new Date()).getTime() + 3 * 30 * 24 * 60 * 60 * 1000);
                        break;
                    case 1:
                        return k("#more_begin_day", "#more_begin_time") > new Date((new Date()).getTime() + 3 * 30 * 24 * 60 * 60 * 1000);
                        break;
                    case 2:
                        return k("#week_begin_day", "#week_begin_time") > new Date((new Date()).getTime() + 3 * 30 * 24 * 60 * 60 * 1000);
                        break;
                    case 3:
                        $("#eventDateIntermHook .interm-item").each(function(D, E) {
                            var C = $(E);
                            if (k(C.find(".interm_day"), C.find(".intermBeginTime")) > new Date((new Date()).getTime() + 3 * 30 * 24 * 60 * 60 * 1000)) {
                                z = true
                            }
                        });
                        return z;
                        break;
                    default:
                        return true
                }
            }
        }
        function c(D) {
            var B = $("#repeat_type").val(),
                A = false,
                C,
                z;
            if (D != B) {
                return false
            } else {
                switch (D) {
                    case 0:
                        C = k("#one_begin_day", "#one_begin_time");
                        z = k("#one_begin_day", "#one_end_time");
                        return z <= C;
                        break;
                    case 1:
                        C = k("#more_begin_day", "#more_begin_time");
                        z = k("#more_begin_day", "#more_end_time");
                        return z <= C;
                        break;
                    case 2:
                        C = k("#week_begin_day", "#week_begin_time");
                        z = k("#week_begin_day", "#week_end_time");
                        return z <= C;
                        break;
                    case 3:
                        $("#eventDateIntermHook .interm-item").each(function(F, G) {
                            var E = $(G);
                            C = k(E.find(".interm_day"), E.find(".intermBeginTime"));
                            z = k(E.find(".interm_day"), E.find(".intermEndTime"));
                            if (z <= C) {
                                A = true
                            }
                        });
                        return A;
                        break;
                    default:
                        return true
                }
            }
        }
        function u(C) {
            var A = $("#repeat_type").val(),
                B,
                z;
            if (C != A) {
                return false
            } else {
                switch (C) {
                    case 1:
                        B = k("#more_begin_day", "#more_begin_time");
                        z = k("#more_end_day", "#more_begin_time");
                        return z < B;
                        break;
                    case 2:
                        B = k("#week_begin_day", "#week_begin_time");
                        z = k("#week_end_day", "#week_begin_time");
                        return z < B;
                        break;
                    default:
                        return true
                }
            }
        }
        function f(D) {
            var A = $("#repeat_type").val(),
                C,
                z;
            if (D != A) {
                return false
            } else {
                switch (D) {
                    case 1:
                        C = k("#more_begin_day", "#more_begin_time");
                        z = k("#more_end_day", "#more_begin_time");
                        return z > new Date(C.getTime() + 3 * 30 * 24 * 60 * 60 * 1000);
                        break;
                    case 2:
                        C = k("#week_begin_day", "#week_begin_time");
                        z = k("#week_end_day", "#week_begin_time");
                        return z > new Date(C.getTime() + 3 * 30 * 24 * 60 * 60 * 1000);
                        break;
                    case 3:
                        var B = [];
                        $("#eventDateIntermHook .interm-item").each(function(F, G) {
                            var E = $(G);
                            B.push(k(E.find(".interm_day"), E.find(".intermEndTime")).getTime())
                        });
                        B.sort();
                        return ((B[B.length - 1] - B[0]) > 3 * 30 * 24 * 60 * 60 * 1000);
                        break;
                    default:
                        return true
                }
            }
        }
        function h(B) {
            var A = $("#repeat_type").val(),
                z = false;
            if (B != A) {
                return false
            } else {
                switch (B) {
                    case 0:
                        return k("#one_begin_day", "#one_begin_time") < new Date();
                        break;
                    case 1:
                        return k("#more_begin_day", "#more_begin_time") < new Date();
                        break;
                    case 2:
                        return k("#week_begin_day", "#week_begin_time") < new Date();
                        break;
                    case 3:
                        $("#eventDateIntermHook .interm-item").each(function(D, E) {
                            z = true;
                            var C = $(E);
                            if (k(C.find(".interm_day"), C.find(".intermEndTime")) > new Date()) {
                                z = false
                            }
                        });
                        return z;
                        break;
                    default:
                        return true
                }
            }
        }
        function y() {
            var z = $("#repeat_type").val();
            if (z != 2) {
                return false
            } else {
                return ! $("#eventDateWeekHook .week-label input:checked").length
            }
        }
        function w() {
            var z = false;
            if ($("#eform input[name=fee]:checked").val() == "1") {
                $.each($("#eform .fee-num"),
                    function(A, B) {
                        if (!$(B).val()) {
                            z = true
                        }
                    })
            }
            return z
        }
        function x() {
            var z = false;
            if ($("#eform input[name=fee]:checked").val() == "1") {
                $.each($("#eform .fee-num"),
                    function(A, B) {
                        if (!/\d+/.test($(B).val())) {
                            z = true
                        }
                    })
            }
            return z
        }
        function s(C) {
            var z = $("#repeat_type").val(),
                B = $("#begin_date"),
                D = $("#begin_time"),
                E = $("#end_date"),
                F = $("#end_time"),
                A = $("#repeat_time");
            if (C != z) {
                return false
            } else {
                B.val();
                D.val();
                E.val();
                F.val();
                A.val();
                switch (C) {
                    case 0:
                        B.val($("#one_begin_day").val());
                        D.val($("#one_begin_time").val());
                        E.val($("#one_begin_day").val());
                        F.val($("#one_end_time").val());
                        break;
                    case 1:
                        B.val($("#more_begin_day").val());
                        D.val($("#more_begin_time").val());
                        E.val($("#more_end_day").val());
                        F.val($("#more_end_time").val());
                        break;
                    case 2:
                        B.val($("#week_begin_day").val());
                        D.val($("#week_begin_time").val());
                        E.val($("#week_end_day").val());
                        F.val($("#week_end_time").val());
                        $("body").trigger("click");
                        break;
                    case 3:
                        $("body").trigger("click");
                        break
                }
            }
        }
        var e = $("#type");
        var r = $("#loc_id");
        var n = $("#district_id");
        var p = $("#street_address");
        var b = {
            loc: "城市名",
            street_address: "详细地址",
            tags: "多个标签用空格区分"
        };
        var v = {
            title: {
                isNull: "请输入活动标题",
                tooLong: "最多30个汉字"
            },
            type: {
                isNull: "请选择活动类型"
            },
            subtype: {
                isNull: "请选择活动子类型"
            },
            oneDayTime: {
                begin_day_isNull: "请输入开始日期",
                begin_time_isNull: "请选择开始时间",
                begin_time_invalidFormat: "请输入正确的开始时间",
                end_time_isNull: "请输入结束时间",
                end_time_invalidFormat: "请输入正确的结束时间",
                start_end_time: "结束时间不能早于起始时间"
            },
            continueTime: {
                begin_day_isNull: "请输入开始日期",
                begin_time_isNull: "请选择开始时间",
                begin_time_invalidFormat: "请输入正确的开始时间",
                end_day_isNull: "请输入结束日期",
                end_time_isNull: "请输入结束时间",
                end_time_invalidFormat: "请输入正确的结束时间",
                start_end_date: "结束日期不能早于起始日期",
                start_end_time: "结束时间不能早于起始时间",
                last_three_months: "活动持续时间不能大于3个月"
            },
            weekTime: {
                begin_day_isNull: "请输入开始日期",
                begin_time_isNull: "请选择开始时间",
                begin_time_invalidFormat: "请输入正确的开始时间",
                end_day_isNull: "请输入结束日期",
                end_time_isNull: "请输入结束时间",
                end_time_invalidFormat: "请输入正确的结束时间",
                start_end_date: "结束日期不能早于起始日期",
                start_end_time: "结束时间不能早于起始时间",
                last_three_months: "活动持续时间不能大于3个月",
                select_week_day: "请至少选择周内的一天"
            },
            intermTime: {
                begin_day_isNull: "请输入开始日期",
                begin_time_isNull: "请选择开始时间",
                begin_time_invalidFormat: "请输入正确的开始时间",
                end_time_isNull: "请输入结束时间",
                end_time_invalidFormat: "请输入正确的结束时间",
                start_end_time: "结束时间不能早于起始时间",
                last_three_months: "活动持续时间不能大于3个月",
                has_started: "活动结束时间已过"
            },
            address: {
                loc_id_isNull: "请输入城市",
                street_address_isNull: "请输入具体地址"
            },
            coordinate: {
                mapIsNull: "请标记地图"
            },
            desc: {
                isNull: "请输入简介",
                tooLong: "最多4000个汉字"
            },
            feeNum: {
                isNull: "请填写价格",
                notNumber: "价格必须是数字"
            },
            feeValue: {
                isNull: "请设置活动费用"
            },
            tags: {
                tooLong: "最多100个字符"
            }
        };
        var l = {
            title: {
                elems: "#title",
                isNull: function(z) {
                    return ! $.trim(z.val())
                },
                tooLong: function(z) {
                    return $.trim(z.val()).length > 64
                }
            },
            type: {
                elems: "#type",
                isNull: function(z) {
                    return z.val() == 0
                }
            },
            subtype: {
                elems: "#subtype",
                isNull: function(B) {
                    var A = $("#type").val();
                    var z = "#subtype_" + A;
                    if ($(z).length) {
                        return B.val() == 0
                    } else {
                        return false
                    }
                }
            },
            oneDayTime: {
                elems: "#one_end_time",
                begin_day_isNull: function() {
                    return d(0)
                },
                begin_time_isNull: function() {
                    return i(0)
                },
                begin_time_invalidFormat: function() {
                    return a(0)
                },
                end_time_isNull: function() {
                    return t(0)
                },
                end_time_invalidFormat: function() {
                    return m(0)
                },
                start_end_time: function() {
                    return c(0)
                },
                writeData: function() {
                    s(0);
                    return false
                }
            },
            continueTime: {
                elems: "#more_end_time",
                begin_day_isNull: function() {
                    return d(1)
                },
                begin_time_isNull: function() {
                    return i(1)
                },
                begin_time_invalidFormat: function() {
                    return a(1)
                },
                end_day_isNull: function() {
                    return g(1)
                },
                end_time_isNull: function() {
                    return t(1)
                },
                end_time_invalidFormat: function() {
                    return m(1)
                },
                start_end_date: function() {
                    return u(1)
                },
                start_end_time: function() {
                    return c(1)
                },
                last_three_months: function() {
                    return f(1)
                },
                writeData: function() {
                    s(1);
                    return false
                }
            },
            weekTime: {
                elems: "#week_end_time",
                begin_day_isNull: function() {
                    return d(2)
                },
                begin_time_isNull: function() {
                    return i(2)
                },
                begin_time_invalidFormat: function() {
                    return a(2)
                },
                end_day_isNull: function() {
                    return g(2)
                },
                end_time_isNull: function() {
                    return t(2)
                },
                end_time_invalidFormat: function() {
                    return m(2)
                },
                start_end_date: function() {
                    return u(2)
                },
                start_end_time: function() {
                    return c(2)
                },
                last_three_months: function() {
                    return f(2)
                },
                select_week_day: function() {
                    return y()
                },
                writeData: function() {
                    s(2);
                    return false
                }
            },
            intermTime: {
                elems: '#eventDateIntermHook .intermEndTime:input[type="text"]',
                begin_day_isNull: function() {
                    return d(3)
                },
                begin_time_isNull: function() {
                    return i(3)
                },
                begin_time_invalidFormat: function() {
                    return a(3)
                },
                end_time_isNull: function() {
                    return t(3)
                },
                end_time_invalidFormat: function() {
                    return m(3)
                },
                start_end_time: function() {
                    return c(3)
                },
                has_started: function() {
                    return h(3)
                },
                last_three_months: function() {
                    return f(3)
                },
                writeData: function() {
                    s(3);
                    return false
                }
            },
            address: {
                elems: "#street_address",
                loc_id_isNull: function() {
                    var z = $("#sel-address-type1");
                    if (z.length > 0 && !z[0].checked) {
                        return
                    }
                    return ! $.trim(r.val())
                },
                street_address_isNull: function() {
                    var z = $("#sel-address-type1");
                    if (z.length > 0 && !z[0].checked) {
                        return
                    }
                    return ! $.trim(p.val())
                }
            },
            coordinate: {
                elems: "#coordinate",
                mapIsNull: function() {
                    return ! $.trim($("#coordinate").val())
                }
            },
            desc: {
                elems: "#desc",
                isNull: function(z) {
                    return ! $.trim(z.val())
                },
                tooLong: function(z) {
                    return z.val().length > 4000
                }
            },
            feeNum: {
                elems: ".fee-num",
                isNull: function() {
                    return w()
                },
                notNumber: function() {
                    return x()
                }
            },
            feeValue: {
                elems: ".fee-value",
                isNull: function() {
                    return ! $("#eform input[name=fee]:checked").length
                }
            },
            tags: {
                elems: "#tags",
                tooLong: function(z) {
                    return z.val().length > 100
                }
            }
        };
        var j = {
            callback: function(z) {
                var A = $("#submit_form").val();
                $("#submit_form").val("正在提交，请稍候...").unbind("click");
                $.post("http://121.199.30.154/wsq_t/upload/plugin.php?id=mrbear_cityactive:post", $(z).serialize(),
                    function(B) {
                        if (B.status) {

                            $(window).unbind();
                            alert('创建成功');
                            window.loction.href = window.loction.href;
                        } else {
                            if (B.msg) {
                                alert(B.msg);
                            } else {
                                alert("创建失败，请正确填写各项内容");
                            }
                            $("#submit_form").val(A).bind("click", q);
                        }
                    },"json")
            }
        };
        $("#eform").bind("hasError",
            function() {
                var z = $(this);
                if (z.find(".has-error").length > 0) {
                    $("html, body").animate({
                        scrollTop: z.find(".has-error:first").offset().top
                    });
                    return;
                }
            }).validateForm(l, v, b, j);
        function q() {
            $("body").trigger("click");
            $("#eform").trigger("submit");
        }
        $("#submit_form").bind("click", q);
        $("#cancel_form").click(function() {
            history.go( - 1);
        })
    });