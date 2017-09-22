$(document).ready(function()
{
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
});