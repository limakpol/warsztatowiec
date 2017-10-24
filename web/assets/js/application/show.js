$(document).ready(function()
{
    $(document).on('click', '.show-box h1 label', function()
    {
        $(this).parent().parent().find('section').slideToggle();
    });
});