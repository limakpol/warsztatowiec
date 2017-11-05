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
});