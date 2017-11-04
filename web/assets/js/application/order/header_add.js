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

        $('.h-enum.selected-customer').text('2. Wpisz dane nowego klienta');

        $('#order_header_add_customer_id').val('');

        $('#searchable-customer > div').slideUp();

        $('#customer-form').slideDown();

        var vehicleSortableParameters = getVehicleSortableParameters();
        vehicleRequest(vehicleSortableParameters);

        var customerSortableParameters = getCustomerSortableParameters();
        customerRequest(customerSortableParameters);
        
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
                    removeCustomerErrors();

                    for(value in data[0])
                    {
                        var cssId = '#order_header_add_customer_' + value;

                        $(cssId).val(data[0][value]).change();
                    }

                    for(value in data[1])
                    {
                        cssId = '#order_header_add_customer_address_' + value;

                        $(cssId).val(data[1][value]).change();
                    }

                    $('#order_header_add_customer_address_province').val(data[1]['province_id']);

                    var buttonsLabels = $('#customer-form .div-form-labels .customer-btn-filter-custom');

                    for (var key in data[2])
                    {
                        buttonsLabels.each(function ()
                        {
                            if ($(this).text() == data[2][key])
                            {
                                $(this).addClass('active');
                                $(this).after('<input class="groupp" type="hidden" name="order_header_add[customer][groupps][' + key + '][name]" required="required" value="' + data[2][key] + '">');
                            }
                        });
                    }

                    $('.h-enum.selected-customer').text('2. Możesz przejrzeć i zmienić dane klienta');

                    $('#searchable-customer > div').slideUp();

                    var vehicleSortableParameters = getVehicleSortableParameters();
                    vehicleSortableParameters.systemFilters = [['customerIds', [customerId]]];
                    vehicleRequest(vehicleSortableParameters);
                }
            }
        });
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
            var input = '<input class="groupp" type="hidden" name="order_header_add[customer][groupps][' + button.data('id') + '][name]" required="required" value="' + button.text() + '">';

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
            var hidden = '<input class="groupp" type="hidden" name="order_header_add[customer][groupps][][name]" required="required" value="' + name + '">';

            $(this).before(button);
            $(this).before(hidden);
            $(this).val('');
        }
    });
    
    
    /* VEHICLE */

    $(document).on('click', '#searchable-vehicle > input', function() {
        $('#searchable-vehicle > div').slideDown();
    });

    $(document).on('keyup', '#searchable-vehicle > input', function() {
        $('#searchable-vehicle > div').slideDown();
    });

    $(document).on('dblclick', '#searchable-vehicle > input', function() {

        $('#searchable-vehicle > div').slideUp();
    });

    $(document).on('click', '#searchable-vehicle .prev', function(event){
        event.preventDefault();
        var sortableParameters = getVehicleSortableParameters();
        sortableParameters.requestedPage = 0;
        vehicleRequest(sortableParameters);
    });

    $(document).on('click', '#searchable-vehicle .next', function(event){
        event.preventDefault();
        var sortableParameters = getVehicleSortableParameters();
        sortableParameters.requestedPage = 2;
        vehicleRequest(sortableParameters);
    });

    $(document).on('click', '#searchable-vehicle th.sort-column', function(){
        var sortableParameters = getVehicleSortableParameters();

        sortableParameters.sortColumnName = $(this).data('column');

        var sortOrder = $('#searchable-vehicle footer .sortOrder').val();
        if(sortOrder == 'DESC')
        {
            sortOrder = 'ASC';
        }
        else
        {
            sortOrder = 'DESC';
        }

        sortableParameters.sortOrder = sortOrder;

        vehicleRequest(sortableParameters);
    });

    $(document).on('keyup', '#searchable-vehicle > input', function()
    {
        if(globalTimeout != null)
        {
            clearTimeout(globalTimeout);
        }

        globalTimeout = setTimeout(function()
        {
            globalTimeout = null;

            var sortableParameters = getVehicleSortableParameters();
            vehicleRequest(sortableParameters);

        }, 1000);
    });

    $(document).on('click', '#vehicle-new', function()
    {
        $('#order_header_add_vehicle_car_brand').focus();

        clearVehicleForm();

        removeVehicleErrors();

        $('.h-enum.selected-vehicle').text('4. Wpisz dane nowego pojazdu');

        $('#order_header_add_vehicle_id').val('');

        $('#searchable-vehicle > div').slideUp();

        var customerSortableParameters = getCustomerSortableParameters();
        customerRequest(customerSortableParameters);

        var vehicleSortableParameters = getVehicleSortableParameters();
        vehicleRequest(vehicleSortableParameters);

    });

    $(document).on('click', '#searchable-vehicle tr:not(:first-child)', function()
    {
        var vehicleId = $(this).data('id');

        $.ajax({
            type: "POST",
            url: "/vehicle/get-one/2",
            data: {
                vehicleId: vehicleId,
            },
            success: function(data) {
                if(data.error > 0)
                {

                }
                else
                {
                    clearVehicleForm();
                    removeVehicleErrors();

                    for(value in data[0])
                    {
                        var cssId = '#order_header_add_vehicle_' + value;

                        $(cssId).val(data[0][value]).change();
                    }

                    $('#order_header_add_vehicle_car_brand').val(data[1]);
                    $('#order_header_add_vehicle_car_model').val(data[2]);
                    
                    $('#order_header_add_vehicle_date_of_inspection_day').val(data[3][0]);
                    $('#order_header_add_vehicle_date_of_inspection_month').val(data[3][1]);
                    $('#order_header_add_vehicle_date_of_inspection_year').val(data[3][2]);

                    $('#order_header_add_vehicle_date_of_oil_change_day').val(data[4][0]);
                    $('#order_header_add_vehicle_date_of_oil_change_month').val(data[4][1]);
                    $('#order_header_add_vehicle_date_of_oil_change_year').val(data[4][2]);

                    $('.h-enum.selected-vehicle').text('4. Możesz przejrzeć i zmienić dane pojazdu');

                    $('#searchable-vehicle > div').slideUp();

                    var customerSortableParameters = getCustomerSortableParameters();
                    customerSortableParameters.systemFilters = [['vehicleIds', [vehicleId]]];
                    customerRequest(customerSortableParameters);
                }
            }
        });
    });

    $(document).on('click', '#order_header_add_vehicle_car_brand', function(){
        $('#selectable-brand .content').slideDown();
    });

    $(document).on('dblclick', '#order_header_add_vehicle_car_brand', function(){
        $('#selectable-brand .content').slideUp();
    });

    $(document).on('click', '#order_header_add_vehicle_car_model', function(){

        var brandName = $('#order_header_add_vehicle_car_brand').val();

        if(brandName == '') return;

        getModels(brandName);

        $('#selectable-model .content').slideDown();
        $('#selectable-brand .content').slideUp();
    });

    $(document).on('dblclick', '#order_header_add_vehicle_car_model', function(){
        $('#selectable-model .content').slideUp();
    });

    $(document).on('click', '#selectable-brand .content div', function(){

        var brandName = $(this).text();

        $('#order_header_add_vehicle_car_brand').val(brandName);

        $('#selectable-brand .content').slideUp();

        getModels(brandName);

        $('#selectable-model .content').slideDown();
    });

    $(document).on('click', '#selectable-model .content div', function(){

        var modelName = $(this).text();

        $('#order_header_add_vehicle_car_model').val(modelName);

        $('#selectable-brand .content').slideUp();
        $('#selectable-model .content').slideUp();
    });

    $(document).on('keyup', '#order_header_add_vehicle_car_brand', function()
    {
        if(globalTimeout != null)
        {
            clearTimeout(globalTimeout);
        }

        globalTimeout = setTimeout(function()
        {
            globalTimeout = null;

            var brandName = $('#order_header_add_vehicle_car_brand').val();

            getModels(brandName);

        }, 1000);
    });

    /* SYMPTOMS */
    $(document).on('click', '#symptoms-inputable .add input', function(event)
    {
        event.preventDefault();

        $('#symptoms-inputable .selectable .content').slideDown();
    });

    $(document).on('dblclick', '#symptoms-inputable .add input', function(event)
    {
        event.preventDefault();

        $('#symptoms-inputable .selectable .content').slideUp();
    });

    $(document).on('click', '#symptoms-inputable .add .btn-add', function(event)
    {
        event.preventDefault();

        var symptom = $('#symptoms-inputable .add input').val();

        insertSymptom(symptom);

        $('#symptoms-inputable .add .selectable input').focus();

    });

    $(document).on('keypress', '#symptoms-inputable .add input', function(event)
    {
        if(event.which == 13)
        {
            var symptom = $(this).val();

            insertSymptom(symptom);

            event.preventDefault();
        }
    });

    $(document).on('click', '#symptoms-inputable .item .btn-remove', function(event)
    {
        $(this).parent().remove();
    });

    $(document).on('click', '#symptoms-inputable .selectable .content div', function(event)
    {
        var symptom = $(this).text();

        if(symptom == '') return;

        insertSymptom(symptom);

        $('#symptoms-inputable .selectable .content').slideUp();

    });

    $(document).on('keyup', '#order_header_add_vehicle_engine_displacement_l', function()
    {

        $('#order_header_add_vehicle_engine_displacement_l + ul').remove();

        var ed = parseFloat($('#order_header_add_vehicle_engine_displacement_l').val().replace(",", "."));

        if(ed == '') return;

        if(ed < 0.5 || (ed > 20 && ed < 500) || ed > 20000)
        {
            $('label[for="order_header_add_vehicle_engine_displacement_l"]').text('Pojemność silnika');
            $('#order_header_add_vehicle_engine_displacement_l').after('<ul><li>Błędna wartość</li></ul>');
        }
        else
        {
            if(ed < 50)
            {
                $('label[for="order_header_add_vehicle_engine_displacement_l"]').text('Pojemność silnika [l]');
            }
            else
            {
                $('label[for="order_header_add_vehicle_engine_displacement_l"]').text('Pojemność silnika [cm3]');
            }
        }
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

/* FUNCTIONS - VEHICLE */

function getVehicleSortableParameters()
{
    var systemFilters = [];
    var customFilters = [];

    sortableParameters = {
        "search": $('#searchable-vehicle > input').val(),
        "limit": 15,
        "sortColumnName": $('#searchable-vehicle footer .sortColumnName').val(),
        "sortOrder": $('#searchable-vehicle footer .sortOrder').val(),
        "currentPage": $('#searchable-vehicle footer .currentPage').val(),
        "requestedPage": 1,
        "systemFilters": systemFilters,
        "customFilters": customFilters,
    };

    return sortableParameters;
}

function vehicleRequest(sortableParameters)
{
    $.ajax({
        type: "POST",
        url: $('#searchable-vehicle footer .retrievePath').val(),
        data: {
            sortableParameters: JSON.stringify(sortableParameters)
        },
        success: function(data)
        {
            if(!data['error'])
            {
                $('#searchable-vehicle > div').html(data);
            }
        }
    });
}

function removeVehicleErrors()
{
    $("input[name*='order_header_add[vehicle]'] + ul").remove();
    $("select[name*='order_header_add[vehicle]'] + ul").remove();
    $("textarea[name*='order_header_add[vehicle]'] + ul").remove();
    $('.selectable + ul').remove();

    return null;
}

function clearVehicleForm()
{
    $("input[name*='order_header_add[vehicle]']").val('').change();
    $("select[name*='order_header_add[vehicle]']").val('').change();
    $("textarea[name*='order_header_add[vehicle]']").val('').change();

    return null;
}
function getModels(brandName)
{

    $.ajax({
        type: "POST",
        url: "/vehicle/retrieve-models",
        data: {
            brandName: brandName,
        },
        success: function(data) {
            if(!data['error'])
            {
                $('#selectable-model .content').html(data);
            }
            else
            {
                $('#selectable-model .content').html('');
            }
        }
    });
}
function insertSymptom(symptom)
{
    console.log(symptom);
    if(symptom == '') return;

    var error = false;

    $('#symptoms-inputable .item input').each(function()
    {
        if($(this).val() == symptom) error = true;
    });

    if(error) return;

    var item = '<div class="item"><input type="text" maxlength="120" name="order_header_add[symptoms][][name]" value="' + symptom + '"><button class="btn-square btn-remove"><i class="fa fa-trash-o" aria-hidden="true"></i></button></div>';

    $('#symptoms-inputable .add').before(item);

    $('#symptoms-inputable .add input').val('');

    return;
}