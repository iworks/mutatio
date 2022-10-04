/**
 * Mutatio — change your site look - v1.0.0
 * http://mutatio.iworks.pl/
 * Copyright (c) 2022; * Licensed GPLv2+ */
document.addEventListener("DOMContentLoaded", function(event) {
    var value;
    var cookie_container = document.getElementById(window.mutatio_cookie.name);
    var mutatio_cookie_xml_http = new XMLHttpRequest();
    /**
     * get cookie value
     */
    var mutatioCookieGetCookieValue = function(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    };
    /**
     * set Cookie Notice
     */
    var mutatioCookieSetCookieNotice = function() {
        var expires = new Date();
        var value = parseInt(expires.getTime());
        var cookie = '';
        var data;
        var query = '';
        /**
         * set time
         */
        value = parseInt(expires.getTime());
        /**
         * add time
         */
        value += parseInt(window.mutatio_cookie.cookie.value) * 1000;
        /**
         * add time zone
         */
        value += parseInt(window.mutatio_cookie.cookie.timezone) * 1000;
        /**
         * set time
         */
        expires.setTime(value + 2 * 24 * 60 * 60 * 1000);
        /**
         * add cookie timestamp
         */
        cookie = window.mutatio_cookie.cookie.name + '=' + value / 1000 + ';';
        cookie += ' expires=' + expires.toUTCString() + ';';
        if (window.mutatio_cookie.cookie.domain) {
            cookie += ' domain=' + window.mutatio_cookie.cookie.domain + ';';
        }
        /**
         * Add cookie now (fix cache issue)
         */
        cookie += ' path=' + window.mutatio_cookie.cookie.path + ';';
        if ('on' === window.mutatio_cookie.cookie.secure) {
            cookie += ' secure;';
        }
        document.cookie = cookie;
        cookie = window.mutatio_cookie.cookie.name + '_close=hide;';
        cookie += ' expires=;';
        if (window.mutatio_cookie.cookie.domain) {
            cookie += ' domain=' + window.mutatio_cookie.cookie.domain + ';';
        }
        cookie += ' path=' + window.mutatio_cookie.cookie.path + ';';
        if ('on' === window.mutatio_cookie.cookie.secure) {
            cookie += ' secure;';
        }
        document.cookie = cookie;
        /**
         * set user meta
         */
        if (undefined !== window.mutatio_cookie.cookie.logged && 'yes' === window.mutatio_cookie.cookie.logged) {
            data = {
                'action': 'mutatio_cookie_notice',
                'user_id': window.mutatio_cookie.cookie.user_id,
                'nonce': window.mutatio_cookie.cookie.nonce
            };
        } else {
            // Dimiss the notice for visitor.
            data = {
                'action': 'mutatio_cookie_notice',
                'nonce': window.mutatio_cookie.cookie.nonce
            };
        }
        /**
         * send data
         */
        for (var key in data) {
            if (query.length) {
                query += '&';
            }
            query += encodeURIComponent(key);
            query += '=';
            query += encodeURIComponent(data[key]);
        }
        mutatio_cookie_xml_http.open('GET', window.mutatio_cookie.cookie.ajaxurl + '?' + query, true);
        mutatio_cookie_xml_http.send(null);
        /**
         * hide
         */
        cookie_container.style.display = 'none';
    };
    /**
     * bind
     */
    cookie_container.getElementsByClassName('button')[0].addEventListener('click', function(e) {
        e.preventDefault();
        mutatioCookieSetCookieNotice();
        return false;
    });
    /**
     * it ws already shown
     */
    value = mutatioCookieGetCookieValue(window.mutatio_cookie.cookie.name + '_close');
    if ('hide' === value) {
        cookie_container.style.display = 'none';
    }
});
