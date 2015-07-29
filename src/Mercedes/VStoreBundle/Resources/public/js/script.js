/**
 * Fix the menu bar to the top part of the window when scrolling
 * @param {type} param
 */
$(document).ready(function () {
    var menu = $('.menu');
    var menuPosition = menu.position();
    //console.log("menu position: " + menuPosition.top);
    $(window).scroll(function () {

        var windowPos = $(window).scrollTop()
        if (menuPosition.top < windowPos) {
            menu.addClass('stick');
        } else {
            menu.removeClass('stick');
        }
    });
});

/**
 * Redirects the application to the page of the respective class of vehicle
 * @param string name
 */
var selectClass = function (name) {
    window.location = "car/" + name;
}

var addSpecification = function (specSlug) {
//    jQuery.ajax("/addSpec/"+specSlug);
    console.log("Specification slug: " + specSlug);
    $.ajax({
        type: 'GET',
        url: "/addSpec/" + specSlug,
        success: function () {
            alert("Specification: " + specSlug + " OK");
            location.reload();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert("Req: " + jqXHR + " Status: " + textStatus + " Error:" + errorThrown);
        }
    });
}

var displayPrice = function () {
    console.log("Displaying price");
//    alert("It works: price");
    $.ajax({
        type: 'GET',
        url: '/price',
        dataType: 'json',
        success: function (response) {
            //alert("Price: " + response.newPrice + " OK");
            $('#recalculatedPrice').html(response.newPrice);
            
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert("Req: " + jqXHR + " Status: " + textStatus + " Error:" + errorThrown);
        }
    });
}


