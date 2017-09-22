$(document).ready(function()
{
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