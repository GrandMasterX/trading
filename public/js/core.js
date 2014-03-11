jQuery.fn.reverse = [].reverse;

(function () {
    var ev = new $.Event('hide'),
        orig = $.fn.hide;
    $.fn.hide = function () {
        $(this).trigger(ev);
        return orig.apply(this, arguments);
    }
})();

Date.prototype.yyyymmdd = function () {
    var yyyy = this.getFullYear().toString();
    var mm = (this.getMonth() + 1).toString(); // getMonth() is zero-based
    var dd = this.getDate().toString();
    return yyyy + '-' + (mm[1] ? mm : "0" + mm[0]) + '-' + (dd[1] ? dd : "0" + dd[0]); // padding
};

var app = {

    debug: false,
    editing: false,

    modules: {},

    init: function () {

        //Load modules
        $('[data-module]').each(function (e, item) {

            var module = $(item).attr('data-module');

            if (app.modules.hasOwnProperty(module) && typeof app.modules[module] === 'function') {
                app.log("loading '" + module + "' module...");
                app.modules[module]($(item));
            }
            else {
                app.log("Can't load module '" + module + "'");
            }
        });

        //Ajax link
        $('.ajax-call').on('click', function (e) {
            e.preventDefault();
            var el = $(this);

            if (!el.attr('data-action'))
                return false;

            app.ajaxCall(el.attr('data-action'), {id: el.attr('data-id')},
                function (response) {
                    if (el.attr('data-callback-class')) {
                        el.addClass(el.attr('data-callback-class'));
                    }
                    if (el.attr('data-callback-text')) {
                        el.text(el.attr('data-callback-text'));
                    }
                    if (el.attr('data-callback-show')) {
                        el.hide();
                        $(el.attr('data-callback-show')).show();
                    }
                }
            );
        });

        //Ajax form
        $('form.ajax').on('submit', function (e) {
            e.preventDefault();
        });
        $('form.ajax-submit').on('submit', function (e) {
            e.preventDefault();

            var that = $(this);
            if (that.hasClass('disabled')) {
                return false;
            }
            that.addClass('disabled');

            var btn = that.find('button[type=submit], input[type=submit]');
            if (btn.hasClass('btn')) {
                var timeout = setTimeout(function () {
                    app.log('timeout');
                    btn.addClass('loading');
                }, 100);
            }

            var clear = function () {
                if (typeof timeout != "undefined") {
                    clearTimeout(timeout);
                }
                btn.removeClass('loading');
                that.removeClass('disabled')
            };

            var success = $('.ajax-submit-success');

            app.ajaxCall($(this).attr('action'), $(this).serialize(),
                function (response) {
                    clear();
                    if (response === true) {
                        if (that.hasClass('ajax-page-reload')) {
                            app.reload();
                        }
                        else if (success && success.length) {
                            that.hide();
                            success.fadeIn(300);
                        }
                        else {
                            app.showMessage("Changes were successfully saved!");
                        }
                    }
                },
                clear
            );
        });
    },

    //Debug
    log: function () {
        if (this.debug === true) {
            console.log(Array.prototype.slice.call(arguments));
        }
    },

    //Redirect
    redirect: function (url) {
        window.location.href = url;
    },

    //Reload page
    reload: function () {
        window.location.reload();
    },

    //Ajax core
    ajaxCall: function (url, params, callback, error_callback, hide_loading) {
        app.log(arguments);
        var loading = $('.pace');

        if (params instanceof jQuery)
            params = params.serialize();
        if (!hide_loading)
            loading.show();

        $.ajax({
            type: 'post',
            dataType: "json",
            url: url,
            data: params,
            success: function (response) {
                loading.hide();
                app.ajaxCallResponse(response, callback, error_callback);
                //$('.table-hover-buttons a.button').tooltip();
            },
            error: function (data, status, e) {
                if (data.status != 0) {
                    loading.hide();
                    app.log(data, status, e);
                    app.showError('Server error.');
                }
            }
        });
    },

    ajaxCallResponse: function (response, callback, error_callback) {
        if (response) {
            for (var i in response) {
                if (!response.hasOwnProperty(i)) continue;

                if (i == 'error' && response[i]) {
                    app.showError(response[i]);
                    if (error_callback) {
                        if (error_callback === true && typeof callback === 'function')
                            callback(response.result);
                        else if (typeof error_callback === 'function')
                            error_callback(response.result);
                    }
                    return;
                }
                else if (i == 'message' && response[i]) {
                    app.showMessage(response[i]);
                }
                else if (i == 'redirect' && response[i]) {
                    app.redirect(response[i]);
                    return;
                }
            }
        }

        if (typeof callback === 'function')
            callback(response ? response.result : false);
    },

    //Notification
    showError: function (msg) {
        app.showNotification(msg, 'error');
    },
    showMessage: function (msg) {
        app.showNotification(msg, 'success');
    },
    showNotification: function (msg, type) {

        var messages = $('.message-list');

        if (!messages || !messages.length)
            messages = $('<div class="message-list"></div>').appendTo('body');

        var item = $('<div class="message-item ' + type + '"><header>' + type + '&nbsp;<span class="close"></span></header><div class="message-item-inner">' + msg + '</div></div>');

        item.hide()
            .appendTo(messages)
            .fadeIn(200).delay(4000).fadeOut(3000, function () {
                item.remove();
            })
            .on('click', '.close', function () {
                item.remove();
            });
    },

    //Escape
    escape: function (text) {
        return $('<div/>').text(text).html();
    },

    modal: function (p) {

        var default_params = {
            id: false,
            title: 'Title',
            content: '<div />',
            callback: false,
            button: 'Submit',
            cancel: 'Cancel',
            pre: false,
            width: false,
            caller: false,
            classes: [],
            height: false
        };

        var params = $.extend(default_params, p);
        var wnd_id = 'app_modal_' + Math.floor(Math.random() * 999999);
        var content_obj = $(params.content);
        var content_html = content_obj.html();

        if (params.caller) {

            params.caller.addClass(wnd_id);

        }

        //Because id can duplicate
        content_obj.empty();

        var wnd = $('' +
            '<div class="screen-lock"></div>' +
            '<div class="modal ' + params.classes.join(' ') + '" id="' + wnd_id + '" data-modal="' + params.id + '">' +
            '<div class="modal-wrap">' +

            (params.title == false ? '' :
                '<header class="modal-header cleared"><span class="modal-title pull-left">' + app.escape(params.title) + '</span></header>'
                ) +

            '<div class="modal-inner">' + content_html + ' </div>' +

            (params.button == false && params.cancel == false ? '' :
                '   <footer class="modal-footer cleared">' +
                    (params.button == false ? '' : '<button class="btn small red pull-right modal-submit">' + app.escape(params.button) +  '</button>') +
                    (params.cancel == false ? '' : '<button class="btn small black pull-right modal-close">' + app.escape(params.cancel) +  '</button>') +
                    '   </footer>' ) +

            '</div>');

        wnd.appendTo($('body'));



        wnd.on('hide', function () {
            content_obj.html(content_html);
            wnd.remove();
        });
        wnd.find('.modal-close,.modal-header-close').on('click', function () {
            wnd.hide();
        });
        wnd.show();

        //Width
        if (params.width) {
            wnd.find('.modal').css({
                width: 'auto',
                'margin-left': function () {
                    return -($(this).width() / 2);
                }
            });
        }

        //Events
        wnd.find('.modal-submit').on('click', function (e) {
            e.preventDefault();
            var form = wnd.find('form.ajax, form.ajax-submit');

            if (form.length) {
                app.ajaxCall(form.attr('action'), form.serialize(), function (response) {
                    params.callback(wnd, response);
                })
            }
            else {
                params.callback(wnd);
            }
        });

        wnd.find('input, select').eq(0).focus();

        wnd.find('form.ajax, form.ajax-submit').on('submit', function (e) {
            e.preventDefault();
        });

        //Pre
        if ($.isFunction(params.pre))
            params.pre(wnd, params.caller);
    },

    //Confirmation
    confirm: function (message) {
        return confirm(message ? message : 'Are you sure?');
    },

    //Common
    fillSelectByAjax: function (select_id, action, loading_text, current, params) {

        var select = select_id instanceof jQuery ? select_id : $(select_id);
        var html = select.html();
        select.html($('<option>').text(loading_text ? loading_text : 'Loading...'));
        select.attr('disabled', 'disabled');

        app.ajaxCall(action, params, function (response) {

            select.html(html);

            if (response) {
                if (response.length) {

                    for (var i in response) {
                        var option = $('<option>').text(response[i].name).val(response[i].id);
                        if (current && current == response[i].id)
                            option.attr('selected', 'selected');
                        select.append(option);
                    }

                } else {

                    //select.hide();
                    //$('<div>No data...</div>').insertAfter(select);

                    select.append('<option disabled="disabled">No data...</option>');

                }
            }

            select.removeAttr('disabled');
        })
    },

    loadContent: function (action, element_id, params, callback) {

        app.ajaxCall(action, params, function (response) {
            if (element_id instanceof jQuery)
                element_id.html(response);
            else
                $(element_id).html(response);

            if (callback && typeof callback === 'function')
                callback(response);
        })
    },

    pushHistoryUrl: function (url) {

        if (typeof history.pushState === 'undefined')
            return false;

        //app.log(url);
        history.pushState(null, null, url);

        return true;
    }
};

$(function () {
    app.init();
});