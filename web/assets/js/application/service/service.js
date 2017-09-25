$(document).ready(function()
{
    $(document).on('click', '.inputable.service .btn-add', function(event)
    {
        event.preventDefault();

        $('.error').remove();

        var submit = $(this);

        var name = submit.parent().parent().find('td:nth-child(1) input').val();
        var measureId = submit.parent().parent().find('td:nth-child(2) select option:checked').val();
        var unitPriceNet = submit.parent().parent().find('td:nth-child(3) input').val();

        if(name == '') return;

        $.ajax({
            type: "POST",
            url: "/service-add",
            data: {
                name: name,
                measureId: measureId,
                unitPriceNet: unitPriceNet,
            },
            success: function(data) {
                if(!data['error'])
                {
                    $('main').html(data);
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

    $(document).on('click', '.inputable.service .btn-edit', function(event)
    {
        event.preventDefault();

        $('.error').remove();

        var submit = $(this);

        var id = submit.data('id');
        var name = submit.parent().parent().find('td:nth-child(1) input').val();
        var measureId = submit.parent().parent().find('td:nth-child(2) select option:checked').val();
        var unitPriceNet = submit.parent().parent().find('td:nth-child(3) input').val();

        if(name == '') return;

        $.ajax({
            type: "POST",
            url: "/service-edit",
            data: {
                id: id,
                name: name,
                measureId: measureId,
                unitPriceNet: unitPriceNet,
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

    $(document).on('click', '.inputable.service .btn-remove', function(event)
    {
        event.preventDefault();

        $('.error').remove();

        var submit = $(this);

        var id = submit.data('id');

        $.ajax({
            type: "POST",
            url: "/service-remove",
            data: {
                id: id,
            },
            success: function(data) {
                if(!data['error'])
                {
                    $('main').html(data);
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