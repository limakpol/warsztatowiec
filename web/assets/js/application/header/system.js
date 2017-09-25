$(document).ready()
{
    $(document).on('click', '#btn-generate-test-data', function(event)
    {
        event.preventDefault();

        $.ajax({
            type: "POST",
            url: '/header/system-generate-test-data',
            success: function(data)
            {
                console.log(data);
            },
        });
    });
}