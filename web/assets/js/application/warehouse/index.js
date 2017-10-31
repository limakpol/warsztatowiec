$(document).ready(function()
{
    $(document).on('click', '.accordion-first-level tr.accordion-header', function()
    {
        $(this).next('tr.accordion-content').find('div.accordion-content').slideToggle();
    });

    var globalTimeout = null;
    $(document).on('keyup', '#div-good-sortable .input-search', function()
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

    $(document).on('change', '#div-good-sortable .select-limit', function()
    {
        var sortableParameters = getSortableParameters();
        request(sortableParameters);
    });


    $(document).on('click', '#div-good-sortable .btn-previous', function()
    {
        var sortableParameters = getSortableParameters();
        sortableParameters.requestedPage = 0;
        request(sortableParameters);
    });

    $(document).on('click', '#div-good-sortable .btn-next', function()
    {
        var sortableParameters = getSortableParameters();
        sortableParameters.requestedPage = 2;
        request(sortableParameters);
    });

    $(document).on('click', '#div-good-sortable .th-sort-column', function()
    {
        var sortableParameters = getSortableParameters();
        sortableParameters.sortColumnName = $(this).data('column');

        var sortOrder = $('#div-good-sortable .sortOrder').val();
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



    $(document).on('click', '.filter .selector', function()
    {
        $(this).parent().find('.content ul').slideToggle();

        if($(this).find('i').hasClass('fa-chevron-down'))
        {
            $(this).find('i').removeClass('fa-chevron-down');
            $(this).find('i').addClass('fa-chevron-up');
        }
        else
        {
            $(this).find('i').removeClass('fa-chevron-up');
            $(this).find('i').addClass('fa-chevron-down');
        }

    });

    $(document).on('click', '.filter .content ul li:not(.active)', function()
    {
        $(this).addClass('active');

        var sortableParameters = getSortableParameters();
        request(sortableParameters);

    });

    $(document).on('click', '.filter .content ul li.active', function()
    {
        $(this).removeClass('active');

        var sortableParameters = getSortableParameters();
        request(sortableParameters);
    });

});

function getSortableParameters()
{
    var filterCategoryIds = [];
    var filterCategoryInputs = $('#filter-categories .content ul li.active label');

    filterCategoryInputs.each(function()
    {
        filterCategoryIds.push($(this).data('id'));
    });

    var filterModelIds = [];
    var filterModelInputs = $('#filter-models .content ul li.active label');

    filterModelInputs.each(function()
    {
        filterModelIds.push($(this).data('id'));
    });

    var filterIndexxIds = [];

    sortableParameters = {
        "search": $('#div-good-sortable .input-search').val(),
        "limit": $('#div-good-sortable .select-limit option:checked').val(),
        "sortColumnName": $('#div-good-sortable .sortColumnName').val(),
        "sortOrder": $('#div-good-sortable .sortOrder').val(),
        "currentPage": $('#div-good-sortable .pagination-info .currentPage').text(),
        "requestedPage": 1,
        "filterCategoryIds": filterCategoryIds,
        "filterModelIds": filterModelIds,
        "filterIndexxIds": filterIndexxIds
    };

    return sortableParameters;
}

function request(sortableParameters)
{

    $.ajax({
        type: "POST",
        url: $('#div-good-sortable .retrievePath').val(),
        data: {
            sortableParameters: JSON.stringify(sortableParameters)
        },
        success: function(data)
        {
            if(!data['error'])
            {
                $('#div-good-sortable > .content').html(data);
            }
        }
    });
}