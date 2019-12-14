var pubmethod = {}, path = window.location.href, lotCode;
var lidCode = { 10004: 8, 10006: 24, 10038: 3, 10003: 14, 10009: 5, 10034: 16, 10007: 9, 10026: 19 };

pubmethod.init = function (code) {
    if (-1 != path.indexOf("video_index") || void 0 != path.split("?")[1] && "" != path.split("?")[1]) {
        lotCode = code;
        var e = pubmethod.tools.type(lotCode);
        void 0 != e && pubmethod.doAjax("", lotCode, e, !0)
    } else
        alert("外链代码有误，请重新获取代码！")
}
,
pubmethod.tools = {
    type: function (e) {
        for (var t = [["cqnc", "10009"], ["xgc", "10048", "10051"], ["egxy", "10046"], ["gxklsf", "10038"], ["jisuft", "10035", "10057", "10058"], ["twbg", "10047"], ["fcsd", "10041", "10043"], ["bjkl8", "10013", "10014", "10054"], ["klsf", "10005", "10011", "10034", "10053"], ["pk10", "10001", "10012", "10037"], ["qgc", "10039", "10040", "10042", "10044", "10045"], ["ssc", "10002", "10003", "10004", "10010", "10036", "10050", "10059", "10060", "10064"], ["kuai3", "10007", "10026", "10027", "10028", "10029", "10030", "10031", "10032", "10033", "10052", "10061", "10062", "10063"], ["shiyi5", "10006", "10008", "10015", "10016", "10017", "10018", "10019", "10020", "10021", "10022", "10023", "10024", "10025", "10055"]], o = 0, r = t.length; o < r; o++)
            for (var s = 0, i = t[o].length; s < i; s++)
                if (e == t[o][s])
                    return t[o][0]
    },
    action: "./data.php?game_id=" + game_id,
    pageView: function (e) {
        return {
            cqnc: "video/cqnc/index.html",
            egxy: "video/pcEgg_video/index.html",
            gxklsf: "video/gxklsf_video/index.html",
            fcsd: "video/fc3DVideo/index.html",
            bjkl8: "video/bjkl8Video/index.html",
            twbg: "video/twbgVideo/twbg_index.html",
            klsf: "video/GDklsf/index.html",
            pk10: "video/PK10/video.html",
            qgc: "video/PK10/video.html",
            ssc: "video/SSC/index.html",
            kuai3: "video/kuai3_video/Kuai3.html",
            shiyi5: "video/11x5_video/index.html",
            jisuft: "video/jisuft_video/index.html",
            xgc: "video/SixColor_animate/index.html"
        }[e]
    },
    random: function () {
        return (new Date).getTime()
    },
    ifObj: function (e) {
        var t = null;
        return "object" != typeof e ? t = JSON.parse(e) : (t = JSON.stringify(e),
        t = JSON.parse(t)),
        t
    },
    cutTime: function (e, t) {
        var o = e.replace("-", "/")
          , t = t.replace("-", "/");
        return o = o.replace("-", "/"),
        t = t.replace("-", "/"),
        (new Date(o) - new Date(t)) / 1e3
    }
},
pubmethod.repeatAjax = function (e, t, s) {
    setTimeout(function () {
        e(t)
    }, 2000)
}
,
pubmethod.doAjax = function (e, t, o, r) {
    var s = {
        url: pubmethod.tools.action,
        issue: e,
        lotCode: t,
        flag: r,
        type: o,
        succM: function (e, t) {
            pubmethod.creatHeadD[o](e, t)
        }
    };
    pubmethod.ajaxM(s)
}
,
pubmethod.ajaxM = function (e) {
    $.ajax({
        url: "./data.php",
        type: "GET",
		dataType: "json", 
        async: !0,
        data: {
            game_id: game_id
        },
        timeout: "6000",
        success: function (t) {
            if (e.issue != "" && e.issue != t.preDrawIssue && parseInt(t.drawIssue, 10) % 100 != 1) {
                pubmethod.repeatAjax(pubmethod.ajaxM, e)
            }
            else {
                try {
                    e.succM(t, e)
                } catch (t) {
                    pubmethod.repeatAjax(pubmethod.ajaxM, e)
                }
            }
        },
        error: function (t) {
            pubmethod.repeatAjax(pubmethod.ajaxM, e)
        }
    })
}
,
pubmethod.creatHeadD = {
    pk10: function (e, t) {
        var o = pubmethod.tools.ifObj(e);
        for (var r = pubmethod.tools.cutTime(o.drawTime, o.serverTime), s = o.preDrawCode.split(","), i = "", u = 0, n = s.length; u < n; u++)
            "0" == s[u].substr(0, 1) ? i += s[u].substr(1, 1) + "," : i += s[u] + ",";
        if (r = r < 0 ? 1 : r,
        showcurrentresult(i),
        $("#currentdrawid").text(o.drawCount),
        $("#nextdrawid").text(o.preDrawIssue),
        $("#stat1_1").text(o.sumFS),
        $("#stat1_2").text("0" == o.sumBigSamll ? "大" : "小"),
        $("#stat1_3").text("0" == o.sumSingleDouble ? "单" : "双"),
        $("#stat2_1").text("0" == o.firstDT ? "龙" : "虎"),
        $("#stat2_2").text("0" == o.secondDT ? "龙" : "虎"),
        $("#stat2_3").text("0" == o.thirdDT ? "龙" : "虎"),
        $("#stat2_4").text("0" == o.fourthDT ? "龙" : "虎"),
        $("#stat2_5").text("0" == o.fifthDT ? "龙" : "虎"),
        t.flag)
            $("#hlogo").find("img").attr("src", "images/logo/logo-" + t.lotCode + ".png"),
            $(".statuslogo").css({
                background: "url(images/logo/logo-" + t.lotCode + ".png)no-repeat"
            }),
            startcountdown(r, t);
        else {
            if (!t.flag && r <= 1)
                throw new Error("error");
            setTimeout(function () {
                finishgame(i)
            }, "1000"),
            setTimeout(function () {
                startcountdown(r - 11, t)
            }, "10000")
        }

    },
    egxy: function (e, t) {
        var o = pubmethod.tools.ifObj(e);
        for (var r = pubmethod.tools.cutTime(o.drawTime, o.serverTime), s = o.preDrawCode.split(","), i = [], u = 0, n = s.length; u < n; u++)
            "0" == s[u].substr(0, 1) ? i.push(s[u].substr(1, 1)) : i.push(s[u]);
        r = r < 0 ? 1 : r;
        var l = {
            nextIssue: o.drawIssue,
            drawTime: o.drawTime,
            serverTime: o.serverTime,
            numArr: i,
            preDrawTime: o.preDrawTime
        };
        if (t.flag)
            pcEgg.startVid(l, t);
        else {
            if (!t.flag && r <= 1)
                throw new Error("error");
            setTimeout(function () {
                pcEgg.stopVid(l, t)
            }, "1000")
        }

    },
    cqnc: function (e, t) {
        var o = pubmethod.tools.ifObj(e);
        for (var r = pubmethod.tools.cutTime(o.drawTime, o.serverTime), s = o.preDrawCode.split(","), i = [], u = 0, n = s.length; u < n; u++)
            "0" == s[u].substr(0, 1) ? i.push(s[u].substr(1, 1)) : i.push(s[u]);
        t.issue = o.drawIssue;
        if (r = r < 0 ? 1 : r,
        t.flag)
            cqncVideo.statusFun(o.preDrawIssue, i, r, !0, t);
        else {
            if (!t.flag && r <= 1)
                throw new Error("error");
            setTimeout(function () {
                stopanimate(i, r, t)
            }, "1000")
        }

    },
    ssc: function (e, t) {
        a = pubmethod.tools.ifObj(e)
        for (var r = pubmethod.tools.cutTime(a.drawTime, a.serverTime), s = a.preDrawCode.split(","), i = [], u = 0, n = s.length; u < n; u++)
            "0" == s[u].substr(0, 1) && s[u].length > 1 ? i.push(s[u].substr(1, 1)) : i.push(s[u]);
        var l = "";
        "0" == a.dragonTiger ? l = "龙" : "1" == a.dragonTiger ? l = "虎" : "2" == a.dragonTiger && (l = "和");
        r = r < 0 ? 1 : r;

        var a = {
            preDrawCode: i,
            id: "#numBig",
            counttime: r,
            preDrawIssue: a.preDrawIssue,
            curDrawIssue: a.drawIssue,
            drawTime: a.drawTime.substr(a.drawTime.length - 8, 8),
            sumNum: a.sumNum,
            sumSingleDouble: 0 == a.sumSingleDouble ? "单" : "双",
            sumBigSmall: 0 == a.sumBigSmall ? "大" : "小",
            dragonTiger: l
        };

        if (t.flag) {
            sscAnimateEnd(a, t),
            $("#hlogo").find("img").attr("src", "img/cqssc/tjssc_logo.png");
        }
        else {
            if (!t.flag && r <= 1)
                throw new Error("error");
            setTimeout(function () {
                sscAnimateEnd(a, t)
            }, "1000")
        }
        //"10002" != o && "10050" != lotCode || new Date("2019-03-29 23:52:00").getTime() - (new Date).getTime() <= 0 && $(".djs").html("<span  style='text-align:center;width:100%;color: #ff0b0b;display:inline-block;font-size:17px;'>停止销售</span>")

    },
    shiyi5: function (e, t) {
        var o = pubmethod.tools.ifObj(e);

        for (var r = pubmethod.tools.cutTime(o.drawTime, o.serverTime), s = o.preDrawCode.split(","), i = [], u = 0, n = s.length; u < n; u++)
            "0" == s[u].substr(0, 1) ? i.push(1 * s[u].substr(1, 1)) : i.push(1 * s[u]);
        t.issue = o.drawIssue;
        if (r = r < 0 ? 1 : r,
        console.log(i),
        t.flag)
            $(".nameLogo").find("img").attr("src", "img/11x5_" + t.lotCode + ".png"),
            k3v.startVideo(o, t),
            console.log($(".nameLogo"), t);
        else {
            if (!t.flag && r <= 1)
                throw new Error("error");
            console.log(o),
            setTimeout(function () {
                k3v.stopVideo(o, t)
            }, "1000")
        }

    },
    klsf: function (e, t) {
        var o = pubmethod.tools.ifObj(e);

        for (var r = pubmethod.tools.cutTime(o.drawTime, o.serverTime), s = o.preDrawCode.split(","), i = [], u = 0, n = s.length; u < n; u++)
            "0" == s[u].substr(0, 1) ? i.push(1 * s[u].substr(1, 1)) : i.push(1 * s[u]);
        r = r < 0 ? 1 : r;
        var l = o.preDrawIssue
          , a = o.drawIssue
          , d = o.drawTime.split(" ")[1];
        t.issue = o.drawIssue;
        if (t.flag)
            $(".video_box").css("background", "url(img/" + t.lotCode + ".jpg) 0 0 no-repeat"),
            fun.fillHtml(l, a, d, r, i, t);
        else {
            if (!t.flag && r <= 1)
                throw new Error("error");
            setTimeout(function () {
                fun.Trueresult(i),
                fun.fillHtml(l, a, d, r, void 0, t)
            }, "1000")
        }

    },
    kuai3: function (e, t) {
        var o = pubmethod.tools.ifObj(e);

        for (var r = pubmethod.tools.cutTime(o.drawTime, o.serverTime), s = o.preDrawCode.split(","), i = [], u = 0, n = s.length; u < n; u++)
            "0" == s[u].substr(0, 1) ? i.push(1 * s[u].substr(1, 1)) : i.push(1 * s[u]);
        r = r < 0 ? 1 : r;
        o.drawTime.split(" ")[1].slice(0, 5);
        console.log(o);
        var l = {
            seconds: r,
            preDrawCode: i,
            sumNum: o.sumNum,
            drawTime: o.drawTime,
            drawIssue: o.drawIssue,
            preDrawIssue: o.preDrawIssue
        };
        if (t.flag)
            $(".nameLogo").find("img").attr("src", "img/" + t.lotCode + ".png"),
            k3v.stopVideo(l, t, o.drawIssue);
        else {
            if (!t.flag && r <= 1)
                throw new Error("error");
            setTimeout(function () {
                k3v.stopVideo(l, t, o.drawIssue)
            }, "1000")
        }

    },
    fcsd: function (e, t) {
        var o = pubmethod.tools.ifObj(e);

        for (var r = pubmethod.tools.cutTime(o.drawTime, o.serverTime), s = o.preDrawCode.split(","), i = [], u = 0, n = s.length; u < n; u++)
            "0" == s[u].substr(0, 1) ? i.push(1 * s[u].substr(1, 1)) : i.push(1 * s[u]);
        r = r < 0 ? 1 : r,
        o.cutime = r;
        o.drawTime.split(" ")[1];
        if (console.log(o),
        o.preDrawCode = i,
        t.flag)
            $(".logo").css("background", "url(img/" + t.lotCode + ".png) center center no-repeat"),
            fcsdv.startVid(o, t);
        else {
            if (t.flag && r <= 1)
                throw new Error("error");
            setTimeout(function () {
                fcsdv.stopVid(o, t)
            }, "1000")
        }

    },
    bjkl8: function (e, t) {
        var o = pubmethod.tools.ifObj(e);

        for (var r = pubmethod.tools.cutTime(o.drawTime, o.serverTime), s = o.preDrawCode.split(","), i = [], u = 0, n = s.length; u < n; u++)
            "0" == s[u].substr(0, 1) ? i.push(1 * s[u].substr(1, 1)) : i.push(1 * s[u]);
        t.issue = o.drawIssue;
        if (r = r < 0 ? 1 : r,
        o.cutime = r,
        console.log(o),
        o.preDrawCode = i,
        t.flag)
            $(".logo").css("background", "url(img/" + t.lotCode + ".png) center center no-repeat"),
            syxwV.startVid(o, t);
        else {
            if (!t.flag && r <= 1)
                throw new Error("error");
            setTimeout(function () {
                syxwV.stopVid(o, t)
            }, "1000")
        }

    },
    twbg: function (e, t) {
        var o = pubmethod.tools.ifObj(e);

        for (var r = pubmethod.tools.cutTime(o.drawTime, o.serverTime), s = o.preDrawCode.split(","), i = [], u = 0, n = s.length; u < n; u++)
            "0" == s[u].substr(0, 1) ? i.push(1 * s[u].substr(1, 1)) : i.push(1 * s[u]);
        t.issue = o.drawIssue;
        if (r = r < 0 ? 1 : r,
        o.cutime = r,
        console.log(o),
        o.preDrawCode = i,
        t.flag)
            syxwV.startVid(o, t);
        else {
            if (!t.flag && r <= 1)
                throw new Error("error");
            setTimeout(function () {
                syxwV.stopVid(o, t)
            }, "1000")
        }

    },
    gxklsf: function (e, t) {
        var o = pubmethod.tools.ifObj(e);

        for (var r = pubmethod.tools.cutTime(o.drawTime, o.serverTime), s = o.preDrawCode.split(","), i = [], u = 0, n = s.length; u < n; u++)
            "0" == s[u].substr(0, 1) ? i.push(1 * s[u].substr(1, 1)) : i.push(1 * s[u]);
        t.issue = o.drawIssue;
        if (r = r < 0 ? 1 : r,
        o.cutime = r,
        console.log(o),
        o.numArr = i,
        t.flag)
            gxklsf.startVid(o, t);
        else {
            if (!t.flag && r <= 1)
                throw new Error("error");
            setTimeout(function () {
                gxklsf.stopVid(o, t)
            }, "1000")
        }

    },
    jisuft: function (e, t) {
        var o = pubmethod.tools.ifObj(e);

        $("#status").css("background-image", "../images/logo_" + o.lotCode + ".png"),
        $(".logo").find("img").attr("src", "images/logo_" + o.lotCode + ".png");
        for (var r = pubmethod.tools.cutTime(o.drawTime, o.serverTime), s = o.preDrawCode.split(","), i = [], u = 0, n = s.length; u < n; u++)
            "0" == s[u].substr(0, 1) ? i.push(1 * s[u].substr(1, 1)) : i.push(1 * s[u]);
        if (r = r < 0 ? 1 : r,
        o.cutime = r,
        console.log(o),
        showcurrentresult(o.preDrawCode),
        $("#currentdrawid").text(o.drawCount),
        $("#nextdrawid").text(o.preDrawIssue),
        $("#stat1_1").text(o.sumFS),
        $("#stat1_2").text("0" == o.sumBigSamll ? "大" : "小"),
        $("#stat1_3").text("0" == o.sumSingleDouble ? "单" : "双"),
        $("#stat2_1").text("0" == o.firstDT ? "龙" : "虎"),
        $("#stat2_2").text("0" == o.secondDT ? "龙" : "虎"),
        $("#stat2_3").text("0" == o.thirdDT ? "龙" : "虎"),
        $("#stat2_4").text("0" == o.fourthDT ? "龙" : "虎"),
        $("#stat2_5").text("0" == o.fifthDT ? "龙" : "虎"),
        t.flag)
            startcountdown(r, t);
        else {
            if (!t.flag && r <= 1)
                throw new Error("error");
            setTimeout(function () {
                finishgame(i.toString())
            }, "1000"),
            setTimeout(function () {
                startcountdown(r - 11, t)
            }, "10000")
        }

    }
};
