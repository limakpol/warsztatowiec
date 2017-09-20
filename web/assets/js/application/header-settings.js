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

    $(document).on('click', '#user_edit_submit', function(event)
    {
        event.preventDefault();

        $('.error').remove();

        var submit = $(this);

        if(submit.hasClass('btn-success')) return;

        $.ajax({
            type: "POST",
            url: "/header/user-index",
            data: $('#div-header-settings-content form').serialize(),
            success: function(data)
            {
                if(data['error'] == 0)
                {
                    displaySuccess(submit);
                }
                else
                {
                    submit.after('<span class="error">' + data['msg'] + '</span>');
                }
            }
        });
    });
});

function displaySuccess(submit)
{
    submit.text('zapisane!').addClass('btn-success');

    window.setTimeout(function()
    {
        submit.text('zapisz').removeClass('btn-success');
        addIcon();
    },1500);
}