$(document).ready(function () {
    $(document).on('click', '.show-inputable .add input', function()
    {
       $(this).next('.select').slideDown();
    });

    $(document).on('dblclick', '.show-inputable .add input', function()
    {
        $(this).next('.select').slideUp();
    });

    $(document).on('click', '.show-inputable .select div', function()
    {
        var text = $(this).text();

        var inputable = $(this).parent().parent().parent().parent();

        inputable.find('.add input').val(text).focus();

        inputable.find('.add .select').slideUp();
    });

    $(document).on('click', '.show-inputable .add .btn-add', function()
    {
        var inputable = $(this).parent().parent().parent().parent();

        var name = inputable.find('.add input').val();

        if(!name) return;

        var path = inputable.data('add-path');

        var orderHeaderId = $('.statuses').data('order-id');

        $.ajax({
            type: "POST",
            url: path,
            data: {
                orderHeaderId: orderHeaderId,
                name: name,
            },
            success: function(data){
                if(!data['error'])
                {
                    if(data['data'] == undefined)
                    {
                        inputable.find('tr.add').before(data);
                    }
                    inputable.find('.add input').val('');

                    inputable.find('.add .select').slideUp();
                }
            },
        });
    });

    $(document).on('keypress', '.show-inputable .add input', function(event)
    {
        if(event.which == 13) {

            var inputable = $(this).parent().parent().parent().parent();

            var name = inputable.find('.add input').val();

            if (!name) return;

            var path = inputable.data('add-path');

            var orderHeaderId = $('.statuses').data('order-id');

            $.ajax({
                type: "POST",
                url: path,
                data: {
                    orderHeaderId: orderHeaderId,
                    name: name,
                },
                success: function (data) {
                    if(!data['error'])
                    {

                        if(data['data'] == undefined)
                        {
                            inputable.find('tr.add').before(data);
                        }

                        inputable.find('.add input').val('');

                        inputable.find('.add .select').slideUp();
                    }
                },
            });
        }
    });

    $(document).on('click', '.show-inputable .present .btn-remove', function()
    {

        var button = $(this);
        var inputable = $(this).parent().parent().parent().parent();

        var id = button.data('id');

        var path = inputable.data('remove-path');

        var orderHeaderId = $('.statuses').data('order-id');

        $.ajax({
            type: "POST",
            url: path,
            data: {
                orderHeaderId: orderHeaderId,
                id: id,
            },
            success: function(data){
                if(!data['error'])
                {
                    button.parent().parent().remove();
                }
            },
        });
    });
});