SimpleToolsNlGDPRCookie = {
    init: function () {


        var $body = jQuery("body");
        var $cookiewarning = jQuery("#cn-accept-cookie");
        var sCookieName = "simple_tools_nl_gdpr_cookie";

        $cookiewarning.on("click", function () {
            SimpleToolsNlGDPRCookie.createCookie(sCookieName, 1, 365);

            jQuery(this).closest("#simpletools_nl_cookie_notice").fadeOut().remove();
            return false;
        });


        // cookie warning
        if (SimpleToolsNlGDPRCookie.readCookie(sCookieName) != 1) {
            SimpleToolsNlGDPRCookie.setCookieWarning(true);
        } else {
            SimpleToolsNlGDPRCookie.setCookieWarning(false);
        }

    },


    readCookie: function (name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    },


    createCookie: function (name, value, days) {
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            var expires = "; expires=" + date.toGMTString();
        } else var expires = "";
        document.cookie = name + "=" + value + expires + "; path=/";
    }
    ,


    setCookieWarning: function (active) {
        if (active) {
            jQuery("#simpletools_nl_cookie_notice").show();
        } else {
            jQuery("#simpletools_nl_cookie_notice").hide();
        }

    }

}


jQuery(document).ready(function () {
    SimpleToolsNlGDPRCookie.init();
});





