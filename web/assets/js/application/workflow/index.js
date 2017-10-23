$(document).ready(function(){

    var globalTimeout = null;
    $(document).on('keyup', '#div-user-sortable .input-search', function()
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



    $(document).on('click', '#div-user-sortable .th-sort-column', function()
    {
        var sortableParameters = getSortableParameters();
        sortableParameters.sortColumnName = $(this).data('column');

        var sortOrder = $('#div-user-sortable .sortOrder').val();
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
    var systemFilters = [];
    var customFilters = [];

    sortableParameters = {
        "search": $('#div-user-sortable .input-search').val(),
        "limit": 500,
        "sortColumnName": $('#div-user-sortable .sortColumnName').val(),
        "sortOrder": $('#div-user-sortable .sortOrder').val(),
        "currentPage": 1,
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
        url: $('#div-user-sortable .retrievePath').val(),
        data: {
            sortableParameters: JSON.stringify(sortableParameters)
        },
        success: function(data)
        {
            if(!data['error'])
            {
                $('#div-user-sortable .content').html(data);
            }
        }
    });
}