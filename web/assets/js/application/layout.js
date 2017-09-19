$(document).ready(function()
{
    $(document).on('click', 'header > div', function()
    {
        $('section.header:nth-child(2)').slideToggle(1000);

        //animate({height: "100vw"}, 700);
    });
});