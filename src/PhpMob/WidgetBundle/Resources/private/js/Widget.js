+function ($) {
    'use strict';

    var Widget = function (element, option) {
        this.$element = $(element);
        this.name = this.$element.data('widget-name');
        this.options = this.$element.data('widget-options');
        this.userOptions = this.$element.data('widget-user-options');
        this.$ticker = null;
        this.$mask = null;

        new AllowExternalWidgetExtension(this);
        new AutoRefreshWidgetExtension(this);
        new LazyLoadWidgetExtension(this);
        new OnClickWidgetExtension(this);
    };

    Widget.DEFAULTS = {
        mask_mode: 'over', // none | clear | over | ticker | fullscreen | .selector | { el: .selector, target: .target }
        mask_style: 'wg-loading' // wg-loading | wg-loading--double | wg-loading-pulse
    };

    Widget.prototype.mask = function (action) {
        this.$mask = this.$element;
        var mode = this.options['mask_mode'];
        var style = this.options['mask_style'];

        if ('none' === mode || !mode) {
            return;
        }

        if ('hide' === action) {
            if (this.$mask.is('button,a')) {
                this.$mask.attr('disabled', false).removeClass('disabled');
            }

            this.$mask.find('.wg-mask').remove();

            return;
        }

        switch (mode) {
            case 'clear':
                this.$mask.html($('<div class="wg-mask wg-mask--clear"/>'));
                break;

            case 'over':
                this.$mask
                // may effect to child style ??
                // if effect calculate mask position with $element offset
                    .css('position', 'relative')
                    .append(
                        $('<div class="wg-mask wg-mask--over"/>').css({
                            'position': 'absolute', 'z-index': 1000,
                            'top': 0, 'bottom': 0, 'left': 0, 'right': 0,
                            'with': '100%', 'height': '100%'
                        })
                    )
                ;
                break;

            case 'ticker':
                this.$mask = this.$ticker;
                break;

            case 'fullscreen':
                this.$mask = $('body')
                    .css('position', 'relative')
                    .append(
                        $('<div class="wg-mask wg-mask--over"/>').css({
                            'position': 'absolute', 'z-index': 1000,
                            'top': 0, 'bottom': 0, 'left': 0, 'right': 0,
                            'with': '100%', 'height': '100%'
                        })
                    )
                ;
                break;

            default:
                var $target = this.$element;

                if ('object' === typeof mode) {
                    $target = mode.target ? $(mode.target) : $target;
                    mode = mode.el;
                }

                this.$mask = $target.find(mode);

                if (!this.$mask.length) {
                    this.$mask = $target.append($(mode).html());
                }

                break;
        }

        var $masking = this.$mask.find('.wg-mask');

        if (!$masking.length) {
            $masking = $('<div class="wg-mask wg-mask--' + mode + '"/>');

            if (this.$mask.is('button,a')) {
                this.$mask.attr('disabled', true).addClass('disabled');
                this.$mask.prepend($masking);
            } else {
                this.$mask.html($masking);
            }
        }

        $masking.html($('<div/>').addClass(style));
    };

    Widget.prototype.isLoading = function () {
        return !!this.$element.find('.wg-mask').length;
    };

    Widget.prototype.isLoaded = function () {
        return this.$element.hasClass('wg--loaded');
    };

    Widget.prototype.load = function (options) {
        if (this.isLoading()) {
            return;
        }

        this.options = DeepExtend(this.options, options);

        var me = this;
        var callback = this.options['callback'] || {};
        var scroll = this.options['scroll_position'] || 'current';

        var success = window[callback.success] || function (response) {
                var $response = $(response);
                var $content = this.$element.find('.wg-content').html();

                switch (me.options['mode']) {
                    case 'pull':
                        $response.find('.wg-content').append($content);
                        break;
                    case 'more':
                        $response.find('.wg-content').prepend($content);
                        break;
                    case 'prev':
                    case 'next':
                        $response.hide();
                        break;
                    default:
                        $content = null;
                }

                var scrollPosition;
                if('top' === scroll) {
                    scrollPosition = 1;
                }

                if('current' === scroll) {
                    scrollPosition = $(window).scrollTop();
                }

                this.$element.replaceWith($response);

                if(scrollPosition) {
                    $(window).scrollTop(scrollPosition);
                }

                this.$element = $response;
                this.$element.addClass('wg--loaded');

                if(!this.$element.is(":visible")){
                    this.$element.fadeIn();
                }

                this.$element.twidget();

                $(document).trigger('dom-node-inserted', [this.$element]);
            };

        var error = window[callback.error] || function () {
                this.$element.replaceWith('<div class="wg-error"></div>');
            };

        this.$element.removeClass('wg--loaded');
        me.mask('show');

        var userOptions = this.userOptions;

        for (var key in userOptions) {
            userOptions[key] = this.options[key];
        }

        $.ajax({
            url: this.options['render_url'],
            type: this.options['render_method'] || 'GET',
            data: {
                widget: {
                    name: this.name,
                    options: userOptions
                }
            },
            error: function (response) {
                me.mask('hide');
                error.call(me, response);
            },
            success: function (response) {
                me.mask('hide');
                success.call(me, response);
            }
        });
    };

    Widget.prototype.submit = function () {
        // TODO;
    };

    // PLUGIN DEFINITION
    function Plugin(option) {
        return this.each(function () {
            var $this = $(this);

            var data = $this.data('twidget');
            var options = DeepExtend({}, Widget.DEFAULTS, typeof option === 'object' && option);

            if (!data) $this.data('twidget', new Widget(this, options));
        })
    }

    var old = $.fn.twidget;
    $.fn.twidget = Plugin;
    $.fn.twidget.Constructor = Widget;

    // NO CONFLICT
    $.fn.twidget.noConflict = function () {
        $.fn.twidget = old;
        return this;
    };

    // DATA-API
    $('[data-widget-name]').each(function () {
        Plugin.call($(this));
    });
}($);
