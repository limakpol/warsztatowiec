$(document).ready()
{
    $(document).on('click', '#btn-generate-test-data', function(event)
    {
        event.preventDefault();

        var submit = $(this);
        submit.removeAttr('id').removeClass('btn-system').addClass('btn-disabled').text('generuję dane..');

        $.ajax({
            type: "POST",
            url: '/header/system-generate-test-data',
            success: function(data)
            {

                submit.removeClass('btn-disabled').addClass('btn-system').text('dane zostały wygenerowane');

            },
        });
    });
}