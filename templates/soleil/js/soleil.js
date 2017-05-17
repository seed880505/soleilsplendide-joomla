// Avoid `console` errors in browsers that lack a console.
(function () {
    var method;
    var noop = function () {
    };
    var methods = [
        'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
        'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
        'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
        'timeline', 'timelineEnd', 'timeStamp', 'trace', 'warn'
    ];
    var length = methods.length;
    var console = (window.console = window.console || {});

    while (length--) {
        method = methods[length];

        // Only stub undefined methods.
        if (!console[method]) {
            console[method] = noop;
        }
    }
}());

// Place any jQuery/helper plugins in here.
var SOLEIL = SOLEIL || {};

SOLEIL.Global = {
    emailReg: /^[a-zA-Z0-9._]+@[a-zA-Z0-9.]+\.[a-zA-Z\s]{2,4}$/
};


SOLEIL.Util = (function () {
    "use strict";

    //"private" variables:
    var myPrivateVar = "I can be accessed only from within YAHOO.myProject.myModule.";

    return {
        myPrivateVar: myPrivateVar
    };

}());


(function ($) {
    $(function () {
        'use strict';


    })
})(jQuery);