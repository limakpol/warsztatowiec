$(document).ready(function()
{
    $(document).on('click', '.inputable.measure .btn-add', function(event)
    {
        event.preventDefault();

        $('.error').remove();

        var submit = $(this);
        
        var type = submit.data('type');
        var name = submit.parent().parent().find('td:nth-child(1) input').val();
        var shortcut = submit.parent().parent().find('td:nth-child(2) input').val();

        if(name == '' || shortcut == '') return;

        $.ajax({
            type: "POST",
            url: "/header/measure-add",
            data: {
                type: type,
                name: name,
                shortcut: shortcut,
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

    $(document).on('click', '.inputable.measure .btn-edit', function(event)
    {
        event.preventDefault();

        $('.error').remove();

        var submit = $(this);

        var id = submit.data('id');
        var name = submit.parent().parent().find('td:nth-child(1) input').val();
        var shortcut = submit.parent().parent().find('td:nth-child(2) input').val();

        if(name == '' || shortcut == '') return;

        $.ajax({
            type: "POST",
            url: "/header/measure-edit",
            data: {
                id: id,
                name: name,
                shortcut: shortcut,
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

    $(document).on('click', '.inputable.measure .btn-remove', function(event)
    {
        event.preventDefault();

        $('.error').remove();

        var submit = $(this);

        var id = submit.data('id');

        $.ajax({
            type: "POST",
            url: "/header/measure-remove",
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