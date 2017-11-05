$(document).ready(function()
{
    $(document).on('click', '.customer-btn-filter-custom', function(event)
    {
        event.preventDefault();

        var button = $(this);

        if(button.hasClass('active'))
        {

            $('input[type=hidden][value="' + button.text() + '"]').remove();
            button.removeClass('active');
        }
        else
        {

            button.after('<input type="hidden" name="customer[groupps][][name]" required="required" value="' + button.text() + '">');
            button.addClass('active');
        }
    });

    $(document).on('keypress', '.input-label-add', function(event)
    {

        if(event.which == 13)
        {

            event.preventDefault();

            var name = $(this).val();

            var groupps = $('.customer-btn-filter-custom');

            var error = false;

            groupps.each(function()
            {
                if($(this).text() == name) error = true;
            });

            if(error) return;


            var button = '<button class="customer-btn-filter-custom active">' + name + '</button>';
            var hidden = '<input type="hidden" name="customer[groupps][][name]" required="required" value="' + name + '">';

            $(this).before(button);
            $(this).before(hidden);
            $(this).val('');
        }

    });
});