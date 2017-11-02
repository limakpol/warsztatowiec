$(document).ready(function()
{
    $(document).on('click', '#checkbox-priority', function()
    {
        var checkbox = $(this);
        var orderHeaderId = $('.statuses').data('order-id');

        $.ajax({
            type: "POST",
            url: "/order/change-priority",
            data: {
                orderHeaderId: orderHeaderId,
            },
            success: function(data)
            {
                if(data['error'])
                {
                    if(checkbox.is(':checked'))
                    {
                        checkbox.prope('checked', false);
                    }
                    else {
                        checkbox.prop('checked', true);
                    }
                }
            }
        });
    });

    $(document).on('change', '#select-workstation', function()
    {
        var orderHeaderId = $('.statuses').data('order-id');
        var workstationId = $(this).val();

        $.ajax({
            type: "POST",
            url: "/order/change-workstation",
            data: {
                orderHeaderId: orderHeaderId,
                workstationId: workstationId,
            },
            success: function(data)
            {

            }
        });
    });

    $(document).on('dblclick', '#order-completed', function()
    {
        var orderHeaderId = $('.statuses').data('order-id');

        $.ajax({
            type: "POST",
            url: "/order/set-completed",
            data: {
                orderHeaderId: orderHeaderId,
            },
            success: function(data)
            {
                $('#order-completed').html(data);
            }
        });
    });

    $(document).on('dblclick', '#order-paid', function()
    {
        var orderHeaderId = $('.statuses').data('order-id');

        $.ajax({
            type: "POST",
            url: "/order/set-paid",
            data: {
                orderHeaderId: orderHeaderId,
            },
            success: function(data)
            {
                $('#order-paid').html(data);
            }
        });
    });
});