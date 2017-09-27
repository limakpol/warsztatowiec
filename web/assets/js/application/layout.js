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