$(document).ready(function(){

    var globalTimeout = null;
    $(document).on('keyup', '#div-customer-sortable .input-search', function()
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

    $(document).on('change', '#div-customer-sortable .select-limit', function()
    {
        var sortableParameters = getSortableParameters();
        request(sortableParameters);
    });

    $(document).on('click', '#div-customer-sortable .div-filters button', function()
    {
        var button = $(this);
        reCheckButton(button);

        var sortableParameters = getSortableParameters();
        
        $.ajax({
            type: "POST",
            url: $('#div-customer-sortable .retrievePath').val(),
            data: {
                sortableParameters: JSON.stringify(sortableParameters)
            },
            success: function(data)
            {
                if(!data['error'])
                {
                    $('#div-customer-sortable .content').html(data);
                }
                else 
                {
                    reCheckButton(button);
                }
            }
        });
    });

    $(document).on('click', '#div-customer-sortable .btn-previous', function()
    {
        var sortableParameters = getSortableParameters();
        sortableParameters.requestedPage = 0;
        request(sortableParameters);
    });

    $(document).on('click', '#div-customer-sortable .btn-next', function()
    {
        var sortableParameters = getSortableParameters();
        sortableParameters.requestedPage = 2;
        request(sortableParameters);
    });

    $(document).on('click', '#div-customer-sortable .th-sort-column', function()
    {
        var sortableParameters = getSortableParameters();
        sortableParameters.sortColumnName = $(this).data('column');

        var sortOrder = $('#div-customer-sortable .sortOrder').val();
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
    var systemFilterInputs = $('#div-customer-sortable  .div-filters.system button.active');
    var systemFilters = [];

    systemFilterInputs.each(function()
    {
        systemFilters.push($(this).data('name'));
    });


    var customFilterInputs = $('#div-customer-sortable  .div-filters.custom button.active');
    var customFilters = [];

    customFilterInputs.each(function()
    {
        customFilters.push($(this).data('id'));
    });

    sortableParameters = {
        "search": $('#div-customer-sortable .input-search').val(),
        "limit": $('#div-customer-sortable .select-limit option:checked').val(),
        "sortColumnName": $('#div-customer-sortable .sortColumnName').val(),
        "sortOrder": $('#div-customer-sortable .sortOrder').val(),
        "currentPage": $('#div-customer-sortable .pagination-info span:first-child').text(),
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
        url: $('#div-customer-sortable .retrievePath').val(),
        data: {
            sortableParameters: JSON.stringify(sortableParameters)
        },
        success: function(data)
        {
            if(!data['error'])
            {
                $('#div-customer-sortable .content').html(data);
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