// Cookie functions from http://www.quirksmode.org/js/cookies.html //

function startsWith(haystack, needle) {
    return haystack.slice(0, needle.length) == needle;
}

function createCookie(name, value, days, path) {
    var getLocation = function (href) {
        var l = document.createElement("a");
        l.href = href;
        return l;
    };

    if (!path) {
        path = '/';
    } else {
        var location = getLocation(path);
        path = location.pathname;
        if (!startsWith(path, '/')) {
            path = '/' + path;
        }
    }
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        var expires = "; expires=" + date.toGMTString();
    } else {
        var expires = "";
    }
    document.cookie = name + "=" + value + expires + "; path=" + path;
}

function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1, c.length);
        }
        if (c.indexOf(nameEQ) == 0) {
            return c.substring(nameEQ.length, c.length);
        }
    }
    return null;
}

function eraseCookie(name, path) {
    createCookie(name, '', -30, path);
}

function getQueryStringValue(name) {
    name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
    var regexS = "[\\?&]" + name + "=([^&#]*)";
    var regex = new RegExp(regexS);
    var results = regex.exec(window.location.href);
    if (results == null) {
        return '';
    } else {
        return decodeURIComponent(results[1].replace(/\+/g, " "));
    }

}

function init() {

}

$.fn.showHidePanel = function () {
    var panel = $(this);

    function setIcon(panel, targetIcon) {
        var iconSpan = panel.find('.show-hide');
        iconSpan.removeClass('glyphicon-chevron-up');
        iconSpan.removeClass('glyphicon-chevron-down');
        iconSpan.addClass(targetIcon);
    }

    var visibility = readCookie(panel.attr('id'));
    if (visibility && visibility == '0') {
        panel.find('.panel-body, .panel-footer').hide();
        setIcon(panel, 'glyphicon-chevron-down');
    } else {
        setIcon(panel, 'glyphicon-chevron-up');
    }

    panel.find('.show-hide').click(function (e) {
        e.preventDefault();
        var id = panel.attr('id');

        var dashboard = panel.find('.panel-body, .panel-footer');
        if (dashboard.css('display') == 'none') {
            createCookie(id, '1', 30);
            dashboard.show();
            setIcon(panel, 'glyphicon-chevron-up');
        } else {
            createCookie(id, '0', 30);
            dashboard.hide();
            setIcon(panel, 'glyphicon-chevron-down');
        }
    });
};

$.fn.clearable = function () {
    var textbox = $(this);

    textbox.closest('div').addClass('form-group has-feedback');
    textbox.addClass('hasclear form-control');
    if (textbox.next('.clearer').length === 0) {
        $('<i/>', {class: 'clearer glyphicon glyphicon-remove-circle form-control-feedback'}).insertAfter(textbox);
    }

    textbox.keyup(function () {
        var t = $(this);
        t.next('.clearer').toggle(Boolean(t.val()));
    });

    var $clearer = $(".clearer");
    $clearer.hide($(this).prev('input').val());

    $clearer.on('click', function () {
        $(this).siblings('input').val('').focus();
        $(this).hide();
    });
};

function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

var cookies = {

    // cookieName: 'dismissed',

    isDismissed: function (id) {
        var dismissed = readCookie('dismissed');

        if (!dismissed) {
            return false;
        }

        var idsDismissed = dismissed.split(',');

        return idsDismissed.indexOf(id) !== -1;
    },

    dismiss: function (id, path) {
        var dismissed = readCookie('dismissed');

        if (!dismissed) {
            dismissed = [];
        } else {
            dismissed = dismissed.split(',');
        }
        if (dismissed.indexOf(id) === -1) {
            dismissed.push(id);
        }
        createCookie('dismissed', dismissed, 30, path);
    }
};

