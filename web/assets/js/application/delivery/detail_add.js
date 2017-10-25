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
});