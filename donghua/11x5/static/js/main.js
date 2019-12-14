﻿function addTime(e) {
    var n = (e = e.split(" ")[1]).split(":"),
    a = n[0],
    t = n[1],
    i = n[2];
    return 3600 * (a = a < 10 ? a.substring(a.length - 1, a.length) : a) + 60 * (t = t < 10 ? t.substring(t.length - 1, t.length) : t) + 1 * (i = i < 10 ? i.substring(i.length - 1, i.length) : i)
}
$(function () {
    $(".eleAnimate").on("click", "#mnKai",
    function () {
        k3v.tryPlay()
    }),
    $(".drawInfo").on("click", "#spanbtn",
    function () {
        "soundsOn" == $("#spanbtn").attr("class") ? ($("#spanbtn").removeClass("soundsOn").addClass("soundsOff"), k3v.sound.stop("audioidB"), k3v.sound.stop("audioidR")) : ($("#spanbtn").removeClass("soundsOff").addClass("soundsOn"), "b" == audioType ? (k3v.sound.play("audioidB"), k3v.sound.stop("audioidR")) : (k3v.sound.play("audioidR"), k3v.sound.stop("audioidB")))
    }),
    k3v.btnStyle()
});
var k3v = {},
tryflag = !0,
timer = null,
audioType = "b",
firth11Load = !0,
ifopen = !0,
animateId = {},
dataStr = {
    preDrawCode: [2, 4, 6, 4, 5],
    sumNum: 12,
    sumBigSmall: "小",
    sumSingleDouble: "单",
    drawIssue: "170517061",
    preDrawTime: "2017-05-17 18:40:00"
};
k3v.startGame = function (e) {
    var n = this;
    n.codePlay = function () {
        var e = $(".codeNum").find("li");
        n.run(-154, 6, "0", e),
        n.run(-1370, 4, "1", e),
        n.run(-762, 10, "2", e),
        n.run(-1522, 5, "3", e),
        n.run(-2, 7, "4", e)
    },
    n.run = function (e, n, a, t) {
        var i = setInterval(function () {
            $(t).eq(a).css("backgroundPositionY", e + "px"),
            (e += n) >= -2 && (e = -1522)
        },
        n);
        animateId[a] = i
    },
    e && n.codePlay(),
    $(".linelist").find("li").addClass("redli"),
    k3v.sound.stop("audioidB"),
    k3v.sound.play("audioidR"),
    audioType = "r",
    k3v.bressBG(10)
},
k3v.stopGame = function (e, n) {
    this.stop = function (e, a) {
        if ("1" == n) setTimeout(function () {
            clearInterval(animateId[e]);
            var n = $(".codeNum").find("li");
            $(n).eq(e).removeAttr("style"),
            $(n).eq(e).removeClass().addClass("num" + a)
        },
        400 * e);
        else if ("2" == n) {
            clearInterval(animateId[e]);
            var t = $(".codeNum").find("li");
            $(t).eq(e).removeAttr("style"),
            $(t).eq(e).removeClass().addClass("num" + a)
        }
    };
    for (var a = 0; a < 5; a++) this.stop(a, 1 * e[a]);
    audioType = "b",
    k3v.sound.play("audioidB"),
    k3v.sound.stop("audioidR")
};
var trytime = [];
k3v.btnStyle = function () {
    $(".animate").on("mousedown", "#mnKai",
    function () {
        $("#mnKai").addClass("mnKaiD")
    }),
    $(".animate").on("mouseup", "#mnKai",
    function () {
        $("#mnKai").removeClass("mnKaiD")
    })
},
k3v.tryPlay = function () {
    var e = [],
    n = $(".animate");
    if (tryflag) {
        $(n).find("#opening").text("模拟开奖中..."),
        $(".noinfor").text("模拟中..."),
        $("#hourtxt").hide(),
        $("#opening").show(),
        tryflag = !1,
        k3v.startGame(!0);
        var a = setTimeout(function () {
            for (var n = 0; n < 5; n++) e.push(Math.round(5 * Math.random() + 1));
            k3v.stopGame(e, "1");
            var t = null;
            $("#hourtxt").fadeIn(),
            $("#opening").hide(),
            void 0 != animateId.bressBG && (clearInterval(animateId.bressBG), $(".manPic").find("span").eq(0).removeClass().addClass("manll"), $(".manPic").find("span").eq(1).removeClass().addClass("manrl"));
            var i = setTimeout(function () {
                for (var e = $(".codeArr").find("li"), n = [], a = 0; a < 5; a++) n.push($(e).eq(a).attr("class").split("code")[1]);
                k3v.stopGame(n, "2"),
                t = setTimeout(function () {
                    tryflag = !0
                },
                2e3),
                trytime.push(t)
            },
            8e3);
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
    $("#opening").text("正在开奖..."),
    $("#hourtxt").hide(),
    $("#opening").show(),
    k3v.startGame(!0)
},
k3v.updateData = function (e) {
    var n = 0 == e.sumBigSmall ? "大" : 1 == e.sumBigSmall ? "小" : "和",
    a = 0 == e.sumSingleDouble ? "单" : 1 == e.sumSingleDouble ? "双" : "和";
    $("#drawIssue").text(e.drawIssue),
    $("#drawTime").text(e.drawTime.split(" ")[1]);
    var t = e.preDrawCode.split(",");
    $(t).each(function (e) {
        $(".codeArr").find("li").eq(e).removeClass().addClass("code" + 1 * this)
    }),
    $(".codeArr").find("li").eq(5).find("span").eq(0).text(e.sumNum),
    $(".codeArr").find("li").eq(5).find("span").eq(1).text(n),
    $(".codeArr").find("li").eq(5).find("span").eq(2).text(a)
},
k3v.cutTime = function (e, n) {
    null != timer && clearInterval(timer);
    var e = e;
    timer = setInterval(function () {
        if (e >= 1) {
            e -= 1;
            var a = Math.floor(e / 3600),
            t = Math.floor(e / 60 % 60),
            i = Math.floor(e % 60),
            s = "";
            if (s = (a < 10 ? "0" + a : a) + ":", s = s + "" + (t < 10 ? "0" + t : t) + ":" + (i < 10 ? "0" + i : i), $("#hourtxt").text(s), e < 10) {
                var o = $(".linelist").find("li");
                $(o).eq(e).addClass("redli")
            }
            e < 20 && (tryflag = !1, $(".noinfor").text("即将开奖，禁止模拟"))
        } else $(".noinfor").text("正在开奖，禁止模拟"),
        clearInterval(timer),
        k3v.playGame(),
        console.log(n),
        setTimeout(pubmethod.doAjax(n.issue, n.lotCode, n.type, !1), "500")
    },
    1e3)
},
k3v.clearTime = function () {
    clearInterval(timer)
},
k3v.startVideo = function (e, n) {
    k3v.sound.stop("audioidB"),
    audioType = "r",
    k3v.updateData(e),
    console.log(e.preDrawCode.split(",")),
    k3v.stopGame(e.preDrawCode.split(","), "2"),
    k3v.cutTime(k3v.getSecond(e.drawTime, e.serverTime), n),
    setTimeout(function () {
        $(".animate").find(".loading").fadeOut(),
        firth11Load = !1
    },
    1e3)
},
k3v.defStartVideo = function (e, n, a, t, i, s) {
    k3v.sound.stop("audioidB"),
    k3v.sound.play("audioidR"),
    $("#hourtxt").hide(),
    $("#opening").show(),
    audioType = "r",
    k3v.playGame(),
    $("#drawIssue").text(e),
    $("#drawTime").text(n),
    $(s).each(function (e) {
        $(".codeArr").find("li").eq(e).removeClass().addClass("code" + this)
    }),
    $(".codeArr").find("li").eq(5).find("span").eq(0).text(a),
    $(".codeArr").find("li").eq(5).find("span").eq(1).text(t),
    $(".codeArr").find("li").eq(5).find("span").eq(2).text(i),
    setTimeout(function () {
        $(".animate").find(".loading").fadeOut(),
        firth11Load = !1
    },
    1e3)
},
k3v.getSecond = function (e, n) {
    return sys_second = addTime(e) - addTime(n),
    console.log(sys_second),
    sys_second
},
k3v.sound = {
    play: function (e) {
        "soundsOn" == $("#spanbtn").attr("class") && document.getElementById(e).play()
    },
    stop: function (e) {
        document.getElementById(e).pause()
    }
},
k3v.stopVideo = function (e, n) {
    k3v.stopGame(e.preDrawCode.split(","), 1),
    setTimeout(function () {
        k3v.cutTime(k3v.getSecond(e.drawTime, e.serverTime), n),
        tryflag = !0
    },
    1e3),
    k3v.updateData(e),
    $("#hourtxt").fadeIn(),
    $("#opening").hide(),
    void 0 != animateId.bressBG && (clearInterval(animateId.bressBG), $(".manPic").find("span").eq(0).removeClass().addClass("manll"), $(".manPic").find("span").eq(1).removeClass().addClass("manrl"))
},
k3v.bressBG = function (e) {
    var n = 1,
    a = !1;
    void 0 != animateId.bressBG && clearInterval(animateId.bressBG);
    var t = setInterval(function () {
        $(".bodybg").find("img").css({
            opacity: n
        }),
        a ? (n = 0, $(".manPic").find("span").eq(0).removeClass("manll").addClass("manlr"), $(".manPic").find("span").eq(1).removeClass("manrr").addClass("manrl"), a = !1) : (n = 1, $(".manPic").find("span").eq(1).removeClass("manrl").addClass("manrr"), $(".manPic").find("span").eq(0).removeClass("manlr").addClass("manll"), a = !0)
    },
    200);
    animateId.bressBG = t
};