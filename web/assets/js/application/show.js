$(document).ready(function()
{
    $(document).on('click', '.show-box h1 label', function()
    {
        $(this).parent().parent().find('section').slideToggle('slow');
    });

    $(document).on('click', '.show-box .details-table tr.header', function()
    {
        $(this).next('tr.content').find('div.content').slideToggle('slow');
    });
});