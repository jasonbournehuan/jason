﻿$(function () {
    $(".loading").fadeOut(1e3,
    function () { })
});
var bgsound = document.getElementById("bgsound"),
kaisound = document.getElementById("kaisound"),
kaiing = bgsound,
ifopen = !1,
fun = {},
interInt = !1,
addint,
fillTime;
fun.createNum = function (e, n) {
    var t = n - e,
    u = Math.random();
    return e + Math.round(u * t)
},
fun.createArr = function () {
    for (var e = [], n = 0; n < 8; n++) {
        var t = fun.createNum(1, 20);
        if (0 != n) for (var u = 0,
        i = e.length - 1; u < e.length; u++) {
            if (t == e[u]) {
                n--;
                break
            }
            if (u == i) {
                e.push(t);
                break
            }
        } else e.push(t)
    }
    return e
},
fun.createtwoArr = function () {
    for (var e = [], n = [], t = 0; t < 20; t++) (n = []).push(fun.createNum(253, 255), fun.createNum(55, 274)),
    e.push(n);
    return e
},
fun.soundrevsion = function () {
    $("#btnsound").hasClass("off") || (kaiing.pause(), kaiing.play())
},
fun.ballStatic = function () {
    clearInterval(initf),
    kaiing.pause(),
    kaiing = bgsound,
    fun.soundrevsion();
    for (var e = fun.createtwoArr(), n = $(".move_ballUl>li"), t = 0; t < n.length; t++) $(n[t]).css({
        top: e[t][0] + "px",
        left: e[t][1] + "px",
        "z-index": fun.createNum(0, 20)
    })
};
var initf, moveIn = !1,
inttime = 10;
fun.moveBall = function () {
    $(".video_box .middle_box li").show(),
    clearInterval(initf),
    kaiing.pause(),
    kaiing = kaisound,
    fun.soundrevsion(),
    $(".result_box>ul").html("");
    var e = $(".move_ballUl>li");
    moveIn = !0,
    initf = setInterval(function () {
        for (var n = 0; n < e.length; n++) $(function () {
            var t = e[n];
            setTimeout(function () {
                var e = fun.createNum(0, 256),
                n = fun.createNum(0, 325);
                e < 10 ? n = fun.createNum(55, 255) : e < 15 && e > 10 ? n = fun.createNum(45, 300) : e < 20 && e > 10 ? n = fun.createNum(35, 295) : e < 25 && e > 15 ? n = fun.createNum(30, 300) : e < 30 && e > 20 ? n = fun.createNum(25, 305) : e < 45 && e > 30 ? n = fun.createNum(20, 315) : e < 55 && e > 45 ? n = fun.createNum(15, 320) : e < 70 && e > 55 ? n = fun.createNum(10, 325) : e < 90 && e > 70 ? n = fun.createNum(5, 325) : e < 110 && e > 90 ? n = fun.createNum(0, 325) : e < 130 && e > 110 ? n = fun.createNum(5, 325) : e < 150 && e > 130 ? n = fun.createNum(10, 325) : e < 165 && e > 150 ? n = fun.createNum(15, 325) : e < 175 && e > 165 ? n = fun.createNum(20, 325) : e < 190 && e > 175 ? n = fun.createNum(25, 315) : e < 200 && e > 190 ? n = fun.createNum(35, 310) : e < 210 && e > 200 ? n = fun.createNum(45, 300) : e < 220 && e > 200 ? n = fun.createNum(55, 290) : e > 220 && (n = fun.createNum(30, 290)),
                $(t).css({
                    top: e + "px",
                    left: n + "px",
                    "z-index": fun.createNum(0, 20)
                })
            },
            fun.createNum(100, 500))
        })
    },
    inttime)
},
fun.addresulthtml = function (e, n) {
    var t = e.length,
    u = "",
    i = 0,
    l = "blue";
    if ($(".result_box>ul").html(""), interInt) return clearInterval(addint),
    !1;
    addint = setInterval(function () {
        interInt = !0,
        l = 19 == e[i] || 20 == e[i] ? "red" : "blue",
        $("." + e[i]).hide(),
        e[i] < 10 ? e[i] = "0" + e[i] : e[i];
        var o = "<li class='ball small " + l + "'>" + e[i] + "</li>";
        n && (u += o),
        $(".result_box>ul").append(o),
        ++i >= t && (interInt = !1, clearInterval(addint)),
        setTimeout(function () {
            $(".small").removeClass("small")
        },
        100),
        n && 8 == i && $("#rethtml").html(u)
    },
    300)
},
fun.Trueresult = function (e) {
    fun.addresulthtml(e, !0),
    setTimeout(function () {
        $(".video_box .middle_box li").css("transition", "all 10ms"),
        clearInterval(initf),
        setTimeout(function () {
            fun.ballStatic(),
            $(".video_box .middle_box li").css("transition", "0"),
            moveIn = !1
        },
        500)
    },
    1e3)
};
var timer;
fun.cutTime = function (e, n) {
    console.log(e),
    null != timer && clearInterval(timer);
    var e = e;
    timer = setInterval(function () {
        if (e >= 1) {
            e -= 1;
            var t = Math.floor(e / 3600),
            u = Math.floor(e / 60 % 60),
            i = Math.floor(e % 60),
            l = "";
            if (l = (t < 10 ? "0" + t : t) + ":", l = l + "" + (u < 10 ? "0" + u : u) + ":" + (i < 10 ? "0" + i : i), $(".Time_box").text(l), e < 10) {
                var o = $(".linelist").find("li");
                $(o).eq(e).addClass("redli")
            }
        } else clearInterval(timer),
        $(".Time_box").hide(),
        $(".opening").show(),
        fun.moveBall(),
        setTimeout(pubmethod.doAjax(n.issue, n.lotCode, n.type, !1), "500")
    },
    1e3)
},
fun.clearTime = function () {
    clearInterval(timer)
},
fun.getSecond = function (e) {
    var n = e.split(":"),
    t = n[0],
    u = n[1],
    i = n[2];
    return 3600 * (t = t < 10 ? t.substring(t.length - 1, t.length) : t) + 60 * (u = u < 10 ? u.substring(u.length - 1, u.length) : u) + 1 * (i = i < 10 ? i.substring(i.length - 1, i.length) : i)
},
fun.fillHtml = function (e, n, t, u, i, l) {
    if (void 0 != i && (clearInterval(addint), clearTimeout(fillTime)), $(".result_box>ul").html(""), $(".Time_box").show(), $(".opening").hide(), $("#nextIssue").html(n), $("#nextOpTime").html(t), $("#thisIss").html(e), fun.cutTime(u, l), fun.ballStatic(), void 0 != i) {
        for (var o = "blue",
        a = "",
        r = 0; r < i.length; r++) o = 19 == i[r] || 20 == i[r] ? "red" : "blue",
        i[r] < 10 ? i[r] = "0" + i[r] : i[r],
        a += "<li class='ball " + o + "'>" + i[r] + "</li>";
        $("#rethtml").html(a),
        $(".result_box>ul").html(a)
    }
},
fun.onPcFillHtml = function (e, n, t, u) {
    if ($(".Time_box").hide(), $(".opening").show(), $("#nextIssue").html(n), $("#nextOpTime").html(t), $("#thisIss").html(e), void 0 != u) {
        for (var i = "blue",
        l = "",
        o = 0; o < u.length; o++) i = 19 == u[o] || 20 == u[o] ? "red" : "blue",
        u[o] < 10 ? u[o] = "0" + u[o] : u[o],
        l += "<li class='ball " + i + "'>" + u[o] + "</li>";
        $("#rethtml").html(l),
        $(".result_box>ul").html(l)
    }
},
fun.stateSound = function () {
    bgsound.play(),
    kaisound.play(),
    bgsound.pause(),
    kaisound.pause()
},
$(function () {
    bgsound = document.getElementById("bgsound"),
    kaisound = document.getElementById("kaisound"),
    kaiing = bgsound,
    $("#btnsound").on("click",
    function () {
        $(this).hasClass("off") ? (kaiing.play(), $(this).removeClass("off")) : (kaiing.pause(), $(this).addClass("off"))
    }),
    $(".kaiBtn").click(function () {
        if (moveIn) return !1;
        moveIn = !0,
        $(".video_box .middle_box li").show();
        var e = $(".result_box>ul").html();
        fun.moveBall(),
        setTimeout(function () {
            var e = fun.createArr();
            fun.addresulthtml(e)
        },
        3e3),
        setTimeout(function () {
            $(".video_box .middle_box li").css("transition", "all 10ms")
        },
        5e3),
        setTimeout(function () {
            clearInterval(initf),
            setTimeout(function () {
                fun.ballStatic(),
                setTimeout(function () {
                    $(".video_box .middle_box li").show(),
                    $(".result_box>ul").html(e),
                    $(".video_box .middle_box li").css("transition", "0"),
                    moveIn = !1
                },
                4e3)
            },
            500)
        },
        6e3)
    })
});