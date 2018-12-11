jQuery(function ($) {
    function filter() {
        $('.filter-group input[type=checkbox]').click(function () {
            let queryString = '',
                inputs = $(this).parent().parent().find('input[type=checkbox]:checked');

            inputs.each(function (index) {
                queryString += $(this).val();
                if (index !== inputs.length - 1) {
                    queryString += ',';
                }
            });
            $(this).parent().parent().find('.result').val(queryString);
        });
    }

    $(document).ready(function () {
        filter();
        var keypressSlider = document.getElementById('range');
        var input0 = document.getElementById('input-with-keypress-0');
        var input1 = document.getElementById('input-with-keypress-1');
        var inputs = [input0, input1];
        var min = parseInt($(input0).attr('data-min'));
        var max = parseInt($(input1).attr('data-max'));
        var minPrice = parseInt($(input0).val());
        var maxPrice = parseInt($(input1).val());
        noUiSlider.create(keypressSlider, {
            start: [minPrice, maxPrice],
            connect: true,
            step: 1,
            format: wNumb({
                decimals: 0
            }),
            range: {
                'min': min,
                'max': max
            }
        });

        $('#range').click(function () {
            input0.removeAttribute('disabled');
            input1.removeAttribute('disabled');
        });
        keypressSlider.noUiSlider.on('slide', function () {
            input0.removeAttribute('disabled');
            input1.removeAttribute('disabled');
        });

        keypressSlider.noUiSlider.on('update', function (values, handle) {
            inputs[handle].value = values[handle];
        });

        function setSliderHandle(i, value) {
            var r = [null, null];
            r[i] = value;
            keypressSlider.noUiSlider.set(r);
        }

        // Listen to keydown events on the input field.
        inputs.forEach(function (input, handle) {

            input.addEventListener('change', function () {
                setSliderHandle(handle, this.value);
            });

            input.addEventListener('keydown', function (e) {

                var values = keypressSlider.noUiSlider.get();
                var value = Number(values[handle]);

                // [[handle0_down, handle0_up], [handle1_down, handle1_up]]
                var steps = keypressSlider.noUiSlider.steps();

                // [down, up]
                var step = steps[handle];

                var position;

                // 13 is enter,
                // 38 is key up,
                // 40 is key down.
                switch (e.which) {

                    case 13:
                        setSliderHandle(handle, this.value);
                        break;

                    case 38:

                        // Get step to go increase slider value (up)
                        position = step[1];

                        // false = no step is set
                        if (position === false) {
                            position = 1;
                        }

                        // null = edge of slider
                        if (position !== null) {
                            setSliderHandle(handle, value + position);
                        }

                        break;

                    case 40:

                        position = step[0];

                        if (position === false) {
                            position = 1;
                        }

                        if (position !== null) {
                            setSliderHandle(handle, value - position);
                        }

                        break;
                }
            });
        });
    });
});
