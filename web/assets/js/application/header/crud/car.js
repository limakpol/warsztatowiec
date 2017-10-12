$(document).ready(function()
{
    $(document).on('click', '.inputable.brand .btn-add', function(event)
    {
        event.preventDefault();

        $('.error').remove();

        var submit = $(this);

        var name = submit.parent().parent().find('td:nth-child(1) input').val();

        if(name == '') return;

        $.ajax({
            type: "POST",
            url: "/header/car-brand-add",
            data: {
                name: name,
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

    $(document).on('click', '.inputable.brand .btn-edit', function(event)
    {
        event.preventDefault();

        $('.error').remove();

        var submit = $(this);

        var id = submit.data('id');
        var name = submit.parent().parent().find('td:nth-child(1) input').val();

        if(name == '') return;

        $.ajax({
            type: "POST",
            url: "/header/car-brand-edit",
            data: {
                id: id,
                name: name,
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

    $(document).on('click', '.inputable.brand .btn-remove', function(event)
    {
        event.preventDefault();

        $('.error').remove();

        var submit = $(this);

        var id = submit.data('id');

        $.ajax({
            type: "POST",
            url: "/header/car-brand-remove",
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

    $(document).on('click', '.inputable.brand tr:not(:last-child) input', function(event)
    {
        event.preventDefault();

        $('.error').remove();

        var input = $(this);

        var id = input.data('id');

        $('#div-header-settings-content tr').removeClass('selected');

        $.ajax({
            type: "POST",
            url: "/header/car-model-index/" + id,
            success: function(data) {
                if(!data['error'])
                {
                    if(id)
                    {
                        input.parent().parent().addClass('selected');
                        $('#div-header-settings-content > div > div:last-child').html(data);
                    }
                    else
                    {
                        $('#div-header-settings-content > div > div:last-child').html('');
                    }
                }
                else
                {
                    var messages = '';

                    data['messages'].forEach(function(value, index)
                    {
                        messages += '<span>' + value + '</span>';
                    });

                    input.parent().parent().after('<tr class="error"><td colspan="4">' + messages + '</td></tr>')
                }
            },
        });
    });

    $(document).on('click', '.inputable.brand tr:last-child input', function(event)
    {
        event.preventDefault();

        $('.error').remove();

        $('.inputable.brand tr').removeClass('selected');
        $('#div-header-settings-content div div:last-child').html('');
    });

    $(document).on('click', '.inputable.model .btn-add', function(event)
    {
        event.preventDefault();

        $('.error').remove();

        var submit = $(this);

        var name = submit.parent().parent().find('td:nth-child(1) input').val();

        if(name == '') return;

        var brandId = $('.inputable.brand tr.selected input').data('id');

        $.ajax({
            type: "POST",
            url: "/header/car-model-add",
            data: {
                name: name,
                brandId: brandId,
            },
            success: function(data) {
                if(!data['error'])
                {
                    $('#div-header-settings-content > div > div:last-child').html(data);
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

    $(document).on('click', '.inputable.model .btn-edit', function(event)
    {
        event.preventDefault();

        $('.error').remove();

        var submit = $(this);

        var id = submit.data('id');
        var name = submit.parent().parent().find('td:nth-child(1) input').val();

        if(name == '') return;

        $.ajax({
            type: "POST",
            url: "/header/car-model-edit",
            data: {
                id: id,
                name: name,
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

    $(document).on('click', '.inputable.model .btn-remove', function(event)
    {
        event.preventDefault();

        $('.error').remove();

        var submit = $(this);

        var id = submit.data('id');

        $.ajax({
            type: "POST",
            url: "/header/car-model-remove",
            data: {
                id: id,
            },
            success: function(data) {
                if(!data['error'])
                {
                    $('#div-header-settings-content div div:last-child').html(data);
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