if(window.ymaps == undefined){
    $.ajax({
        type: "GET",
        url: "https://api-maps.yandex.ru/2.1/?lang=ru_RU",
        dataType: "script",
        cache: true,
        async: false,
    });
}