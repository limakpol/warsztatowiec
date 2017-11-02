$(document).ready(function()
{
    /* CATEGORIES */

    $(document).on('click', '.selectable-modal header i', function()
    {
        $('.selectable-modal').remove();
    });

    $(document).on('click', '#categories-form-selectable-modal .btn-choose', function(event)
    {
        event.preventDefault();

        $.ajax({
            type: "POST",
            url: "/warehouse/selectable/get-categories",
            success: function(data) {
                if(!data['error'])
                {
                    $('.selectable-modal').remove();

                    var modal = '<div id="categories-selectable-modal" class="selectable-modal"></div>';

                    $('main.section-inner').before(modal);

                    $('#categories-selectable-modal').html(data);

                    var selectedInputs = $('#categories-form-selectable-modal .ids input');
                    var categoryLis = $('#categories-selectable-modal main ul li');

                    selectedInputs.each(function()
                    {
                        var selectedId = $(this).val();

                        categoryLis.each(function()
                        {
                            if($(this).find('label').data('id') == selectedId)
                            {
                                $(this).addClass('active');
                            }
                        });

                    });
                }
            },
        });
    });

    $(document).on('click', '#categories-selectable-modal main li', function()
    {
        var li = $(this);

        if(li.hasClass('active'))
        {
            li.removeClass('active');
        }
        else
        {
            li.addClass('active');
        }
    });

    $(document).on('click', '#categories-selectable-modal footer .btn-save', function()
    {
        var selectedLabels = $('#categories-selectable-modal main li.active label');

        $('#categories-form-selectable-modal .content .names').html('');
        $('#categories-form-selectable-modal .content .ids').html('');

        selectedLabels.each(function()
        {
            var input = '<input type="hidden" ' +
                'name="good[categories][]" ' +
                'value="' +  $(this).data('id') + '">';

            var label = '<label>' +  $(this).text() + '</label>';

            $('#categories-form-selectable-modal .content .names').append(label);
            $('#categories-form-selectable-modal .content .ids').append(input);

        });

        $('#categories-selectable-modal').remove();
    });

    $(document).on('click', '#categories-selectable-modal main ul .addable .btn-add.active', function()
    {
        $(this).removeClass('active');
        $('.selectable-modal main ul .addable div').hide(400);

        var name = $('.selectable-modal main ul .addable div input').val();

        if(!name) return;

        var goodId = $('#good_id').val();

        var url = $('#add-category-path').val();

        $.ajax({
            type: "POST",
            url: url,
            data: {
                name: name,
                goodId: goodId,
            },
            success: function(data) {
                $('#categories-selectable-modal').html(data);
            }
        });
    });

    /* MODELS */

    $(document).on('click', '.selectable-modal header i', function()
    {
        $('.selectable-modal').remove();
    });

    $(document).on('click', '#models-form-selectable-modal .btn-choose', function(event)
    {
        event.preventDefault();

        $.ajax({
            type: "POST",
            url: "/warehouse/selectable/get-models",
            success: function(data) {
                if(!data['error'])
                {
                    $('.selectable-modal').remove();

                    var modal = '<div id="models-selectable-modal" class="selectable-modal"></div>';

                    $('main.section-inner').before(modal);

                    $('#models-selectable-modal').html(data);

                    var selectedInputs = $('#models-form-selectable-modal .ids input');
                    var modelLis = $('#models-selectable-modal main ul li');

                    selectedInputs.each(function()
                    {
                        var selectedId = $(this).val();

                        modelLis.each(function()
                        {
                            if($(this).find('label').data('id') == selectedId)
                            {
                                $(this).addClass('active');
                            }
                        });

                    });
                }
            },
        });
    });

    $(document).on('click', '#models-selectable-modal main li', function()
    {
        var li = $(this);

        if(li.hasClass('active'))
        {
            li.removeClass('active');
        }
        else
        {
            li.addClass('active');
        }
    });

    $(document).on('click', '#models-selectable-modal footer .btn-save', function()
    {
        var selectedLabels = $('#models-selectable-modal main li.active label');

        $('#models-form-selectable-modal .content .names').html('');
        $('#models-form-selectable-modal .content .ids').html('');

        selectedLabels.each(function()
        {
            var input = '<input type="hidden" ' +
                'name="good[car_models][]" ' +
                'value="' +  $(this).data('id') + '">';

            var label = '<label>' +  $(this).text() + '</label>';

            $('#models-form-selectable-modal .content .names').append(label);
            $('#models-form-selectable-modal .content .ids').append(input);

        });

        $('#models-selectable-modal').remove();
    });

    $(document).on('click', '#models-selectable-modal main ul .addable .btn-add.active', function()
    {
        $(this).removeClass('active');
        $('.selectable-modal main ul .addable div').hide(400);

        var brand = $('.selectable-modal main ul .addable div input:first-child').val();
        var model = $('.selectable-modal main ul .addable div input:last-child').val();

        if(!brand || !model) return;

        var goodId = $('#good_id').val();

        var url = $('#add-car-model-path').val();

        $.ajax({
            type: "POST",
            url: url,
            data: {
                brand: brand,
                model: model,
                goodId: goodId,
            },
            success: function(data) {
                $('#models-selectable-modal').html(data);
            }
        });
    });
    
});