! function(e, t)
{
    "object" == typeof exports && "undefined" != typeof module ? t(require("jquery")) : "function" == typeof define && define.amd ? define(["jquery"], t) : t(e.jQuery)
}(this, function(e)
{
    "use strict";

    function t(e, t)
    {
        return function(n, i)
        {
            var s, o = [];
            return t(i) && (s = k.splitTokens(k.split(n, e)), y.each(i, function(t, i)
            {
                var a = t.value;
                if (k.stringEncloses(n, a)) return !1;
                var r = k.splitTokens(k.split(a, e));
                0 === y.minus(s, r).length && o.push(i)
            })), 1 === o.length ? o[0] : -1
        }
    }

    function n(e, t)
    {
        var n = e.data && e.data[t];
        return n && new RegExp("^" + k.escapeRegExChars(n) + "([" + w + "]|$)", "i").test(e.value)
    }

    function i(e, t)
    {
        var n = /<strong>/;
        return n.test(t) && !n.test(e) ? t : e
    }

    function s(e, t, n, s, o)
    {
        var a = this;
        return i(a.highlightMatches(e, n, s, o), a.highlightMatches(t, n, s, o))
    }

    function o(e)
    {
        this.urlSuffix = e.toLowerCase(), this.noSuggestionsHint = "Неизвестное значение", this.matchers = [O.matchByNormalizedQuery(), O.matchByWords()]
    }

    function a(t, n)
    {
        var i = this;
        i.element = t, i.el = e(t), i.suggestions = [], i.badQueries = [], i.selectedIndex = -1, i.currentValue = i.element.value, i.intervalId = 0, i.cachedResponse = {}, i.enrichmentCache = {}, i.currentRequest = null, i.inputPhase = e.Deferred(), i.fetchPhase = e.Deferred(), i.enrichPhase = e.Deferred(), i.onChangeTimeout = null, i.triggering = {}, i.$wrapper = null, i.options = e.extend(
        {}, B, n), i.classes = x, i.disabled = !1, i.selection = null, i.$viewport = e(window), i.$body = e(document.body), i.type = null, i.status = {}, i.setupElement(), i.initializer = e.Deferred(), i.el.is(":visible") ? i.initializer.resolve() : i.deferInitialization(), i.initializer.done(e.proxy(i.initialize, i))
    }

    function r()
    {
        j.each(Q, function(e)
        {
            e.abort()
        }), Q = {}
    }

    function l()
    {
        K = null, B.geoLocation = G
    }

    function c(t)
    {
        return e.map(t, function(e)
        {
            var t = j.escapeHtml(e.text);
            return t && e.matched && (t = "<strong>" + t + "</strong>"), t
        }).join("")
    }

    function u(t, n)
    {
        var i = t.split(", ");
        return 1 === i.length ? t : e.map(i, function(e)
        {
            return '<span class="' + n + '">' + e + "</span>"
        }).join(", ")
    }

    function d(t, n)
    {
        var i = !1;
        return e.each(t, function(e, t)
        {
            if (i = t.value == n.value && t != n) return !1
        }), i
    }

    function f(e, t)
    {
        var n = t.selection,
            i = n && n.data && t.bounds;
        return i && y.each(t.bounds.all, function(t, s)
        {
            return i = n.data[t] === e.data[t]
        }), i
    }

    function p(e)
    {
        var t = e.replace(/^(\d{2})(\d*?)(0+)$/g, "$1$2"),
            n = t.length,
            i = -1;
        return n <= 2 ? i = 2 : n > 2 && n <= 5 ? i = 5 : n > 5 && n <= 8 ? i = 8 : n > 8 && n <= 11 ? i = 11 : n > 11 && n <= 15 ? i = 15 : n > 15 && (i = 19), k.padEnd(t, i, "0")
    }

    function h(e)
    {
        this.plan = e.status.plan, this.isMobile = e.isMobile;
        var t = e.getContainer();
        this.element = pe.selectByClass(x.promo, t)
    }

    function g()
    {
        new h(this).show()
    }
    e = e && e.hasOwnProperty("default") ? e.default : e;
    var m = {
            isArray: function(e)
            {
                return Array.isArray(e)
            },
            isFunction: function(e)
            {
                return "[object Function]" === Object.prototype.toString.call(e)
            },
            isEmptyObject: function(e)
            {
                return 0 === Object.keys(e).length && e.constructor === Object
            },
            isPlainObject: function(e)
            {
                return void 0 !== e && "object" == typeof e && null !== e && !e.nodeType && e !== e.window && !(e.constructor && !Object.prototype.hasOwnProperty.call(e.constructor.prototype, "isPrototypeOf"))
            }
        },
        y = {
            compact: function(e)
            {
                return e.filter(function(e)
                {
                    return !!e
                })
            },
            each: function(e, t)
            {
                if (Array.isArray(e)) return void e.some(function(e, n)
                {
                    return !1 === t(e, n)
                });
                Object.keys(e).some(function(n)
                {
                    var i = e[n];
                    return !1 === t(i, n)
                })
            },
            intersect: function(e, t)
            {
                var n = [];
                return Array.isArray(e) && Array.isArray(t) ? e.filter(function(e)
                {
                    return -1 !== t.indexOf(e)
                }) : n
            },
            minus: function(e, t)
            {
                return t && 0 !== t.length ? e.filter(function(e)
                {
                    return -1 === t.indexOf(e)
                }) : e
            },
            makeArray: function(e)
            {
                return m.isArray(e) ? Array.prototype.slice.call(e) : [e]
            },
            minusWithPartialMatching: function(e, t)
            {
                return t && 0 !== t.length ? e.filter(function(e)
                {
                    return !t.some(function(t)
                    {
                        return 0 === t.indexOf(e)
                    })
                }) : e
            },
            slice: function(e, t)
            {
                return Array.prototype.slice.call(e, t)
            }
        },
        v = {
            delay: function(e, t)
            {
                return setTimeout(e, t || 0)
            }
        },
        b = {
            areSame: function e(t, n)
            {
                var i = !0;
                return typeof t == typeof n && ("object" == typeof t && null != t && null != n ? (y.each(t, function(t, s)
                {
                    return i = e(t, n[s])
                }), i) : t === n)
            },
            assign: function(e, t)
            {
                if ("function" == typeof Object.assign) return Object.assign.apply(null, arguments);
                if (null == e) throw new TypeError("Cannot convert undefined or null to object");
                for (var n = Object(e), i = 1; i < arguments.length; i++)
                {
                    var s = arguments[i];
                    if (null != s)
                        for (var o in s) Object.prototype.hasOwnProperty.call(s, o) && (n[o] = s[o])
                }
                return n
            },
            clone: function(e)
            {
                return JSON.parse(JSON.stringify(e))
            },
            compact: function(e)
            {
                var t = b.clone(e);
                return y.each(t, function(e, n)
                {
                    null !== e && void 0 !== e && "" !== e || delete t[n]
                }), t
            },
            fieldsAreNotEmpty: function(e, t)
            {
                if (!m.isPlainObject(e)) return !1;
                var n = !0;
                return y.each(t, function(t, i)
                {
                    return n = !!e[t]
                }), n
            },
            getDeepValue: function e(t, n)
            {
                var i = n.split("."),
                    s = i.shift();
                return t && (i.length ? e(t[s], i.join(".")) : t[s])
            },
            indexObjectsById: function(e, t, n)
            {
                var i = {};
                return y.each(e, function(e, s)
                {
                    var o = e[t],
                        a = {};
                    n && (a[n] = s), i[o] = b.assign(a, e)
                }), i
            }
        },
        _ = {
            ENTER: 13,
            ESC: 27,
            TAB: 9,
            SPACE: 32,
            UP: 38,
            DOWN: 40
        },
        x = {
            hint: "suggestions-hint",
            mobile: "suggestions-mobile",
            nowrap: "suggestions-nowrap",
            promo: "suggestions-promo",
            promo_desktop: "suggestions-promo-desktop",
            selected: "suggestions-selected",
            suggestion: "suggestions-suggestion",
            subtext: "suggestions-subtext",
            subtext_inline: "suggestions-subtext suggestions-subtext_inline",
            subtext_delimiter: "suggestions-subtext-delimiter",
            subtext_label: "suggestions-subtext suggestions-subtext_label",
            removeConstraint: "suggestions-remove",
            value: "suggestions-value"
        },
        S = ".suggestions",
        w = "\\s\"'~\\*\\.,:\\|\\[\\]\\(\\)\\{\\}<>№",
        C = new RegExp("[" + w + "]+", "g"),
        E = new RegExp("[\\-\\+\\\\\\?!@#$%^&]+", "g"),
        k = {
            escapeHtml: function(e)
            {
                var t = {
                    "&": "&amp;",
                    "<": "&lt;",
                    ">": "&gt;",
                    '"': "&quot;",
                    "'": "&#x27;",
                    "/": "&#x2F;"
                };
                return e && y.each(t, function(t, n)
                {
                    e = e.replace(new RegExp(n, "g"), t)
                }), e
            },
            escapeRegExChars: function(e)
            {
                return e.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&")
            },
            formatToken: function(e)
            {
                return e && e.toLowerCase().replace(/[ёЁ]/g, "е")
            },
            getWordExtractorRegExp: function()
            {
                return new RegExp("([^" + w + "]*)([" + w + "]*)", "g")
            },
            normalize: function(e, t)
            {
                return k.split(e, t).join(" ")
            },
            padEnd: function(e, t, n)
            {
                return String.prototype.padEnd ? e.padEnd(t, n) : (t >>= 0, n = String(void 0 !== n ? n : " "), e.length > t ? String(e) : (t -= e.length, t > n.length && (n += n.repeat(t / n.length)), String(e) + n.slice(0, t)))
            },
            split: function(e, t)
            {
                var n = e.toLowerCase().replace("ё", "е").replace(/(\d+)([а-я]{2,})/g, "$1 $2").replace(/([а-я]+)(\d+)/g, "$1 $2"),
                    i = y.compact(n.split(C));
                if (!i.length) return [];
                var s = i.pop(),
                    o = y.minus(i, t);
                return o.push(s), o
            },
            splitTokens: function(e)
            {
                var t = [];
                return y.each(e, function(e, n)
                {
                    var i = e.split(E);
                    t = t.concat(y.compact(i))
                }), t
            },
            stringEncloses: function(e, t)
            {
                return e.length > t.length && -1 !== e.toLowerCase().indexOf(t.toLowerCase())
            },
            tokenize: function(e, t)
            {
                var n = y.compact(k.formatToken(e).split(C)),
                    i = y.minus(n, t),
                    s = y.minus(n, i);
                return n = k.withSubTokens(i.concat(s))
            },
            withSubTokens: function(e)
            {
                var t = [];
                return y.each(e, function(e, n)
                {
                    var i = e.split(E);
                    t.push(e), i.length > 1 && (t = t.concat(y.compact(i)))
                }), t
            }
        },
        P = {
            Deferred: function()
            {
                return e.Deferred()
            },
            ajax: function(t)
            {
                return e.ajax(t)
            },
            extend: function()
            {
                return e.extend.apply(null, arguments)
            },
            isJqObject: function(t)
            {
                return t instanceof e
            },
            param: function(t)
            {
                return e.param(t)
            },
            proxy: function(t, n)
            {
                return e.proxy(t, n)
            },
            select: function(t)
            {
                return e(t)
            },
            supportsCors: function()
            {
                return e.support.cors
            }
        },
        T = {
            getDefaultType: function()
            {
                return P.supportsCors() ? "POST" : "GET"
            },
            getDefaultContentType: function()
            {
                return P.supportsCors() ? "application/json" : "application/x-www-form-urlencoded"
            },
            fixURLProtocol: function(e)
            {
                return P.supportsCors() ? e : e.replace(/^https?:/, location.protocol)
            },
            addUrlParams: function(e, t)
            {
                return e + (/\?/.test(e) ? "&" : "?") + P.param(t)
            },
            serialize: function(e)
            {
                return P.supportsCors() ? JSON.stringify(e, function(e, t)
                {
                    return null === t ? void 0 : t
                }) : (e = b.compact(e), P.param(e, !0))
            }
        },
        V = function()
        {
            var e = 0;
            return function(t)
            {
                return (t || "") + ++e
            }
        }(),
        j = {
            escapeRegExChars: k.escapeRegExChars,
            escapeHtml: k.escapeHtml,
            formatToken: k.formatToken,
            normalize: k.normalize,
            reWordExtractor: k.getWordExtractorRegExp,
            stringEncloses: k.stringEncloses,
            addUrlParams: T.addUrlParams,
            getDefaultContentType: T.getDefaultContentType,
            getDefaultType: T.getDefaultType,
            fixURLProtocol: T.fixURLProtocol,
            serialize: T.serialize,
            arrayMinus: y.minus,
            arrayMinusWithPartialMatching: y.minusWithPartialMatching,
            arraysIntersection: y.intersect,
            compact: y.compact,
            each: y.each,
            makeArray: y.makeArray,
            slice: y.slice,
            delay: v.delay,
            areSame: b.areSame,
            compactObject: b.compact,
            getDeepValue: b.getDeepValue,
            fieldsNotEmpty: b.fieldsAreNotEmpty,
            indexBy: b.indexObjectsById,
            isArray: m.isArray,
            isEmptyObject: m.isEmptyObject,
            isFunction: m.isFunction,
            isPlainObject: m.isPlainObject,
            uniqueId: V
        },
        B = {
            autoSelectFirst: !1,
            serviceUrl: "https://suggestions.dadata.ru/suggestions/api/4_1/rs",
            url: null,
            onSearchStart: e.noop,
            onSearchComplete: e.noop,
            onSearchError: e.noop,
            onSuggestionsFetch: null,
            onSelect: null,
            onSelectNothing: null,
            onInvalidateSelection: null,
            minChars: 1,
            deferRequestBy: 100,
            enrichmentEnabled: !0,
            params:
            {},
            paramName: "query",
            timeout: 3e3,
            formatResult: null,
            formatSelected: null,
            noCache: !1,
            containerClass: "suggestions-suggestions",
            tabDisabled: !1,
            triggerSelectOnSpace: !1,
            triggerSelectOnEnter: !0,
            triggerSelectOnBlur: !0,
            preventBadQueries: !1,
            hint: "Выберите вариант или продолжите ввод",
            noSuggestionsHint: null,
            type: null,
            requestMode: "suggest",
            count: 5,
            $helpers: null,
            headers: null,
            scrollOnFocus: !0,
            mobileWidth: 980,
            initializeInterval: 100
        },
        L = function(e)
        {
            return function(t)
            {
                if (0 === t.length) return !1;
                if (1 === t.length) return !0;
                var n = e(t[0].value);
                return 0 === t.filter(function(t)
                {
                    return 0 !== e(t.value).indexOf(n)
                }).length
            }
        }(function(e)
        {
            return e
        }),
        O = {
            matchByNormalizedQuery: function(e)
            {
                return function(t, n)
                {
                    var i = k.normalize(t, e),
                        s = [];
                    return y.each(n, function(n, o)
                    {
                        var a = n.value.toLowerCase();
                        return !k.stringEncloses(t, a) && (!(a.indexOf(i) > 0) && void(i === k.normalize(a, e) && s.push(o)))
                    }), 1 === s.length ? s[0] : -1
                }
            },
            matchByWords: function(e)
            {
                return t(e, L)
            },
            matchByWordsAddress: function(e)
            {
                return t(e, L)
            },
            matchByFields: function(e)
            {
                return function(t, n)
                {
                    var i = k.splitTokens(k.split(t)),
                        s = [];
                    return 1 === n.length && (e && y.each(e, function(e, t)
                    {
                        var i = b.getDeepValue(n[0], t),
                            o = i && k.splitTokens(k.split(i, e));
                        o && o.length && (s = s.concat(o))
                    }), 0 === y.minusWithPartialMatching(i, s).length) ? 0 : -1
                }
            }
        },
        R = ["ао", "аобл", "дом", "респ", "а/я", "аал", "автодорога", "аллея", "арбан", "аул", "б-р", "берег", "бугор", "вал", "вл", "волость", "въезд", "высел", "г", "городок", "гск", "д", "двлд", "днп", "дор", "дп", "ж/д_будка", "ж/д_казарм", "ж/д_оп", "ж/д_платф", "ж/д_пост", "ж/д_рзд", "ж/д_ст", "жилзона", "жилрайон", "жт", "заезд", "заимка", "зона", "к", "казарма", "канал", "кв", "кв-л", "км", "кольцо", "комн", "кордон", "коса", "кп", "край", "линия", "лпх", "м", "массив", "местность", "мкр", "мост", "н/п", "наб", "нп", "обл", "округ", "остров", "оф", "п", "п/о", "п/р", "п/ст", "парк", "пгт", "пер", "переезд", "пл", "пл-ка", "платф", "погост", "полустанок", "починок", "пр-кт", "проезд", "промзона", "просек", "просека", "проселок", "проток", "протока", "проулок", "р-н", "рзд", "россия", "рп", "ряды", "с", "с/а", "с/мо", "с/о", "с/п", "с/с", "сад", "сквер", "сл", "снт", "спуск", "ст", "ст-ца", "стр", "тер", "тракт", "туп", "у", "ул", "уч-к", "ф/х", "ферма", "х", "ш", "бульвар", "владение", "выселки", "гаражно-строительный", "город", "деревня", "домовладение", "дорога", "квартал", "километр", "комната", "корпус", "литер", "леспромхоз", "местечко", "микрорайон", "набережная", "область", "переулок", "платформа", "площадка", "площадь", "поселение", "поселок", "проспект", "разъезд", "район", "республика", "село", "сельсовет", "слобода", "сооружение", "станица", "станция", "строение", "территория", "тупик", "улица", "улус", "участок", "хутор", "шоссе"],
        D = [
        {
            id: "kladr_id",
            fields: ["kladr_id"],
            forBounds: !1,
            forLocations: !0
        },
        {
            id: "postal_code",
            fields: ["postal_code"],
            forBounds: !1,
            forLocations: !0
        },
        {
            id: "country_iso_code",
            fields: ["country_iso_code"],
            forBounds: !1,
            forLocations: !0
        },
        {
            id: "country",
            fields: ["country"],
            forBounds: !0,
            forLocations: !0,
            kladrFormat:
            {
                digits: 0,
                zeros: 13
            },
            fiasType: "country_iso_code"
        },
        {
            id: "region_iso_code",
            fields: ["region_iso_code"],
            forBounds: !1,
            forLocations: !0
        },
        {
            id: "region_fias_id",
            fields: ["region_fias_id"],
            forBounds: !1,
            forLocations: !0
        },
        {
            id: "region_type_full",
            fields: ["region_type_full"],
            forBounds: !1,
            forLocations: !0,
            kladrFormat:
            {
                digits: 2,
                zeros: 11
            },
            fiasType: "region_fias_id"
        },
        {
            id: "region",
            fields: ["region", "region_type", "region_type_full", "region_with_type"],
            forBounds: !0,
            forLocations: !0,
            kladrFormat:
            {
                digits: 2,
                zeros: 11
            },
            fiasType: "region_fias_id"
        },
        {
            id: "area_fias_id",
            fields: ["area_fias_id"],
            forBounds: !1,
            forLocations: !0
        },
        {
            id: "area_type_full",
            fields: ["area_type_full"],
            forBounds: !1,
            forLocations: !0,
            kladrFormat:
            {
                digits: 5,
                zeros: 8
            },
            fiasType: "area_fias_id"
        },
        {
            id: "area",
            fields: ["area", "area_type", "area_type_full", "area_with_type"],
            forBounds: !0,
            forLocations: !0,
            kladrFormat:
            {
                digits: 5,
                zeros: 8
            },
            fiasType: "area_fias_id"
        },
        {
            id: "city_fias_id",
            fields: ["city_fias_id"],
            forBounds: !1,
            forLocations: !0
        },
        {
            id: "city_type_full",
            fields: ["city_type_full"],
            forBounds: !1,
            forLocations: !0,
            kladrFormat:
            {
                digits: 8,
                zeros: 5
            },
            fiasType: "city_fias_id"
        },
        {
            id: "city",
            fields: ["city", "city_type", "city_type_full", "city_with_type"],
            forBounds: !0,
            forLocations: !0,
            kladrFormat:
            {
                digits: 8,
                zeros: 5
            },
            fiasType: "city_fias_id"
        },
        {
            id: "city_district_fias_id",
            fields: ["city_district_fias_id"],
            forBounds: !1,
            forLocations: !0
        },
        {
            id: "city_district_type_full",
            fields: ["city_district_type_full"],
            forBounds: !1,
            forLocations: !0,
            kladrFormat:
            {
                digits: 11,
                zeros: 2
            },
            fiasType: "city_district_fias_id"
        },
        {
            id: "city_district",
            fields: ["city_district", "city_district_type", "city_district_type_full", "city_district_with_type"],
            forBounds: !0,
            forLocations: !0,
            kladrFormat:
            {
                digits: 11,
                zeros: 2
            },
            fiasType: "city_district_fias_id"
        },
        {
            id: "settlement_fias_id",
            fields: ["settlement_fias_id"],
            forBounds: !1,
            forLocations: !0
        },
        {
            id: "settlement_type_full",
            fields: ["settlement_type_full"],
            forBounds: !1,
            forLocations: !0,
            kladrFormat:
            {
                digits: 11,
                zeros: 2
            },
            fiasType: "settlement_fias_id"
        },
        {
            id: "settlement",
            fields: ["settlement", "settlement_type", "settlement_type_full", "settlement_with_type"],
            forBounds: !0,
            forLocations: !0,
            kladrFormat:
            {
                digits: 11,
                zeros: 2
            },
            fiasType: "settlement_fias_id"
        },
        {
            id: "street_fias_id",
            fields: ["street_fias_id"],
            forBounds: !1,
            forLocations: !0
        },
        {
            id: "street_type_full",
            fields: ["street_type_full"],
            forBounds: !1,
            forLocations: !0,
            kladrFormat:
            {
                digits: 15,
                zeros: 2
            },
            fiasType: "street_fias_id"
        },
        {
            id: "street",
            fields: ["street", "street_type", "street_type_full", "street_with_type"],
            forBounds: !0,
            forLocations: !0,
            kladrFormat:
            {
                digits: 15,
                zeros: 2
            },
            fiasType: "street_fias_id"
        },
        {
            id: "house",
            fields: ["house", "house_type", "house_type_full", "block", "block_type"],
            forBounds: !0,
            forLocations: !1,
            kladrFormat:
            {
                digits: 19
            }
        }],
        I = {
            urlSuffix: "address",
            noSuggestionsHint: "Неизвестный адрес",
            matchers: [O.matchByNormalizedQuery(R), O.matchByWordsAddress(R)],
            dataComponents: D,
            dataComponentsById: b.indexObjectsById(D, "id", "index"),
            unformattableTokens: R,
            enrichmentEnabled: !0,
            enrichmentMethod: "suggest",
            enrichmentParams:
            {
                count: 1,
                locations: null,
                locations_boost: null,
                from_bound: null,
                to_bound: null
            },
            getEnrichmentQuery: function(e)
            {
                return e.unrestricted_value
            },
            geoEnabled: !0,
            isDataComplete: function(e)
            {
                var t = [this.bounds.to || "flat"],
                    n = e.data;
                return !m.isPlainObject(n) || b.fieldsAreNotEmpty(n, t)
            },
            composeValue: function(e, t)
            {
                var n = e.country,
                    i = e.region_with_type || y.compact([e.region, e.region_type]).join(" ") || e.region_type_full,
                    s = e.area_with_type || y.compact([e.area_type, e.area]).join(" ") || e.area_type_full,
                    o = e.city_with_type || y.compact([e.city_type, e.city]).join(" ") || e.city_type_full,
                    a = e.settlement_with_type || y.compact([e.settlement_type, e.settlement]).join(" ") || e.settlement_type_full,
                    r = e.city_district_with_type || y.compact([e.city_district_type, e.city_district]).join(" ") || e.city_district_type_full,
                    l = e.street_with_type || y.compact([e.street_type, e.street]).join(" ") || e.street_type_full,
                    c = y.compact([e.house_type, e.house, e.block_type, e.block]).join(" "),
                    u = y.compact([e.flat_type, e.flat]).join(" "),
                    d = e.postal_box && "а/я " + e.postal_box;
                return i === o && (i = ""), t && t.saveCityDistrict || (t && t.excludeCityDistrict ? r = "" : r && !e.city_district_fias_id && (r = "")), y.compact([n, i, s, o, r, a, l, c, u, d]).join(", ")
            },
            formatResult: function()
            {
                var e = [],
                    t = !1;
                return D.forEach(function(n)
                    {
                        t && e.push(n.id), "city_district" === n.id && (t = !0)
                    }),
                    function(t, n, i, s)
                    {
                        var o, a, r, l = this,
                            c = i.data && i.data.city_district_with_type,
                            u = s && s.unformattableTokens,
                            d = i.data && i.data.history_values;
                        return d && d.length > 0 && (o = k.tokenize(n, u), a = this.type.findUnusedTokens(o, t), (r = this.type.getFormattedHistoryValues(a, d)) && (t += r)), t = l.highlightMatches(t, n, i, s), t = l.wrapFormattedValue(t, i), c && (!l.bounds.own.length || l.bounds.own.indexOf("street") >= 0) && !m.isEmptyObject(l.copyDataComponents(i.data, e)) && (t += '<div class="' + l.classes.subtext + '">' + l.highlightMatches(c, n, i) + "</div>"), t
                    }
            }(),
            findUnusedTokens: function(e, t)
            {
                return e.filter(function(e)
                {
                    return -1 === t.indexOf(e)
                })
            },
            getFormattedHistoryValues: function(e, t)
            {
                var n = [],
                    i = "";
                return t.forEach(function(t)
                {
                    y.each(e, function(e)
                    {
                        if (t.toLowerCase().indexOf(e) >= 0) return n.push(t), !1
                    })
                }), n.length > 0 && (i = " (бывш. " + n.join(", ") + ")"), i
            },
            getSuggestionValue: function(e, t)
            {
                var n = null;
                return t.hasSameValues ? n = e.options.restrict_value ? this.getValueWithinConstraints(e, t.suggestion) : e.bounds.own.length ? this.getValueWithinBounds(e, t.suggestion) : t.suggestion.unrestricted_value : t.hasBeenEnriched && e.options.restrict_value && (n = this.getValueWithinConstraints(e, t.suggestion,
                {
                    excludeCityDistrict: !0
                })), n
            },
            getValueWithinConstraints: function(e, t, n)
            {
                return this.composeValue(e.getUnrestrictedData(t.data), n)
            },
            getValueWithinBounds: function(e, t, n)
            {
                var i = e.copyDataComponents(t.data, e.bounds.own.concat(["city_district_fias_id"]));
                return this.composeValue(i, n)
            }
        },
        q = {
            urlSuffix: "fio",
            noSuggestionsHint: !1,
            matchers: [O.matchByNormalizedQuery(), O.matchByWords()],
            fieldNames:
            {
                surname: "фамилия",
                name: "имя",
                patronymic: "отчество"
            },
            isDataComplete: function(e)
            {
                var t, i = this,
                    s = i.options.params,
                    o = e.data;
                return m.isFunction(s) && (s = s.call(i.element, e.value)), s && s.parts ? t = s.parts.map(function(e)
                {
                    return e.toLowerCase()
                }) : (t = ["surname", "name"], n(e, "surname") && t.push("patronymic")), b.fieldsAreNotEmpty(o, t)
            },
            composeValue: function(e)
            {
                return y.compact([e.surname, e.name, e.patronymic]).join(" ")
            }
        },
        F = {
            LEGAL: [2, 2, 5, 1],
            INDIVIDUAL: [2, 2, 6, 2]
        },
        $ = {
            urlSuffix: "party",
            noSuggestionsHint: "Неизвестная организация",
            matchers: [O.matchByFields(
            {
                value: null,
                "data.address.value": R,
                "data.inn": null,
                "data.ogrn": null
            })],
            dataComponents: D,
            enrichmentEnabled: !0,
            enrichmentMethod: "findById",
            enrichmentParams:
            {
                count: 1,
                locations_boost: null
            },
            getEnrichmentQuery: function(e)
            {
                return e.data.hid
            },
            geoEnabled: !0,
            formatResult: function(e, t, n, o)
            {
                var a = this,
                    r = a.type.formatResultInn.call(a, n, t),
                    l = a.highlightMatches(b.getDeepValue(n.data, "ogrn"), t, n),
                    c = i(r, l),
                    u = a.highlightMatches(b.getDeepValue(n.data, "management.name"), t, n),
                    d = b.getDeepValue(n.data, "address.value") || "";
                return a.isMobile && ((o || (o = {})).maxLength = 50), e = s.call(a, e, b.getDeepValue(n.data, "name.latin"), t, n, o), e = a.wrapFormattedValue(e, n), d && (d = d.replace(/^(\d{6}?\s+|Россия,\s+)/i, ""), d = a.isMobile ? d.replace(new RegExp("^([^" + w + "]+[" + w + "]+[^" + w + "]+).*"), "$1") : a.highlightMatches(d, t, n,
                {
                    unformattableTokens: R
                })), (c || d || u) && (e += '<div class="' + a.classes.subtext + '"><span class="' + a.classes.subtext_inline + '">' + (c || "") + "</span>" + (i(d, u) || "") + "</div>"), e
            },
            formatResultInn: function(e, t)
            {
                var n, i, s = this,
                    o = e.data && e.data.inn,
                    a = F[e.data && e.data.type],
                    r = /\d/;
                if (o) return i = s.highlightMatches(o, t, e), a && (i = i.split(""), n = a.map(function(e)
                {
                    for (var t, n = ""; e && (t = i.shift());) n += t, r.test(t) && e--;
                    return n
                }), i = n.join('<span class="' + s.classes.subtext_delimiter + '"></span>') + i.join("")), i
            }
        },
        A = {
            urlSuffix: "email",
            noSuggestionsHint: !1,
            matchers: [O.matchByNormalizedQuery()],
            isQueryRequestable: function(e)
            {
                return this.options.suggest_local || e.indexOf("@") >= 0
            }
        },
        z = {
            urlSuffix: "bank",
            noSuggestionsHint: "Неизвестный банк",
            matchers: [O.matchByFields(
            {
                value: null,
                "data.bic": null,
                "data.swift": null
            })],
            dataComponents: D,
            geoEnabled: !0,
            formatResult: function(e, t, n, i)
            {
                var s = this,
                    o = s.highlightMatches(b.getDeepValue(n.data, "bic"), t, n),
                    a = b.getDeepValue(n.data, "address.value") || "";
                return e = s.highlightMatches(e, t, n, i), e = s.wrapFormattedValue(e, n), a && (a = a.replace(/^\d{6}( РОССИЯ)?, /i, ""), a = s.isMobile ? a.replace(new RegExp("^([^" + w + "]+[" + w + "]+[^" + w + "]+).*"), "$1") : s.highlightMatches(a, t, n,
                {
                    unformattableTokens: R
                })), (o || a) && (e += '<div class="' + s.classes.subtext + '"><span class="' + s.classes.subtext_inline + '">' + o + "</span>" + a + "</div>"), e
            },
            formatSelected: function(e)
            {
                return b.getDeepValue(e, "data.name.payment") || null
            }
        },
        N = {
            NAME: q,
            ADDRESS: I,
            PARTY: $,
            EMAIL: A,
            BANK: z
        };
    N.get = function(e)
    {
        return N.hasOwnProperty(e) ? N[e] : new o(e)
    }, P.extend(B,
    {
        suggest_local: !0
    });
    var M = {
            chains:
            {},
            on: function(e, t)
            {
                return this.get(e).push(t), this
            },
            get: function(e)
            {
                var t = this.chains;
                return t[e] || (t[e] = [])
            }
        },
        H = {
            suggest:
            {
                defaultParams:
                {
                    type: j.getDefaultType(),
                    dataType: "json",
                    contentType: j.getDefaultContentType()
                },
                addTypeInUrl: !0
            },
            "iplocate/address":
            {
                defaultParams:
                {
                    type: "GET",
                    dataType: "json"
                },
                addTypeInUrl: !1
            },
            status:
            {
                defaultParams:
                {
                    type: "GET",
                    dataType: "json"
                },
                addTypeInUrl: !0
            },
            findById:
            {
                defaultParams:
                {
                    type: j.getDefaultType(),
                    dataType: "json",
                    contentType: j.getDefaultContentType()
                },
                addTypeInUrl: !0
            }
        },
        U = {
            suggest:
            {
                method: "suggest",
                userSelect: !0,
                updateValue: !0,
                enrichmentEnabled: !0
            },
            findById:
            {
                method: "findById",
                userSelect: !1,
                updateValue: !1,
                enrichmentEnabled: !1
            }
        };
    a.prototype = {
        initialize: function()
        {
            var e = this;
            e.uniqueId = j.uniqueId("i"), e.createWrapper(), e.notify("initialize"), e.setOptions(), e.fixPosition()
        },
        deferInitialization: function()
        {
            var e, t = this,
                n = "mouseover focus keydown",
                i = function()
                {
                    t.initializer.resolve(), t.enable()
                };
            t.initializer.always(function()
            {
                t.el.off(n, i), clearInterval(e)
            }), t.disabled = !0, t.el.on(n, i), e = setInterval(function()
            {
                t.el.is(":visible") && i()
            }, t.options.initializeInterval)
        },
        isInitialized: function()
        {
            return "resolved" === this.initializer.state()
        },
        dispose: function()
        {
            var e = this;
            e.initializer.reject(), e.notify("dispose"), e.el.removeData("suggestions").removeClass("suggestions-input"), e.removeWrapper(), e.el.trigger("suggestions-dispose")
        },
        notify: function(t)
        {
            var n = this,
                i = j.slice(arguments, 1);
            return e.map(M.get(t), function(e)
            {
                return e.apply(n, i)
            })
        },
        createWrapper: function()
        {
            var t = this;
            t.$wrapper = e('<div class="suggestions-wrapper"/>'), t.el.after(t.$wrapper), t.$wrapper.on("mousedown" + S, e.proxy(t.onMousedown, t))
        },
        removeWrapper: function()
        {
            var t = this;
            t.$wrapper && t.$wrapper.remove(), e(t.options.$helpers).off(S)
        },
        onMousedown: function(t)
        {
            var n = this;
            t.preventDefault(), n.cancelBlur = !0, j.delay(function()
            {
                delete n.cancelBlur
            }), 0 == e(t.target).closest(".ui-menu-item").length && j.delay(function()
            {
                e(document).one("mousedown", function(t)
                {
                    var i = n.el.add(n.$wrapper).add(n.options.$helpers);
                    n.options.floating && (i = i.add(n.$container)), i = i.filter(function()
                    {
                        return this === t.target || e.contains(this, t.target)
                    }), i.length || n.hide()
                })
            })
        },
        scrollToTop: function()
        {
            var t = this,
                n = t.options.scrollOnFocus;
            !0 === n && (n = t.el), n instanceof e && n.length > 0 && e("body,html").animate(
            {
                scrollTop: n.offset().top
            }, "fast")
        },
        setOptions: function(t)
        {
            var n = this;
            e.extend(n.options, t), n.type = N.get(n.options.type), e.each(
            {
                requestMode: U
            }, function(t, i)
            {
                if (n[t] = i[n.options[t]], !n[t]) throw n.disable(), "`" + t + "` option is incorrect! Must be one of: " + e.map(i, function(e, t)
                {
                    return '"' + t + '"'
                }).join(", ")
            }), e(n.options.$helpers).off(S).on("mousedown" + S, e.proxy(n.onMousedown, n)), n.isInitialized() && n.notify("setOptions")
        },
        fixPosition: function(t)
        {
            var n, i, s = this,
                o = {};
            s.isMobile = s.$viewport.width() <= s.options.mobileWidth, s.isInitialized() && (!t || "scroll" != t.type || s.options.floating || s.isMobile) && (s.$container.appendTo(s.options.floating ? s.$body : s.$wrapper), s.notify("resetPosition"), s.el.css("paddingLeft", ""), s.el.css("paddingRight", ""), o.paddingLeft = parseFloat(s.el.css("paddingLeft")), o.paddingRight = parseFloat(s.el.css("paddingRight")), e.extend(o, s.el.offset()), o.borderTop = "none" == s.el.css("border-top-style") ? 0 : parseFloat(s.el.css("border-top-width")), o.borderLeft = "none" == s.el.css("border-left-style") ? 0 : parseFloat(s.el.css("border-left-width")), o.innerHeight = s.el.innerHeight(), o.innerWidth = s.el.innerWidth(), o.outerHeight = s.el.outerHeight(), o.componentsLeft = 0, o.componentsRight = 0, n = s.$wrapper.offset(), i = {
                top: o.top - n.top,
                left: o.left - n.left
            }, s.notify("fixPosition", i, o), o.componentsLeft > o.paddingLeft && s.el.css("paddingLeft", o.componentsLeft + "px"), o.componentsRight > o.paddingRight && s.el.css("paddingRight", o.componentsRight + "px"))
        },
        clearCache: function()
        {
            this.cachedResponse = {}, this.enrichmentCache = {}, this.badQueries = []
        },
        clear: function()
        {
            var e = this,
                t = e.selection;
            e.isInitialized() && (e.clearCache(), e.currentValue = "", e.selection = null, e.hide(), e.suggestions = [], e.el.val(""), e.el.trigger("suggestions-clear"), e.notify("clear"), e.trigger("InvalidateSelection", t))
        },
        disable: function()
        {
            var e = this;
            e.disabled = !0, e.abortRequest(), e.visible && e.hide()
        },
        enable: function()
        {
            this.disabled = !1
        },
        isUnavailable: function()
        {
            return this.disabled
        },
        update: function()
        {
            var e = this,
                t = e.el.val();
            e.isInitialized() && (e.currentValue = t, e.isQueryRequestable(t) ? e.updateSuggestions(t) : e.hide())
        },
        setSuggestion: function(t)
        {
            var n, i, s = this;
            e.isPlainObject(t) && e.isPlainObject(t.data) && (t = e.extend(!0,
            {}, t), s.isUnavailable() && s.initializer && "pending" === s.initializer.state() && (s.initializer.resolve(), s.enable()), s.bounds.own.length && (s.checkValueBounds(t), n = s.copyDataComponents(t.data, s.bounds.all), t.data.kladr_id && (n.kladr_id = s.getBoundedKladrId(t.data.kladr_id, s.bounds.all)), t.data = n), s.selection = t, s.suggestions = [t], i = s.getSuggestionValue(t) || "", s.currentValue = i, s.el.val(i), s.abortRequest(), s.el.trigger("suggestions-set"))
        },
        fixData: function()
        {
            var t = this,
                n = t.extendedCurrentValue(),
                i = t.el.val(),
                s = e.Deferred();
            s.done(function(e)
            {
                t.selectSuggestion(e, 0, i,
                {
                    hasBeenEnriched: !0
                }), t.el.trigger("suggestions-fixdata", e)
            }).fail(function()
            {
                t.selection = null, t.el.trigger("suggestions-fixdata")
            }), t.isQueryRequestable(n) ? (t.currentValue = n, t.getSuggestions(n,
            {
                count: 1,
                from_bound: null,
                to_bound: null
            }).done(function(e)
            {
                var t = e[0];
                t ? s.resolve(t) : s.reject()
            }).fail(function()
            {
                s.reject()
            })) : s.reject()
        },
        extendedCurrentValue: function()
        {
            var t = this,
                n = t.getParentInstance(),
                i = n && n.extendedCurrentValue(),
                s = e.trim(t.el.val());
            return j.compact([i, s]).join(" ")
        },
        getAjaxParams: function(t, n)
        {
            var i = this,
                s = e.trim(i.options.token),
                o = e.trim(i.options.partner),
                r = i.options.serviceUrl,
                l = i.options.url,
                c = H[t],
                u = e.extend(
                {
                    timeout: i.options.timeout
                }, c.defaultParams),
                d = {};
            return l ? r = l : (/\/$/.test(r) || (r += "/"), r += t, c.addTypeInUrl && (r += "/" + i.type.urlSuffix)), r = j.fixURLProtocol(r), e.support.cors ? (s && (d.Authorization = "Token " + s), o && (d["X-Partner"] = o), d["X-Version"] = a.version, u.headers || (u.headers = {}), u.xhrFields || (u.xhrFields = {}), e.extend(u.headers, i.options.headers, d), u.xhrFields.withCredentials = !1) : (s && (d.token = s), o && (d.partner = o), d.version = a.version, r = j.addUrlParams(r, d)), u.url = r, e.extend(u, n)
        },
        isQueryRequestable: function(e)
        {
            var t, n = this;
            return t = e.length >= n.options.minChars, t && n.type.isQueryRequestable && (t = n.type.isQueryRequestable.call(n, e)), t
        },
        constructRequestParams: function(t, n)
        {
            var i = this,
                s = i.options,
                o = e.isFunction(s.params) ? s.params.call(i.element, t) : e.extend(
                {}, s.params);
            return i.type.constructRequestParams && e.extend(o, i.type.constructRequestParams.call(i)), e.each(i.notify("requestParams"), function(t, n)
            {
                e.extend(o, n)
            }), o[s.paramName] = t, e.isNumeric(s.count) && s.count > 0 && (o.count = s.count), e.extend(o, n)
        },
        updateSuggestions: function(e)
        {
            var t = this;
            t.fetchPhase = t.getSuggestions(e).done(function(n)
            {
                t.assignSuggestions(n, e)
            })
        },
        getSuggestions: function(t, n, i)
        {
            var s, o = this,
                a = o.options,
                r = i && i.noCallbacks,
                l = i && i.useEnrichmentCache,
                c = i && i.method || o.requestMode.method,
                u = o.constructRequestParams(t, n),
                d = e.param(u ||
                {}),
                f = e.Deferred();
            return s = o.cachedResponse[d], s && e.isArray(s.suggestions) ? f.resolve(s.suggestions) : o.isBadQuery(t) ? f.reject() : r || !1 !== a.onSearchStart.call(o.element, u) ? o.doGetSuggestions(u, c).done(function(e)
            {
                o.processResponse(e) && t == o.currentValue ? (a.noCache || (l ? o.enrichmentCache[t] = e.suggestions[0] : (o.enrichResponse(e, t), o.cachedResponse[d] = e, a.preventBadQueries && 0 === e.suggestions.length && o.badQueries.push(t))), f.resolve(e.suggestions)) : f.reject(), r || a.onSearchComplete.call(o.element, t, e.suggestions)
            }).fail(function(e, n, i)
            {
                f.reject(), r || "abort" === n || a.onSearchError.call(o.element, t, e, n, i)
            }) : f.reject(), f
        },
        doGetSuggestions: function(t, n)
        {
            var i = this,
                s = e.ajax(i.getAjaxParams(n,
                {
                    data: j.serialize(t)
                }));
            return i.abortRequest(), i.currentRequest = s, i.notify("request"), s.always(function()
            {
                i.currentRequest = null, i.notify("request")
            }), s
        },
        isBadQuery: function(t)
        {
            if (!this.options.preventBadQueries) return !1;
            var n = !1;
            return e.each(this.badQueries, function(e, i)
            {
                return !(n = 0 === t.indexOf(i))
            }), n
        },
        abortRequest: function()
        {
            var e = this;
            e.currentRequest && e.currentRequest.abort()
        },
        processResponse: function(t)
        {
            var n, i = this;
            return !(!t || !e.isArray(t.suggestions)) && (i.verifySuggestionsFormat(t.suggestions), i.setUnrestrictedValues(t.suggestions), e.isFunction(i.options.onSuggestionsFetch) && (n = i.options.onSuggestionsFetch.call(i.element, t.suggestions), e.isArray(n) && (t.suggestions = n)), !0)
        },
        verifySuggestionsFormat: function(t)
        {
            "string" == typeof t[0] && e.each(t, function(e, n)
            {
                t[e] = {
                    value: n,
                    data: null
                }
            })
        },
        getSuggestionValue: function(t, n)
        {
            var i, s = this,
                o = s.options.formatSelected || s.type.formatSelected,
                a = n && n.hasSameValues,
                r = n && n.hasBeenEnriched,
                l = null;
            return e.isFunction(o) && (i = o.call(s, t)), "string" != typeof i && (i = t.value, s.type.getSuggestionValue && null !== (l = s.type.getSuggestionValue(s,
            {
                suggestion: t,
                hasSameValues: a,
                hasBeenEnriched: r
            })) && (i = l)), i
        },
        hasSameValues: function(t)
        {
            var n = !1;
            return e.each(this.suggestions, function(e, i)
            {
                if (i.value === t.value && i !== t) return n = !0, !1
            }), n
        },
        assignSuggestions: function(e, t)
        {
            var n = this;
            n.suggestions = e, n.notify("assignSuggestions", t)
        },
        shouldRestrictValues: function()
        {
            var e = this;
            return e.options.restrict_value && e.constraints && 1 == Object.keys(e.constraints).length
        },
        setUnrestrictedValues: function(t)
        {
            var n = this,
                i = n.shouldRestrictValues(),
                s = n.getFirstConstraintLabel();
            e.each(t, function(e, t)
            {
                t.unrestricted_value || (t.unrestricted_value = i ? s + ", " + t.value : t.value)
            })
        },
        areSuggestionsSame: function(e, t)
        {
            return e && t && e.value === t.value && j.areSame(e.data, t.data)
        },
        getNoSuggestionsHint: function()
        {
            var e = this;
            return !1 !== e.options.noSuggestionsHint && (e.options.noSuggestionsHint || e.type.noSuggestionsHint)
        }
    };
    var W = {
        setupElement: function()
        {
            this.el.attr("autocomplete", "off").attr("autocorrect", "off").attr("autocapitalize", "off").attr("spellcheck", "false").addClass("suggestions-input").css("box-sizing", "border-box")
        },
        bindElementEvents: function()
        {
            var t = this;
            t.el.on("keydown" + S, e.proxy(t.onElementKeyDown, t)), t.el.on(["keyup" + S, "cut" + S, "paste" + S, "input" + S].join(" "), e.proxy(t.onElementKeyUp, t)), t.el.on("blur" + S, e.proxy(t.onElementBlur, t)), t.el.on("focus" + S, e.proxy(t.onElementFocus, t))
        },
        unbindElementEvents: function()
        {
            this.el.off(S)
        },
        onElementBlur: function()
        {
            var e = this;
            if (e.cancelBlur) return void(e.cancelBlur = !1);
            e.options.triggerSelectOnBlur ? e.isUnavailable() || e.selectCurrentValue(
            {
                noSpace: !0
            }).always(function()
            {
                e.hide()
            }) : e.hide(), e.fetchPhase.abort && e.fetchPhase.abort()
        },
        onElementFocus: function()
        {
            var t = this;
            t.cancelFocus || j.delay(e.proxy(t.completeOnFocus, t)), t.cancelFocus = !1
        },
        onElementKeyDown: function(e)
        {
            var t = this;
            if (!t.isUnavailable())
                if (t.visible)
                {
                    switch (e.which)
                    {
                        case _.ESC:
                            t.el.val(t.currentValue), t.hide(), t.abortRequest();
                            break;
                        case _.TAB:
                            if (!1 === t.options.tabDisabled) return;
                            break;
                        case _.ENTER:
                            t.options.triggerSelectOnEnter && t.selectCurrentValue();
                            break;
                        case _.SPACE:
                            return void(t.options.triggerSelectOnSpace && t.isCursorAtEnd() && (e.preventDefault(), t.selectCurrentValue(
                            {
                                continueSelecting: !0,
                                dontEnrich: !0
                            }).fail(function()
                            {
                                t.currentValue += " ", t.el.val(t.currentValue), t.proceedChangedValue()
                            })));
                        case _.UP:
                            t.moveUp();
                            break;
                        case _.DOWN:
                            t.moveDown();
                            break;
                        default:
                            return
                    }
                    e.stopImmediatePropagation(), e.preventDefault()
                }
            else switch (e.which)
            {
                case _.DOWN:
                    t.suggest();
                    break;
                case _.ENTER:
                    t.options.triggerSelectOnEnter && t.triggerOnSelectNothing()
            }
        },
        onElementKeyUp: function(e)
        {
            var t = this;
            if (!t.isUnavailable())
            {
                switch (e.which)
                {
                    case _.UP:
                    case _.DOWN:
                    case _.ENTER:
                        return
                }
                clearTimeout(t.onChangeTimeout), t.inputPhase.reject(), t.currentValue !== t.el.val() && t.proceedChangedValue()
            }
        },
        proceedChangedValue: function()
        {
            var t = this;
            t.abortRequest(), t.inputPhase = e.Deferred().done(e.proxy(t.onValueChange, t)), t.options.deferRequestBy > 0 ? t.onChangeTimeout = j.delay(function()
            {
                t.inputPhase.resolve()
            }, t.options.deferRequestBy) : t.inputPhase.resolve()
        },
        onValueChange: function()
        {
            var e, t = this;
            t.selection && (e = t.selection, t.selection = null,
                t.trigger("InvalidateSelection", e)), t.selectedIndex = -1, t.update(), t.notify("valueChange")
        },
        completeOnFocus: function()
        {
            var e = this;
            e.isUnavailable() || e.isElementFocused() && (e.update(), e.isMobile && (e.setCursorAtEnd(), e.scrollToTop()))
        },
        isElementFocused: function()
        {
            return document.activeElement === this.element
        },
        isElementDisabled: function()
        {
            return Boolean(this.element.getAttribute("disabled") || this.element.getAttribute("readonly"))
        },
        isCursorAtEnd: function()
        {
            var e, t, n = this,
                i = n.el.val().length;
            try
            {
                if ("number" == typeof(e = n.element.selectionStart)) return e === i
            }
            catch (e)
            {}
            return !document.selection || (t = document.selection.createRange(), t.moveStart("character", -i), i === t.text.length)
        },
        setCursorAtEnd: function()
        {
            var e = this.element;
            try
            {
                e.selectionEnd = e.selectionStart = e.value.length, e.scrollLeft = e.scrollWidth
            }
            catch (t)
            {
                e.value = e.value
            }
        }
    };
    e.extend(a.prototype, W), M.on("initialize", W.bindElementEvents).on("dispose", W.unbindElementEvents);
    var Q = {};
    r();
    var Z = {
        checkStatus: function()
        {
            function e(e)
            {
                j.isFunction(t.options.onSearchError) && t.options.onSearchError.call(t.element, null, s, "error", e)
            }
            var t = this,
                n = t.options.token && t.options.token.trim() || "",
                i = t.options.type + n,
                s = Q[i];
            s || (s = Q[i] = P.ajax(t.getAjaxParams("status"))), s.done(function(n, i, s)
            {
                if (n.search)
                {
                    var o = s.getResponseHeader("X-Plan");
                    n.plan = o, P.extend(t.status, n)
                }
                else e("Service Unavailable")
            }).fail(function()
            {
                e(s.statusText)
            })
        }
    };
    a.resetTokens = r, P.extend(a.prototype, Z), M.on("setOptions", Z.checkStatus);
    var K, G = !0,
        J = {
            checkLocation: function()
            {
                var t = this,
                    n = t.options.geoLocation;
                t.type.geoEnabled && n && (t.geoLocation = e.Deferred(), e.isPlainObject(n) || e.isArray(n) ? t.geoLocation.resolve(n) : (K || (K = e.ajax(t.getAjaxParams("iplocate/address"))), K.done(function(e)
                {
                    var n = e && e.location && e.location.data;
                    n && n.kladr_id ? t.geoLocation.resolve(
                    {
                        kladr_id: n.kladr_id
                    }) : t.geoLocation.reject()
                }).fail(function()
                {
                    t.geoLocation.reject()
                })))
            },
            getGeoLocation: function()
            {
                return this.geoLocation
            },
            constructParams: function()
            {
                var t = this,
                    n = {};
                return t.geoLocation && e.isFunction(t.geoLocation.promise) && "resolved" == t.geoLocation.state() && t.geoLocation.done(function(t)
                {
                    n.locations_boost = e.makeArray(t)
                }), n
            }
        };
    "GET" != j.getDefaultType() && (e.extend(B,
    {
        geoLocation: G
    }), e.extend(a,
    {
        resetLocation: l
    }), e.extend(a.prototype,
    {
        getGeoLocation: J.getGeoLocation
    }), M.on("setOptions", J.checkLocation).on("requestParams", J.constructParams));
    var X = {
        enrichSuggestion: function(t, n)
        {
            var i = this,
                s = e.Deferred();
            if (!i.options.enrichmentEnabled || !i.type.enrichmentEnabled || !i.requestMode.enrichmentEnabled || n && n.dontEnrich) return s.resolve(t);
            if (t.data && null != t.data.qc) return s.resolve(t);
            i.disableDropdown();
            var o = i.type.getEnrichmentQuery(t),
                a = i.type.enrichmentParams,
                r = {
                    noCallbacks: !0,
                    useEnrichmentCache: !0,
                    method: i.type.enrichmentMethod
                };
            return i.currentValue = o, i.enrichPhase = i.getSuggestions(o, a, r).always(function()
            {
                i.enableDropdown()
            }).done(function(e)
            {
                var n = e && e[0];
                s.resolve(n || t, !!n)
            }).fail(function()
            {
                s.resolve(t)
            }), s
        },
        enrichResponse: function(t, n)
        {
            var i = this,
                s = i.enrichmentCache[n];
            s && e.each(t.suggestions, function(e, i)
            {
                if (i.value === n) return t.suggestions[e] = s, !1
            })
        }
    };
    e.extend(a.prototype, X);
    var Y = {
            width: "auto",
            floating: !1
        },
        ee = {
            createContainer: function()
            {
                var t = this,
                    n = "." + t.classes.suggestion,
                    i = t.options,
                    s = e("<div/>").addClass(i.containerClass).css(
                    {
                        position: "absolute",
                        display: "none"
                    });
                t.$container = s, s.on("click" + S, n, e.proxy(t.onSuggestionClick, t))
            },
            getContainer: function()
            {
                return this.$container.get(0)
            },
            removeContainer: function()
            {
                var e = this;
                e.options.floating && e.$container.remove()
            },
            setContainerOptions: function()
            {
                var t = this;
                t.$container.off("mousedown.suggestions"), t.options.floating && t.$container.on("mousedown.suggestions", e.proxy(t.onMousedown, t))
            },
            onSuggestionClick: function(t)
            {
                var n, i = this,
                    s = e(t.target);
                if (!i.dropdownDisabled)
                {
                    for (i.cancelFocus = !0, i.el.focus(); s.length && !(n = s.attr("data-index"));) s = s.closest("." + i.classes.suggestion);
                    n && !isNaN(n) && i.select(+n)
                }
            },
            setDropdownPosition: function(e, t)
            {
                var n, i = this,
                    s = i.$viewport.scrollLeft();
                i.isMobile ? (n = i.options.floating ?
                {
                    left: s + "px",
                    top: t.top + t.outerHeight + "px"
                } :
                {
                    left: e.left - t.left + s + "px",
                    top: e.top + t.outerHeight + "px"
                }, n.width = i.$viewport.width() + "px") : (n = i.options.floating ?
                {
                    left: t.left + "px",
                    top: t.top + t.borderTop + t.innerHeight + "px"
                } :
                {
                    left: e.left + "px",
                    top: e.top + t.borderTop + t.innerHeight + "px"
                }, j.delay(function()
                {
                    var e = i.options.width;
                    "auto" === e && (e = i.el.outerWidth()), i.$container.outerWidth(e)
                })), i.$container.toggleClass(i.classes.mobile, i.isMobile).css(n), i.containerItemsPadding = t.left + t.borderLeft + t.paddingLeft - s
            },
            setItemsPositions: function()
            {
                var e = this;
                e.getSuggestionsItems().css("paddingLeft", e.isMobile ? e.containerItemsPadding + "px" : "")
            },
            getSuggestionsItems: function()
            {
                return this.$container.children("." + this.classes.suggestion)
            },
            toggleDropdownEnabling: function(e)
            {
                this.dropdownDisabled = !e, this.$container.attr("disabled", !e)
            },
            disableDropdown: function()
            {
                this.toggleDropdownEnabling(!1)
            },
            enableDropdown: function()
            {
                this.toggleDropdownEnabling(!0)
            },
            hasSuggestionsToChoose: function()
            {
                var t = this;
                return t.suggestions.length > 1 || 1 === t.suggestions.length && (!t.selection || e.trim(t.suggestions[0].value) !== e.trim(t.selection.value))
            },
            suggest: function()
            {
                var t = this,
                    n = t.options,
                    i = [];
                if (t.requestMode.userSelect)
                {
                    if (t.hasSuggestionsToChoose()) !t.isMobile && n.hint && t.suggestions.length && i.push('<div class="' + t.classes.hint + '">' + n.hint + "</div>"), t.selectedIndex = -1, t.suggestions.forEach(function(e, n)
                    {
                        e == t.selection && (t.selectedIndex = n), t.buildSuggestionHtml(e, n, i)
                    });
                    else
                    {
                        if (t.suggestions.length) return void t.hide();
                        var s = t.getNoSuggestionsHint();
                        if (!s) return void t.hide();
                        i.push('<div class="' + t.classes.hint + '">' + s + "</div>")
                    }
                    i.push('<div class="' + x.promo + '"></div>'), i.push("</div>"), t.$container.html(i.join("")), n.autoSelectFirst && -1 === t.selectedIndex && (t.selectedIndex = 0), -1 !== t.selectedIndex && t.getSuggestionsItems().eq(t.selectedIndex).addClass(t.classes.selected), e.isFunction(n.beforeRender) && n.beforeRender.call(t.element, t.$container), t.$container.show(), t.visible = !0, t.setItemsPositions()
                }
            },
            buildSuggestionHtml: function(e, t, n)
            {
                n.push('<div class="' + this.classes.suggestion + '" data-index="' + t + '">');
                var i = this.options.formatResult || this.type.formatResult || this.formatResult;
                n.push(i.call(this, e.value, this.currentValue, e,
                {
                    unformattableTokens: this.type.unformattableTokens
                }));
                var s = this.makeSuggestionLabel(this.suggestions, e);
                s && n.push('<span class="' + this.classes.subtext_label + '">' + j.escapeHtml(s) + "</span>"), n.push("</div>")
            },
            wrapFormattedValue: function(e, t)
            {
                var n = this,
                    i = j.getDeepValue(t.data, "state.status");
                return '<span class="' + n.classes.value + '"' + (i ? ' data-suggestion-status="' + i + '"' : "") + ">" + e + "</span>"
            },
            formatResult: function(e, t, n, i)
            {
                var s = this;
                return e = s.highlightMatches(e, t, n, i), s.wrapFormattedValue(e, n)
            },
            highlightMatches: function(t, n, i, s)
            {
                var o, a, r, l, d, f, p, h = this,
                    g = [],
                    m = s && s.unformattableTokens,
                    y = s && s.maxLength,
                    v = j.reWordExtractor();
                if (!t) return "";
                for (o = k.tokenize(n, m), a = e.map(o, function(e)
                    {
                        return new RegExp("^((.*)([\\-\\+\\\\\\?!@#$%^&]+))?(" + j.escapeRegExChars(e) + ")([^\\-\\+\\\\\\?!@#$%^&]*[\\-\\+\\\\\\?!@#$%^&]*)", "i")
                    });
                    (r = v.exec(t)) && r[0];) l = r[1], g.push(
                {
                    text: l,
                    hasUpperCase: l.toLowerCase() !== l,
                    formatted: j.formatToken(l),
                    matchable: !0
                }), r[2] && g.push(
                {
                    text: r[2]
                });
                for (d = 0; d < g.length; d++) f = g[d], !f.matchable || f.matched || -1 !== e.inArray(f.formatted, m) && !f.hasUpperCase || e.each(a, function(e, t)
                {
                    var n, i = t.exec(f.formatted),
                        s = d + 1;
                    if (i) return i = {
                        before: i[1] || "",
                        beforeText: i[2] || "",
                        beforeDelimiter: i[3] || "",
                        text: i[4] || "",
                        after: i[5] || ""
                    }, i.before && (g.splice(d, 0,
                    {
                        text: f.text.substr(0, i.beforeText.length),
                        formatted: i.beforeText,
                        matchable: !0
                    },
                    {
                        text: i.beforeDelimiter
                    }), s += 2, n = i.before.length, f.text = f.text.substr(n), f.formatted = f.formatted.substr(n), d--), n = i.text.length + i.after.length, f.formatted.length > n && (g.splice(s, 0,
                    {
                        text: f.text.substr(n),
                        formatted: f.formatted.substr(n),
                        matchable: !0
                    }), f.text = f.text.substr(0, n), f.formatted = f.formatted.substr(0, n)), i.after && (n = i.text.length, g.splice(s, 0,
                    {
                        text: f.text.substr(n),
                        formatted: f.formatted.substr(n)
                    }), f.text = f.text.substr(0, n), f.formatted = f.formatted.substr(0, n)), f.matched = !0, !1
                });
                if (y)
                {
                    for (d = 0; d < g.length && y >= 0; d++) f = g[d], (y -= f.text.length) < 0 && (f.text = f.text.substr(0, f.text.length + y) + "...");
                    g.length = d
                }
                return p = c(g), u(p, h.classes.nowrap)
            },
            makeSuggestionLabel: function(t, n)
            {
                var i, s, o = this,
                    a = o.type.fieldNames,
                    r = {},
                    l = j.reWordExtractor(),
                    c = [];
                if (a && d(t, n) && n.data && (e.each(a, function(e)
                    {
                        var t = n.data[e];
                        t && (r[e] = j.formatToken(t))
                    }), !e.isEmptyObject(r)))
                {
                    for (;
                        (i = l.exec(j.formatToken(n.value))) && (s = i[1]);) e.each(r, function(e, t)
                    {
                        if (t == s) return c.push(a[e]), delete r[e], !1
                    });
                    if (c.length) return c.join(", ")
                }
            },
            hide: function()
            {
                var e = this;
                e.visible = !1, e.selectedIndex = -1, e.$container.hide().empty()
            },
            activate: function(e)
            {
                var t, n, i = this,
                    s = i.classes.selected;
                return !i.dropdownDisabled && (n = i.getSuggestionsItems(), n.removeClass(s), i.selectedIndex = e, -1 !== i.selectedIndex && n.length > i.selectedIndex) ? (t = n.eq(i.selectedIndex), t.addClass(s), t) : null
            },
            deactivate: function(e)
            {
                var t = this;
                t.dropdownDisabled || (t.selectedIndex = -1, t.getSuggestionsItems().removeClass(t.classes.selected), e && t.el.val(t.currentValue))
            },
            moveUp: function()
            {
                var e = this;
                if (!e.dropdownDisabled) return -1 === e.selectedIndex ? void(e.suggestions.length && e.adjustScroll(e.suggestions.length - 1)) : 0 === e.selectedIndex ? void e.deactivate(!0) : void e.adjustScroll(e.selectedIndex - 1)
            },
            moveDown: function()
            {
                var e = this;
                if (!e.dropdownDisabled) return e.selectedIndex === e.suggestions.length - 1 ? void e.deactivate(!0) : void e.adjustScroll(e.selectedIndex + 1)
            },
            adjustScroll: function(e)
            {
                var t, n, i, s = this,
                    o = s.activate(e),
                    a = s.$container.scrollTop();
                o && o.length && (t = o.position().top, t < 0 ? s.$container.scrollTop(a + t) : (n = t + o.outerHeight(), i = s.$container.innerHeight(), n > i && s.$container.scrollTop(a - i + n)), s.el.val(s.suggestions[e].value))
            }
        };
    e.extend(B, Y), e.extend(a.prototype, ee), M.on("initialize", ee.createContainer).on("dispose", ee.removeContainer).on("setOptions", ee.setContainerOptions).on("fixPosition", ee.setDropdownPosition).on("fixPosition", ee.setItemsPositions).on("assignSuggestions", ee.suggest);
    var te = {
            addon: null
        },
        ne = {
            NONE: "none",
            SPINNER: "spinner",
            CLEAR: "clear"
        },
        ie = function(e)
        {
            var t = P.select('<span class="suggestions-addon"/>');
            this.owner = e, this.$el = t, this.type = ne.NONE, this.visible = !1, this.initialPadding = null, t.on("click", P.proxy(this, "onClick"))
        };
    ie.prototype = {
        checkType: function()
        {
            var e = this.owner.options.addon,
                t = !1;
            y.each(ne, function(n, i)
            {
                if (t = n == e) return !1
            }), t || (e = this.owner.isMobile ? ne.CLEAR : ne.SPINNER), e != this.type && (this.type = e, this.$el.attr("data-addon-type", e), this.toggle(!0))
        },
        isEnabled: function()
        {
            return !this.owner.isElementDisabled()
        },
        toggle: function(e)
        {
            var t;
            switch (this.type)
            {
                case ne.CLEAR:
                    t = !!this.owner.currentValue;
                    break;
                case ne.SPINNER:
                    t = !!this.owner.currentRequest;
                    break;
                default:
                    t = !1
            }
            this.isEnabled() || (t = !1), t != this.visible && (this.visible = t, t ? this.show(e) : this.hide(e))
        },
        show: function(e)
        {
            var t = this,
                n = {
                    opacity: 1
                };
            e ? (this.$el.show().css(n), this.showBackground(!0)) : this.$el.stop(!0, !0).delay(50).queue(function()
            {
                t.$el.show(), t.showBackground(), t.$el.dequeue()
            }).animate(n, "fast")
        },
        hide: function(e)
        {
            var t = this,
                n = {
                    opacity: 0
                };
            e && this.$el.hide().css(n), this.$el.stop(!0).animate(n,
            {
                duration: "fast",
                complete: function()
                {
                    t.$el.hide(), t.hideBackground()
                }
            })
        },
        fixPosition: function(e, t)
        {
            var n = t.innerHeight;
            this.checkType(), this.$el.css(
            {
                left: e.left + t.borderLeft + t.innerWidth - n + "px",
                top: e.top + t.borderTop + "px",
                height: n,
                width: n
            }), this.initialPadding = t.paddingRight, this.width = n, this.visible && (t.componentsRight += n)
        },
        showBackground: function(e)
        {
            var t = this.owner.el,
                n = {
                    paddingRight: this.width
                };
            this.width > this.initialPadding && (this.stopBackground(), e ? t.css(n) : t.animate(n,
            {
                duration: "fast",
                queue: "addon"
            }).dequeue("addon"))
        },
        hideBackground: function(e)
        {
            var t = this.owner.el,
                n = {
                    paddingRight: this.initialPadding
                };
            this.width > this.initialPadding && (this.stopBackground(!0), e ? t.css(n) : t.delay(50, "addon").animate(n,
            {
                duration: "fast",
                queue: "addon"
            }).dequeue("addon"))
        },
        stopBackground: function(e)
        {
            this.owner.el.stop("addon", !0, e)
        },
        onClick: function(e)
        {
            this.isEnabled() && this.type == ne.CLEAR && this.owner.clear()
        }
    };
    var se = {
        createAddon: function()
        {
            var e = new ie(this);
            this.$wrapper.append(e.$el), this.addon = e
        },
        fixAddonPosition: function(e, t)
        {
            this.addon.fixPosition(e, t)
        },
        checkAddonType: function()
        {
            this.addon.checkType()
        },
        checkAddonVisibility: function()
        {
            this.addon.toggle()
        },
        stopBackground: function()
        {
            this.addon.stopBackground()
        }
    };
    P.extend(B, te), M.on("initialize", se.createAddon).on("setOptions", se.checkAddonType).on("fixPosition", se.fixAddonPosition).on("clear", se.checkAddonVisibility).on("valueChange", se.checkAddonVisibility).on("request", se.checkAddonVisibility).on("resetPosition", se.stopBackground);
    var oe = {
            constraints: null,
            restrict_value: !1
        },
        ae = ["country_iso_code", "region_iso_code", "region_fias_id", "area_fias_id", "city_fias_id", "city_district_fias_id", "settlement_fias_id", "street_fias_id"],
        re = function(e, t)
        {
            var n, i, s = this,
                o = {};
            s.instance = t, s.fields = {}, s.specificity = -1, m.isPlainObject(e) && t.type.dataComponents && y.each(t.type.dataComponents, function(t, n)
            {
                var i = t.id;
                t.forLocations && e[i] && (s.fields[i] = e[i], s.specificity = n)
            }), n = Object.keys(s.fields), i = y.intersect(n, ae), i.length ? (y.each(i, function(e, t)
            {
                o[e] = s.fields[e]
            }), s.fields = o, s.specificity = s.getFiasSpecificity(i)) : s.fields.kladr_id && (s.fields = {
                kladr_id: s.fields.kladr_id
            }, s.significantKladr = p(s.fields.kladr_id), s.specificity = s.getKladrSpecificity(s.significantKladr))
        };
    P.extend(re.prototype,
    {
        getLabel: function()
        {
            return this.instance.type.composeValue(this.fields,
            {
                saveCityDistrict: !0
            })
        },
        getFields: function()
        {
            return this.fields
        },
        isValid: function()
        {
            return !m.isEmptyObject(this.fields)
        },
        getKladrSpecificity: function(e)
        {
            var t = -1,
                n = e.length;
            return y.each(this.instance.type.dataComponents, function(e, i)
            {
                e.kladrFormat && n === e.kladrFormat.digits && (t = i)
            }), t
        },
        getFiasSpecificity: function(e)
        {
            var t = -1;
            return y.each(this.instance.type.dataComponents, function(n, i)
            {
                n.fiasType && e.indexOf(n.fiasType) > -1 && t < i && (t = i)
            }), t
        },
        containsData: function(e)
        {
            var t = !0;
            return this.fields.kladr_id ? !!e.kladr_id && 0 === e.kladr_id.indexOf(this.significantKladr) : (y.each(this.fields, function(n, i)
            {
                return t = !!e[i] && e[i].toLowerCase() === n.toLowerCase()
            }), t)
        }
    }), a.ConstraintLocation = re;
    var le = function(e, t)
    {
        this.id = V("c"), this.deletable = !!e.deletable, this.instance = t;
        var n = y.makeArray(e && (e.locations || e.restrictions));
        this.locations = n.map(function(e)
        {
            return new re(e, t)
        }), this.locations = this.locations.filter(function(e)
        {
            return e.isValid()
        }), this.label = e.label, null == this.label && t.type.composeValue && (this.label = this.locations.map(function(e)
        {
            return e.getLabel()
        }).join(", ")), this.label && this.isValid() && (this.$el = P.select(document.createElement("li")).append(P.select(document.createElement("span")).text(this.label)).attr("data-constraint-id", this.id), this.deletable && this.$el.append(P.select(document.createElement("span")).addClass(t.classes.removeConstraint)))
    };
    P.extend(le.prototype,
    {
        isValid: function()
        {
            return this.locations.length > 0
        },
        getFields: function()
        {
            return this.locations.map(function(e)
            {
                return e.getFields()
            })
        }
    });
    var ce = {
        createConstraints: function()
        {
            var e = this;
            e.constraints = {}, e.$constraints = P.select('<ul class="suggestions-constraints"/>'), e.$wrapper.append(e.$constraints), e.$constraints.on("click", "." + e.classes.removeConstraint, P.proxy(e.onConstraintRemoveClick, e))
        },
        setConstraintsPosition: function(e, t)
        {
            var n = this;
            n.$constraints.css(
            {
                left: e.left + t.borderLeft + t.paddingLeft + "px",
                top: e.top + t.borderTop + Math.round((t.innerHeight - n.$constraints.height()) / 2) + "px"
            }), t.componentsLeft += n.$constraints.outerWidth(!0) + t.paddingLeft
        },
        onConstraintRemoveClick: function(e)
        {
            var t = this,
                n = P.select(e.target).closest("li"),
                i = n.attr("data-constraint-id");
            delete t.constraints[i], t.update(), n.fadeOut("fast", function()
            {
                t.removeConstraint(i)
            })
        },
        setupConstraints: function()
        {
            var e, t = this,
                n = t.options.constraints;
            if (!n) return void t.unbindFromParent();
            P.isJqObject(n) || "string" == typeof n || "number" == typeof n.nodeType ? (e = P.select(n), e.is(t.constraints) || (t.unbindFromParent(), e.is(t.el) || (t.constraints = e, t.bindToParent()))) : (t._constraintsUpdating = !0, y.each(t.constraints, function(e, n)
            {
                t.removeConstraint(n)
            }), y.each(y.makeArray(n), function(e, n)
            {
                t.addConstraint(e)
            }), t._constraintsUpdating = !1, t.fixPosition())
        },
        filteredLocation: function(e)
        {
            var t = [],
                n = {};
            if (y.each(this.type.dataComponents, function()
                {
                    this.forLocations && t.push(this.id)
                }), m.isPlainObject(e) && y.each(e, function(e, i)
                {
                    e && t.indexOf(i) >= 0 && (n[i] = e)
                }), !m.isEmptyObject(n)) return n.kladr_id ?
            {
                kladr_id: n.kladr_id
            } : n
        },
        addConstraint: function(e)
        {
            var t = this;
            e = new le(e, t), e.isValid() && (t.constraints[e.id] = e, e.$el && (t.$constraints.append(e.$el), t._constraintsUpdating || t.fixPosition()))
        },
        removeConstraint: function(e)
        {
            var t = this;
            delete t.constraints[e], t.$constraints.children('[data-constraint-id="' + e + '"]').remove(), t._constraintsUpdating || t.fixPosition()
        },
        constructConstraintsParams: function()
        {
            for (var e, t, n = this, i = [], s = n.constraints, o = {}; P.isJqObject(s) && (e = s.suggestions()) && !(t = b.getDeepValue(e, "selection.data"));) s = e.constraints;
            return P.isJqObject(s) ? (t = new re(t, e).getFields()) && (n.bounds.own.indexOf("city") > -1 && delete t.city_fias_id, o.locations = [t], o.restrict_value = !0) : s && (y.each(s, function(e, t)
            {
                i = i.concat(e.getFields())
            }), i.length && (o.locations = i, o.restrict_value = n.options.restrict_value)), o
        },
        getFirstConstraintLabel: function()
        {
            var e = this,
                t = m.isPlainObject(e.constraints) && Object.keys(e.constraints)[0];
            return t ? e.constraints[t].label : ""
        },
        bindToParent: function()
        {
            var e = this;
            e.constraints.on(["suggestions-select." + e.uniqueId, "suggestions-invalidateselection." + e.uniqueId, "suggestions-clear." + e.uniqueId].join(" "), P.proxy(e.onParentSelectionChanged, e)).on("suggestions-dispose." + e.uniqueId, P.proxy(e.onParentDispose, e))
        },
        unbindFromParent: function()
        {
            var e = this,
                t = e.constraints;
            P.isJqObject(t) && t.off("." + e.uniqueId)
        },
        onParentSelectionChanged: function(e, t, n)
        {
            ("suggestions-select" !== e.type || n) && this.clear()
        },
        onParentDispose: function(e)
        {
            this.unbindFromParent()
        },
        getParentInstance: function()
        {
            return P.isJqObject(this.constraints) && this.constraints.suggestions()
        },
        shareWithParent: function(e)
        {
            var t = this.getParentInstance();
            t && t.type === this.type && !f(e, t) && (t.shareWithParent(e), t.setSuggestion(e))
        },
        getUnrestrictedData: function(e)
        {
            var t = this,
                n = [],
                i = {},
                s = -1;
            return y.each(t.constraints, function(t, n)
            {
                y.each(t.locations, function(t, n)
                {
                    t.containsData(e) && t.specificity > s && (s = t.specificity)
                })
            }), s >= 0 ? (e.region_kladr_id && e.region_kladr_id === e.city_kladr_id && n.push.apply(n, t.type.dataComponentsById.city.fields), y.each(t.type.dataComponents.slice(0, s + 1), function(e, t)
            {
                n.push.apply(n, e.fields)
            }), y.each(e, function(e, t)
            {
                -1 === n.indexOf(t) && (i[t] = e)
            })) : i = e, i
        }
    };
    P.extend(B, oe), P.extend(a.prototype, ce), "GET" != T.getDefaultType() && M.on("initialize", ce.createConstraints).on("setOptions", ce.setupConstraints).on("fixPosition", ce.setConstraintsPosition).on("requestParams", ce.constructConstraintsParams).on("dispose", ce.unbindFromParent);
    var ue = {
        proceedQuery: function(e)
        {
            var t = this;
            e.length >= t.options.minChars ? t.updateSuggestions(e) : t.hide()
        },
        selectCurrentValue: function(e)
        {
            var t = this,
                n = P.Deferred();
            return t.inputPhase.resolve(), t.fetchPhase.done(function()
            {
                var i;
                t.selection && !t.visible ? n.reject() : (i = t.findSuggestionIndex(), t.select(i, e), -1 === i ? n.reject() : n.resolve(i))
            }).fail(function()
            {
                n.reject()
            }), n
        },
        selectFoundSuggestion: function()
        {
            var e = this;
            e.requestMode.userSelect || e.select(0)
        },
        findSuggestionIndex: function()
        {
            var e, t = this,
                n = t.selectedIndex;
            return -1 === n && (e = t.el.val().trim()) && t.type.matchers.some(function(i)
            {
                return -1 !== (n = i(e, t.suggestions))
            }), n
        },
        select: function(e, t)
        {
            var n, i = this,
                s = i.suggestions[e],
                o = t && t.continueSelecting,
                a = i.currentValue;
            if (!i.triggering.Select)
            {
                if (!s) return o || i.selection || i.triggerOnSelectNothing(), void i.onSelectComplete(o);
                n = i.hasSameValues(s), i.enrichSuggestion(s, t).done(function(s, o)
                {
                    var r = P.extend(
                    {
                        hasBeenEnriched: o,
                        hasSameValues: n
                    }, t);
                    i.selectSuggestion(s, e, a, r)
                })
            }
        },
        selectSuggestion: function(e, t, n, i)
        {
            var s = this,
                o = i.continueSelecting,
                a = !s.type.isDataComplete || s.type.isDataComplete.call(s, e),
                r = s.selection;
            s.triggering.Select || (s.type.alwaysContinueSelecting && (o = !0), a && (o = !1), i.hasBeenEnriched && s.suggestions[t] && (s.suggestions[t].data = e.data), s.requestMode.updateValue && (s.checkValueBounds(e), s.currentValue = s.getSuggestionValue(e, i), !s.currentValue || i.noSpace || a || (s.currentValue += " "), s.el.val(s.currentValue)), s.currentValue ? (s.selection = e, s.areSuggestionsSame(e, r) || s.trigger("Select", e, s.currentValue != n), s.requestMode.userSelect && s.onSelectComplete(o)) : (s.selection = null, s.triggerOnSelectNothing()), s.shareWithParent(e))
        },
        onSelectComplete: function(e)
        {
            var t = this;
            e ? (t.selectedIndex = -1, t.updateSuggestions(t.currentValue)) : t.hide()
        },
        triggerOnSelectNothing: function()
        {
            var e = this;
            e.triggering.SelectNothing || e.trigger("SelectNothing", e.currentValue)
        },
        trigger: function(e)
        {
            var t = this,
                n = j.slice(arguments, 1),
                i = t.options["on" + e];
            t.triggering[e] = !0, j.isFunction(i) && i.apply(t.element, n), t.el.trigger.call(t.el, "suggestions-" + e.toLowerCase(), n), t.triggering[e] = !1
        }
    };
    P.extend(a.prototype, ue), M.on("assignSuggestions", ue.selectFoundSuggestion);
    var de = {
            bounds: null
        },
        fe = {
            setupBounds: function()
            {
                this.bounds = {
                    from: null,
                    to: null
                }
            },
            setBoundsOptions: function()
            {
                var t, n, i = this,
                    s = [],
                    o = e.trim(i.options.bounds).split("-"),
                    a = o[0],
                    r = o[o.length - 1],
                    l = [],
                    c = [];
                i.type.dataComponents && e.each(i.type.dataComponents, function()
                {
                    this.forBounds && s.push(this.id)
                }), -1 === e.inArray(a, s) && (a = null), n = e.inArray(r, s), -1 !== n && n !== s.length - 1 || (r = null), (a || r) && (t = !a, e.each(s, function(e, n)
                {
                    if (n == a && (t = !0), c.push(n), t && l.push(n), n == r) return !1
                })), i.bounds.from = a, i.bounds.to = r, i.bounds.all = c, i.bounds.own = l
            },
            constructBoundsParams: function()
            {
                var e = this,
                    t = {};
                return e.bounds.from && (t.from_bound = {
                    value: e.bounds.from
                }), e.bounds.to && (t.to_bound = {
                    value: e.bounds.to
                }), t
            },
            checkValueBounds: function(e)
            {
                var t, n = this;
                if (n.bounds.own.length && n.type.composeValue)
                {
                    var i = n.bounds.own.slice(0);
                    1 === i.length && "city_district" === i[0] && i.push("city_district_fias_id"), t = n.copyDataComponents(e.data, i), e.value = n.type.composeValue(t)
                }
            },
            copyDataComponents: function(t, n)
            {
                var i = {},
                    s = this.type.dataComponentsById;
                return s && e.each(n, function(n, o)
                {
                    e.each(s[o].fields, function(e, n)
                    {
                        null != t[n] && (i[n] = t[n])
                    })
                }), i
            },
            getBoundedKladrId: function(t, n)
            {
                var i, s = n[n.length - 1];
                return e.each(this.type.dataComponents, function(e, t)
                {
                    if (t.id === s) return i = t.kladrFormat, !1
                }), t.substr(0, i.digits) + new Array((i.zeros || 0) + 1).join("0")
            }
        };
    e.extend(B, de), e.extend(a.prototype, fe), M.on("initialize", fe.setupBounds).on("setOptions", fe.setBoundsOptions).on("requestParams", fe.constructBoundsParams);
    var pe = {
        selectByClass: function(e, t)
        {
            var n = "." + e;
            return t ? t.querySelector(n) : document.querySelector(n)
        },
        addClass: function(e, t)
        {
            var n = e.className.split(" "); - 1 === n.indexOf(t) && n.push(t), e.className = n.join(" ")
        },
        setStyle: function(e, t, n)
        {
            e.style[t] = n
        },
        listenTo: function(e, t, n, i)
        {
            e.addEventListener(t, i, !1), n && (eventsByNamespace[n] || (eventsByNamespace[n] = []), eventsByNamespace[n].push(
            {
                eventName: t,
                element: e,
                callback: i
            }))
        },
        stopListeningNamespace: function(e)
        {
            var t = eventsByNamespace[e];
            t && t.forEach(function(e)
            {
                e.element.removeEventListener(e.eventName, e.callback, !1)
            })
        }
    };
    h.prototype.show = function()
    {
        "FREE" === this.plan && this.element && (this.setStyles(), this.setHtml())
    }, h.prototype.setStyles = function()
    {
        this.element.style.display = "block", this.isMobile || this.element.classList.add(x.promo_desktop)
    }, h.prototype.setHtml = function()
    {
        this.element.innerHTML = '<a target="_blank" href="https://dadata.ru/suggestions/?utm_source=dadata&utm_medium=module&utm_campaign=suggestions-jquery"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 167.55 38.92"><defs><style>.cls-1{fill:#cdcccc;}.cls-2{fill:#ef4741;}.cls-3{fill:#fff;}</style></defs><title>dadata-logo</title><path class="cls-1" d="M192.61,153.07H196v-3.15h-3.39Zm9.55-14.46v-2.45h-3v16.91h3.14V142.2a4.39,4.39,0,0,1,4.23-3.7h1.75v-2.69h-1.54C203.75,135.81,202.35,137.76,202.16,138.61Zm20.2-2.45v11.3a5,5,0,0,1-4.65,3.66,7.19,7.19,0,0,1-2-.23,2,2,0,0,1-1.12-.6,2.38,2.38,0,0,1-.44-.86,4.38,4.38,0,0,1-.1-1V136.16h-3.14v12.4a4.83,4.83,0,0,0,1.26,3.65q1.26,1.21,4.61,1.21c3.38,0,4.62-.91,5.56-2.34v2h3.14V136.16Z" transform="translate(-57.96 -122.27)"/><rect class="cls-2" width="131.91" height="38.92" rx="3" ry="3"/><path class="cls-3" d="M119.34,130.39h-9.18v22.68h10.23c3.84,0,10.18-.35,10.18-6.88v-8.91C130.56,130.74,123.18,130.39,119.34,130.39Zm5.77,15.2c0,3.27-2.38,3.6-5.09,3.6h-4.41V134.27H119c2.71,0,6.14.33,6.14,3.6Zm-48-15.2H68v22.68H78.18c3.84,0,10.18-.35,10.18-6.88v-8.91C88.36,130.74,81,130.39,77.14,130.39Zm5.77,15.2c0,3.27-2.38,3.6-5.09,3.6H73.41V134.27h3.36c2.71,0,6.14.33,6.14,3.6Zm74-14.32h-5.1V148a6.28,6.28,0,0,0,.4,2.36,4,4,0,0,0,1,1.54,4.56,4.56,0,0,0,1.57.88,8.16,8.16,0,0,0,1.85.42q.89.08,2.08.09a24.23,24.23,0,0,0,2.83-.17v-2.87h-1.82a3.08,3.08,0,0,1-2.31-.61,3.79,3.79,0,0,1-.52-2.36V139h4.65v-3.14h-4.65Zm21,5.68q-1.82-1.14-6.5-1.13h-5.92v.25l.73,2.9h5.19a5,5,0,0,1,2.5.5,2.37,2.37,0,0,1,.72,2v1.15H168.9q-3,0-4.12,1.17T163.62,148c0,2.21.37,3.14,1.12,3.84s2.2,1.22,4.48,1.22h7.06c1.76,0,3.45-.83,3.45-2.82v-8.81Q179.73,138.08,177.91,136.94Zm-3.29,13.3h-3.35a4.27,4.27,0,0,1-2.22-.35q-.44-.35-.44-2t.42-2.06a3.55,3.55,0,0,1,2.1-.38h3.49Zm-27.5-13.3q-1.82-1.14-6.5-1.13h-5.92v.25l.73,2.9h5.19a5,5,0,0,1,2.5.5,2.38,2.38,0,0,1,.72,2v1.15h-5.73q-3,0-4.12,1.17T132.84,148c0,2.21.37,3.14,1.12,3.84s2.2,1.22,4.48,1.22h7.06c1.77,0,3.45-.83,3.45-2.82v-8.81Q148.94,138.08,147.13,136.94Zm-3.28,13.3h-3.35a4.27,4.27,0,0,1-2.22-.35q-.44-.35-.44-2t.42-2.06a3.55,3.55,0,0,1,2.1-.38h3.49Zm-38.92-13.3q-1.82-1.14-6.5-1.13H92.5v.25l.73,2.9h5.19a5,5,0,0,1,2.5.5,2.38,2.38,0,0,1,.72,2v1.15H95.91q-3,0-4.12,1.17T90.63,148c0,2.21.37,3.14,1.12,3.84s2.2,1.22,4.48,1.22h7.06c1.77,0,3.45-.83,3.45-2.82v-8.81Q106.74,138.08,104.92,136.94Zm-3.28,13.3H98.29a4.27,4.27,0,0,1-2.22-.35q-.44-.35-.44-2t.42-2.06a3.55,3.55,0,0,1,2.1-.38h3.49Z" transform="translate(-57.96 -122.27)"/></svg></a>'
    }, M.on("assignSuggestions", g), a.defaultOptions = B, a.version = "20.1.1", e.Suggestions = a, e.fn.suggestions = function(t, n)
    {
        return 0 === arguments.length ? this.first().data("suggestions") : this.each(function()
        {
            var i = e(this),
                s = i.data("suggestions");
            "string" == typeof t ? s && "function" == typeof s[t] && s[t](n) : (s && s.dispose && s.dispose(), s = new a(this, t), i.data("suggestions", s))
        })
    }
});