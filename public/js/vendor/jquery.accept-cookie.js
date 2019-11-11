/*!
 * jQuery Cookie Plugin v1.3.1
 * https://github.com/carhartl/jquery-cookie
 *
 * Copyright 2013 Klaus Hartl
 * Released under the MIT license
 */
(function (factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD. Register as anonymous module.
        define(['jquery'], factory);
    } else {
        // Browser globals.
        factory(jQuery);
    }
}(function ($) {

    var pluses = /\+/g;

    function raw(s) {
        return s;
    }

    function decoded(s) {
        return decodeURIComponent(s.replace(pluses, ' '));
    }

    function converted(s) {
        if (s.indexOf('"') === 0) {
            // This is a quoted cookie as according to RFC2068, unescape
            s = s.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, '\\');
        }
        try {
            return config.json ? JSON.parse(s) : s;
        } catch(er) {}
    }

    var config = $.cookie = function (key, value, options) {

        // write
        if (value !== undefined) {
            options = $.extend({}, config.defaults, options);

            if (typeof options.expires === 'number') {
                var days = options.expires, t = options.expires = new Date();
                t.setDate(t.getDate() + days);
            }

            value = config.json ? JSON.stringify(value) : String(value);

            return (document.cookie = [
                config.raw ? key : encodeURIComponent(key),
                '=',
                config.raw ? value : encodeURIComponent(value),
                options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
                options.path    ? '; path=' + options.path : '',
                options.domain  ? '; domain=' + options.domain : '',
                options.secure  ? '; secure' : ''
            ].join(''));
        }

        // read
        var decode = config.raw ? raw : decoded;
        var cookies = document.cookie.split('; ');
        var result = key ? undefined : {};
        for (var i = 0, l = cookies.length; i < l; i++) {
            var parts = cookies[i].split('=');
            var name = decode(parts.shift());
            var cookie = decode(parts.join('='));

            if (key && key === name) {
                result = converted(cookie);
                break;
            }

            if (!key) {
                result[name] = converted(cookie);
            }
        }

        return result;
    };

    config.defaults = {};

    $.removeCookie = function (key, options) {
        if ($.cookie(key) !== undefined) {
            $.cookie(key, '', $.extend(options, { expires: -1 }));
            return true;
        }
        return false;
    };

}));

