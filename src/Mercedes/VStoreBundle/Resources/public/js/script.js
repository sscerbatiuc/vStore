/**
 * Fix the menu bar to the top part of the window when scrolling
 * @param {type} param
 */
$(document).ready(function () {
    var menu = $('.menu');
    var menuPosition = menu.position();
    console.log("menu position: " + menuPosition.top);
    $(window).scroll(function () {

        var windowPos = $(window).scrollTop()
        if (menuPosition.top < windowPos) {
            menu.addClass('stick');
        } else {
            menu.removeClass('stick');
        }
    });
});

var selectClass = function (name) {
    window.location = "car/"+name;
}
	