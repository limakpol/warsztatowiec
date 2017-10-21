$(document).ready(function()
{
    /* CUSTOMER */

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
        var sortableParameters = getCustomerSortableParameters();
        sortableParameters.requestedPage = 0;
        customerRequest(sortableParameters);
    });

    $(document).on('click', '#searchable-customer .next', function(event){
        event.preventDefault();
        var sortableParameters = getCustomerSortableParameters();
        sortableParameters.requestedPage = 2;
        customerRequest(sortableParameters);
    });

    $(document).on('click', '#searchable-customer th.sort-column', function(){
        var sortableParameters = getCustomerSortableParameters();

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

        customerRequest(sortableParameters);
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

            var sortableParameters = getCustomerSortableParameters();
            customerRequest(sortableParameters);

        }, 1000);
    });

    $(document).on('click', '#customer-new', function()
    {
        $('#order_header_add_customer_forename').focus();

        clearCustomerForm();

        removeCustomerErrors();

        $('.h-enum.selected-customer').text('2. Wpisz dane klienta');

        $('#order_header_add_customer_id').val('new');

        $('#searchable-customer > div').slideUp();

        $('#customer-form').slideDown();

    });
    
});

/* FUNCTIONS - CUSTOMER */

function getCustomerSortableParameters()
{
    var systemFilters = [];
    var customFilters = [];

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

function customerRequest(sortableParameters)
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
    $("input[name*='order_header_add[customer]'] + ul").remove();
    $("select[name*='order_header_add[customer]'] + ul").remove();
    $("textarea[name*='order_header_add[customer]'] + ul").remove();

    return null;
}

function clearCustomerForm()
{
    $("input[name*='order_header_add[customer]']").val('').change();
    $("select[name*='order_header_add[customer]']").val('').change();
    $("textarea[name*='order_header_add[customer]']").val('').change();
    $('#order_header_add_customer_mobile_phone1').val('+48');
    $('#order_header_add_customer_mobile_phone2').val('+48');
    $('#customer-form .div-form-labels input[type=hidden]').remove();
    $('#customer-form .div-form-labels button.active').removeClass('active');

    return null;
}