$(document).ready(function(){

    $(document).on('click', '#searchable-customer > input', function() {
        $('#searchable-customer > div').slideDown();
    });

    $(document).on('keyup', '#searchable-customer > input', function() {
        $('#searchable-customer > div').slideDown();
    });

    $(document).on('dblclick', '#searchable-customer > input', function() {

        $('#searchable-customer > div').slideUp();
    });

    $(document).on('click', '#searchable-customer .prev', function(event){
        event.preventDefault();
        var sortableParameters = getSortableParameters();
        sortableParameters.requestedPage = 0;
        request(sortableParameters);
    });

    $(document).on('click', '#searchable-customer .next', function(event){
        event.preventDefault();
        var sortableParameters = getSortableParameters();
        sortableParameters.requestedPage = 2;
        request(sortableParameters);
    });

    $(document).on('click', '#only-suppliers span', function(){
        if($('#only-suppliers input').is(':checked'))
        {
            $('#only-suppliers input').prop('checked', false);
        }
        else
        {
            $('#only-suppliers input').prop('checked', true);
        }

        var sortableParameters = getSortableParameters();
        request(sortableParameters);
    });

    $(document).on('click', '#only-suppliers input', function(){
        var sortableParameters = getSortableParameters();
        request(sortableParameters);
    });

    $(document).on('click', '#searchable-customer th.sort-column', function(){
        var sortableParameters = getSortableParameters();

        sortableParameters.sortColumnName = $(this).data('column');

        var sortOrder = $('#searchable-customer footer .sortOrder').val();
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

    var globalTimeout = null;
    $(document).on('keyup', '#searchable-customer > input', function()
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

    $(document).on('click', '#customer-new', function()
    {
        $('#delivery_header_add_customer_forename').focus();

        clearCustomerForm();

        removeCustomerErrors();

        $('.h-enum.selected-customer').text('2. Wpisz dane dostawcy');

        $('#delivery_header_add_customer_id').val('new');

        $('#searchable-customer > div').slideUp();

        $('#customer-form').slideDown();

    });

    $(document).on('click', '#customer-empty', function()
    {
        $('#delivery_header_add_customer_id').val('');

        $('.h-enum.selected-customer').text('2. Przyjęcie wewnętrzne (brak dostawcy)');

        $('#searchable-customer > div').slideUp();

        $('#customer-form').slideUp();

        clearCustomerForm();

        removeCustomerErrors();
    });

    $(document).on('click', '#searchable-customer tr:not(:first-child)', function()
    {
        var customerId = $(this).data('id');

        $.ajax({
            type: "POST",
            url: "/customer/get-one/2",
            data: {
                customerId: customerId,
            },
            success: function(data) {
                if(data.error > 0)
                {

                }
                else
                {
                    for(value in data[0])
                    {
                        var cssId = '#delivery_header_add_customer_' + value;

                        $(cssId).val(data[0][value]).change();
                    }

                    for(value in data[1])
                    {
                        cssId = '#delivery_header_add_customer_address_' + value;

                        $(cssId).val(data[1][value]).change();
                    }

                    $('#delivery_header_add_customer_address_province').val(data[1]['province_id']);
                }

            }
        });

        removeCustomerErrors();

        $('.h-enum.selected-customer').text('2. Możesz przejrzeć i zmienić dane dostawcy');

        $('#searchable-customer > div').slideUp();

        $('#customer-form').slideDown();

    });
});

function getSortableParameters()
{
    var systemFilters = [];
    var customFilters = [];

    if($('#only-suppliers input').is(':checked'))
    {
        systemFilters = ['supplier'];
    }

    sortableParameters = {
        "search": $('#searchable-customer > input').val(),
        "limit": 15,
        "sortColumnName": $('#searchable-customer footer .sortColumnName').val(),
        "sortOrder": $('#searchable-customer footer .sortOrder').val(),
        "currentPage": $('#searchable-customer footer .currentPage').val(),
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
        url: $('#searchable-customer footer .retrievePath').val(),
        data: {
            sortableParameters: JSON.stringify(sortableParameters)
        },
        success: function(data)
        {
            if(!data['error'])
            {
                $('#searchable-customer > div').html(data);
            }
        }
    });
}

function removeCustomerErrors()
{
    $("input[name*='delivery_header_add[customer]'] + ul").remove();
    $("select[name*='delivery_header_add[customer]'] + ul").remove();
    $("textarea[name*='delivery_header_add[customer]'] + ul").remove();

    return null;
}

function clearCustomerForm()
{
    $("input[name*='delivery_header_add[customer]']").val('').change();
    $("select[name*='delivery_header_add[customer]']").val('').change();
    $("textarea[name*='delivery_header_add[customer]']").val('').change();

    return null;
}