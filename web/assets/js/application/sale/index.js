$(document).ready(function(){

    var globalTimeout = null;
    $(document).on('keyup', '#div-sale-sortable .input-search', function()
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

    $(document).on('change', '#div-sale-sortable .select-limit', function()
    {
        var sortableParameters = getSortableParameters();
        request(sortableParameters);
    });

    $(document).on('click', '#div-sale-sortable .div-filters button', function()
    {
        var button = $(this);
        reCheckButton(button);

        var sortableParameters = getSortableParameters();
        
        $.ajax({
            type: "POST",
            url: $('#div-sale-sortable .retrievePath').val(),
            data: {
                sortableParameters: JSON.stringify(sortableParameters)
            },
            success: function(data)
            {
                if(!data['error'])
                {
                    $('#div-sale-sortable .content').html(data);
                }
                else 
                {
                    reCheckButton(button);
                }
            }
        });
    });

    $(document).on('click', '#div-sale-sortable .btn-previous', function()
    {
        var sortableParameters = getSortableParameters();
        sortableParameters.requestedPage = 0;
        request(sortableParameters);
    });

    $(document).on('click', '#div-sale-sortable .btn-next', function()
    {
        var sortableParameters = getSortableParameters();
        sortableParameters.requestedPage = 2;
        request(sortableParameters);
    });

    $(document).on('click', '#div-sale-sortable .th-sort-column', function()
    {
        var sortableParameters = getSortableParameters();
        sortableParameters.sortColumnName = $(this).data('column');

        var sortOrder = $('#div-sale-sortable .sortOrder').val();
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
        "search": $('#div-sale-sortable .input-search').val(),
        "limit": $('#div-sale-sortable .select-limit option:checked').val(),
        "sortColumnName": $('#div-sale-sortable .sortColumnName').val(),
        "sortOrder": $('#div-sale-sortable .sortOrder').val(),
        "currentPage": $('#div-sale-sortable .pagination-info .currentPage').text(),
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
        url: $('#div-sale-sortable .retrievePath').val(),
        data: {
            sortableParameters: JSON.stringify(sortableParameters)
        },
        success: function(data)
        {
            if(!data['error'])
            {
                $('#div-sale-sortable .content').html(data);
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