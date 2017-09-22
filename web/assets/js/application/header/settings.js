$(document).ready(function()
{
    $(document).on('click', '#div-header-settings-menu ul li', function()
    {

        var selectedLi = $(this);
        var url = selectedLi.data('path');

        $.ajax({
            type: "POST",
            url: url,
            success: function(data)
            {
                if(!data['error'])
                {
                    $('#div-header-settings-content').html(data);
                    $('#div-header-settings-menu ul li.active').removeClass('active');
                    selectedLi.addClass('active');

                    addIcon();
                }
            }
        });
    });
});




