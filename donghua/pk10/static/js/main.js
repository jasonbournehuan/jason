var util = {
    $apiUrl: "//" + window.location.host,
    $gameCode: "bjpk10",
    $ajaxPost: function (e, t, n, a) { $ && $.ajax({ type: "POST", dataType: "json", url: e, data: t, success: n, timeout: 1e4, error: a }) },
    $ajaxGet: function (e, t, n, a) { $ && $.ajax({ type: "GET", dataType: "json", url: e, data: t, success: n, timeout: 1e4, error: a }) },
    offsetTime: function () { return 6e4 * ((new Date).getTimezoneOffset() - -480) },
    randomNum: function (e) {
        for (var t = "", e = e || 20, n = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "A", "B", "C", "D", "E",
            "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"],
            a = 0; a < e; a++) { t += n[Math.ceil(35 * Math.random())] } return t
    }
},gameCode = "bjpk10",
    liveResultUrl = "./data.php?game_id=" + game_id, liveResultType, liveResult = {},
    liveResultCtrl = {
        getNewByGamecode: function () {
            function e() {
                util.$ajaxGet(liveResultUrl + "&" + util.randomNum(50), {}, function (t) {
                    liveResult.preIssue != t.preIssue ? (liveResultType = 1, liveResult = t, console.info("已获取到开奖结果")) : setTimeout(e, 1e3)
                }, function (t) { console.log(t), setTimeout(e, 3e3) })
            } e()
        },
        getResult: function () {
            var e = this, t = liveResult.openDateTime;
            console.info(t + "秒后开奖");
            setTimeout(function () { e.getNewByGamecode(); }, t * 1000)
        }

    };
