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
            url: "/header/user-edit",
            data: $('#div-header-settings-content form').serialize(),
            success: function(data)
            {
                if(data['error'] == 0)
                {
                    displaySuccess(submit, 'zapisane!');
                }
                else
                {
                    data['messages'].forEach(function(value, index)
                    {
                        submit.after('<span class="error">' + value + '</span>');
                    });

                }
            }
        });
    });

    $(document).on('click', '#change_password_submit', function(event)
    {
        event.preventDefault();

        $('.error').remove();

        var submit = $(this);

        if(submit.hasClass('btn-success')) return;

        $.ajax({
            type: "POST",
            url: "/header/password-change",
            data: $('#div-header-settings-content form').serialize(),
            success: function(data)
            {
                console.log(data);
                if(data['error'] == 0)
                {
                    displaySuccess(submit, 'hasło zmienione!');
                    $('#div-header-settings-content form input').val('');
                }
                else
                {
                    data['messages'].forEach(function(value, index)
                    {
                        submit.after('<span class="error">' + value + '</span>');
                    });

                }
            }
        });
    });
});

function displaySuccess(submit, msg)
{
    submit.text(msg).addClass('btn-success');

    window.setTimeout(function()
    {
        submit.text('zapisz').removeClass('btn-success');
        addIcon();
    }, 1500);
}