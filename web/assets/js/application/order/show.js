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

    $(document).on('dblclick', '#input-paid', function()
    {
        var input = $(this);

        if(input.hasClass('input-disabled'))
        {
            input.removeClass('input-disabled');
            $('#paid-buttons').show('slow');
        }
        else
        {
            input.addClass('input-disabled');
            $('#paid-buttons').hide('slow');
        }
    });

    $(document).on('click', '#paid-buttons button', function()
    {
        var orderHeaderId = $('.statuses').data('order-id');
        var amountPaid = $('#input-paid').val();

        $.ajax({
            type: "POST",
            url: "/order/pay",
            data: {
                amountPaid: amountPaid,
                orderHeaderId: orderHeaderId,
            },
            success: function(data) {
                $('#input-paid').addClass('input-disabled');
                $('#paid-buttons').hide('slow');

                if(!data['error'])
                {
                    $('#paid-amount').val(data['data'][0]);
                    $('#input-paid').val(data['data'][0]);
                }
                else
                {
                    var paidAmount = $('#paid-amount').val();

                    $('#input-paid').val(paidAmount);
                }
            }
        });

    });
});