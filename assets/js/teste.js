HTMLCollection.prototype.forEach = NodeList.prototype.forEach, document.addEventListener("DOMContentLoaded", function() {
    for (var e in hot_uacq_options) hot_uacq_options[e] && 0 !== parseInt(hot_uacq_options[e]) || (hot_uacq_options[e] = !1);
    var f = window.location.href,
        g = document.referrer,
        t = window.innerWidth,
        s = window.scrollY,
        i = window.innerHeight,
        l = document.documentElement.scrollHeight,
        a = document.getElementsByClassName("hot-post-title").length ? encodeURIComponent(document.getElementsByClassName("hot-post-title")[0].innerText) : encodeURIComponent(document.title),
        n = -1 !== f.indexOf("localhost") || -1 !== f.indexOf("blog.vulcano.rocks"),
        r = document.getElementsByClassName("hot-post-header").length,
        o = document.querySelector("[data-page-template]"),
        c = document.getElementById("hot-quiz"),
        d = document.getElementsByClassName("hot-search-header").length,
        m = document.getElementsByClassName("hot-search-resultless").length,
        u = document.getElementsByClassName("hot-author-header").length,
        h = t <= 768,
        p = t <= 399,
        v = document.getElementById("wpadminbar"),
        E = document.getElementsByClassName("hot-header")[0].clientHeight,
        L = {
            default: "hot-footer-fixed",
            open: "hot-footer-fixed-open",
            close: "hot-footer-fixed-close"
        },
        y = L.default,
        b = document.getElementById(L.default),
        _ = document.getElementsByClassName("hot-cta-popup").length,
        w = document.getElementsByClassName("hot-cta-full-width").length,
        B = !0,
        T = document.getElementById("hot-post-index-floater"),
        x = document.getElementById("hot-post-index"),
        N = document.getElementById("hot-post-index-floater"),
        C = document.querySelectorAll("[data-toggle]"),
        q = -1 !== document.cookie.indexOf("_OneSignal_session") || window.sessionStorage.ONE_SIGNAL_NOTIFICATION_PERMISSION && "granted" === window.sessionStorage.ONE_SIGNAL_NOTIFICATION_PERMISSION,
        I = "hot_newsletter_signed",
        S = -1 !== document.cookie.indexOf(I);

    function A() {
        var t = {};
        return document.cookie.split("; ").forEach(function(e) {
            t[e.split("=")[0]] = e.split("=")[1]
        }), t
    }
    if (992 <= t) {
        document.querySelectorAll("[data-desktop-loading]").forEach(function(e) {
            e.setAttribute("src", e.dataset.desktopLoading)
        });
        var k = document.querySelector("[data-post-content]");
        k && k.querySelectorAll('a:not([href*="#"])').forEach(function(e) {
            e.getAttribute("target") && "_blank" === e.getAttribute("target") || e.setAttribute("target", "_blank")
        })
    }

    function H(e) {
        return document.getElementById(e).getBoundingClientRect().top + window.scrollY
    }

    function M(e) {
        var t = e ? "hidden" : "auto";
        document.getElementsByTagName("html")[0].style.overflow = t, document.getElementsByTagName("body")[0].style.overflow = t
    }

    function O(e) {
        window.open(e, "", "width=700,height=450,menubar=0,resizable=0,scrollbars=0,titlebar=0,toolbar=0")
    }

    function R(e) {
        "scrollBehavior" in document.documentElement.style ? window.scrollTo({
            behavior: "smooth",
            left: 0,
            top: e
        }) : window.scroll(0, e)
    }

    function D(e) {
        B = !1;
        for (var t = document.getElementsByClassName("hot-notification-button"), n = 0; t.length > n; n++) t[n].setAttribute("disabled", !0), t[n].innerText = t[n].dataset[e], t[n].classList.add("no-icon");
        if (b && (document.getElementById(L.default).remove(), b = !1), document.getElementsByClassName("hot-menu-mobile-cta-button").length && document.getElementsByClassName("hot-menu-mobile-cta-button")[0].remove(), T && N.classList.add("no-footer-fixed"), _) {
            var o = document.getElementsByClassName("hot-cta-popup")[0];
            o.classList.contains("active") && setTimeout(function() {
                M(!1), o.classList.remove("active")
            }, 3e3)
        }
    }
    768 <= t && document.querySelectorAll("[data-tablet-loading]").forEach(function(e) {
        e.setAttribute("src", e.dataset.tabletLoading)
    }), t < 768 && document.querySelectorAll("[data-mobile-loading]").forEach(function(e) {
        e.setAttribute("src", e.dataset.mobileLoading)
    });
    var z = [],
        P = 0;

    function F(e, t, n) {
        var o = e + t;
        if (P < z.length) {
            var a = document.getElementById(z[P][0]);
            a ? (n || o > H(z[P][0]) || l <= o + 150) && (a.setAttribute("src", z[P][1]), P++, F(e, t, n)) : (P++, F(e, t, n))
        }
    }
    document.querySelectorAll("[data-lazy-loading]").forEach(function(e, t) {
        var n = e.dataset.lazyLoading;
        e.id = e.id ? e.id : "hot-lazy-loading-" + t, z.push([e.id, n])
    }), -1 !== navigator.userAgent.indexOf("Hotjar") && F(i, s, !0), (d || u || !h && (w && 870 < i || 635 < i)) && F(i, s, !1);
    var U = !1;
    if (B) {
        var X = window.OneSignal || [],
            G = {
                autoRegister: !1,
                persistNotification: !0
            };
        G.welcomeNotification = hot_notification.welcomeNotification, G.promptOptions = hot_notification.promptOptions, n ? (G.appId = "a9c24fd4-c8b6-4a80-872a-f1b7eccdc3d1", G.subdomainName = "hotmart.os.tc", G.httpPermissionRequest = {
            enable: !0
        }, G.safari_web_id = "web.onesignal.auto.1afe2633-50cf-455e-8f3e-a50d8cbe1d12") : (G.appId = hot_notification.appId, G.safari_web_id = hot_notification.safari_web_id), X.push(["init", G]), q && D("already_enabled"), X.push(function() {
            X.isPushNotificationsEnabled(function(e) {
                e && (X.getTags(function(e) {
                    !e.language && "pt-br" === hot_notification.language || e.language === hot_notification.language ? D("already_enabled") : D("unavailable")
                }), U = !0)
            })
        }), X.isPushNotificationsSupported() || (D("unavailable"), U = !0), X.push(function() {
            X.on("subscriptionChange", function(e) {
                if (e) {
                    D("already_enabled");
                    var t = A(),
                        n = {
                            language: hot_notification.language,
                            origin_url: window.location.hostname + window.location.pathname,
                            hotid: t.hotid,
                            pardot_visitor_id: t.visitor_id506291
                        };
                    X.sendTags(n), setTimeout(function() {
                        X.sendTags(n), setTimeout(function() {
                            X.sendTags(n), setTimeout(function() {
                                X.sendTags(n), setTimeout(function() {
                                    X.sendTags(n)
                                }, 1e4)
                            }, 5e3)
                        }, 2e3)
                    }, 1e3)
                }
            })
        })
    }
    if (hot_uacq_options.uacq_popup_enabled && _) {
        var j = document.getElementsByClassName("hot-cta-popup")[0];
        document.addEventListener("mouseleave", function() {
            sessionStorage.getItem("popup_shown") || (j.querySelectorAll("[data-ondemand-loading]").forEach(function(e) {
                e.setAttribute("src", e.dataset.ondemandLoading)
            }), B && !U ? (j.classList.add("active"), M(!0), document.getElementById("hot-cta-popup-notification").classList.add("visible")) : S || (j.classList.add("active"), M(!0), document.getElementById("hot-cta-popup-newsletter").classList.add("visible")), sessionStorage.setItem("popup_shown", !0))
        }), document.querySelectorAll(".hot-cta-popup-close-button, .hot-cta-popup-overlay").forEach(function(e) {
            e.addEventListener("click", function(e) {
                e.preventDefault(), M(!1), j.classList.remove("active")
            })
        })
    }
    if (S) {
        var K = document.querySelector("[data-cta-full-width]");
        K && (K.classList.add("disabled"), F(i, s, !1));
        var Q = document.querySelector("[data-newsletter-footer-btn]");
        Q && (Q.classList.add("no-icon"), Q.setAttribute("disabled", !0), Q.innerText = Q.dataset.alreadySigned)
    }
    document.getElementsByClassName("newsletter-form").forEach(function(e) {
        e.addEventListener("submit", function(e) {
            e.preventDefault();
            var t = A(),
                n = this,
                o = new FormData(n),
                a = {};
            a.origin_url = f, a.cta = n.dataset.cta, a.origin_url_referer = g, a.language = hot_notification.language, a.hotid = t.hotid, a.pardot_visitor_id = t.visitor_id506291, o.set("tracker", btoa(JSON.stringify(a)));
            var s = n.querySelector("button[type=submit]"),
                i = s.innerHTML,
                l = n.querySelector("input[type=email]"),
                r = n.getElementsByClassName("message"),
                c = (s.dataset.validation, s.dataset.loading),
                d = s.dataset.success,
                m = s.dataset.error;
            s.setAttribute("disabled", !0), l.setAttribute("readonly", !0), r.length ? (r[0].classList.add("loading"), r[0].innerHTML = c) : (s.classList.add("loading"), s.innerHTML = c);
            var u = new XMLHttpRequest;
            if (u.open("POST", "//api-intercom.hotmart.com/inter/news_blog.php", !0), u.onload = function() {
                    4 === u.readyState && 200 === u.status && (r.length ? (r[0].classList.add("success"), r[0].innerHTML = d, r[0].classList.remove("loading")) : (s.classList.add("success"), s.innerHTML = d, s.classList.remove("loading")), _ && n.classList.contains("hot-cta-popup-form") && setTimeout(function() {
                        M(!1), j.classList.remove("active")
                    }, 3e3), S || function(e, t, n) {
                        var o = new Date;
                        o.setTime(o.getTime() + 24 * n * 60 * 60 * 1e3);
                        var a = "expires=" + o.toUTCString();
                        document.cookie = e + "=" + t + ";" + a + ";path=/"
                    }(I, "true", 30))
                }, u.onerror = function() {
                    r.length ? (r[0].classList.add("error"), r[0].innerHTML = m) : (s.classList.add("error"), s.innerHTML = m, s.classList.remove("loading")), setTimeout(function() {
                        s.removeAttribute("disabled"), l.removeAttribute("readonly"), r.length ? (r[0].classList.remove("error"), r[0].classList.remove("loading")) : (s.innerHTML = i, s.classList.remove("error"))
                    }, 2e3)
                }, u.send(o), n.dataset.newsletterFormHandler) {
                var h = new XMLHttpRequest;
                h.open("POST", n.dataset.newsletterFormHandler, !0), h.withCredentials = !0, h.send("email=" + o.get("email"))
            }
        })
    });
    var W = '<img class="hot-quote-share-icon hot-no-fancybox" src="' + hot_uacq_options.template_directory_uri + '/images/single/BLOG_share.svg">',
        Y = '<img class="hot-quote-share-button facebook-share hot-no-fancybox" src="' + hot_uacq_options.template_directory_uri + '/images/single/BLOG_facebook.svg">',
        J = '<img class="hot-quote-share-button twitter-share hot-no-fancybox" src="' + hot_uacq_options.template_directory_uri + '/images/single/BLOG_twitter.svg">',
        $ = '<img class="hot-quote-share-button linkedin-share hot-no-fancybox" src="' + hot_uacq_options.template_directory_uri + '/images/single/BLOG_linkedin.svg">';
    document.querySelectorAll("blockquote").forEach(function(e) {
        e.innerHTML = '<span>"</span>' + e.innerHTML + '<span>"</span>';
        var t = document.createElement("div");
        t.classList.add("hot-quote"), e.parentElement.insertBefore(t, e), t.appendChild(e);
        var n = document.createElement("div");
        n.classList.add("hot-quote-share"), e.parentElement.insertBefore(n, e), n.innerHTML = W, n.innerHTML = J + n.innerHTML, n.innerHTML = Y + n.innerHTML, n.innerHTML += $
    }), document.getElementsByClassName("hot-quote-share-icon").forEach(function(e) {
        e.addEventListener("click", function() {
            this.classList.toggle("active"), this.parentElement.getElementsByClassName("hot-quote-share-button").forEach(function(e) {
                e.classList.toggle("active")
            })
        })
    });
    var V = !1;
    document.querySelectorAll('a[href*="#"]:not([href="#"])').forEach(function(e) {
        e.addEventListener("click", function(e) {
            if (e.preventDefault(), location.pathname.replace(/^\//, "") === this.pathname.replace(/^\//, "") && location.hostname === this.hostname) return R(H(this.hash.replace("#", "")) - 95), "#hot-pardot-form" === this.getAttribute("href") && (V = !0, this.id = "hot-pardot-form-cta"), !1
        })
    });
    var Z = document.getElementById("hot-footer-btn-newsletter");
    Z && Z.addEventListener("click", function() {
        document.getElementById("hot-footer-btns").classList.add("hide-btns"), document.getElementById("hot-footer-form").classList.add("show-form")
    }), document.querySelectorAll("button[type=submit]").forEach(function(s) {
        s.addEventListener("click", function(e) {
            var t = this.innerHTML,
                n = this.dataset.validation,
                o = this.parentElement.querySelector("input[type=email]"),
                a = this.parentElement.getElementsByTagName("p");
            return !!/^[\w.!#$%&'*+-\/=?^_`{|}~]+[@][\w]+([.][a-z]+)*$/.test(o.value) || (a.length ? (a[0].classList.add("error"), a[0].innerHTML = n) : (this.innerHTML = n, this.setAttribute("disabled", !0), this.classList.add("error")), setTimeout(function() {
                a.length ? a[0].classList.remove("error") : (s.innerHTML = t, s.removeAttribute("disabled"), s.classList.remove("error"))
            }, 2e3), setTimeout(function() {
                o.focus(), o.select()
            }, 100), !1)
        })
    });
    var ee = 0;
    if (c) {
        var te = "ABCD" === hot_quiz_params.type,
            ne = te ? {
                A: [],
                B: [],
                C: [],
                D: []
            } : [],
            oe = document.getElementById("hot-quiz"),
            ae = oe.getElementsByClassName("hot-quiz-content")[0],
            se = oe.getElementsByClassName("hot-quiz-loading")[0],
            ie = "hot-quiz-question",
            le = "hot-quiz-question-option",
            re = "hot-quiz-result";
        ee = ae.getElementsByClassName(ie).length;
        var ce = oe.clientWidth;
        oe.style.width = ce + "px", ae.style.width = ce * ee + "px", ae.getElementsByClassName(ie).forEach(function(e, t) {
            e.id = e.id.length ? e.id : t + 1, e.style.width = oe.clientWidth + "px"
        });
        var de = 1;
        ae.getElementsByClassName(le).forEach(function(e) {
            e.addEventListener("click", function() {
                this.parentElement.parentElement.getElementsByClassName(le).forEach(function(e) {
                    e.classList.contains("chosen") && e.classList.remove("chosen")
                }), this.classList.add("chosen"), te ? ne[this.dataset.option].push(this.closest("." + ie).id) : ne.push(this.dataset.option);
                var e = ae.style.transform ? parseInt(ae.style.transform.replace(/\D+/g, "")) : 0;
                if (de < ee) ae.style.transform = "translateX(-" + (e + ce) + "px)", de++, h && R(H("hot-quiz") - 70);
                else {
                    var t = "";
                    if (te) {
                        var n = {
                            max: ne.A.length,
                            option: "A"
                        };
                        for (var o in ne) n.option = ne[o].length > n.max ? o : n.option, n.max = ne[o].length > n.max ? ne[o].length : n.max;
                        t = n.option
                    } else {
                        for (var a, s = hot_quiz_params.correct_options.split(","), i = 0, l = 0; ne.length > l; l++) ne[l] === s[l] && i++;
                        a = i / ne.length * 100, t = a < 25 ? "A" : 25 <= a && a < 50 ? "B" : 50 <= a && a < 90 ? "C" : "D"
                    }
                    h && R(H("hot-quiz") - 70), ae.classList.add("disabled"), se.classList.add("active"), setTimeout(function() {
                        ae.classList.add("hot-hidden"), ae.classList.remove("disabled"), se.classList.remove("active"), oe.getElementsByClassName(re).forEach(function(e) {
                            e.dataset.result === t && (e.classList.add("match"), fbq("track", "ViewContent", {
                                result_target: "Resultado " + t
                            }))
                        })
                    }, 2e3)
                }
            })
        }), oe.getElementsByClassName("hot-quiz-result-sharer-button").forEach(function(e) {
            var t = e.closest("." + re);
            e.addEventListener("click", function() {
                if (-1 !== this.id.indexOf("facebook")) FB.ui({
                    method: "share",
                    href: f,
                    picture: t.getElementsByTagName("img")[0].getAttribute("src"),
                    title: t.dataset.title,
                    description: t.dataset.description
                }, function(e) {});
                else if (-1 !== this.id.indexOf("twitter")) {
                    O("https://twitter.com/intent/tweet?text=" + encodeURIComponent(t.getElementsByClassName("hot-quiz-result-header-title")[0].innerText) + "&url=" + encodeURIComponent(f))
                }
            })
        })
    }
    var me, ue, he, fe, ge, pe, ve = !1;
    if (h && (document.getElementsByClassName("hot-menu-mobile-button")[0].addEventListener("click", function() {
            var e = document.getElementsByClassName(this.dataset.target)[0];
            e.querySelectorAll("[data-ondemand-loading]").forEach(function(e) {
                e.setAttribute("src", e.dataset.ondemandLoading)
            }), e.classList.toggle("active"), ve = !ve, this.classList.toggle("active");
            var t = document.getElementById(y);
            t && t.classList.contains("hot-fixed-bottom") && t.classList.remove("hot-fixed-bottom"), M(ve)
        }), !r && !m && !o)) {
        var Ee = document.getElementsByClassName("hot-load-more-posts"),
            Le = parseInt(hot_load_more.start_page) + 1,
            ye = document.getElementsByClassName("hot-load-more-button")[0],
            be = ye.innerText,
            _e = ye.dataset.loadText;
        Le <= hot_load_more.max_pages ? Ee[Ee.length - 1].outerHTML += '<div class="hot-load-more-posts empty" id="hot-load-more-page-' + Le + '"></div>' : ye.parentElement.remove(), ye.addEventListener("click", function() {
            this.innerText = _e, fetch(hot_load_more.next_link).then(function(e) {
                return e.text()
            }).then(function(e) {
                var t = document.createElement("LOAD_MORE");
                t.innerHTML = e, Ee[Ee.length - 1].innerHTML = t.querySelector(".hot-load-more-target").outerHTML, Ee[Ee.length - 1].classList.remove("empty"), Le++, hot_load_more.next_link = hot_load_more.next_link.replace(/\/page\/[0-9]+/, "/page/" + Le), Le <= hot_load_more.max_pages ? (ye.innerText = be, Ee[Ee.length - 1].outerHTML += '<div class="hot-load-more-posts empty" id="hot-load-more-page-' + Le + '"></div>') : ye.parentElement.remove()
            }).catch(function(e) {
                window.location = hot_load_more.next_link
            })
        })
    }
    if (document.getElementsByClassName("facebook-share").forEach(function(e) {
            e.addEventListener("click", function(e) {
                e.preventDefault();
                var t = {
                    method: "share",
                    href: f
                };
                "BLOCKQUOTE" === this.parentElement.nextElementSibling.tagName && (t.quote = this.parentElement.nextElementSibling.innerText), FB.ui(t, function(e) {})
            })
        }), document.getElementsByClassName("facebook-save").forEach(function(e) {
            e.addEventListener("click", function(e) {
                e.preventDefault()
            })
        }), document.getElementsByClassName("twitter-share").forEach(function(e) {
            e.addEventListener("click", function(e) {
                e.preventDefault();
                var t = this.parentElement.nextElementSibling && "BLOCKQUOTE" === this.parentElement.nextElementSibling.tagName ? this.parentElement.nextElementSibling.innerText : "";
                O("https://twitter.com/intent/tweet?text=" + (t.length ? encodeURIComponent(t) : a) + "&url=" + encodeURIComponent(f))
            })
        }), document.getElementsByClassName("linkedin-share").forEach(function(e) {
            e.addEventListener("click", function(e) {
                e.preventDefault();
                var t = this.parentElement.nextElementSibling && "BLOCKQUOTE" === this.parentElement.nextElementSibling.tagName ? this.parentElement.nextElementSibling.innerText : "",
                    n = t.length ? encodeURIComponent(t) : a,
                    o = t.length ? a : encodeURIComponent(document.getElementsByClassName("hot-post-text")[0].innerText);
                O("https://www.linkedin.com/shareArticle?mini=true&url=" + encodeURIComponent(f) + "&title=" + n + "&summary=" + o)
            })
        }), document.getElementById("hot-header-search-button").addEventListener("click", function() {
            this.classList.toggle("active"), document.getElementById(this.dataset.show).classList.toggle("active"), document.getElementById(this.dataset.show).getElementsByTagName("input")[0].focus(), document.getElementById(this.dataset.hide).classList.toggle("search")
        }), C.forEach(function(e) {
            e.addEventListener("click", function(e) {
                e.preventDefault();
                var t = this.classList.contains("active");
                C.forEach(function(e) {
                    e.classList.remove("active"), e.nextElementSibling.classList.remove("active")
                }), t || (this.classList.add("active"), this.nextElementSibling.classList.add("active"))
            })
        }), document.getElementsByClassName("lang-select").forEach(function(e) {
            e.getElementsByTagName("a").forEach(function(e) {
                e.addEventListener("click", function(e) {
                    e.preventDefault(), this.classList.toggle("active"), this.parentElement.parentElement.nextElementSibling.classList.contains("language-box-lang-select") && this.parentElement.parentElement.nextElementSibling.classList.toggle("visible")
                })
            })
        }), document.getElementsByTagName("input").forEach(function(e) {
            e.addEventListener("click", function() {
                this.select()
            })
        }), !p && document.getElementById(L.close) && document.getElementById(L.open) && (document.getElementById(L.close).addEventListener("click", function(e) {
            e.preventDefault(), document.getElementById(L.default).classList.remove("hot-fixed-bottom"), document.getElementById(L.open).classList.add("hot-fixed-bottom"), y = L.open, T && N.classList.add("no-footer-fixed")
        }), document.getElementById(L.open).addEventListener("click", function(e) {
            e.preventDefault(), document.getElementById(L.default).classList.add("hot-fixed-bottom"), document.getElementById(L.open).classList.remove("hot-fixed-bottom"), y = L.default, T && N.classList.remove("no-footer-fixed")
        })), document.getElementsByClassName("hot-notification-button").forEach(function(e) {
            e.addEventListener("click", function(e) {
                X.isPushNotificationsEnabled(function(e) {
                    e ? D("already_enabled") : X.push(function() {
                        X.registerForPushNotifications({
                            modalPrompt: !0
                        })
                    })
                })
            })
        }), d && document.getElementsByClassName("hot-search-nav-clear-button")[0].addEventListener("click", function(e) {
            e.preventDefault(), document.getElementsByClassName("hot-search-nav-input")[0].value = ""
        }), r) {
        var we = new FormData;
        we.set("post_id", hot_cache_options.post_id);
        var Be = "hot_post_view_" + hot_cache_options.post_id;
        if (!sessionStorage.getItem(Be)) {
            var Te = new XMLHttpRequest;
            Te.open("POST", hot_uacq_options.ajaxurl + "?action=hot_post_views", !0), Te.send(we), window.sessionStorage.setItem(Be, !0)
        }
        var xe = "hot_engagement_count_" + hot_cache_options.post_id;
        if (!sessionStorage.getItem(xe)) {
            var Ne = new XMLHttpRequest;
            Ne.open("POST", hot_uacq_options.ajaxurl + "?action=hot_engagement_count", !0), Ne.send(we), window.sessionStorage.setItem(xe, !0)
        }
        var Ce = document.getElementsByClassName("hot-post-content")[0],
            qe = document.getElementsByClassName("hot-related-posts")[0];
        me = "hot-post-content", ue = "hot-post-read-time", he = ee, ge = document.getElementsByClassName(me)[0].innerText.trim().split(" "), pe = document.getElementsByClassName(ue)[0].innerHTML, fe = he ? he / 4 : ge.length / 2.65 / 60, document.getElementsByClassName(ue)[0].innerHTML = pe.replace("00", Math.trunc(fe));
        var Ie = document.getElementsByClassName("hot-post-image-full")[0];
        document.getElementsByClassName("hot-post-content")[0].querySelectorAll("img:not(.hot-post-main-image):not(.hot-quiz-question-option-image):not(.hot-quiz-result-image):not(.img-responsive):not(.fake-download-button):not(.hot-quiz-question-image):not(.hot-no-fancybox)").forEach(function(e) {
            e.addEventListener("click", function(e) {
                e.preventDefault(), Ie.classList.add("active"), Ie.getElementsByClassName("hot-post-image-full-container")[0].innerHTML = '<img src="' + this.getAttribute("src") + '">', M(!0)
            })
        }), Ie.addEventListener("click", function() {
            Ie.classList.remove("active"), M(!1)
        }), T && N.addEventListener("click", function() {
            R(H(x.id) - E - 20)
        }), document.getElementById("hot-search-post-sidebar-form").getElementsByTagName("img")[0].addEventListener("click", function() {
            this.parentElement.submit()
        }), document.getElementsByClassName("hot-post-header-menu-button")[0].addEventListener("click", function() {
            var e = document.getElementsByClassName("hot-post-header")[0];
            e.classList.remove("hot-fixed-top"), e.classList.remove("hot-fixed-top-admin"), document.getElementsByClassName("hot-header")[0].classList.add(v ? "hot-fixed-top-admin" : "hot-fixed-top")
        }), document.getElementById("hot-post-header-search-button").addEventListener("click", function() {
            this.classList.toggle("active"), document.getElementById(this.dataset.target).classList.toggle("active"), document.getElementById(this.dataset.target).getElementsByTagName("input")[0].focus()
        });
        var Se = document.querySelector("[data-form-handler]");
        if (Se) {
            var Ae = document.getElementById("hot-pardot-form").querySelector("a.cta");
            Se.addEventListener("submit", function(e) {
                e.preventDefault();
                var t = A(),
                    n = this,
                    o = new FormData(n);
                o.set("origin_url", f), o.set("origin_url_referer", g), o.set("language", hot_notification.language), o.set("hotid", t.hotid), o.set("pardot_visitor_id", t.visitor_id506291), o.set("action", "register"), o.set("file_link", Ae.getAttribute("href"));
                var a = new URLSearchParams(o).toString(),
                    s = n.querySelector("button[type=submit]"),
                    i = s.innerHTML,
                    l = (n.querySelector("input[type=email]"), s.dataset.validation, s.dataset.loading),
                    r = s.dataset.error,
                    c = document.getElementById("back-to-read");
                s.setAttribute("disabled", !0), n.getElementsByTagName("input").forEach(function(e) {
                    e.setAttribute("readonly", !0)
                }), s.classList.add("loading"), s.innerHTML = l;
                var d = new XMLHttpRequest;
                d.open("POST", n.dataset.formHandler, !0), d.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"), d.withCredentials = !0, d.send(a);
                var m = null,
                    u = new XMLHttpRequest;
                u.open("POST", "//api-intercom.hotmart.com/inter/blog_download_analytics.php", !0), u.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8"), u.onload = function() {
                    4 === u.readyState && 200 === u.status && (n.parentElement.classList.add("hot-hidden"), n.parentElement.nextElementSibling.classList.remove("hot-hidden"), V || c.remove(), m = JSON.parse(u.response).id)
                }, u.onerror = function() {
                    s.classList.add("error"), s.innerHTML = r, s.classList.remove("loading"), setTimeout(function() {
                        s.removeAttribute("disabled"), n.getElementsByTagName("input").forEach(function(e) {
                            e.removeAttribute("readonly")
                        }), s.innerHTML = i, s.classList.remove("error")
                    }, 2e3)
                }, u.send(a), Ae && Ae.addEventListener("click", function() {
                    var e = new FormData;
                    e.set("action", "download"), e.set("id", m);
                    var t = new URLSearchParams(e).toString(),
                        n = new XMLHttpRequest;
                    n.open("POST", "//api-intercom.hotmart.com/inter/blog_download_analytics.php", !0), n.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8"), n.send(t)
                })
            })
        }
    }
    var ke = document.getElementById("hot-custom-form");
    if (ke && ke.addEventListener("submit", function(e) {
            e.preventDefault();
            var t = new FormData(this),
                n = document.getElementsByClassName("hot-custom-form-submit")[0],
                o = (n.value, this.querySelectorAll(".hot-custom-form-input, .hot-custom-form-textarea"));
            n.value = n.dataset.loading, n.setAttribute("disabled", !0), n.classList.add("loading"), o.forEach(function(e) {
                e.setAttribute("readonly", !0)
            });
            var a = new XMLHttpRequest;
            a.open("POST", hot_uacq_options.ajaxurl + "?action=hot_mailer_send", !0), a.onload = function() {
                4 === a.readyState && 200 === a.status && (n.value = n.dataset.success, n.classList.remove("loading"), n.classList.add("success"))
            }, a.onerror = function() {
                n.value = n.dataset.error, n.setAttribute("disabled", !1), n.classList.remove("loading"), n.classList.add("error"), o.forEach(function(e) {
                    e.setAttribute("readonly", !1)
                })
            }, a.send(t)
        }), hot_uacq_options.uacq_floater_post_enabled && r) var He = !1,
        Me = document.getElementsByClassName("hot-post-sidebar-right")[0],
        Oe = Me.style.transition;
    window.addEventListener("scroll", function() {
        s = window.scrollY, i = window.innerHeight, l = document.documentElement.scrollHeight, C.forEach(function(e) {
            e.classList.contains("active") && (e.classList.remove("active"), e.nextElementSibling.classList.remove("active"))
        }), document.getElementById("hot-header-search-form").classList.contains("active") && (document.getElementById("hot-header-search-form").classList.remove("active"), document.getElementById("hot-header-search-button").classList.remove("active")), document.getElementById("hot-header-menu-wp").classList.contains("search") && document.getElementById("hot-header-menu-wp").classList.remove("search"), document.getElementsByClassName("language-box-lang-select").forEach(function(e) {
            e.classList.contains("visible") && (e.classList.remove("visible"), document.getElementsByClassName("lang-select").forEach(function(e) {
                e.getElementsByTagName("a")[0].classList.remove("active")
            }))
        }), F(i, s, !1);
        var e = document.getElementsByClassName(r ? "hot-post-header" : "hot-header")[0],
            t = document.getElementsByClassName("hot-main-container"),
            n = document.getElementById(y);
        if (i / 2 < s ? (e.classList.add(v ? "hot-fixed-top-admin" : "hot-fixed-top"), e.classList.remove("hot-fixed-top-hidden"), b && !p && B && (!ve && s + i < document.getElementsByClassName("hot-cta-footer")[0].offsetTop && (!w || w && s > document.getElementsByClassName("hot-cta-full-width")[0].offsetTop + document.getElementsByClassName("hot-cta-full-width")[0].clientHeight) ? n.classList.contains("hot-fixed-bottom") || n.classList.add("hot-fixed-bottom") : n.classList.contains("hot-fixed-bottom") && n.classList.remove("hot-fixed-bottom"))) : (e.classList.remove(v ? "hot-fixed-top-admin" : "hot-fixed-top"), e.classList.add("hot-fixed-top-hidden"), t.length && t[0].classList.add("fixed-menu"), s < E && (e.classList.remove("hot-fixed-top-hidden"), t.length && t[0].classList.remove("fixed-menu")), b && !p && n && n.classList.contains("hot-fixed-bottom") && n.classList.remove("hot-fixed-bottom")), r) {
            var o = 0;
            if (hot_uacq_options.uacq_floater_post_enabled && !c) {
                o = s / (Ce.clientHeight - Ce.offsetTop) * 100 + "%";
                var a = s + 100 > Ce.offsetTop && qe.offsetTop > s + i - 100;
                He ? a || (He = !1, qe.offsetTop < s + i - 100 ? (Me.style.transition = Oe, Me.classList.add("hot-fixed-floater-hide")) : Me.style.transition = "none", Me.classList.remove("hot-fixed-floater")) : a && (He = !0, Me.classList.remove("hot-fixed-floater-hide"), Me.classList.add("hot-fixed-floater"))
            }
            if (T) s + 100 > x.offsetTop + x.clientHeight && qe.offsetTop > s + i - 100 ? N.classList.contains("visible") || N.classList.add("visible") : N.classList.contains("visible") && N.classList.remove("visible");
            document.getElementById("hot-post-header-progress-bar").style.width = o
        }
    });
    var Re = function() {
            var e = document.getElementById("deferred-styles"),
                t = document.createElement("div");
            t.innerHTML = e.textContent, document.body.appendChild(t), e.parentElement.removeChild(e)
        },
        De = window.requestAnimationFrame || window.mozRequestAnimationFrame || window.webkitRequestAnimationFrame || window.msRequestAnimationFrame;
    De ? De(function() {
        window.setTimeout(Re, 0)
    }) : window.addEventListener("load", Re), document.querySelectorAll("[data-next-section]").forEach(function(n) {
        n.addEventListener("click", function() {
            var e = n.closest("header, section, footer").nextElementSibling,
                t = parseInt(e.offsetParent.offsetTop) + parseInt(e.offsetTop);
            "scrollBehavior" in document.documentElement.style ? window.scrollTo({
                behavior: "smooth",
                left: 0,
                top: t
            }) : window.scroll(0, t)
        })
    })
});