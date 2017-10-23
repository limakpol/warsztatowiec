$(document).ready(function(){

    var globalTimeout = null;
    $(document).on('keyup', '#div-delivery-sortable .input-search', function()
    {
        if(globalTimeout != null)
        {
            clearTimeout(globalTimeout);
        }

        globalTimeout = setTimeout(function()
        {
            globalTimeout = null;

            var sortableParameters = getSortableParameters();
            request(sortableParameters);

        }, 1000);
    });

    $(document).on('change', '#div-delivery-sortable .select-limit', function()
    {
        var sortableParameters = getSortableParameters();
        request(sortableParameters);
    });

    $(document).on('click', '#div-delivery-sortable .div-filters button', function()
    {
        var button = $(this);
        reCheckButton(button);

        var sortableParameters = getSortableParameters();
        
        $.ajax({
            type: "POST",
            url: $('#div-delivery-sortable .retrievePath').val(),
            data: {
                sortableParameters: JSON.stringify(sortableParameters)
            },
            success: function(data)
            {
                if(!data['error'])
                {
                    $('#div-delivery-sortable .content').html(data);
                }
                else 
                {
                    reCheckButton(button);
                }
            }
        });
    });

    $(document).on('click', '#div-delivery-sortable .btn-previous', function()
    {
        var sortableParameters = getSortableParameters();
        sortableParameters.requestedPage = 0;
        request(sortableParameters);
    });

    $(document).on('click', '#div-delivery-sortable .btn-next', function()
    {
        var sortableParameters = getSortableParameters();
        sortableParameters.requestedPage = 2;
        request(sortableParameters);
    });

    $(document).on('click', '#div-delivery-sortable .th-sort-column', function()
    {
        var sortableParameters = getSortableParameters();
        sortableParameters.sortColumnName = $(this).data('column');

        var sortOrder = $('#div-delivery-sortable .sortOrder').val();
        if(sortOrder == 'DESC')
        {
            sortOrder = 'ASC';
        }
        else
        {
            sortOrder = 'DESC';
        }
        sortableParameters.sortOrder = sortOrder;

        request(sortableParameters);
    });

});


function getSortableParameters()
{
    var customFilters = [];
    var systemFilters = [];

    sortableParameters = {
        "search": $('#div-delivery-sortable .input-search').val(),
        "limit": $('#div-delivery-sortable .select-limit option:checked').val(),
        "sortColumnName": $('#div-delivery-sortable .sortColumnName').val(),
        "sortOrder": $('#div-delivery-sortable .sortOrder').val(),
        "currentPage": $('#div-delivery-sortable .pagination-info .currentPage').text(),
        "requestedPage": 1,
        "systemFilters": systemFilters,
        "customFilters": customFilters,
    };

    return sortableParameters;
}

function request(sortableParameters)
{

    $.ajax({
        type: "POST",
        url: $('#div-delivery-sortable .retrievePath').val(),
        data: {
            sortableParameters: JSON.stringify(sortableParameters)
        },
        success: function(data)
        {
            if(!data['error'])
            {
                $('#div-delivery-sortable .content').html(data);
            }
        }
    });
}
function reCheckButton(button)
{
    if(button.hasClass('active'))
    {
        button.removeClass('active');
    }
    else
    {
        button.addClass('active');
    }
}