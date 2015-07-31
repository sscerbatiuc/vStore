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

/**
 * Adds the specified option to the vehicle asynchronously
 * @param {type} specSlug
 * @returns {undefined}
 */
var addSpecification = function(specSlug){
//    jQuery.ajax("/addSpec/"+specSlug);

/** Retrieves asynchronously the price of the vehicle
 * @returns {Number}
 */
var displayPrice = function () {
    console.log("Displaying price");
//    alert("It works: price");
    $.ajax({
        type: 'GET',
        url: '/price',
        dataType: 'json',
        success: function (response) {
//            var responseJson = JSON.parse(response);
            console.log(response);
            console.log(response.newPrice);
            $('#recalculatedPrice').html(response.newPrice + '&#8364');
            $('.Price').css("display", "block");
            return 1;
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert("Req: " + jqXHR + " Status: " + textStatus + " Error:" + errorThrown);
            return 0;
        }
    });
}

/**
 * Equips the vehicle stored in the session with the selected specification
 * @param string specSlug
 * @returns {Number}
 */
var addSpecification = function (specSlug) {

    console.log("Specification slug: " + specSlug);
    $.ajax({
        type: 'GET',
        url: "/addSpec/" + specSlug,
        dataType: 'json',
        success: function (response) {
            console.log(response);
//            NOT NECESSARY IF SET THE CONTENT-TYPE OF THE RESPONSE AS JSON
//            var responseJson = JSON.parse(response);
            console.log(response.specName);
            displayPrice();
            $('.alert').toggleClass('alert-warning', false);
            $('.alert').toggleClass('alert-success', true);
            $('.alert').css("display", "block");
            $('.alert').html('<strong>' + response.specName + '</strong> has been added');
            return 1;
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("ERROR: Req: " + jqXHR + " Status: " + textStatus + " Error:" + errorThrown);
            return 0;
        }
    });
}

/**
 * Removes the selected specification from the vehicle stored in the session
 * @param {string} specSlug
 * @returns {Number}
 */
var removeSpecification = function (specSlug) {
    console.log("Specification slug: " + specSlug);
    $.ajax({
        type: 'GET',
        url: "/removeSpec/" + specSlug,
        dataType: 'json',
        success: function (response) {
            console.log("Remove Specification: Response [OK] ");
            console.log("The specification: " + response.removedSpec + " was successfully removed");
            displayPrice();
            $('.alert').toggleClass('alert-success', false);
            $('.alert').toggleClass('alert-warning', true);
            $('.alert').css("display", "block");
            $('.alert').html('<strong>' + response.removedSpec + '</strong> has been removed');
            return 1;
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("ERROR: Req: " + jqXHR + " Status: " + textStatus + " Error:" + errorThrown);
            return 0;
        }
    });
}

/**
 * Adds or removes the specification from a vehicle based on user input
 * @param {string} specSlug
 * @returns {Number} 1- specification has been added, -1 - specification has been removed
 *                   0 - error
 * 
 */
var manageVehicleSpecs = function (specSlug) {

    var checkbox = $('#' + specSlug);
    if (checkbox.is(':checked'))
    {
        addSpecification(specSlug);
        return 1;

    } else {

        removeSpecification(specSlug);
        return -1;
    }
    return 0;
}


var addVipDiscount = function(){
    $.ajax({
        type: 'GET',
        url: "/isVip/true",
        success: function () {
            console.log("VIP Discount successfully added");
            displayPrice();
            return 1;
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("ERROR: Req: " + jqXHR + " Status: " + textStatus + " Error:" + errorThrown);
            return 0;
        }
    });
}


var removeVipDiscount = function(){
    $.ajax({
        type: 'GET',
        url: "/isVip/false",
        success: function () {
            console.log("VIP Discount successfully added");
            displayPrice();
            return 1;
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("ERROR: Req: " + jqXHR + " Status: " + textStatus + " Error:" + errorThrown);
            return 0;
        }
    });
}

/**
 * Assigns or removes asynchronously the Vip discount option to/from
 * the vehicle stored in the session
 * @returns {Number}
 */
var manageDiscount = function(){
    var checkbox = $('#vipDiscount');
    if (checkbox.is(':checked')){
         
         addVipDiscount();
         return 1; /*added*/
         
    } else {
        
        removeVipDiscount();
        return -1; /*removed*/
    }
    return 0; /*error*/
}

/**
 * Refreshes the current page
 * @returns {Number} 1
 */
var reloadPage = function () {
    location.reload();
    return 1;
}


}