(function($) {
    "use strict";

    var languages = {
        'pl-PL': 'pl',
        'en-US': 'en',
        'pl-pl': 'pl',
        'en-us': 'en'
    }

    var messages = {
        pl: 'Korzystając z tej strony wyrażasz zgodę na korzystanie z cookies i podobnych technologii. <a href="#open">Do czego wykorzystujemy cookies?</a> <a href="#close">Zamknij</a>.',
        en: 'We are using cookies to give you the best experience on our site. By continuing to use our website without changing the settings, you are agreeing to our use of cookies. <a href="#open">How do we use cookies?</a> <a href="#close">Close</a>.'
    }

    var contents = {
        pl: '<h3>Polityka cookies</h3><p>W ramach tej strony internetowej używane są tzw. ciasteczka (ang. cookies). Są to niewielkie pliki tekstowe, zawierające informacje wykorzystywane do różnych celów: uwierzytelniania użytkowników, prowadzenia statystyk tej strony internetowej, dopasowywania reklam, i tym podobnych. Ciasteczka nie pozwalają na rozpoznanie danych osobowych, ani nie mają wpływu na działanieTwojego komputera lub innego urządzenia, z którego korzystasz do przeglądania tej strony.</p><h3>Wyłączenie cookies</h3><p>Wyłączenie ciasteczek jest możliwe. Należy liczyć się jednak z tym, że ta strona internetowa przestanie dostarczać treść lub usługi w zadowalający i wygodny sposób. Poniższe linki prowadzą do stron, na których dowiesz się jak wyłączyć ciasteczka w Twojej przeglądarce:</p><ul><li><a href="http://support.microsoft.com/kb/196955">Internet Explorer</a></li><li><a href="http://help.opera.com/Windows/12.10/pl/cookies.html">Opera</a></li><li><a href="http://support.google.com/chrome/bin/answer.py?hl=pl&answer=95647">Chrome</a></li><li><a href="http://support.mozilla.org/pl/kb/W%C5%82%C4%85czanie%20i%20wy%C5%82%C4%85czanie%20obs%C5%82ugi%20ciasteczek">Firefox</a></li><li><a href="http://support.apple.com/kb/PH5042">Safari</a></li><li><a href="http://support.google.com/chrome/bin/answer.py?hl=pl&answer=95647">Android</a></li><li><a href="http://support.apple.com/kb/HT1677?viewlocale=pl_PL">Safari Mobile</a></li><li><a href="http://www.windowsphone.com/pl-pl/how-to/wp7/web/changing-privacy-and-other-browser-settings">Windows Phone</a></li></ul><p><a href="#close">Zamknij</a></p>',
        en: '<h2>About cookies</h2><p>Cookies are information packets sent by web servers to web browsers, and stored by the web browsers.</p><p>The information is then sent back to the server each time the browser requests a page from the server.  This enables a web server to identify and track web browsers.</p><p>There are two main kinds of cookies: session cookies and persistent cookies.  Session cookies are deleted from your computer when you close your browser, whereas persistent cookies remain stored on your computer until deleted, or until they reach their expiry date.</p><h2>Cookies on our website</h2><p>Our site uses only third party cookies listed below. No cookies are set up directly by our site.</p><h2>Google cookies</h2><p>Our site uses Google Analytics to analyse the use of this website.  Google Analytics generates statistical and other information about website use by means of cookies, which are stored on users\' computers.  The information generated relating to our website is used to create reports about the use of the website. Google will store and use this information. Google\'s privacy policy is available at: http://www.google.com/privacypolicy.html.</p><h2>Third party cookies</h2><p>Cookies provided by Facebook and Google+ are also used on this site. These cookies are used to provide the social sharing buttons with information about whether you have already liked or not the page.</p><h2>Refusing cookies</h2><p>Most browsers allow you to refuse to accept cookies.</p><p>In Internet Explorer, you can refuse all cookies by clicking “Tools”, “Internet Options”, “Privacy”, and selecting “Block all cookies” using the sliding selector.</p><p>In Firefox, you can adjust your cookies settings by clicking “Tools”, “Options” and “Privacy”.</p><p>Blocking cookies will have a negative impact upon the usability of some websites, including our site.</p><h2>About this cookies policy</h2><p>We created this <a href="http://www.freenetlaw.com/free-cookies-policy/">cookies policy</a> with the help of a Contractology form available at www.freenetlaw.com.Other templates available on the Contractology website include <a href="http://www.contractology.com/precedents/website-privacy-policy.html">web privacy notices</a>.<p><a href="#close">Close</a></p>'
    }

    var opts = {
        url_open_selector: 'a[href="#open"]',
        url_close_selector: 'a[href="#close"]',
        content_selector: '#accept-cookie-content',
        content: null,
        message_selector: '#accept-cookie-message',
        message: null,
        show_once: true
    }

    $.accept_cookie = function(options) {
        $.extend(opts, options)
    }

    function decorate(contents) {
        return $('<div class="accept-cookie-message"></div>').append(contents)
    }

    function decorate_content(content) {
        var data = $('<div class="accept-cookie-overlay"></div><div class="accept-cookie-content"></div>')

        data.filter('.accept-cookie-content').html(content)

        return data
    }

    function content_css(content) {
        content.filter('.accept-cookie-overlay').css({
            width: '100%',
            height: '100%',
            position: 'absolute',
            top: '0',
            left: '0',
            zIndex: '100000',
            background: '#000',
            opacity: '0.6'
        })

        content.filter('.accept-cookie-content').css({
            marginLeft: (($(window).width() / 2) - 300) + 'px',
            width: '600px',
            marginTop: '100px',
            backgroundColor: 'white',
            padding: '0.5em 1em',
            borderRadius: '4px',
            border: '1px solid #ccc',
            position: 'absolute',
            left: '0',
            top: '0',
            zIndex: '100001'
        })

        return content
    }

    function message_css(message) {
        return message.css({
            borderRadius: '4px',
            border: '1px solid #ccc',
            backgroundColor: 'white',
            padding: '0.25em 0',
            textAlign: 'center',
            top: '0px',
            left: '0px',
            width: '100%',
            height: '1em',
            position: 'absolute',
            zIndex: '99999'
        })
    }

    $(function() {
        var lang = $('html').attr('lang')

        if(lang in languages) {
            lang = languages[lang]
        }

        var content = opts.content || $(opts.content_selector).html() || contents[lang]
        var message = opts.message || $(opts.message_selector).html() || messages[lang]

        if(!message) {
            throw new Error("No message found. Provide the plugin with a message before running.");
        }

        if(opts.show_once && $.cookie('accept-cookie')) {
            return;
        }

        var message_box = message_css(decorate(message)).prependTo('body')

        message_box.find(opts.url_close_selector).click(function() {
            $.cookie('accept-cookie', 'accepted');
            message_box.hide()
        })

        message_box.find(opts.url_open_selector).click(function() {
            message_box.hide()

            var content_box = content_css(decorate_content(content)).prependTo('body')

            content_box.find(opts.url_close_selector).click(function() {
                $.cookie('accept-cookie', 'accepted', { path: '/', expires: 1000 });
                content_box.hide()
            })
        })

        if(opts.show_once) {
            $.cookie('accept-cookie', 'accepted', { path: '/', expires: 1000 });
        }
    })

})(jQuery);
