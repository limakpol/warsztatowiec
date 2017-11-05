$(document).ready(function()
{
    $(document).on('click', '#order_action_action', function()
    {
        if($(this).val())
        {
           $('#action-name').hide('fast');
        }
        else
        {
            $('#action-name').show('fast');
            $('#order_action_action_name').focus();

        }

        $('#order_action_action_name').val('');
        $('#order_action_action + ul').remove();
    });

    $(document).on('keypress', '#order_action_action_name', function()
    {
        $('#order_action_action_name + ul').remove();
    });

    /* WORKMANS */

    $(document).on('click', '.main-form .multiselect .selector', function()
    {
        $(this).parent().find('.content ul').slideToggle();

        if($(this).find('i').hasClass('fa-chevron-down'))
        {
            $(this).find('i').removeClass('fa-chevron-down');
            $(this).find('i').addClass('fa-chevron-up');
        }
        else
        {
            $(this).find('i').removeClass('fa-chevron-up');
            $(this).find('i').addClass('fa-chevron-down');
        }

    });

    $(document).on('click', '.main-form .multiselect .content ul li:not(.active)', function()
    {
        $(this).addClass('active');

        var id = $(this).data('id');

        var input = '<input type="hidden" name="order_action[workmans][]" value="' + id + '">';

        $('#workmans .ids').append(input);

    });

    $(document).on('click', '.main-form .multiselect .content ul li.active', function()
    {
        $(this).removeClass('active');

        var id = $(this).data('id');

        var input = $('#workmans .ids input[value=' + id + ']');

        input.remove();
    });

});