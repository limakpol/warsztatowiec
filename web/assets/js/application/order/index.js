$(document).ready(function(){

    var globalTimeout = null;
    $(document).on('keyup', '#div-order-sortable .input-search', function()
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

    $(document).on('change', '#div-order-sortable .select-limit', function()
    {
        var sortableParameters = getSortableParameters();
        request(sortableParameters);
    });

    $(document).on('click', '#div-order-sortable .div-filters button', function()
    {
        var button = $(this);
        reCheckButton(button);

        var sortableParameters = getSortableParameters();
        
        $.ajax({
            type: "POST",
            url: $('#div-order-sortable .retrievePath').val(),
            data: {
                sortableParameters: JSON.stringify(sortableParameters)
            },
            success: function(data)
            {
                if(!data['error'])
                {
                    $('#div-order-sortable .content').html(data);
                }
                else 
                {
                    reCheckButton(button);
                }
            }
        });
    });

    $(document).on('click', '#div-order-sortable .btn-previous', function()
    {
        var sortableParameters = getSortableParameters();
        sortableParameters.requestedPage = 0;
        request(sortableParameters);
    });

    $(document).on('click', '#div-order-sortable .btn-next', function()
    {
        var sortableParameters = getSortableParameters();
        sortableParameters.requestedPage = 2;
        request(sortableParameters);
    });

    $(document).on('click', '#div-order-sortable .th-sort-column', function()
    {
        var sortableParameters = getSortableParameters();
        sortableParameters.sortColumnName = $(this).data('column');

        var sortOrder = $('#div-order-sortable .sortOrder').val();
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
        "search": $('#div-order-sortable .input-search').val(),
        "limit": $('#div-order-sortable .select-limit option:checked').val(),
        "sortColumnName": $('#div-order-sortable .sortColumnName').val(),
        "sortOrder": $('#div-order-sortable .sortOrder').val(),
        "currentPage": $('#div-order-sortable .pagination-info .currentPage').text(),
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
        url: $('#div-order-sortable .retrievePath').val(),
        data: {
            sortableParameters: JSON.stringify(sortableParameters)
        },
        success: function(data)
        {
            if(!data['error'])
            {
                $('#div-order-sortable .content').html(data);
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