﻿$(function () {
    $(".animate").find(".loading").fadeOut(1e3,
    function () { }),
    $(".kuai3Animate").on("click", ".kaimodule",
    function () {
        k3v.tryPlay()
    }),
    $("#soundBtn").on("click", "#spanbtn",
    function () {
        document.getElementById("audio");
        "sounds" == $("#spanbtn").attr("class") ? ($("#soundBtn").children().removeClass("sounds").addClass("sounds2"), k3v.sound.stop("")) : ($("#soundBtn").children().removeClass("sounds2").addClass("sounds"), k3v.sound.play("all"))
    })
});
var k3v = {},
tryflag = !0,
timer = null,
ifpaused = "",
animateId = {};
k3v.startGame = function (t) {
    var e = this;
    e.codePlay = function () {
        var t = $("#code").find("li");
        e.run(2, "80", "0", t),
        e.run(5, "80", "1", t),
        e.run(8, "80", "2", t)
    },
    e.run = function (t, e, n, a) {
        var i = setInterval(function () {
            $(a).eq(n).attr("class", "k3v0" + t),
            ++t >= 8 && (t = 1)
        },
        e);
        animateId[n] = i
    },
    t && e.codePlay(),
    $(".linelist").find("li").addClass("redli"),
    ifpaused = "audioidB",
    $("#spanbtn").hasClass("sounds") && k3v.sound.play("audioidR"),
    k3v.bressBG(10)
},
k3v.stopGame = function (t) {
    this.stop = function (t, e) {
        setTimeout(function () {
            clearInterval(animateId[t]);
            var n = $("#code").find("li");
            $(n).eq(t).attr("class", "k3v" + e)
        },
        800 * t)
    };
    for (var e = 0; e < 3; e++) this.stop(e, t[e])
};
var trytime = [];
k3v.tryPlay = function () {
    var t = [];
    if (tryflag) {
        $("#timetitle").text("模拟开奖"),
        $("#hourtxt").hide(),
        $("#opening").show(),
        tryflag = !1,
        k3v.startGame(!0);
        var e = setTimeout(function () {
            for (var n = 0; n < 3; n++) t.push(Math.round(5 * Math.random() + 1));
            k3v.stopGame(t);
            var a = setTimeout(function () {
                for (var t = $("#codetop").find("li"), e = [], n = 0, a = t.length; n < a; n++) e.push($(t).eq(n).text());
                k3v.stopGame(e),
                setTimeout(function () {
                    tryflag = !0
                },
                3e3)
            },
            8e3),
            i = setTimeout(function () {
                $("#timetitle").text("倒计时"),
                $("#hourtxt").show(),
                $("#opening").hide();
                var t = $("#hourtxt").text().split(":"),
                e = t[0],
                n = t[1],
                a = t[2],
                i = 3600 * (e = e < 10 ? e.substring(e.length - 1, e.length) : e) + 60 * (n = n < 10 ? n.substring(n.length - 1, n.length) : n) + 1 * (a = a < 10 ? a.substring(a.length - 1, a.length) : a);
                k3v.cutTime(i),
                ifpaused = "audioidB",
                $("#spanbtn").hasClass("sounds") && k3v.sound.play("audioidB"),
                k3v.bressBG()
            },
            2e3);
            trytime.push(e),
            trytime.push(a),
            trytime.push(i)
        },
        5e3)
    } else $(".noinfor").fadeIn(200, "",
    function () {
        setTimeout(function () {
            $(".noinfor").fadeOut("300")
        },
        1e3)
    })
},
k3v.playGame = function () {
    k3v.startGame(!0)
},
k3v.updateData = function (t) {
    var e = t.preDrawCode,
    n = ($("#num1").text(e[0]), $("#num2").text(e[1]), $("#num3").text(e[2]), $("#sumNum").text(t.sumNum), $("#sumBigSmall").text(k3v.sumBigSmall(t.sumNum)), $("#drawIssue").text(t.drawIssue), t.preDrawIssue.toString().slice(-3));
    $(".nowDraw").text(n);
    if (void 0 != t.drawTime) a = t.drawTime.substr(t.drawTime.length - 8, 8);
    else var a = "";
    $("#drawTime").text(a)
},
k3v.cutTime = function (t, e, qishu) {
    null != timer && clearInterval(timer);
    var t = t;
    timer = setInterval(function () {
        if (t >= 1) {
            t -= 1;
            var n = Math.floor(t / 3600),
            a = Math.floor(t / 60 % 60),
            i = Math.floor(t % 60),
            s = "";
            if (s = (n < 10 ? "0" + n : n) + ":", s = s + "" + (a < 10 ? "0" + a : a) + ":" + (i < 10 ? "0" + i : i), $("#hourtxt").text(s), t < 10) {
                var o = $(".linelist").find("li");
                $(o).eq(t).addClass("redli")
            }
            t < 20 && (tryflag = !1, $(".noinfor").text("即将开奖，禁止模拟"))
        } else $(".noinfor").text("正在开奖，禁止模拟"),
        clearInterval(timer),
        k3v.playGame(),
        $("#timetitle").text("正在开奖"),
        $("#hourtxt").hide(),
        $("#opening").show(),
        setTimeout(pubmethod.doAjax(qishu, e.lotCode, e.type, !1), "500")
    },
    1e3)
},
k3v.sound = {
    play: function (t) {
        "sounds" == $("#spanbtn").attr("class") && ("all" == t ? document.getElementById(ifpaused).play() : (document.getElementById("audioidB").pause(), document.getElementById("audioidR").pause(), document.getElementById(t).play()))
    },
    stop: function (t) {
        var e = document.getElementById("audioidB");
        ifpaused = e.paused ? "audioidR" : "audioidB",
        document.getElementById("audioidB").pause(),
        document.getElementById("audioidR").pause()
    }
},
k3v.stopVideo = function (t, e,qishu) {
    k3v.stopGame(t.preDrawCode),
    k3v.updateData(t),
    setTimeout(function () {
        $("#timetitle").text("倒计时"),
        $("#hourtxt").fadeIn(),
        $("#opening").hide(),
        $(".linelist").find("li").removeClass("redli"),
        k3v.cutTime(t.seconds, e, qishu),
        ifpaused = "audioidB",
        $("#spanbtn").hasClass("sounds") && k3v.sound.play("audioidB"),
        k3v.bressBG(),
        tryflag = !0
    },
    2e3)
},
k3v.bressBG = function (t) {
    var e = 1,
    n = !1;
    void 0 != animateId.bressBG && clearInterval(animateId.bressBG),
    void 0 == t && (t = 80);
    var a = setInterval(function () {
        $(".bodybg").find("img").stop().animate({
            opacity: "0." + e
        },
        t),
        n ? (e -= 1) < 1 && (n = !1) : (e += 1) > 8 && (n = !0)
    },
    t);
    animateId.bressBG = a
},
k3v.sumBigSmall = function (t) {
    return t <= 10 ? "小" : "大"
};