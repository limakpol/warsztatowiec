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
            url: "/warehouse/category/get-selectable-modal",
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

});