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

    $(document).on('click', '#only-recipients span', function(){

        if($('#only-recipients input').is(':checked'))
        {
            $('#only-recipients input').prop('checked', false);
        }
        else
        {
            $('#only-recipients input').prop('checked', true);
        }

        var sortableParameters = getSortableParameters();
        request(sortableParameters);
    });

    $(document).on('click', '#only-recipients input', function(){
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
        $('#sale_header_add_customer_forename').focus();

        clearCustomerForm();

        removeCustomerErrors();

        $('.h-enum.selected-customer').text('2. Wpisz dane odbiorcy');

        $('#sale_header_add_customer_id').val('new');

        $('#searchable-customer > div').slideUp();

        $('#customer-form').slideDown();

        $('#sale_header_add_customer_forename').focus();

    });

    $(document).on('click', '#customer-empty', function()
    {
        $('#sale_header_add_customer_id').val('');

        $('.h-enum.selected-customer').text('2. Wystawienie wewnętrzne (brak odbiorcy)');

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
                    clearCustomerForm();
                    for(value in data[0])
                    {
                        var cssId = '#sale_header_add_customer_' + value;

                        $(cssId).val(data[0][value]).change();
                    }

                    for(value in data[1])
                    {
                        cssId = '#sale_header_add_customer_address_' + value;

                        $(cssId).val(data[1][value]).change();
                    }

                    $('#sale_header_add_customer_address_province').val(data[1]['province_id']);

                    var buttonsLabels = $('#customer-form .div-form-labels .customer-btn-filter-custom');

                    for (var key in data[2])
                    {
                        buttonsLabels.each(function ()
                        {
                            if ($(this).text() == data[2][key])
                            {
                                $(this).addClass('active');
                                $(this).after('<input class="groupp" type="hidden" name="sale_header_add[customer][groupps][' + key + '][name]" required="required" value="' + data[2][key] + '">');
                            }
                        });
                    }
                }

            }
        });

        removeCustomerErrors();

        $('.h-enum.selected-customer').text('2. Możesz przejrzeć i zmienić dane odbiorcy');

        $('#searchable-customer > div').slideUp();

        $('#customer-form').slideDown();
    });

    $(document).on('click', '.customer-btn-filter-custom', function(event)
    {
        event.preventDefault();

        var button = $(this);

        if(button.hasClass('active'))
        {
            $('input[class="groupp"][type=hidden][value="' + button.text() + '"]').remove();
            button.removeClass('active');
        }
        else
        {
            var input = '<input class="groupp" type="hidden" name="sale_header_add[customer][groupps][' + button.data('id') + '][name]" required="required" value="' + button.text() + '">';

            button.after(input);
            button.addClass('active');
        }
    });

    $(document).on('keypress', '.input-label-add', function(event)
    {

        if(event.which == 13)
        {
            event.preventDefault();

            var name = $(this).val();

            if(name == '') return;

            var buttons = $('.customer-btn-filter-custom');

            var error = false;

            buttons.each(function()
            {
                if($(this).text() == name)
                {
                    error = true;
                }
            });

            if(error) return;

            var button = '<button class="customer-btn-filter-custom active">' + name + '</button>';
            var hidden = '<input class="groupp" type="hidden" name="sale_header_add[customer][groupps][][name]" required="required" value="' + name + '">';

            $(this).before(button);
            $(this).before(hidden);
            $(this).val('');
        }
    });

    $(document).on('change', '#sale_header_add_document_type', function(){
        var documentType = $(this).val();

        if(documentType == '')
        {
            $('#sale_header_add_document_number').val('');

            return;
        }

        $.ajax({
            type: "POST",
            url: "/sale/get-next-number",
            data: {
                documentType: documentType,
            },
            success: function(data)
            {
                if(data['error'] == 0)
                {
                    $('#sale_header_add_document_number').val(data['documentNumber']);
                }
            }
        });
    });

});

function getSortableParameters()
{
    var systemFilters = [];
    var customFilters = [];

    if($('#only-recipients input').is(':checked'))
    {
        systemFilters = ['recipient'];
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
    $("input[name*='sale_header_add[customer]'] + ul").remove();
    $("select[name*='sale_header_add[customer]'] + ul").remove();
    $("textarea[name*='sale_header_add[customer]'] + ul").remove();

    return null;
}

function clearCustomerForm()
{
    $("input[name*='sale_header_add[customer]']").val('').change();
    $("select[name*='sale_header_add[customer]']").val('').change();
    $("textarea[name*='sale_header_add[customer]']").val('').change();
    $('#sale_header_add_customer_mobile_phone1').val('+48');
    $('#sale_header_add_customer_mobile_phone2').val('+48');
    $('#customer-form .div-form-labels input[type=hidden]').remove();
    $('#customer-form .div-form-labels button.active').removeClass('active');

    return null;
}