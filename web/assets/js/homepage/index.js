$(document).ready(function()
{
    $(document).on('click', '#menu-square', function()
    {
        if($('header ul').css("display") == "none")
        {
            $('header ul').css("display", "flex");
            $('main').css("display", "none");
        }
        else
        {
            $('main').css("display", "flex");
            $('header ul').css("display", "none");
        }
        console.log($('header ul').css("display"));
    });
});