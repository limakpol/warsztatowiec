$(document).ready(function()
{
    $(document).on('click', '.inputable.status .btn-add', function(event)
    {
        event.preventDefault();

        $('.error').remove();

        var submit = $(this);

        var name = submit.parent().parent().find('td:nth-child(1) input').val();
        var color = submit.parent().parent().find('td:nth-child(2) input').val();

        if(name == '' || color == '') return;

        $.ajax({
            type: "POST",
            url: "/header/status-add",
            data: {
                name: name,
                color: color,
            },
            success: function(data) {
                if(!data['error'])
                {
                    $('#div-header-settings-content').html(data);
                }
                else
                {
                    var messages = '';

                    data['messages'].forEach(function(value, index)
                    {
                        messages += '<span>' + value + '</span>';
                    });

                    submit.parent().parent().after('<tr class="error"><td colspan="4">' + messages + '</td></tr>')
                }
            },
        });
    });

    $(document).on('click', '.inputable.status .btn-edit', function(event)
    {
        event.preventDefault();

        $('.error').remove();

        var submit = $(this);

        var id = submit.data('id');
        var name = submit.parent().parent().find('td:nth-child(1) input').val();
        var color = submit.parent().parent().find('td:nth-child(2) input').val();

        if(name == '' || color == '') return;

        $.ajax({
            type: "POST",
            url: "/header/status-edit",
            data: {
                id: id,
                name: name,
                color: color,
            },
            success: function(data) {
                if(!data['error'])
                {
                    submit.removeClass('btn-edit').addClass('btn-add').addClass('btn-success');

                    window.setTimeout(function()
                    {
                        submit.removeClass('btn-add').removeClass('btn-success').addClass('btn-edit');
                    }, 1500);

                }
                else
                {
                    var messages = '';

                    data['messages'].forEach(function(value, index)
                    {
                        messages += '<span>' + value + '</span>';
                    });

                    submit.parent().parent().after('<tr class="error"><td colspan="4">' + messages + '</td></tr>')
                }
            },
        });
    });

    $(document).on('click', '.inputable.status .btn-remove', function(event)
    {
        event.preventDefault();

        $('.error').remove();

        var submit = $(this);

        var id = submit.data('id');

        $.ajax({
            type: "POST",
            url: "/header/status-remove",
            data: {
                id: id,
            },
            success: function(data) {
                if(!data['error'])
                {
                    $('#div-header-settings-content').html(data);
                }
                else
                {
                    var messages = '';

                    data['messages'].forEach(function(value, index)
                    {
                        messages += '<span>' + value + '</span>';
                    });

                    submit.parent().parent().after('<tr class="error"><td colspan="4">' + messages + '</td></tr>')
                }
            },
        });
    });
});