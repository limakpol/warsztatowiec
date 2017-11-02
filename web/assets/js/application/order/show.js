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
});