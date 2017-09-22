$(document).ready(function()
{
    $(document).on('click', '#new-workshop', function(event)
    {
        event.preventDefault();

        $.ajax({
            type: "POST",
            url: "/header/workshop-add",
            success: function(data)
            {
                if(!data['error'])
                {
                    $('#div-header-settings-content').html(data);

                    addIcon();
                }
            }
        });
    });

    $(document).on('click', '#workshop_add_submit', function(event)
    {
        event.preventDefault();

        $('.error').remove();

        var submit = $(this);

        if(submit.hasClass('btn-success')) return;

        $.ajax({
            type: "POST",
            url: "/header/workshop-add",
            data: $('#div-header-settings-content form').serialize(),
            success: function(data)
            {
                if(data['error'] == 0)
                {
                    $.ajax({
                        type: "POST",
                        url: "/header/workshop-index",
                        success: function(data)
                        {
                            if(!data['error'])
                            {
                                $('#div-header-settings-content').html(data);

                                addIcon();
                            }
                        }
                    });
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

    $(document).on('click', '.switch-workshop', function(event)
    {
        event.preventDefault();

        $('.error').remove();

        var button = $(this);

        $.ajax({
            type: "POST",
            url: "/header/workshop-switch",
            data: {
                id: button.data('id'),
            },
            success: function(data)
            {
                if(data['error'] == 0)
                {
                    location.reload();
                }
                else
                {
                    data['messages'].forEach(function(value, index)
                    {
                        button.after('<span class="error">' + value + '</span>');
                    });
                }
            }
        });

    });
});