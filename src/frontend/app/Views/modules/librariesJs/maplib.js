L.TileLayer.Rosreestr = L.TileLayer.extend(
    {
        options:
            {
                tileSize: 1024,
                opacity: 0.7
            },
        getTileUrl: function(e)
        {
            var t = this._map,
                r = t.options.crs,
                i = this.options.tileSize,
                o = e.multiplyBy(i),
                s = o.add([i, i]),
                l = r.project(t.unproject(o, e.z)),
                n = r.project(t.unproject(s, e.z)),
                a = [l.x, n.y, n.x, l.y].join(",");
            return L.Util.template(this._url, L.extend(
                {
                    s: this._getSubdomain(e),
                    bbox: encodeURIComponent(a)
                }, this.options))
        }
    }), L.tileLayer.Rosreestr = function(t, r){
        return r.clickable && (L.TileLayer.Rosreestr = e(L.TileLayer.Rosreestr)), new L.TileLayer.Rosreestr(t, r)
    };
L.TileLayer.Yandex = L.Layer.extend(
{
    includes: L.Evented,
    options:
        {
            minZoom: 0,
            maxZoom: 18,
            attribution: "",
            opacity: 1,
            traffic: !1,
            zIndex: 1
        },
    possibleShortMapTypes:
        {
            schemaMap: "map",
            satelliteMap: "satellite",
            hybridMap: "hybrid",
            publicMap: "publicMap",
            publicMapInHybridView: "publicMapHybrid"
        },
    _getPossibleMapType: function(t)
    {
        var i = "yandex#map";
        if ("string" != typeof t) return i;
        for (var e in this.possibleShortMapTypes)
        {
            if (t === this.possibleShortMapTypes[e])
            {
                i = "yandex#" + t;
                break
            }
            t === "yandex#" + this.possibleShortMapTypes[e] && (i = t)
        }
        return i
    },
    initialize: function(t, i)
    {
        L.Util.setOptions(this, i), this._type = this._getPossibleMapType(t)
    },
    onAdd: function(t, i)
    {
        this._map = t, this._insertAtTheBottom = i, this._initContainer(), this._initMapObject(), t.on("viewreset", this._reset, this), this._limitedUpdate = L.Util.throttle(this._update, 150, this), t.on("move", this._update, this), t._controlCorners.bottomright.style.marginBottom = "3em", this._reset(), this._update(!0)
    },
    onRemove: function(t)
    {
        this._map._container.removeChild(this._container), this._map.off("viewreset", this._reset, this), this._map.off("move", this._update, this), t._controlCorners.bottomright.style.marginBottom = "0em"
    },
    getAttribution: function()
    {
        return this.options.attribution
    },
    setOpacity: function(t)
    {
        this.options.opacity = t, t < 1 && L.DomUtil.setOpacity(this._container, t)
    },
    setElementSize: function(t, i)
    {
        t.style.width = i.x + "px", t.style.height = i.y + "px"
    },
    _initContainer: function()
    {
        var t = this._map._container,
            i = t.firstChild;
        this._container || (this._container = L.DomUtil.create("div", "leaflet-yandex-layer"), this._container.id = "YMapContainer", this._container.style.zIndex = "auto"), this.options.overlay && (i = (i = this._map._container.getElementsByClassName("leaflet-map-pane")[0]).nextSibling, L.Browser.opera && (this._container.className += " leaflet-objects-pane")), t.insertBefore(this._container, i), this.setOpacity(this.options.opacity), this.setElementSize(this._container, this._map.getSize())
    },
    _initMapObject: function()
    {
        if (!this._yandex)
        {
            if (void 0 === ymaps.Map) return ymaps.load(["package.map"], this._initMapObject, this);
            if (this.options.traffic && (void 0 === ymaps.control || void 0 === ymaps.control.TrafficControl)) return ymaps.load(["package.traffic", "package.controls"], this._initMapObject, this);
            var t = new ymaps.Map(this._container,
                {
                    center: [0, 0],
                    zoom: 0,
                    behaviors: [],
                    controls: []
                });
            this.options.traffic && t.controls.add(new ymaps.control.TrafficControl(
                {
                    shown: !0
                })), "yandex#null" === this._type && (this._type = new ymaps.MapType("null", []), t.container.getElement().style.background = "transparent"), t.setType(this._type), this._yandex = t, this._update(!0), this.fire("MapObjectInitialized",
                {
                    mapObject: t
                }), t.behaviors.get("drag").options.set("inertia", !1), t.behaviors.get("drag").options.set("inertiaDuration", 0)
        }
    },
    _reset: function()
    {
        this._initContainer()
    },
    _update: function(t)
    {
        if (this._yandex)
        {
            this._resize(t);
            var i = this._map.getCenter(),
                e = [i.lat, i.lng],
                n = this._map.getZoom();
            (t || this._yandex.getZoom() !== n) && this._yandex.setZoom(n), this._yandex.panTo(e,
                {
                    duration: 0,
                    delay: 0
                })
        }
    },
    _resize: function(t)
    {
        var i = this._map.getSize(),
            e = this._container.style;
        e.width === i.x + "px" && e.height === i.y + "px" && !0 !== t || (this.setElementSize(this._container, i), this._yandex.container.fitToViewport())
    }
});
$('head').append('<meta name="referrer" content="no-referrer">');
$('head').append('<meta name="referrer" content="never">');
$.RM = {
    map: null,
    options : {
        zoom            : $.map_options.zoom,
        layer           : 'googleMap',
        layerBorders    : 1,
        thematic        : 0,
        thematic_select : 0,
        baloon          : undefined,
        number          : $.map_options.number,
        lat             : $.map_options.lat,
        lng             : $.map_options.lng,
        address         : $.map_options.address,
        openInfo        : 1,
        typesByZoom     : {
            0  : 4,
            1  : 4,
            2  : 4,
            3  : 4,
            4  : 4,
            5  : 4,
            6  : 4,
            7  : 3,
            8  : 3,
            9  : 3,
            10 : 3,
            11 : 2,
            12 : 2,
            13 : 2,
            14 : 2,
            15 : 1,
            16 : 1,
            17 : 1,
            18 : 1,
        },
        lrselect: null,
        lrpolygon:null,
    },
    layers: {
        rosreestr: new L.tileLayer.Rosreestr('https://pkk.rosreestr.ru/arcgis/rest/services/PKK6/Cadastre/MapServer/export?layers=show%3A0%2C1%2C2%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19%2C20%2C23%2C24%2C29%2C30%2C31%2C32%2C33%2C34%2C35%2C38%2C39&dpi=96&format=PNG32&bbox={bbox}&bboxSR=102100&imageSR=102100&size=1024%2C1024&transparent=true&f=image', {
            subdomains: ['a', 'b', 'c', 'd'],
            zIndex:3
        }),
        rosreestrSelect: function(type, id){
            var layers = "";
            if(type == 4){
                layers = "layers="+encodeURIComponent("show:10,11,12")+"&layerDefs="+encodeURIComponent("{\"10\":\"objectid = -1\",\"11\":\"objectid = -1\",\"12\":\"ID = '"+id+"'\"}");
            }
            if(type == 3){
                layers = "layers="+encodeURIComponent("show:10,11,12")+"&layerDefs="+encodeURIComponent("{\"10\":\"objectid = -1\",\"11\":\"ID = '"+id+"'\",\"12\":\"objectid = -1\"}");
            }
            if(type == 2){
                layers = "layers="+encodeURIComponent("show:10,11,12")+"&layerDefs="+encodeURIComponent("{\"10\":\"ID = '"+id+"'\",\"11\":\"objectid = -1\",\"12\":\"objectid = -1\"}");
            }
            if(type == 1){
                layers = "layers="+encodeURIComponent("show:7,8")+"&layerDefs="+encodeURIComponent("{\"7\":\"id = '"+id+"'\",\"8\":\"id = '"+id+"'\"}");
            }
            return new L.tileLayer.Rosreestr('https://pkk.rosreestr.ru/arcgis/rest/services/PKK6/CadastreSelected/MapServer/export?dpi=96&transparent=true&format=png32&bbox={bbox}&size=1024%2C1024&bboxSR=102100&imageSR=102100&{egrn}&f=image', {
                subdomains: ['a', 'b', 'c', 'd'],
                zIndex:5,
                egrn: layers
            });
        },
        rosreestrThematic: {
            1: new L.tileLayer.Rosreestr('https://pkk.rosreestr.ru/arcgis/rest/services/PKK6/Thematic/MapServer/export?layers=show%3A1&dpi=96&transparent=true&format=PNG32&bbox={bbox}&size=1024%2C1024&bboxSR=102100&imageSR=102100&f=image', {
                subdomains: ['a', 'b', 'c', 'd'],
                zIndex:4
            }),
            2: new L.tileLayer.Rosreestr('https://pkk.rosreestr.ru/arcgis/rest/services/PKK6/Thematic/MapServer/export?layers=show%3A2%2C3&dpi=96&transparent=true&format=PNG32&bbox={bbox}&size=1024%2C1024&bboxSR=102100&imageSR=102100&f=image', {
                subdomains: ['a', 'b', 'c', 'd'],
                zIndex:4
            }),
            3: new L.tileLayer.Rosreestr('https://pkk.rosreestr.ru/arcgis/rest/services/PKK6/Thematic/MapServer/export?layers=show%3A4%2C5&dpi=96&transparent=true&format=PNG32&bbox={bbox}&size=1024%2C1024&bboxSR=102100&imageSR=102100&f=image', {
                subdomains: ['a', 'b', 'c', 'd'],
                zIndex:4
            }),
            4: new L.tileLayer.Rosreestr('https://pkk.rosreestr.ru/arcgis/rest/services/PKK6/Thematic/MapServer/export?layers=show%3A13%2C14&dpi=96&transparent=true&format=PNG32&bbox={bbox}&size=1024%2C1024&bboxSR=102100&imageSR=102100&f=image', {
                subdomains: ['a', 'b', 'c', 'd'],
                zIndex:4
            }),
            5: new L.tileLayer.Rosreestr('https://pkk.rosreestr.ru/arcgis/rest/services/PKK6/Thematic/MapServer/export?layers=show%3A6%2C7&dpi=96&transparent=true&format=PNG32&bbox={bbox}&size=1024%2C1024&bboxSR=102100&imageSR=102100&f=image', {
                subdomains: ['a', 'b', 'c', 'd'],
                zIndex:4
            }),
            6: new L.tileLayer.Rosreestr('https://pkk.rosreestr.ru/arcgis/rest/services/PKK6/Thematic/MapServer/export?layers=show%3A1&dpi=96&transparent=true&format=PNG32&bbox={bbox}&size=1024%2C1024&bboxSR=102100&imageSR=102100&f=image', {
                subdomains: ['a', 'b', 'c', 'd'],
                zIndex:4
            }),
            7: new L.tileLayer.Rosreestr('https://pkk.rosreestr.ru/arcgis/rest/services/PKK6/Thematic/MapServer/export?layers=show%3A3%2C4%2C5%2C6&dpi=96&transparent=true&format=PNG32&bbox={bbox}&size=1024%2C1024&bboxSR=102100&imageSR=102100&f=image', {
                subdomains: ['a', 'b', 'c', 'd'],
                zIndex:4
            }),
        },
        googleMap: new L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
            subdomains: ["mt0", "mt1", "mt2", "mt3"],
            zIndex:1,
            attribution: '<a rel="nofollow" href="https://google.com/maps" target="_blank">Google Maps</a>, <a href="https://www.google.com/intl/ru_ru/help/terms_maps.html" target="_blank">Условия использования</a>',
        }),
        googleSat: new L.tileLayer('https://{s}.google.com/vt/lyrs=h&x={x}&y={y}&z={z}', {
            subdomains: ["mt0", "mt1", "mt2", "mt3"],
            zIndex:2,
            attribution: '<a rel="nofollow" href="https://google.com/maps" target="_blank">Google Maps</a>, <a href="https://www.google.com/intl/ru_ru/help/terms_maps.html" target="_blank">Условия использования</a>',
        }),
        googleSatS: new L.tileLayer('https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
            subdomains: ["mt0", "mt1", "mt2", "mt3"],
            zIndex:1,
            attribution: '<a rel="nofollow" href="https://google.com/maps" target="_blank">Google Maps</a>, <a href="https://www.google.com/intl/ru_ru/help/terms_maps.html" target="_blank">Условия использования</a>',
        }),
        twoGis: new L.tileLayer('https://tile{s}.maps.2gis.com/tiles?x={x}&y={y}&z={z}&v=46', {
            subdomains: ["0", "1", "2", "3"],
            zIndex:1,
            attribution: '<a rel="nofollow" href="https://www.2gis.ru" target="_blank" title="2ГИС — Городской информационный сервис">2ГИС — Городской информационный сервис</a>, <a rel="nofollow" target="_blank" href="http://law.2gis.ru/licensing-agreement/">Условия использования</a>',
        }),
        osm: new L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            zIndex:1,
            attribution: '<a rel="nofollow" target="_blank" href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        }),
        yandexMap: new L.TileLayer.Yandex(),
        yandexSat: new L.TileLayer.Yandex('hybrid'),
    },
    init: function(){
        L.control.attribution({prefix:false});
        L.Icon.Default.imagePath = '/static/css/images/';
        L.Icon.Default.prototype.options.iconUrl = 'marker-icon.png';
        L.Icon.Default.prototype.options.shadowUrl = 'marker-shadow.png';
        $.RM.map = L.map('map', {
            attributionControl: true,
            zoomControl: false,
            zoomAnimation: true,
            doubleClickZoom: true
        }).setView([$.RM.options.lat, $.RM.options.lng], $.RM.options.zoom);

        $.RM.f.setLayer($.RM.options.layer);
        $.RM.f.setLayerBorders($.RM.options.layerBorders);
        $.RM.f.getTematics($.RM.options.thematic_select);
        if($.RM.options.baloon != undefined){
            $.RM.options.baloon.remove();
        }
        $.RM.options.baloon = L.marker([$.RM.options.lat, $.RM.options.lng]).addTo($.RM.map);
        $.RM.f.handlers();

    },
    f: {
        handlers: function()
        {
            setTimeout(function(){
                $('.map .__box').addClass('_show');
                $('.map .__image').removeClass('_show');
            }, 300);

            $.RM.map.on('zoomstart', function(ev) {
                $('#YMapContainer').css('display', 'none');
            });
            $.RM.map.on('movestart', function(ev) {
                $('#YMapContainer').css('display', 'none');
            });
            $.RM.map.on('zoomend', function(ev) {
                setTimeout(function(){
                    $('#YMapContainer').css('display', 'block');
                }, 50);
            });
            $.RM.map.on('moveend', function(ev) {
                setTimeout(function(){
                    $('#YMapContainer').css('display', 'block');
                }, 50);
            });
            $.RM.map.on('click', function(ev) {
                $("#loaderbody").fadeIn(10);
                if($.RM.options.baloon != undefined){
                    $.RM.options.baloon.remove();
                }
                $('.page').addClass('_load');
                if($('.page').hasClass('_open') == false)
                {
                    $(".js__searchCaret").trigger('click');
                    setTimeout(function(){
                        $.RM.f.setBaloon(ev.latlng.lat, ev.latlng.lng);
                    }, 100);
                }
                else
                {
                    $.RM.f.setBaloon(ev.latlng.lat, ev.latlng.lng);
                }

                $.RM.options.baloon = L.marker([ev.latlng.lat, ev.latlng.lng]).addTo($.RM.map);
            });
            $.RM.map.on('dblclick', function(ev) {
                /*$.RM.f.zoom(1);*/
            });

            $(".map .__zoom .__btn._plus").click(function(){$.RM.f.zoom(1)});
            $(".map .__zoom .__btn._minus").click(function(){$.RM.f.zoom(0)});

            $(".map .__control .__list li").click(function(){
                var type = $(this).data("type");
                $.RM.f.setLayer(type);
            });
            $(".js__mapBorder").change(function(){
                $.RM.options.layerBorders = 0;
                if($(this).prop('checked')){
                    $.RM.options.layerBorders = 1;
                }
                $.RM.f.setLayerBorders($.RM.options.layerBorders);
            });
            $(".js__mapTheme").change(function(){
                $.RM.f.removeThematic();
                $.RM.options.thematic = 0;
                $.RM.options.thematic_select = parseInt($('.map .__control .__options .__select').val());
                if($(this).prop('checked')){
                    $.RM.options.thematic = 1;
                }
                $.RM.f.setThematic();
            });
            $(".map .__control .__options .__select").change(function(){
                $.RM.f.removeThematic();
                $.RM.options.thematic_select = parseInt($(this).val());
                $.RM.f.setThematic();
            });
            $('.map__cblock._control').click(function(){
                $(this).fadeOut(0);
                $(".map__bwrap._control").addClass("_open");
            });
            $(".map__bwrapRollup._control, .map__bwrapClose._control").click(function(){
                $(".map__bwrap._control").removeClass("_open");
                $('.map__cblock._control').fadeIn(0);
            });
            $('.map__cblock._info').click(function(){
                $(this).fadeOut(0);
                $(".map__bwrap._info").addClass("_open");
                $('.map__cblock._info').removeClass('_wait');
                $.RM.options.openInfo = 1;
            });
        },
        zoom: function(a){
            $.RM.options.zoom = $.RM.map.getZoom();
            if(a==1){
                $.RM.options.zoom +=1;
            }else{
                $.RM.options.zoom -=1;
            }
            if($.RM.options.zoom<=1){$.RM.options.zoom=1;}
            if($.RM.options.zoom>=18){$.RM.options.zoom=18;}
            $.RM.map.setZoom($.RM.options.zoom);

        },
        removeThematic: function()
        {
            if($.RM.options.thematic_select != 0){
                $.RM.layers.rosreestrThematic[$.RM.options.thematic_select].remove();
            }
            return true;
        },
        setLayer: function(layer){
            if($.RM.layers[layer] == undefined){var layer = 'googleMap';}
            $.RM.layers[$.RM.options.layer].remove();
            $.RM.layers.googleSatS.remove();
            $.RM.layers[layer].addTo($.RM.map);
            if(layer == 'googleSat'){
                $.RM.layers.googleSatS.addTo($.RM.map);
            }
            $.RM.options.layer = layer;
            $('.map .__control .__list li').each(function(i,e){
                $(e).removeClass('_active');
            });
            $('.map .__control .__list li[data-type='+layer+']').addClass('_active');
        },
        setLayerBorders: function(status){
            $('.js__mapBorder').prop("checked", false);
            $.RM.layers.rosreestr.remove();
            if(status == 1){
                $('.js__mapBorder').prop("checked", true);
                $.RM.layers.rosreestr.addTo($.RM.map);
            }
        },
        getTematics: function(id){
            $.ajax({
                type: "POST",
                url: "/ajax/map/getTematics",
                data: {id:id},
                success: function(data) {
                    var html = '';
                    for(var k in data.response){
                        html += '<option '+(data.response[k].id == 2?"selected":'')+' value="'+data.response[k].id+'">'+data.response[k].title+'</option>';
                    }
                    $('.map .__control .__options .__select').html(html);
                }
            });
        },
        setThematic: function(){
            if($.RM.options.thematic == 0){
                $('.map .__control .__options .__thema-wrap').fadeOut(0);
                $.RM.layers.rosreestrThematic[$.RM.options.thematic_select].remove();
            }else{
                $('.map .__control .__options .__thema-wrap').fadeIn(0);
                $.RM.layers.rosreestrThematic[$.RM.options.thematic_select].addTo($.RM.map);
                $.ajax({
                    type: "POST",
                    url: "/ajax/map/getTematicById",
                    data: {id:$.RM.options.thematic_select},
                    success: function(data) {
                        var html = '';
                        for(var k in data.response){
                            html += '<div class="__label"><div class="__color" style="background: #'+data.response[k].hex+';"></div><div class="__text">'+data.response[k].title+'</div></div>';
                        }
                        $('.map .__control .__options .__thema-wrap .__labels').html(html);
                    }
                });
            }
        },
        setBaloon: function(lat, lng, nolink)
        {
            var type = $.RM.options.typesByZoom[$.RM.map.getZoom()];

            var headers = jQuery.ajaxSettings.headers;
            jQuery.ajaxSettings.headers = {};
            jQuery.ajax({
                type: "GET",
                url: "https://pkk.rosreestr.ru/api/features/"+type+"?sq=%7B%22type%22%3A%22Point%22%2C%22coordinates%22%3A%5B"+lng+"%2C"+lat+"%5D%7D&tolerance=1&limit=11",
                dataType: "json",
                success: function(msg) {

                    if(msg.features.length == 0)
                    {
                        $.location(location.href, "[content-main]");
                        return false;
                    }
                    var attr = 0;
                    var id = {};
                    var cn = '';
                    var center = {};
                    for(var key in msg.features){
                        if(msg.features[key].sort > attr){
                            attr = msg.features[key].sort;
                            id      = msg.features[key].attrs.id;
                            cn      = msg.features[key].attrs.cn;
                            center  = msg.features[key].center;
                        }
                    }
                    if($.RM.options.lrselect != null){
                        $.RM.options.lrselect.remove();
                    }
                    $.RM.options.lrselect = $.RM.layers.rosreestrSelect(type,id).addTo($.RM.map);
                    if(nolink == undefined){
                        if(cn != ""){
                            $.RM.f.setLinkByEgrn(cn, center);
                        }
                    }
                }
            });
            jQuery.ajaxSettings.headers = headers;
        },
        getInfoByEgrn: function(type, id){
            $.ajax({
                type: "POST",
                url: "/ajax_map/"+type+"/"+id,
                dataType: "json",
                
                success: function(msg) {
                    if(msg.status == 0){return false;}
                    msg = b64.decode(msg.response.d);msg = JSON.parse(msg);
                    if(msg != undefined){
                        if($.RM.options.lrselect != null){
                            $.RM.options.lrselect.remove();
                        }
                        $.RM.options.lrselect = $.RM.layers.rosreestrSelect(type,id).addTo($.RM.map);

                        $(".map__cblock--info").children('.map__cblock-img').removeClass('map__cblock-img--loading');
                        $(".map__cblock--info").addClass('effects__bounce');
                        $('.map__cblock--info').addClass('map__cblock--wait');
                        setTimeout(function(){$(".map__cblock--info").removeClass('effects__bounce');}, 700);
                        $.RM.f.setLinkByEgrn(id);
                    }
                }
            });
        },
        setLinkByEgrn: function(id, center){
            $.ajax({
                type: "POST",
                url: "/ajax/map/getLinkByEgrn",
                data: {number:id},
                success: function(data) {
                    var url = data.response.link;
                    $.location(url, "[content-main]", {center: JSON.stringify(center)});
                }
            });
        },
        setMapByAddress: function(text)
        {
            text = b64.decode(text);
            $.ajax({
                url: "https://geocode-maps.yandex.ru/1.x/?format=json&results=1&apikey=f9a7dd6d-c1e4-49af-b469-ee0ec24a0efa&geocode=" + text,
                dataType: "JSON",
                success: function(e) {
                    var t = e.response.GeoObjectCollection.featureMember[0].GeoObject;
                    coord = t.Point.pos.split(" "),
                        bL = t.boundedBy.Envelope.lowerCorner.split(" "), bU = t.boundedBy.Envelope.upperCorner.split(" ");
                    $.RM.map.setZoom($.RM.options.zoom,{animate:false});
                    if($.RM.options.baloon != undefined){
                        $.RM.options.baloon.remove();
                    }
                    $.RM.options.baloon = L.marker([coord[1], coord[0]]).addTo($.RM.map);
                    $.RM.f.setBaloon(coord[1], coord[0], 1);
                    $.RM.map.setView([coord[1], coord[0]], $.RM.options.zoom, {animate:false});
                },
                error: function() {
                    console.log("error")
                }
            });
        },
        setLatLng: function()
        {
            $.RM.map.setZoom($.RM.options.zoom,{animate:false});
            if($.RM.options.baloon != undefined){
                $.RM.options.baloon.remove();
            }
            $.RM.options.baloon = L.marker([$.RM.options.lat, $.RM.options.lng]).addTo($.RM.map);
            $.RM.map.setView([$.RM.options.lat, $.RM.options.lng], $.RM.options.zoom, {animate:false});
        },
        setMapByEgrn: function(id, onlink){
            var mass = id.split(':');
            switch(mass.length){
                case 1:
                    var url  = '/ajax_map/4?text='+id+'&tolerance=131129&limit=11';
                    $.RM.options.zoom = 6;
                    break;
                case 2:
                    var url  = '/ajax_map/3?text='+id+'&tolerance=131129&limit=11';
                    $.RM.options.zoom = 9;
                    break;
                case 3:
                    var url  = '/ajax_map/2?text='+id+'&tolerance=131129&limit=11';
                    $.RM.options.zoom = 13;
                    break;
                case 4:
                    $.RM.options.zoom = 17;
                    var url  = '/ajax_map/1?text='+id+'&tolerance=131129&limit=11';
                    /* $.ajax({
                         type: "POST",
                         url: '/ajax/getCoordByEgrn.json',
                         
                         data: {token:xscr_, id: id},
                         success: function(msg) {
                             var data = msg;
                             
                             if(data.status == 1){
                                 $.RM.map.setZoom($.RM.options.zoom,{animate:false});
                                 if($.RM.options.baloon != undefined){
                                     $.RM.options.baloon.remove();
                                 }
                                 $.RM.options.baloon = L.marker([data.response.lat, data.response.lon]).addTo($.RM.map);
                                 $.RM.f.setBaloon(data.response.lat,data.response.lon, (onlink==undefined?1:undefined));
                                 $.RM.map.setView([data.response.lat,data.response.lon], $.RM.options.zoom, {animate:false});
                             }
                         }
                     });
                     return false;*/
                    break;
            }
            $.ajax({
                type: "POST",
                url: url,
                dataType: "json",
                
                success: function(msg) {
                    if(msg.status == 0){return false;}
                    msg = b64.decode(msg.response.d);msg = JSON.parse(msg);
                    if(msg.features != undefined){
                        if(msg.features.length > 0){
                            var lat = $.RM.f.y2lat(msg.features[0].center.y);
                            var lng = $.RM.f.x2lon(msg.features[0].center.x);
                            $.RM.map.setZoom($.RM.options.zoom,{animate:false});
                            if($.RM.options.baloon != undefined){
                                $.RM.options.baloon.remove();
                            }
                            $.RM.options.baloon = L.marker([lat, lng]).addTo($.RM.map);
                            $.RM.f.setBaloon(lat,lng, (onlink==undefined?1:undefined));
                            $.RM.map.setView([lat,lng], $.RM.options.zoom, {animate:false});
                        }
                    }
                }
            });
        },
        x2lon: function(x){
            return x / (Math.PI / 180.0) / 6378137.0;
        },
        y2lat: function(y){
            return (2 * Math.atan(Math.exp(y / 6378137)) - Math.PI / 2) / (Math.PI / 180);
        },
        setPolygonCoords: function(type,id)
        {
            $.ajax({
                type: "POST",
                async:true,
                url: "/ajax/getPoly.json",
                
                data: {type:type,egrn:id},
                success: function(msg) {
                    var data = msg;
                    
                    if(data.status == 1){
                        var coord = JSON.parse(b64.decode(data.data));
                        if(coord.length != 0){
                            var latlngs = coord;
                            if($.RM.options.lrpolygon != null){
                                $.RM.options.lrpolygon.remove();
                            }
                            console.log(latlngs);
                            $.RM.options.lrpolygon = L.polygon(latlngs, {color: '#6c7be3',weight:2}).addTo($.RM.map);
                        }
                    }else{
                        console.log('Error setPolygonCoords;');
                    }
                }
            });
        },

        reload: function()
        {
            $.pjax.reload({container: '[c-pj-search],[c-pj-info],[c-pj-mapseo]',type:"POST",data:{}});
        },

        getInfoPkk: function(hash,attempt){
            if(attempt==undefined){attempt = 0;}
            if(attempt >= 3){alert('Service unavailable, please try again later.'); return false;}
            var r = JSON.parse(b64.decode(hash));
            $.ajax({
                type: "POST",
                url: "/ajax_map/"+r.pkk+'/'+r.kid,
                timeout: 3000,
                dataType: "json",
                
                success: function(msg) {
                    if(msg.status == 0){return false;}
                    msg = b64.decode(msg.response.d);msg = JSON.parse(msg);
                    var data = b64.encode(JSON.stringify(msg));
                    $.ajax({
                        type: "POST",
                        url: "/ajax/saveInfoPkk.json",
                        
                        data: {b:hash,k:data},
                        success: function(msg) {
                            var data = msg;
                            
                            if(data.status == 1){
                                $.pjax.reload({container: '[c-pj-search],[c-pj-info],[c-pj-mapseo]',type:"POST",data:{'pj_search':RK.search.value,'up_map':1}});
                            }else{
                                console.log('Error saveInfoPkk;');
                            }
                        }
                    });
                },
                error: function(){
                    attempt++;
                    $.RM.f.getInfoPkk(hash,attempt);
                },
            });
        },
        updateObjectPkk: function(hash,attempt){
            if(attempt==undefined){attempt = 0;}
            if(attempt >= 3){alert('Service unavailable, please try again later.'); return false;}
            var r = JSON.parse(b64.decode(hash));
            $.ajax({
                type: "POST",
                url: "/ajax_map/"+r.pkk+'/'+r.kid,
                dataType: "json",
                
                success: function(msg) {
                    if(msg.status == 0){return false;}
                    msg = b64.decode(msg.response.d);msg = JSON.parse(msg);
                    var data = msg;
                    if(data.feature == null){
                        alert("Нет границ");
                        return false;
                    }
                    $.ajax({
                        type: "POST",
                        url: "/ajax/updateObjectPkk.json",
                        
                        data: {b:hash,k:b64.encode(JSON.stringify(data))},
                        success: function(msg) {
                            var data = msg;
                            
                            if(data.status == 1){
                                $.pjax.reload({container: '[c-pj-search],[c-pj-info],[c-pj-mapseo]',type:"POST",data:{'up_map':0}});
                            }else{
                                console.log('Error saveInfoPkk;');
                            }
                        }
                    });
                },
                error: function(){
                    attempt++;
                    $.RM.f.updateObjectPkk(hash,attempt);
                },
            });
        },
        getPaginPkk: function(hash, attempt){
            if(attempt==undefined){attempt = 0;}
            if(attempt >= 3){alert('Service unavailable, please try again later.'); return false;}
            var r = JSON.parse(b64.decode(hash));
            $.ajax({
                type: "GET",
                url: "//pkk5.rosreestr.ru/api/typeahead?text="+r.s+"&limit=10",
                dataType: "json",
                timeout: 3000,
                success: function(msg) {
                    var data = b64.encode(JSON.stringify(msg));
                    $.ajax({
                        type: "POST",
                        url: "/ajax/savePaginPkk.json",
                        
                        data: {b:hash,k:data},
                        success: function(msg) {
                            var data = msg;
                            
                            if(data.status == 1){
                                $.pjax.reload({container: '[c-pj-search],[c-pj-info],[c-pj-mapseo]',type:"POST",data:{'pj_search':RK.search.value}});
                            }else{
                                console.log('Error savePaginPkk;');
                            }
                        }
                    });
                },
                error: function(){
                    attempt++;
                    $.RM.f.getPaginPkk(hash, attempt);
                },
            });
        },
        getLandsPkk: function(hash, attempt){
            if(attempt==undefined){attempt = 0;}
            if(attempt >= 3){alert('Service unavailable, please try again later.'); return false;}
            var r = JSON.parse(b64.decode(hash));
            $.ajax({
                type: "POST",
                url: "/ajax_map/1?text=%D0%92%20%D0%B3%D1%80%D0%B0%D0%BD%D0%B8%D1%86%D0%B0%D1%85%20%D0%BA%D0%B2%D0%B0%D1%80%D1%82%D0%B0%D0%BB%D0%B0%20"+r.k+"&tolerance=4&limit=10&skip="+r.s+"&sqo="+r.k+"&sqot=2",
                dataType: "json",
                
                timeout: 3000,
                success: function(msg) {
                    var data = b64.encode(JSON.stringify(msg));
                    $.ajax({
                        type: "POST",
                        url: "/ajax/savePaginPkk.json",
                        
                        data: {b:hash,k:data},
                        success: function(msg) {
                            
                            if(data.status == 0){return false;}
                            msg = b64.decode(msg.response.d);msg = JSON.parse(msg);
                            var data = msg;
                            

                            if(data.status == 1){
                                if(data.nhash != undefined){
                                    $.RM.f.getLandsPkk(data.nhash, 0);
                                }else{
                                    $.pjax.reload({container: '[c-pj-search],[c-pj-info],[c-pj-mapseo]',type:"POST",data:{'pj_search':RK.search.value}});
                                }
                            }else{
                                console.log('Error savePaginPkk;');
                            }
                        }
                    });
                },
                error: function(){
                    attempt++;
                    $.RM.f.getLandsPkk(hash, attempt);
                },
            });
        },
        animateLoadInfo: function()
        {
            $('.info__w').children().each(function(i,e){
                if(!$(e).hasClass('noblur')){
                    $(e).addClass('_blur');
                }
            });
            $('.info__loadwrap').fadeIn(0);
        }
    }
}