var gameCode = "bjpk10", animateSoundType = !0, parLiveResult, openDateTime, openNum, preIssue, windflameTimer,
    runningSoundTimer, carTimer, posTimer, carpositionoffset = [0, 9, 25, 40, 53, 67, 78, 101, 122, 139], lightsSound = $("#lights")[0],
    carStartSound = $("#carStarting")[0], carRunningSound = $("#running")[0], finishSound = $("#finish")[0],
    animate = {
        imgLoad: function () { console.log("游戏资源下载完成"); },
        stopAllSound: function () { lightsSound.volume = 0, carStartSound.volume = 0, carRunningSound.volume = 0, finishSound.volume = 0 },
        startAllSound: function () { animateSoundType && (lightsSound.volume = 1, carStartSound.volume = 1, carRunningSound.volume = 1, finishSound.volume = 1) },
        lightsSound: function () { lightsSound.play() },
        carStartSoundStart: function () { carStartSound.play() },
        carStartSoundStop: function () { carStartSound.pause(), carStartSound.currentTime = 0 },
        carRunningSoundStart: function () { carRunningSound.play() },
        carRunningSoundStop: function () { carRunningSound.pause(), carRunningSound.currentTime = 0 },
        finishSoundStart: function () { finishSound.play() },
        finishSoundStop: function () { finishSound.pause(), carRunningSound.currentTime = 0 },
        lightStart: function () {
            animate.carStartSoundStart(),
                runningSoundTimer = setTimeout(function () { animate.carRunningSoundStart() }, 24e3),
            $(".redlight").fadeIn(1e3, function () {
                $(".yellowlight").fadeIn(1e3, function () {
                    animate.lightsSound(),
                        $(".greenlight").fadeIn(1e3, function () {
                            setTimeout(function () {
                                $(".trafficlight").hide(), animate.otherStart(), posTimer = setInterval(function () { animate.checkposition() }, 300),
                                animate.carCtrl(), carTimer = setInterval(function () { animate.carCtrl() }, 2e3)
                            }, 300)
                        })
                })
            })
        },
        otherStart: function () {
            function a() {
                $(".wind").animate({ opacity: .7 }, 150, function () {
                    $(".wind").css("opacity", "1")
                }), $(".flame").animate({ opacity: .7 }, 150, function () { $(".flame").css("opacity", "1") })
            }
            for (var e = 1; e < 11; e++) $(".wheel" + e + "a").css("display", "block"),
                $(".wheel" + e + "b").css("display", "block");
            var t = $("#roadstart");
            TweenMax.to(t, 1, { left: "1334px", ease: Power1.easeIn }),
            road = $("#roaditm"),
            TweenMax.to(roaditm, .4, { left: "-120px", repeat: -1, ease: Linear.easeNone });
            var n = $("#scenaryitm");
            TweenMax.to(n, 20, { left: "0", repeat: -1, ease: Linear.easeNone }),
            windflameTimer = setInterval(function () { a() }, 150)
        },
        flameCtrl: function (a, e) {
            parseInt($("#car" + e).css("left")) > a ? ($(".car" + e + " .wind").css("display", "block"), $(".car" + e + " .flame").css("display", "block")) : ($(".car" + e + " .wind").css("display", "none"), $(".car" + e + " .flame").css("display", "none"))
        },
        carCtrl: function () {
            var a = Math.floor(40 * Math.random() + 30) / 10,
                e = Math.floor(40 * Math.random() + 30) / 10,
                t = Math.floor(40 * Math.random() + 30) / 10,
                n = Math.floor(40 * Math.random() + 30) / 10,
                r = Math.floor(40 * Math.random() + 30) / 10,
                o = Math.floor(40 * Math.random() + 30) / 10,
                i = Math.floor(40 * Math.random() + 30) / 10,
                l = Math.floor(40 * Math.random() + 30) / 10,
                s = Math.floor(40 * Math.random() + 30) / 10,
                u = Math.floor(40 * Math.random() + 30) / 10,
                d = Math.floor(10 * Math.random() + 1) / 10,
                m = Math.floor(10 * Math.random() + 1) / 10,
                c = Math.floor(10 * Math.random() + 1) / 10,
                f = Math.floor(10 * Math.random() + 1) / 10,
                p = Math.floor(10 * Math.random() + 1) / 10,
                h = Math.floor(10 * Math.random() + 1) / 10,
                v = Math.floor(10 * Math.random() + 1) / 10,
                M = Math.floor(10 * Math.random() + 1) / 10,
                y = Math.floor(10 * Math.random() + 1) / 10,
                S = Math.floor(10 * Math.random() + 1) / 10,
                g = Math.floor(1100 * Math.random() + 200);
            animate.flameCtrl(g, "1"), g += "px";
            var x = Math.floor(1100 * Math.random() + 200);
            animate.flameCtrl(x, "2"), x += "px";
            var T = Math.floor(1100 * Math.random() + 200);
            animate.flameCtrl(T, "3"), T += "px";
            var w = Math.floor(1100 * Math.random() + 200);
            animate.flameCtrl(w, "4"), w += "px";
            var I = Math.floor(1100 * Math.random() + 200);
            animate.flameCtrl(I, "5"), I += "px";
            var C = Math.floor(1100 * Math.random() + 200);
            animate.flameCtrl(C, "6"), C += "px";
            var D = Math.floor(1100 * Math.random() + 200);
            animate.flameCtrl(D, "7"), D += "px";
            var R = Math.floor(1100 * Math.random() + 200);
            animate.flameCtrl(R, "8"), R += "px";
            var A = Math.floor(1100 * Math.random() + 200);
            animate.flameCtrl(A, "9"), A += "px";
            var N = Math.floor(1100 * Math.random() + 200);
            animate.flameCtrl(N, "10"), N += "px";
            var L = $("#car1"), b = $("#car2"), k = $("#car3"), B = $("#car4"), E = $("#car5"), P = $("#car6"), _ = $("#car7"), q = $("#car8"), W = $("#car9"), F = $("#car10");
            TweenMax.to(L, a, { left: g, delay: d }),
            TweenMax.to(b, e, { left: x, delay: m }),
            TweenMax.to(k, t, { left: T, delay: c }),
            TweenMax.to(B, n, { left: w, delay: f }),
            TweenMax.to(E, r, { left: I, delay: p }),
            TweenMax.to(P, o, { left: C, delay: h }),
            TweenMax.to(_, i, { left: D, delay: v }),
            TweenMax.to(q, l, { left: R, delay: M }),
            TweenMax.to(W, s, { left: A, delay: y }),
            TweenMax.to(F, u, { left: N, delay: S })
        },
        resultWrite: function () {
            for (var a = liveResult, e = a.preIssue, t = a.sumArr, n = a.dragonTigerArr, r = 0; r < openNum.length; r++) {
                var o = r + 1, i = "#pos" + o, l = openNum[r], s = -64 * (l - 1); $(i).css("background-position", "0px " + s + "px")
            }
            $("#currentdrawid").text(e), $("#nextdrawtime").text(e - 0 + 1)
            //$("#stat1_1").text(t[0]), $("#stat1_2").text(typeData[1][t[1]]), $("#stat1_3").text(typeData[2][t[2]]);
            //for (var r = 0; r < n.length; r++) $("#stat2_" + (r + 1)).text(typeData[3][n[r]])
        },
        checkposition: function () {
            carposition = new Array, carsequence = new Array,
            my_array = new Array;
            for (var a = 0; a < 10; a++) {
                var e = a + 1, t = parseInt($("#car" + e).css("left")); t += carpositionoffset[a], t = t + "." + a, carposition[a] = parseFloat(t)
            } carposition.sort(function (a, e) { return a - e });
            for (var a = 0; a < 10; a++) {
                var n = carposition[a]; n = String(n), my_array = n.split("."), void 0 == my_array[1] ? carsequence[a] = "0" : carsequence[a] = my_array[1]
            }
            for (var a = 0; a < 10; a++) {
                var r = a + 1, o = "#pos" + r, i = carsequence[a], l = -64 * i; $(o).css("background-position", "0px " + l + "px")
            }
        },
        finishShow: function () {
            setTimeout(function () {
                clearTimeout(runningSoundTimer), animate.carRunningSoundStop(), animate.carStartSoundStop()
            }, 3300),
            TweenMax.killAll(), $("#roaditm").css("left", "-1300px"); var a = document.getElementById("roaditm");
            TweenMax.to(a, .4, { left: "-120px", repeat: -1, ease: Linear.easeNone });
            var e = document.getElementById("scenaryitm");
            TweenMax.to(e, 20, { left: "0", repeat: -1, ease: Linear.easeNone });
            var t = document.getElementById("roadstart");
            TweenMax.to(t, 1, { left: "1334px", ease: Linear.easeNone, delay: 3 }),
            $("#roadstart").css("left", "-250px"), clearInterval(carTimer);
            for (var n = 0; n < 10; n++) {
                var r = Math.floor(10 * Math.random() + 1); r /= 10;
                var o = parseInt(openNum[n]) - 1, i = 100 * n - carpositionoffset[o] + 350, l = i + "px", s = "car" + openNum[n], u = $("#" + s);
                TweenMax.to(u, 3, { left: l, delay: r })
            }
            $(".flashlight").delay(3200).fadeIn(100, function () {
                $(".flashlight").fadeOut(500), TweenMax.killAll(), clearInterval(posTimer), clearInterval(windflameTimer);
                for (var a = 0; a < 10; a++) {
                    var e = "car" + (a + 1), t = $("#" + e);
                    TweenMax.to(t, 2, { left: t.offset().left - 1500, delay: 2 })
                } setTimeout(animate.resultPage, 3500)
            })
        },
        resultPage: function () {
            TweenMax.killAll(), $(".resultitm").css("opacity", 0),
            $(".resultcar1").css({ left: "483px", top: "288px" }),
            $(".resultcar2").css({ left: "170px", top: "251px" }),
            $(".resultcar3").css({ left: "946px", top: "254px" }),
            $(".page1").css("display", "none"),
            $(".page2").css("display", "block");
            for (var a = 0; a < 3; a++) {
                var e = a + 1, t = "#resultcar" + e; $(t).find("div").attr("class", "rcar rcar" + openNum[a])
            }
            animate.finishSoundStart();
            var n = document.getElementById("resultcar1");
            TweenMax.to(n, 1, { left: "395px", top: "328px", opacity: 1, delay: .2 });
            var r = document.getElementById("resultcar2");
            TweenMax.to(r, 1, { left: "81px", top: "287px", opacity: 1, delay: .7 });
            var o = document.getElementById("resultcar3");
            TweenMax.to(o, 1, { left: "859px", top: "291px", opacity: 1, delay: 1.2 });
            var i = document.getElementById("result1");
            TweenMax.to(i, 1, { opacity: 1, delay: .2 });
            var l = document.getElementById("result2");
            TweenMax.to(l, 1, { opacity: 1, delay: .7 });
            var s = document.getElementById("result3");
            TweenMax.to(s, 1, { opacity: 1, delay: 1.2 }), animate.resultWrite(), setTimeout(animate.resetPage, 5e3)
        },
        resetPage: function () {
            console.log("reset");
            for (var a = 1; a < 11; a++) $(".wheel" + a + "a").hide(), $(".wheel" + a + "b").hide();
            for (var a = 0; a < 10; a++) $("#car" + (a + 1)).removeAttr("style");
			liveResult.openDateTime = liveResult.openDateTime - 15;
            $(".wind").hide(), $(".flame").hide(),
            $("#roadstart").removeAttr("style"),
            $("#scenaryitm").removeAttr("style"),
            $("#roaditm").removeAttr("style"),
            $(".trafficlight").show(),
            $(".redlight").hide(),
            $(".yellowlight").hide(),
            $(".greenlight").hide(),
            $(".page1").show(),
            $(".page2").hide(),
            liveResultCtrl.getResult();
            animate.init()
        },
        convertDate: function (seconds) {
            /// <summary>
            /// 秒转分钟
            /// </summary>
            /// <param name="seconds" type="type"></param>
            /// <returns type=""></returns>
            var mm;
            var ss;
            if (seconds === null || seconds < 0) {
                return;
            }
            mm = seconds / 60 | 0;
            ss = parseInt(seconds) - mm * 60;
            if (parseInt(mm) < 10) {
                mm = "0" + mm;
            }
            if (ss < 10) {
                ss = "0" + ss;
            }
            return mm + ":" + ss;
        },
        timeCount: function () {
            var a = $(".countdownnum2"), e = $(".countdownnum"), t = 1;
            a.text("99");
            var n = setInterval(function () {
                var e = parseInt(a.text()), t = 0 == e ? 99 : e - 1 < 10 ? "0" + (e - 1) : e - 1; a.text(t)
            }, 10);
            e.text(animate.convertDate(liveResult.openDateTime));
            r = setInterval(function () {
                liveResult.openDateTime--;
                var o = (liveResult.openDateTime),
                    i = Math.floor(o / 60), l = i < 10 ? "0" + i : i,
                    s = Math.floor(o % 60), u = s < 10 ? "0" + s : s; e.text(l + ":" + u),
                o <= 3 && t && (animate.init(), t = 0),
                o <= 0 && (clearInterval(r), clearInterval(n), a.text("00"), t = 1)

            }, 1e3)
        },
        init: function () {
            function a() {
                liveResult.preIssue != preIssue ? (openNum = liveResult.openNum, animate.finishShow()) : setTimeout(a, 1e3)
            }
            var e = this;
            openDateTime = liveResult.openDateTime,
            openNum = liveResult.openNum,
            preIssue = liveResult.preIssue,
            animate.resultWrite(),
            3 >= openDateTime ? (animate.lightStart(), setTimeout(a, 3e3)) : animate.timeCount()
        }
    };

$(function () {
    util.$ajaxGet(liveResultUrl + "&" + util.randomNum(50), "", function (e) {
        var t = e; liveResult = t, t.issue - t.preIssue != 2 && t.openDateTime > 0 && (liveResultType = 1);
        liveResultCtrl.getResult();
        animate.init();
    });
    $("#soundCtrl").on("click", function () { $btn = $(this), $btn.hasClass("on") ? (animate.stopAllSound(), $btn.removeClass("on")) : (animate.startAllSound(), $btn.addClass("on")) })
});
