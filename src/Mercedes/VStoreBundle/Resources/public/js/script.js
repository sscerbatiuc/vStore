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

/**
 * Redirects the application to the page of the respective class of vehicle
 * @param string name
 */
var selectClass = function (name) {
    window.location = "car/" + name;
}

var addSpecification = function(specSlug){
//    jQuery.ajax("/addSpec/"+specSlug);
    $.ajax({
       type: 'GET',
       url: "/addSpec/"+specSlug,
       success:function(){
           alert("Specification: "+specSlug+" OK");
           location.reload();
       },
        error: function (jqXHR, textStatus, errorThrown) {
            alert("Req: "+jqXHR+ " Status: "+textStatus+" Error:"+errorThrown);
        }
    });
}

/**
 * 
 * @param {type} param
 */
//$('.customizeButton').click(function () {
//    $('#modalBodyContent').load("/specSelect", function (responseTxt, statusTxt, xhr) {
//        if (statusTxt == "success")
//            alert("External content loaded successfully!");
//        if (statusTxt == "error")
//            alert("Error: " + xhr.status + ": " + xhr.statusText);
//    });
//});


