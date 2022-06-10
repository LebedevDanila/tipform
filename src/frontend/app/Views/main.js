/*var some_interval = null;
var timer_search = {
    loading: 0,
    gt:null,
    qm:null,
    type: 'search',
    start: function(type){
        if(type != undefined)
        {
            timer_search.type = type
        }
        $("."+timer_search.type+"__load").addClass('_open');
        $("."+timer_search.type+"__table").removeClass('_open');
        timer_search.gt = setTimeout('timer_search.timers.sec()', 1000);
        timer_search.qm = setTimeout('timer_search.timers.mil()', 33);
    },
    stop: function(){
        clearTimeout(timer_search.gt);
        clearTimeout(timer_search.qm);
        $("#"+timer_search.type+"__time_s").text(35);
        $("#"+timer_search.type+"__time_m").text(99);
        $("."+timer_search.type+"__load").removeClass('_open');
        $("."+timer_search.type+"__table").addClass('_open');
    },
    timers: {
        sec: function(){
            var sec = parseInt($("#"+timer_search.type+"__time_s").text());
            sec -=1;
            if (sec < 10){sec = '0' + sec;}
            $("#"+timer_search.type+"__time_s").html(sec);
            timer_search.gt = setTimeout('timer_search.timers.sec()', 1000);
            if(sec <= 0){
                timer_search.stop();
            }
        },
        mil: function(){
            var sec = parseInt($("#"+timer_search.type+"__time_m").text());
            sec -=4;
            if (sec <= 0){ sec = 99; }
            if (sec < 10){sec = '0' + sec;}
            $("#"+timer_search.type+"__time_m").html(sec);
            timer_search.qm = setTimeout('timer_search.timers.mil()', 33);
        }
    }
};*/
/*addEventListener("popstate",function(e){
    var path = e.target.location.pathname;
    e.preventDefault();
    location.href=path;
    return false;
},false);*/
$(function(){
    $.loadScript = function(name)
    {
        if(eval('$.fn.'+name) != undefined)
        {
            return false;
        }
        $.ajax({
            type: "GET",
            url: "/bundles/js/lib."+name+"."+GLOBAL.version.js+".js",
            dataType: "script",
            cache: true,
            async: false,
            success: function(){}
        });
    };
    $.loadCSS = function(file){
        var link = document.createElement("link");
        link.setAttribute("rel", "stylesheet");
        link.setAttribute("type", "text/css");
        link.setAttribute("href", file);
        document.getElementsByTagName("head")[0].appendChild(link)
    };
    function initSetup(time, hash){
        var headers = {};
        headers['X-'+GLOBAL.protect+'-CSRF'] = time+'-'+hash;
        headers['X-'+GLOBAL.protect+'-REFE'] = location.href;
        $.ajaxSetup({
            headers: headers,
            complete: onRequestCompleted
        });
        //$(".loader._page").addClass('_disabled');
    }
    function onRequestCompleted(xhr, textStatus) {
        if (xhr.getResponseHeader('X-'+GLOBAL.protect+'-Block') == 1) {
            var href = xhr.getResponseHeader("Path-Loc");
            location.href = href;
            return false;
        }
    }

    $.getJsonFromUrl = function(url) {
        if(!url) url = location.href;
        var question = url.indexOf("?");
        var hash = url.indexOf("#");
        if(hash==-1 && question==-1) return {};
        if(hash==-1) hash = url.length;
        var query = question==-1 || hash==question+1 ? url.substring(hash) :
            url.substring(question+1,hash);
        var result = {};
        query.split("&").forEach(function(part) {
            if(!part) return;
            //part = part.split("+").join(" ");
            var eq = part.indexOf("=");
            var key = eq>-1 ? part.substr(0,eq) : part;
            key = (key.substring(0,1)=="#"?key.substring(1):key);
            var val = eq>-1 ? decodeURIComponent(part.substr(eq+1)) : "";
            var from = key.indexOf("[");
            if(from==-1) result[decodeURIComponent(key)] = val;
            else {
                var to = key.indexOf("]",from);
                var index = decodeURIComponent(key.substring(from+1,to));
                key = decodeURIComponent(key.substring(0,from));
                if(!result[key]) result[key] = [];
                if(!index) result[key].push(val);
                else result[key][index] = val;
            }
        });
        return result;
    }

    $.tokenDadata = '295cb6c3e7f2defa0584d77f8aef4bf88e436908';
    $.uniqueid = function(){
        var idstr=String.fromCharCode(Math.floor((Math.random()*25)+65));
        do {
            var ascicode=Math.floor((Math.random()*42)+48);
            if (ascicode<58 || ascicode>64){
                idstr+=String.fromCharCode(ascicode);
            }
        }while (idstr.length<8);
        return (idstr);
    }
    $.number_format = function(number, decimals, dec_point, thousands_sep){
        var i, j, kw, kd, km;

        if( isNaN(decimals = Math.abs(decimals)) ){
            decimals = 2;
        }
        if( dec_point == undefined ){
            dec_point = ",";
        }
        if( thousands_sep == undefined ){
            thousands_sep = ".";
        }

        i = parseInt(number = (+number || 0).toFixed(decimals)) + "";

        if( (j = i.length) > 3 ){
            j = j % 3;
        } else{
            j = 0;
        }

        km = (j ? i.substr(0, j) + thousands_sep : "");
        kw = i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands_sep);
        kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).replace(/-/, 0).slice(2) : "");

        return km + kw + kd;
    }


    $.initCsrf = function(){
        var headers = {};
        headers['X-'+GLOBAL.protect+'-REFE'] = location.href;
        $.ajax({
            type: "POST",
            url: "/ajax/protection/init",
            dataType: "json",
            async: false,
            headers: headers,
            success: function(data) {
                if(data.error){alert(data.error.message);return false;}
                initSetup(data.response.data.time, data.response.data.hash);
            }
        });
    }
    $.openPopup = function(name, params, func){
        //$(".loader_page").removeClass('loader_disabled');
        $.ajax({
            type: "POST",
            url: "/popups/"+name+"/getPopup",
            dataType: "json",
            async: true,
            data: (params==undefined?null:params),
            success: function(data) {
                //$(".loader_page").addClass('loader_disabled');
                if(data.error){alert(data.error.message);return false;}
                $.initCsrf();
                $('body').append($.b64.decode(data.response.content));
                if(func != undefined){eval(func);}
            }
        });
    }
    $.validEmail = function(email){
        return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email);
    }
    $.initCsrf();
    /*$.datepicker.regional['ru'] = {
        closeText: 'Закрыть',
        prevText: '&#x3c;Пред',
        nextText: 'След&#x3e;',
        currentText: 'Сегодня',
        monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
        monthNamesShort: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
        dayNames: ['воскресенье', 'понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота'],
        dayNamesShort: ['вск', 'пнд', 'втр', 'срд', 'чтв', 'птн', 'сбт'],
        dayNamesMin: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
        weekHeader: 'Нед',
        dateFormat: 'dd.mm.yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
    };
    $.datepicker.setDefaults($.datepicker.regional['ru']);


    $(document).pjax('a','[content-main]',{type:"POST",scrollTo:true,fragment:'[content-main]',data:{'request_id': $.uniqueid()}});

    $(document).on('pjax:send', function() {
        $(".page").addClass('_load');
        $('.header__loader').children().css('width', '100%');
        $('.header__loader').children().css('opacity', '1');
        $(".loader._page").removeClass('_disabled');
        timer_search.stop();
    });
    $(document).on('pjax:end', function() {
        $('.header__loader').children().addClass("_end");
        $(".loader._page").addClass('_disabled');
        setTimeout(function(){
            $('.header__loader').children().removeClass("_end");
            $('.header__loader').children().css('opacity', '0');
        }, 500);
        setTimeout(function(){
            $('.header__loader').children().css('width', '0%');
        }, 700);
        $.initCsrf();
        if(window.gtag != undefined)
        {
            gtag('config', GA_MEASUREMENT_ID, {'page_path': location.pathname});
        }
    });
    $(document).on('pjax:timeout', function(event) {
        event.preventDefault();
    });
    $(document).on('submit', 'form', function(event) {
        $.pjax.submit(event, '[content-main]');
        location.reload();
    });

    $.location = function(url, container, data, scrollTo)
    {
        container   = (container==undefined?'[content-main]':container);
        scrollTo    = (scrollTo==undefined?true:scrollTo);
        var request = {};
        if(data != undefined)
        {
            request = data;
        }
        request.request_id = $.uniqueid();
        $.pjax({
            url: url,
            container: container,
            fragment:container,
            type: "POST",
            scrollTo: scrollTo,
            data: request
        });
    }*/

});