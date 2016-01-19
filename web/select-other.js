(function (window, $) {
    $.fn.selectOther = function (options) {
        return this.each(function () {
            var el = $(this),
                input = el.find(':input'),
                select = $('<select></select>');
            select.insertBefore(input);

            options = $.extend({
                'items' :  [],
                'otherText' : 'Other',
                'selectClass' : '',
                'blankFirstOption' : true
            }, options);

            select.addClass(options.selectClass);
            if (options.blankFirstOption) {
                select.append(
                    $('<option></option>')
                );
            }
            for(var i = 0; i < options.items.length; i++) {
                select.append(
                    $('<option></option>').text(options.items[i])
                );
            }
            select.append(
                $('<option></option>').text(options.otherText)
            );

            if (input.val()) {
                var selectedOption = select.children().filter(function () { return $(this).text() == input.val(); });
                if (selectedOption.length) {
                    input.hide();
                    select.val(input.val());
                } else {
                    select.children().each(function () {
                        if ($(this).text() == options.otherText) {
                            $(this).prop('selected', true);
                        }
                    });
                }
            } else {
                input.hide()
            }

            select.on('change', function () {
                if (select.val() == options.otherText) {
                    input.show();
                    input.val('');
                } else {
                    input.hide();
                    input.val(select.val());
                }
            });

        });
    }
})(window, jQuery);