$(document).ready(function()
{
    /* GOOD */
    $(document).on('click', '#searchable-good > input', function()
    {
        $('#searchable-good > div').slideDown();
    });

    $(document).on('keyup', '#searchable-good > input', function()
    {
        $('#searchable-good > div').slideDown();
    });

    $(document).on('dblclick', '#searchable-good > input', function()
    {
        $('#searchable-good > div').slideUp();
    });

    $(document).on('click', '#searchable-good tr:not(:first-child)', function()
    {
        var goodId = $(this).data('id');

        $.ajax({
            type: "POST",
            url: "/warehouse/get-one-good",
            data: {
                goodId: goodId,
            },
            success: function(data)
            {
                $('#delivery_detail_add_indexx_good_id').val(data.id);
                $('#delivery_detail_add_indexx_good_name').val(data.name);
                $('#delivery_detail_add_indexx_good_measure').val(data.measure_id);
                $('#delivery_detail_add_indexx_good_quantity').val(data.quantity);
                $('#delivery_detail_add_indexx_good_remarks').val(data.remarks);
            }
        });
    });

    
    /* INDEXX */

    $(document).on('click', '#searchable-indexx > input', function()
    {
        $('#searchable-indexx > div').slideDown();
    });

    $(document).on('keyup', '#searchable-indexx > input', function()
    {
        $('#searchable-indexx > div').slideDown();
    });

    $(document).on('dblclick', '#searchable-indexx > input', function()
    {
        $('#searchable-indexx > div').slideUp();
    });

    $(document).on('click', '#searchable-indexx tr:not(:first-child)', function()
    {
        var indexxId = $(this).data('id');

        $.ajax({
            type: "POST",
            url: "/warehouse/get-one-indexx",
            data: {
                indexxId: indexxId,
            },
            success: function(data)
            {
                $('#delivery_detail_add_indexx_id').val(data.id);
                $('#delivery_detail_add_indexx_name').val(data.name);
                $('#delivery_detail_add_indexx_producer').val(data.producer_id);
                $('#delivery_detail_add_indexx_quantity').val(data.quantity);
                $('#delivery_detail_add_indexx_unit_price_net').val(data.unit_price_net);
            }
        });
    });

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
            var input = '<input type="hidden" value="' +  $(this).data('id') + '">';
            var label = '<label>' +  $(this).text() + '</label>';

            $('#categories-form-selectable-modal .content .names').append(label);
            $('#categories-form-selectable-modal .content .ids').append(input);

        });

        $('#categories-selectable-modal').remove();
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
            var input = '<input type="hidden" value="' +  $(this).data('id') + '">';
            var label = '<label>' +  $(this).text() + '</label>';

            $('#models-form-selectable-modal .content .names').append(label);
            $('#models-form-selectable-modal .content .ids').append(input);

        });

        $('#models-selectable-modal').remove();
    });

});