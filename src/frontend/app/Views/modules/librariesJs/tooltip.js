$.fn.style_my_tooltips = function(a)
{
    var a = $.extend(
        {
            tip_follows_cursor: "on",
            tip_delay_time: 200
        }, a);
    return $("body").append("<div id='s-m-t-tooltip'></div>"), smtTip = $("#s-m-t-tooltip"), smtTip.hide(), this.each(function()
    {
        function b(a)
        {
            smtMouseCoordsX = a.pageX, smtMouseCoordsY = a.pageY, c()
        }

        function c()
        {
            var a = 24,
                b = smtMouseCoordsX + 0 + $(smtTip).outerWidth(),
                c = smtMouseCoordsY + a + $(smtTip).outerHeight();
            if (b <= $(window).width()) smtTip.css("left", smtMouseCoordsX + 0);
            else
            {
                var d = smtMouseCoordsX - 0 - $(smtTip).width();
                smtTip.css("left", d)
            }
            if (c <= $(window).height()) smtTip.css("top", smtMouseCoordsY + a);
            else
            {
                var e = smtMouseCoordsY - a - $(smtTip).height();
                smtTip.css("top", e)
            }
        }

        function d()
        {
            smtTip.fadeTo("fast", 1, function()
            {
                clearInterval(f)
            })
        }
        var f;
        $(this).hover(function(c)
        {
            var e = $(this);
            e.data("smtTitle", e.attr("title"));
            var g = e.data("smtTitle");
            e.attr("title", ""), smtTip.empty().append(g).hide(), f = setInterval(d, a.tip_delay_time), "off" == a.tip_follows_cursor ? b(c) : $(document).bind("mousemove", function(a)
            {
                b(a)
            })
        }, function()
        {
            var b = $(this);
            "off" != a.tip_follows_cursor && $(document).unbind("mousemove"), null != f && clearInterval(f), smtTip.is(":animated") ? smtTip.hide() : smtTip.fadeTo("fast", 0), b.attr("title", b.data("smtTitle"))
        })
    })
};