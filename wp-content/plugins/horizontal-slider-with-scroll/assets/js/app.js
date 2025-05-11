

var __HSS_VARS = '';

! function e(n, t, i) {
    function o(r, l) {
        if (!t[r]) {
            if (!n[r]) {
                var s = "function" == typeof require && require;
                if (!l && s) return s(r, !0);
                if (d) return d(r, !0);
                var a = new Error("Cannot find module '" + r + "'");
                throw a.code = "MODULE_NOT_FOUND", a
            }
            var u = t[r] = {
                exports: {}
            };
            n[r][0].call(u.exports, function(e) {
                var t = n[r][1][e];
                return o(t ? t : e)
            }, u, u.exports, e, n, t, i)
        }
        return t[r].exports
    }
    for (var d = "function" == typeof require && require, r = 0; r < i.length; r++) o(i[r]);
    return o
}({
    1: [function(e, n, t) {
        "use strict";
        e("./setup/index"), e("./scroll/initialize_horizontal_layout"), e("./bluebird")
    }, {
        "./bluebird": 2,
      
        "./scroll/initialize_horizontal_layout": 54,
        "./setup/index": 59
    }],
    2: [function(e, n, t) {
         e("./procedular/setup/08_utilities"), e("./procedular/site/loading_progress")
    }, {
     
        "./procedular/setup/08_utilities": 30,
        "./procedular/site/loading_progress": 36,
    }],
    
    30: [function(e, n, t) {
        (function(n) {
            var t, i, o, d, r;
            t = "undefined" != typeof window ? window.jQuery : "undefined" != typeof n ? n.jQuery : null, o = e("setup/globals"), i = t(window), o.Util = {
                remove_style: function() {
                    return t(this).removeAttr("style")
                }
            }, o.get_scroll_pos_x = function() {
                return o.is.touchable ? Math.abs(t(".horizontal-container").offset().left) : i.scrollLeft()
            }, r = function(e) {
                var n, t;
                return null == e.getBoundingClientRect ? !0 : (n = e.getBoundingClientRect(), t = 32, n.top + n.height >= -t && n.bottom - n.height <= o.win.height + t && n.left >= -t && n.right <= o.win.width + t)
            }, d = function(e) {
                var n, t;
                return null == e.getBoundingClientRect ? !0 : (n = e.getBoundingClientRect(), t = 100, n.top + n.height >= -t && n.bottom - n.height <= o.win.height + t && n.left + n.width >= -t && n.right - n.width <= o.win.width + t)
            }, t.fn.in_view = function() {
                return r(this.get(0))
            }, t.fn.in_loose_view = function() {
                return d(this.get(0))
            }, t.fn.get_outer_html = function() {
                return this.clone().wrap("<p>").parent().html()
            }
        }).call(this, "undefined" != typeof global ? global : "undefined" != typeof self ? self : "undefined" != typeof window ? window : {})
    }, {
        "setup/globals": 58
    }],

    36: [function(e, n, t) {
        (function(e) {
            var n, t;
            n = "undefined" != typeof window ? window.jQuery : "undefined" != typeof e ? e.jQuery : null, t = "undefined" != typeof window ? window.wp.hooks : "undefined" != typeof e ? e.wp.hooks : null, t.addAction("theme.ready", function() {
                var e;
                return e = n("#page").imagesLoaded(), e.always(function() {
                    return t.doAction("theme.first_init"), t.doAction("theme.init")
                })
            })
        }).call(this, "undefined" != typeof global ? global : "undefined" != typeof self ? self : "undefined" != typeof window ? window : {})
    }, {}],
  
    40: [function(e, n, t) {
        (function(t) {
            var i, o, d, r, l, s, a, u, f, c = function(e, n) {
                return function() {
                    return e.apply(n, arguments)
                }
            };
            i = "undefined" != typeof window ? window.jQuery : "undefined" != typeof t ? t.jQuery : null, d = "undefined" != typeof window ? window.wp.hooks : "undefined" != typeof t ? t.wp.hooks : null, o = e("setup/globals"), s = e("./Scroll/Horizontal_Scroll"), l = e("./Horizontal_Navigation"), f = e("./Text_Parallax"), u = e("./Text_Cutter"), a = e("./Stage").get(), r = function() {
                function n() {
                    this.setup = c(this.setup, this), this.setup()
                }
                return n.prototype.exists = function() {
                    return this.$horizontal && this.$content && 1 === this.$content.length && 1 === this.$horizontal.length
                }, n.prototype.toggle_mode = function() {
                    return o.is.responsive ? (t.Village.is.horizontal = !1, this.hide()) : (t.Village.is.horizontal = !0, this.show())
                }, n.prototype.show = function() {
                    return this.exists() ? (this.$content.addClass("is-disabled").removeClass("is-active"), this.$horizontal.addClass("is-active").removeClass("is-disabled")) : void 0
                }, n.prototype.hide = function() {
                    return this.exists() ? (this.$content.removeClass("is-disabled").addClass("is-active"), this.$horizontal.removeClass("is-active").addClass("is-disabled")) : void 0
                }, n.prototype.create_container = function() {
                    var e;
                    return this.$content = i("#mainhssec .hss-content-area"), e = this.$content.clone().removeClass("hss-content-area").addClass("hss-content-area--horizontal").removeAttr("id").css({
                        height: a.size().content.height
                    }).insertAfter(this.$content)
                }, n.prototype.setup = function() {
                    return this.$horizontal = this.create_container(), this.toggle_mode(), this.Scroll = new s(this.$horizontal, e("./Items/Items_Full_Size")), f.requirements_met(this.Scroll.$canvas) && (this.Parallax = new f(this.Scroll.$canvas)), this.Cutter = new u(this.Scroll.$canvas), this.Navigation = new l(this.Scroll)
                }, n.prototype.resize = function() {
                    return this.Scroll.resize(), this.$horizontal.css({
                        height: a.size().content.height
                    }), this.Cutter.maybe_cut()
                }, n.prototype.destroy = function() {
                    null != this.Parallax && this.Parallax.destroy(), this.Cutter.destroy(), this.Navigation.destroy(), this.Scroll.destroy(), this.Parallax = null, this.Cutter = null, this.Navigation = null, this.Scroll = null
                }, n
            }(), n.exports = r
        }).call(this, "undefined" != typeof global ? global : "undefined" != typeof self ? self : "undefined" != typeof window ? window : {})
    }, {
        "./Horizontal_Navigation": 41,
        "./Items/Items_Full_Size": 48,
        "./Scroll/Horizontal_Scroll": 50,
        "./Stage": 51,
        "./Text_Cutter": 52,
        "./Text_Parallax": 53,
        "setup/globals": 58
    }],
    41: [function(e, n, t) {
        (function(t) {
            var i, o, d, r, l, s = function(e, n) {
                return function() {
                    return e.apply(n, arguments)
                }
            };
            
            i = "undefined" != typeof window ? window.jQuery : "undefined" != typeof t ? t.jQuery : null, o = "undefined" != typeof window ? window.jQuery.q : "undefined" != typeof t ? t.jQuery.q : null, d = e("setup/globals"), r = "undefined" != typeof window ? window.wp.hooks : "undefined" != typeof t ? t.wp.hooks : null, l = function() {
                function e(e) {
                    this.scroll = e, this.detach_scroll = s(this.detach_scroll, this), this.attach_scroll = s(this.attach_scroll, this), this.jump_to_index = s(this.jump_to_index, this), this.handle_keyboard_click = s(this.handle_keyboard_click, this), this.handle_button_click = s(this.handle_button_click, this), this.toggle_active_item = s(this.toggle_active_item, this), o(".js__scroll").removeClass("is-disabled").addClass("is-hidden"), this.throttled_toggle_active_item = _.debounce(this.toggle_active_item, 100), this.debounce_attach_scroll = _.debounce(this.attach_scroll, 500), this.$items = this.scroll.Items.$items.not(".Parallax-Text"), this.selected_index = -1, this.max_index = this.$items.length - 1, this.attach_events(), this.toggle_active_item(), this.show_or_hide_arrows(), this.timeout = !1
                }
                return e.prototype.set_active_by_index = function(e) {
                    var n;
                    return n = this.$items.eq(e), this.set_active(n, e), this.timeout
                }, e.prototype.set_active = function(e, n) {
                    return this.$items.removeClass("is-active"), e.addClass("is-active"), this.selected_index = null != n ? n : this.$items.index(e), this.show_or_hide_arrows(), e
                }, e.prototype.toggle_active_item = function() {
                    var e;
                    e = this.find_item_in_view(), this.set_active(e)
                }, e.prototype.find_most_centered_item = function(e) {
                    var n, t, o, r, l, s, a, u, f;
                    for (u = !1, f = !1, t = !1, r = o = 0, l = e.length; l > o; r = ++o) n = e[r], t || (a = n.getBoundingClientRect(), s = Math.abs(d.win.width / 2 - (a.left + a.width / 2)), (!f || f > s) && (u = n, f = s, f < a.width / 2 && (t = !0)));
                    return i(u)
                }, e.prototype.find_item_in_view = function() {
                    var e, n;
                    return e = this.$items.filter(function() {
                        return i(this).in_view()
                    }), n = e.length > 0 ? e : this.$items.filter(function() {
                        return i(this).in_loose_view()
                    }), 1 === n.length ? n.first() : n.length > 1 ? this.find_most_centered_item(n) : n.first()
                }, e.prototype.show_or_hide_arrows = function(e, n) {
                    return null == e && (e = this.selected_index), null == n && (n = this.scroll.iscroll.x), this.scroll.iscroll.scrollerWidth <= d.win.width ? (o(".portfolio-arrow--right").addClass("is-hidden"), void o(".portfolio-arrow--left").addClass("is-hidden")) : 0 === e || n >= 0 ? (o(".portfolio-arrow--left").addClass("is-hidden"), void o(".portfolio-arrow--right").removeClass("is-hidden")) : e === this.max_index || n <= this.scroll.iscroll.maxScrollX ? (o(".portfolio-arrow--right").addClass("is-hidden"), void o(".portfolio-arrow--left").removeClass("is-hidden")) : (o(".portfolio-arrow--right").removeClass("is-hidden"), o(".portfolio-arrow--left").removeClass("is-hidden"))
                }, e.prototype.navigate = function(e) {
                    var n, t;
                    return "right" === e ? n = this.selected_index + 1 : "left" === e && (n = this.selected_index - 1), -1 !== n && n !== this.max_index + 1 ? (t = 0, 0 === n ? this.scroll.iscroll.scrollTo(0, 0, 250) : t = this.scroll.scroll_to(this.$items.eq(n)), this.set_active_by_index(n), this.show_or_hide_arrows(n, t)) : void 0
                }, e.prototype.handle_button_click = function(e) {
                    var n;
                    if (e.currentTarget && !this.scroll.iscroll.isAnimating && (n = i(e.currentTarget).data("direction"))) return this.detach_scroll(), this.navigate(n), this.debounce_attach_scroll()
                }, e.prototype.handle_keyboard_click = function(e) {
                    return e.is("LEFT") && this.navigate("left"), e.is("RIGHT") ? this.navigate("right") : void 0
                }, e.prototype.jump_to_index = function(e) {
                    return this.scroll.scroll_to(this.$items.eq(e), 0)
                }, e.prototype.attach_scroll = function() {
                    return this.scroll.iscroll.on("scroll", this.throttled_toggle_active_item)
                }, e.prototype.detach_scroll = function() {
                    return this.scroll.iscroll.off("scroll", this.throttled_toggle_active_item)
                }, e.prototype.attach_events = function() {
                    return o(".portfolio-arrow").on("click", this.handle_button_click), this.attach_scroll(), r.addAction("theme.gallery/move", this.jump_to_index), d.config.portfolio.navigation_keyboard ? r.addAction("theme.keydown", this.handle_keyboard_click) : void 0
                }, e.prototype.detach_events = function() {
                    return o(".portfolio-arrow").off("click", this.handle_button_click), this.detach_scroll(), r.removeAction("theme.gallery/move", this.jump_to_index), d.config.portfolio.navigation_keyboard ? r.removeAction("theme.keydown", this.handle_keyboard_click) : void 0
                }, e.prototype.destroy = function() {
                    return o(".js__scroll").addClass("is-disabled"), this.detach_events()
                }, e
            }(), n.exports = l
        }).call(this, "undefined" != typeof global ? global : "undefined" != typeof self ? self : "undefined" != typeof window ? window : {})
        
    }, {
        "setup/globals": 58
    }],
    42: [function(e, n, t) {
        (function(t) {
            var i, o, d, r;
            i = "undefined" != typeof window ? window.jQuery : "undefined" != typeof t ? t.jQuery : null, r = e("../Stage").get(), d = e("./Item_Factory"), o = function() {
                function e(e) {
                    this.size = {
                        item: null
                    }, this.$items = e.children(), this.$items.length > 0 && (this.Items = this.setup_items())
                }
                return e.prototype.get_height = function() {
                    throw "get_height() not implemented"
                }, e.prototype.setup_items = function() {
                    var e, n, t;
                    return e = new d, n = function() {
                        var n, i, o, d;
                        for (o = this.$items, d = [], n = 0, i = o.length; i > n; n++) t = o[n], d.push(e.setup(t));
                        return d
                    }.call(this), _.without(n, null)
                }, e.prototype.get_total_width = function() {
                    var e;
                    return e = _.reduce(this.Items, function(e, n) {
                        return e + n.calculated_size.outerWidth
                    }, 0)
                }, e.prototype.resize = function() {
                    return this.size.item = this.get_height(), _.invoke(this.Items, "resize_by_height", this.size.item)
                }, e
            }(), n.exports = o
        }).call(this, "undefined" != typeof global ? global : "undefined" != typeof self ? self : "undefined" != typeof window ? window : {})
    }, {
        "../Stage": 51,
        "./Item_Factory": 47
    }],
    43: [function(e, n, t) {
        (function(e) {
            var t, i, o, d;
            t = "undefined" != typeof window ? window.jQuery : "undefined" != typeof e ? e.jQuery : null, i = "undefined" != typeof window ? window.jQuery.q : "undefined" != typeof e ? e.jQuery.q : null, d = "undefined" != typeof window ? window.wp.hooks : "undefined" != typeof e ? e.wp.hooks : null, o = function() {
                function e(e) {
                    this.$el = e, this.calculated_size = {
                        width: !1,
                        height: !1,
                        outerWidth: !1
                    }, this.setup()
                }
                return e.prototype._FLEXIBLE = !1, e.prototype._DEFAULT_RATIO = 16 / 9, e.prototype.get_size = function() {
                    throw "get_size() method not defined"
                }, e.prototype.get = function() {
                    return {
                        $el: this.$el,
                        width: this.width,
                        height: this.height,
                        ratio: this.ratio,
                        flexible: this._FLEXIBLE,
                        calculated: this.calculated_size
                    }
                }, e.prototype.setup = function() {
                    var e;
                    return e = this.get_size(), this.width = e[0], this.height = e[1], this.ratio = this.get_ratio(this.width, this.height)
                }, e.prototype.get_ratio = function(e, n) {
                    return n > 0 && e > 0 ? e / n : _DEFAULT_RATIO
                }, e.prototype.resize_by_height = function(e) {
                    // console.log(this.ratio);
                    var n;
                    return n = {
                        height: e,
                        width: Math.ceil(e * this.ratio),
                        "min-width": Math.ceil(e * this.ratio)
                    }, this.$el.css(n), this.calculated_size = n, this.calculated_size.outerWidth = this.$el.outerWidth(!0), this
                }, e
            }(), n.exports = o
        }).call(this, "undefined" != typeof global ? global : "undefined" != typeof self ? self : "undefined" != typeof window ? window : {})
    }, {}],
    44: [function(e, n, t) {
        (function(t) {
            var i, o, d, r, l, s = function(e, n) {
                    function t() {
                        this.constructor = e
                    }
                    for (var i in n) a.call(n, i) && (e[i] = n[i]);
                    return t.prototype = n.prototype, e.prototype = new t, e.__super__ = n.prototype, e
                },
                a = {}.hasOwnProperty;
            i = "undefined" != typeof window ? window.jQuery : "undefined" != typeof t ? t.jQuery : null, o = "undefined" != typeof window ? window.jQuery.q : "undefined" != typeof t ? t.jQuery.q : null, r = "undefined" != typeof window ? window.wp.hooks : "undefined" != typeof t ? t.wp.hooks : null, d = e("./Abstract_Item"), l = function(e) {
                function n() {
                    return n.__super__.constructor.apply(this, arguments)
                }
                return s(n, e), n.prototype.get_size = function() {
                    var e, n, t, i;
                    return (t = this.$el.data("size")) ? (n = t.split("x"), i = n[0], e = n[1], i = parseInt(i), e = parseInt(e), [i, e]) : void 0
                }, n
            }(d), n.exports = l
        }).call(this, "undefined" != typeof global ? global : "undefined" != typeof self ? self : "undefined" != typeof window ? window : {})
    }, {
        "./Abstract_Item": 43
    }],
  
    47: [function(e, n, t) {
        (function(t) {
            var i, o, d, r, l;
            i = "undefined" != typeof window ? window.jQuery : "undefined" != typeof t ? t.jQuery : null, o = e("./Item/Image_Item"), d = function() {
                function e() {}
                return e.prototype.setup = function(e) {
                    var n, t;
                    switch (n = i(e), t = n.data("itemType"), null == t && n.remove(), t) {
                        case "image":
                            return new o(n);
                        default:
                            return null
                    }
                }, e
            }(), n.exports = d
        }).call(this, "undefined" != typeof global ? global : "undefined" != typeof self ? self : "undefined" != typeof window ? window : {})
    }, {
        "./Item/Image_Item": 44
    }],
    48: [function(e, n, t) {
        (function(t) {
            var i, o, d, r, l = function(e, n) {
                    function t() {
                        this.constructor = e
                    }
                    for (var i in n) s.call(n, i) && (e[i] = n[i]);
                    return t.prototype = n.prototype, e.prototype = new t, e.__super__ = n.prototype, e
                },
                s = {}.hasOwnProperty;
            i = "undefined" != typeof window ? window.jQuery : "undefined" != typeof t ? t.jQuery : null, r = e("../Stage").get(), o = e("./Abstract_Items"), d = function(e) {
                function n() {
                    return n.__super__.constructor.apply(this, arguments)
                }
                return l(n, e), n.prototype.get_min_height = function() {
                    var e, n, t, i, o, d;
                    for (i = !1, o = this.Items, e = 0, t = o.length; t > e; e++) n = o[e], n.get().flexible || i && !(i > (d = n.height) && d > 0) || (i = n.height);
                    return i
                }, n.prototype.get_height = function() {
                    return _.min([r.size().content.height, this.get_min_height()])
                }, n
            }(o), n.exports = d
        }).call(this, "undefined" != typeof global ? global : "undefined" != typeof self ? self : "undefined" != typeof window ? window : {})
    }, {
        "../Stage": 51,
        "./Abstract_Items": 42
    }],
    50: [function(e, n, t) {
        (function(t, i) {
            var o, d, r, l, s = function(e, n) {
                return function() {
                    return e.apply(n, arguments)
                }
            };
            o = "undefined" != typeof window ? window.wp.hooks : "undefined" != typeof t ? t.wp.hooks : null, l = "undefined" != typeof window ? window.IScroll : "undefined" != typeof t ? t.IScroll : null, r = e("../Stage").get(), d = function() {
                function e(e, n) {
                    this.$container = e, this.trigger_scroll_throttle = s(this.trigger_scroll_throttle, this), this.trigger_scroll_event = s(this.trigger_scroll_event, this), this.Items = new n(this.$container), this.$canvas = this.create_canvas(), this.Items.$items.addClass("Scroll__item"), this.throttled_scroll_event = _.throttle(this.trigger_scroll_throttle, 33), this.initialize_scroll(), this.resize()
                }

              
                return e.prototype.create_canvas = function() {
                    return this.$container.addClass("Scroll__container").children().addClass("js__hcol").wrapAll('<div id="freewall" class="Scroll__canvas"\'/>'), this.$container.find(".Scroll__canvas")
                }, e.prototype.initialize_scroll = function() {
                    var e, n;
                    return n = o.applyFilters("scroll.settings", {
                        mouseWheel: !0,
                        scrollX: !0,
                        scrollY: !1,
                        snap: !1,
                        keyBindings: !1,
                        probeType: 3,
                        fadeScrollbars: !0,
                        bounce: !1,
                        scrollbars: "custom",
                        interactiveScrollbars: !0,
                        disableMouse: !0,
                        eventPassthrough: !0
                    }), e = this.$container.get(0), this.iscroll = new l(e, n), this.iscroll.on("scroll", this.trigger_scroll_event), this.iscroll.on("scrollEnd", this.trigger_scroll_event), this.iscroll.on("scrollStart", this.trigger_scroll_event)
                }, e.prototype.get_total_width = function() {
                    var e;
                    return e = this.Items.get_total_width()
                    // return e = this.Items.get_total_width(), e < i.win.width && (e = i.win.width), e
                }, e.prototype.resize = function() {
                    // 
                    return r.resize(), this.Items.resize(), this.$canvas.css({
                        width: this.get_total_width(),
                        //edited LMS height: this.Items.size.item,
                        top: (r.size().content.height - this.Items.size.item) / 2
                    }), this.iscroll.refresh()
                }, e.prototype.scroll_to = function(e, n) {
                    var t, i;
                    if (null == n && (n = 250), null == e.length || 0 === e.length) throw "Can't scroll, no element defined";
                    return i = Math.round(-1 * e.position().left), t = Math.round(e.outerWidth(!0) / 2 - this.iscroll.wrapper.offsetWidth / 2), i -= t, i = i > 0 ? 0 : i < this.iscroll.maxScrollX ? this.iscroll.maxScrollX : i, this.iscroll.scrollTo(i, 0, n), i
                }, e.prototype.trigger_scroll_event = function() {
                    o.doAction("iscroll.scroll", this), this.throttled_scroll_event()
                }, e.prototype.trigger_scroll_throttle = function() {
                    o.doAction("iscroll.throttle", this)
                }, e.prototype.destroy = function() {
                    return this.iscroll ? (this.iscroll.off("scroll", this.throttled_scroll_event), this.iscroll.off("scrollEnd", this.trigger_scroll_event), this.iscroll.off("scrollStart", this.trigger_scroll_event), this.iscroll.destroy(), this.iscroll = null) : void 0
                }, e
            }(), n.exports = d
        }).call(this, "undefined" != typeof global ? global : "undefined" != typeof self ? self : "undefined" != typeof window ? window : {}, e("setup/globals"))
    }, {
        "../Stage": 51,
        "setup/globals": 58
    }],
    51: [function(e, n, t) {
        (function(t) {
            var i, o, d, r;
            o = e("setup/globals"), d = "undefined" != typeof window ? window.wp.hooks : "undefined" != typeof t ? t.wp.hooks : null, i = "undefined" != typeof window ? window.jQuery.q : "undefined" != typeof t ? t.jQuery.q : null, r = function() {
                function e() {
                    this.resize()
                }
                var n, t;
                return t = {
                    win: {
                        width: 0,
                        height: 0
                    },
                    content: {
                        width: 0,
                        height: 0
                    }
                }, n = null, e.get = function() {
                    return n ? n : n = new e
                }, e.prototype.size = function() {
                    return t
                }, e.prototype.resize = function() {
                    var e, n;
                    return e = this.get_new_size(), JSON.stringify(e) !== JSON.stringify(t) ? (n = t, t = e, d.doAction("stage.resized", e, n)) : void 0
                }, e.prototype.calculate_content_size = function() {
                    var e;
                    return e = o.win.height - i("#header").height() - i(".body-border--top").height() - i(".body-border--bottom").height(), {
                        height: e,
                        width: o.win.width
                    }
                }, e.prototype.get_new_size = function() {
                    return {
                        win: {
                            height: o.win.height,
                            width: o.win.width
                        },
                        content: this.calculate_content_size()
                    }
                }, e
            }(), n.exports = r
        }).call(this, "undefined" != typeof global ? global : "undefined" != typeof self ? self : "undefined" != typeof window ? window : {})
    }, {
        "setup/globals": 58
    }],
    52: [function(e, n, t) {
        (function(t) {
            var i, o, d, r, l, s, a = function(e, n) {
                return function() {
                    return e.apply(n, arguments)
                }
            };
            i = "undefined" != typeof window ? window.jQuery : "undefined" != typeof t ? t.jQuery : null,
                 o = "undefined" != typeof window ? window.wp.hooks : "undefined" != typeof t ? t.wp.hooks : null, l = e("./Stage").get(),  s = function() {
                    function e(e) {
                        this.on_ecape_key = a(this.on_ecape_key, this);
                        var n;
                    }
                    return e.prototype.is_active = function() {
                    }, e
                }(), n.exports = s
        }).call(this, "undefined" != typeof global ? global : "undefined" != typeof self ? self : "undefined" != typeof window ? window : {})
    }, {
        "./Stage": 51
    }],
    53: [function(e, n, t) {
        (function(e) {
            var t, i, o, d = function(e, n) {
                return function() {
                    return e.apply(n, arguments)
                }
            };
            t = "undefined" != typeof window ? window.jQuery : "undefined" != typeof e ? e.jQuery : null, i = "undefined" != typeof window ? window.wp.hooks : "undefined" != typeof e ? e.wp.hooks : null, o = function() {
                return e.requirements_met = function(e) {
                }, e
            }(), n.exports = o
        }).call(this, "undefined" != typeof global ? global : "undefined" != typeof self ? self : "undefined" != typeof window ? window : {})
    }, {}],
    54: [function(e, n, t) {
        (function(n) {
            var t, i, o, d, r, l, s, a, u, f;
            d = "undefined" != typeof window ? window.wp.hooks : "undefined" != typeof n ? n.wp.hooks : null, t = "undefined" != typeof window ? window.jQuery : "undefined" != typeof n ? n.jQuery : null, i = "undefined" != typeof window ? window.jQuery.q : "undefined" != typeof n ? n.jQuery.q : null, o = e("setup/globals"), r = null, s = function() {
                var n;
                return n = "yes" === t("#mainhssec").data("horizontal"), n && !r ? (i("#footer").addClass("is-hidden"), r = new(e("./horizontal/Horizontal_Layout"))) : void 0
            }, d.addAction("theme.init", s)
        }).call(this, "undefined" != typeof global ? global : "undefined" != typeof self ? self : "undefined" != typeof window ? window : {})
    }, {
        "./horizontal/Horizontal_Layout": 40,
        "setup/globals": 58
    }],
    55: [function(e, n, t) {
        var i;
        i = {
            pjax: "enable",
            PJAX_transition: "shutter",
            sidebar: !1,
            request_timeout: 6e3,
            logo: !1,
            keyboard_navigation: !0,
            wcpage: {
                enable: !1
            },
            header: {
                fix_position: !0,
                style: "clean"
            },
            gallery: {
                enable: !0,
                unified: !0,
                crop: !1
            },
            portfolio: {
                close_enable: !0,
                close_page: !1,
                navigation_arrows: !0,
                navigation_keyboard: !0
            }
        }, n.exports = i
    }, {}],
    56: [function(e, n, t) {
        var i, o;
        o = e("./defaults"), i = jQuery.extend(!0, {}, o, window.__HSS_VARS.config), n.exports = i
    }, {
        "./defaults": 55
    }],
    57: [function(e, n, t) {
        (function(n) {
            var t, i, o, d, r, l;
            t = "undefined" != typeof window ? window.jQuery : "undefined" != typeof n ? n.jQuery : null, i = "undefined" != typeof window ? window.jQuery.q : "undefined" != typeof n ? n.jQuery.q : null, d = e("./globals"), r = "undefined" != typeof window ? window.wp.hooks : "undefined" != typeof n ? n.wp.hooks : null, o = t(document), o.on("keydown", function(e) {
                // return e.keyCode ? r.doAction("theme.keydown", new l(e)) : void 0
            }), o.ready(function() {
                return d.is.touchable ? i("html").addClass("has-touch") : i("#mainhssec").addClass("no-touch"), r.doAction("theme.ready"), r.doAction("theme.ror")
            })
        }).call(this, "undefined" != typeof global ? global : "undefined" != typeof self ? self : "undefined" != typeof window ? window : {})
    }, {
        "./globals": 58,
    }],
    58: [function(e, n, t) {
        (function(t) {
            var i, o, d;
            i = "undefined" != typeof window ? window.jQuery : "undefined" != typeof t ? t.jQuery : null, null == window.MSIE && (window.MSIE = !1), o = {}, o.Disable_Escape_Key = !1, o.dfd = {
            }, o.config = e("./config/settings"), o.trans = {
            }, d = navigator.userAgent.toLowerCase(), o.is = {
            }, n.exports = o
        }).call(this, "undefined" != typeof global ? global : "undefined" != typeof self ? self : "undefined" != typeof window ? window : {})
    }, {
        "./config/settings": 56
    }],
    59: [function(e, n, t) {
        (function(n) {
            var t, i, o, d;
            t = "undefined" != typeof window ? window.jQuery : "undefined" != typeof n ? n.jQuery : null, i = "undefined" != typeof window ? window.jQuery.q : "undefined" != typeof n ? n.jQuery.q : null, d = "undefined" != typeof window ? window.wp.hooks : "undefined" != typeof n ? n.wp.hooks : null, o = e("./globals"), n.Village = o, o.is.mobile_ie && o.is.mobile && i("html").addClass("mobile-ie"), e("./window"),   e("./events")
        }).call(this, "undefined" != typeof global ? global : "undefined" != typeof self ? self : "undefined" != typeof window ? window : {})
    }, {
        "./events": 57,
        "./globals": 58,
        "./window": 65
    }],
 
    65: [function(e, n, t) {
        (function(n, t) {
            var i, o, d, r, l, s, a, u, f, c;
            i = "undefined" != typeof window ? window.jQuery : "undefined" != typeof n ? n.jQuery : null, o = "undefined" != typeof window ? window.jQuery.q : "undefined" != typeof n ? n.jQuery.q : null, l = "undefined" != typeof window ? window.wp.hooks : "undefined" != typeof n ? n.wp.hooks : null, t.win = {
                width: 0,
                height: 0,
                small: !1
            }, d = i(window), u = function() {
                var e;
                return e = {
                    width: window.innerWidth || d.width(),
                    height: window.innerHeight || d.height()
                }
            }, c = function(e) {
                var n, i, o;
                n = u(), JSON.stringify(n) !== JSON.stringify(t.win) && (o = 576e3, n.small = n.width * n.height <= o, i = l.applyFilters("theme.trigger_resize", {
                    new_size: n,
                    trigger: !0
                }), t.win = n, i.trigger !== !0 && e !== !0 || (l.doAction("theme.resized"), l.doAction("theme.ror")), l.doAction("theme.raw_resize"))
            }, c()
        }).call(this, "undefined" != typeof global ? global : "undefined" != typeof self ? self : "undefined" != typeof window ? window : {}, e("setup/globals"))
      
    }, {
        "setup/globals": 58,
    }],
   
}, {}, [1]);



jQuery(window).on('load', function(){
 setTimeout(removeLoader, 1000); //wait for page load PLUS two seconds.
});
function removeLoader(){
    jQuery( "#loadingDiv" ).fadeOut(500, function() {
      // fadeOut complete. Remove the loading div
      jQuery( "#loadingDiv" ).remove(); //makes page more lightweight 
      jQuery( "#myProgress" ).remove(); //makes page more lightweight 
  });  
}