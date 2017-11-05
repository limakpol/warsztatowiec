$(document).ready(function()
{

    addIcon();
    $(document).on('click', 'header.section-inner > div', function()
    {
        var selectedLi = $('#div-header-settings-menu ul li:first-child');
        var url = selectedLi.data('path');

        $.ajax({
            type: "POST",
            url: url,
            success: function(data)
            {
                if(!data['error'])
                {
                    if($('section.header:nth-child(2)').is(":visible"))
                    {
                        headerToggle();
                    }
                    else
                    {
                        load(data, selectedLi);
                        addIcon();
                        headerToggle();
                    }
                }
            }
        });
    });

    $(document).on('click', '#workshop-comments div button', function(event){
        event.preventDefault();

        var comment = $('#workshop-comments textarea').val();

        if(comment.length < 3) return;

        var path = window.location.href;
        var button = $(this);

        $.ajax({
            type: "POST",
            url: "/workshop/send-comment",
            data: {
                comment: comment,
                path: path,
            },
            success: function(data) {
                button.text('dziękujemy!').addClass('btn-success');
                $('#workshop-comments textarea').val('').change();

                window.setTimeout(function()
                {
                    button.text('wyślij').removeClass('btn-success');
                    addIcon();
                }, 1500);
            }
    });
    });

});

function headerToggle()
{
    $('section.header:nth-child(2)').slideToggle(1000);
}

function load(data, selectedLi)
{
    $('#div-header-settings-content').html(data);
    $('#div-header-settings-menu ul li.active').removeClass('active');
    selectedLi.addClass('active');
}
function addIcon()
{
    $('.add-i').append(function(){
        if($(this).find('i').length !=0) return;

        return  '<i class="fa fa-' + $(this).data('add-i') + '" aria-hidden="true"></i>'
    });
}