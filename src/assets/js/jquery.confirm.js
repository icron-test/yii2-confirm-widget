+function ($) {
    'use strict';
    var Confirm = function (element, options) {
        this.options = options;
        this.$element = $(element);
        this.$element.html();
    };

    Confirm.VERSION = '0.1';

    Confirm.DEFAULTS = {
        'btnSend': '',
        'btnConfirm': '',
        'inputDestination': '',
        'inputCode': '',
        'serviceUrl': ''
    };

    Confirm.prototype.send = function () {
        //
    };

    Confirm.prototype.confirm = function () {
        //
    };

    function Plugin(option) {
        return this.each(function () {
            var $this = $(this);
            var data = $this.data('confirm');
            var options = $.extend({}, Confirm.DEFAULTS, typeof option == 'object' && option);
            if (!data) {
                $this.data('confirm', (data = new Confirm(this, options)));
            }
            if (typeof option == 'string') {
                data[option]();
            }
        })
    }

    $.fn.modal = Plugin;
    $.fn.modal.Constructor = Confirm;

}(jQuery);