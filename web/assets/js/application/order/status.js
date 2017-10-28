$(document).ready(function()
{
    $(document).on('click', 'td.statuses', function()
    {
        var orderHeaderId = $(this).data('order-id');

        $.ajax({
            type: "POST",
            url: "/order/status/get-box",
            data:{
              orderHeaderId: orderHeaderId,
            },
            success: function(data) {
                if(!data['error'])
                {
                    var statusBox = '<div class="status-box"></div>';

                    $('.footer footer').before(statusBox);

                    $('.status-box').html(data);
                }
            }
        });
    });

    $(document).on('click', '.status-box header i', function()
    {
       $('.status-box').remove();
    });

    $(document).on('mouseover', '.status-box main button', function(){

       var hexColor = $(this).data('color');

       $(this).css("border-color", hexColor);
    });

    $(document).on('mouseout', '.status-box main button:not(.active)', function(){

        $(this).css("border-color", "#aaa");
    });

    $(document).on('click', '.status-box main button', function(){

        var button = $(this);
        
        var hexColor = button.data('color');

        if(button.hasClass('active'))
        {
            button.removeClass('active');
            button.css("border-color", "#aaa");
        }
        else
        {
            button.addClass('active');
            button.css("border-color", hexColor);
        }
    });

    $(document).on('click', '.status-box footer button', function(event){

        event.preventDefault();

        var button = $(this);
        var orderHeaderId = $(this).data('order-header-id');
        var statusButtons = $('.status-box main button.active');

        var statusIds = [];
        statusButtons.each(function()
        {
            statusIds.push($(this).data('id'));
        });

        $.ajax({
            type: "POST",
            url: "/order/status-assign",
            data: {
                orderHeaderId: orderHeaderId,
                statusIds: statusIds,
            },
            success: function(data) {
                if(data['error'])
                {
                    button.after('<span class="error">Wystąpił błąd</span>');
                }
                else
                {
                    $('.status-box').remove();
                }

                $('td.statuses[data-order-id=' + orderHeaderId + ']').html(data);

            }
        });
    });
});