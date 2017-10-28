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

                    var modal = '<div class="selectable-modal"></div>';

                    $('footer').before(modal);

                    $('.selectable-modal').html(data);
                }
            },
        });

    });

});