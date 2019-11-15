$(document).foundation();
$(window).bind("load", function () {
    let footer = $("#footer");
    let pos = footer.position();
    let height = $(window).height();
    height = height - pos.top;
    height = height - footer.height();
    if (height > 0) {
        footer.css({
            'margin-top': height + 'px'
        });
    }
});