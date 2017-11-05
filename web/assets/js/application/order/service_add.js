$(document).ready(function() {
    /* SERVICE */

    $(document).on('click', '#searchable-service > input', function () {
        $('#searchable-service > div').slideDown();
    });

    $(document).on('keyup', '#searchable-service > input', function () {
        $('#searchable-service > div').slideDown();
    });

    $(document).on('dblclick', '#searchable-service > input', function () {

        $('#searchable-service > div').slideUp();
    });

    $(document).on('click', '#searchable-service .prev', function (event) {
        event.preventDefault();

        var sortableParameters = getServiceSortableParameters();
        sortableParameters.requestedPage = 0;

        serviceRequest(sortableParameters);
    });

    $(document).on('click', '#searchable-service .next', function (event) {
        event.preventDefault();

        var sortableParameters = getServiceSortableParameters();
        sortableParameters.requestedPage = 2;

        serviceRequest(sortableParameters);
    });

    $(document).on('click', '#searchable-service th.sort-column', function () {
        var sortableParameters = getServiceSortableParameters();

        sortableParameters.sortColumnName = $(this).data('column');

        var sortOrder = $('#searchable-service footer .sortOrder').val();
        if (sortOrder == 'DESC') {
            sortOrder = 'ASC';
        }
        else {
            sortOrder = 'DESC';
        }

        sortableParameters.sortOrder = sortOrder;

        serviceRequest(sortableParameters);
    });

    var globalTimeout = null;
    $(document).on('keyup', '#searchable-service > input', function () {
        if (globalTimeout != null) {
            clearTimeout(globalTimeout);
        }

        globalTimeout = setTimeout(function () {
            globalTimeout = null;

            var sortableParameters = getServiceSortableParameters();
            serviceRequest(sortableParameters);

        }, 1000);
    });

    $(document).on('click', '#service-new', function () {
        $('#order_header_add_service_forename').focus();

        clearServiceForm();

        removeServiceErrors();

        $('.h-enum.selected-service').text('2. Wpisz dane nowej usługi');

        $('#order_service_service_id').val('');

        $('#searchable-service > div').slideUp();

    });

    $(document).on('click', '#searchable-service tr:not(:first-child)', function () {
        
        var serviceId = $(this).data('id');

        $.ajax({
            type: "POST",
            url: "/service/get-one/2",
            data: {
                id: serviceId,
            },
            success: function (data) {
                if (data.error > 0) {

                }
                else {
                    clearServiceForm();
                    removeServiceErrors();
                    for (value in data) {
                        var cssId = '#order_service_service_' + value;

                        $(cssId).val(data[value]).change();
                    }
                    $('#order_service_service_measure').val(data['measure_id']).change();

                    $('.h-enum.selected-service').text('2. Możesz przejrzeć i zmienić dane usługi');

                    $('#searchable-service > div').slideUp();

                }
            }
        });
    });

    $(document).on('click', '.service-btn-filter-custom', function (event) {
        event.preventDefault();

        var button = $(this);

        if (button.hasClass('active')) {
            $('input[class="groupp"][type=hidden][value="' + button.text() + '"]').remove();
            button.removeClass('active');
        }
        else {
            var input = '<input class="groupp" type="hidden" name="order_header_add[service][groupps][' + button.data('id') + '][name]" required="required" value="' + button.text() + '">';

            button.after(input);
            button.addClass('active');
        }
    });

    $(document).on('keypress', '.input-label-add', function (event) {

        if (event.which == 13) {
            event.preventDefault();

            var name = $(this).val();

            if (name == '') return;

            var buttons = $('.service-btn-filter-custom');

            var error = false;

            buttons.each(function () {
                if ($(this).text() == name) {
                    error = true;
                }
            });

            if (error) return;

            var button = '<button class="service-btn-filter-custom active">' + name + '</button>';
            var hidden = '<input class="groupp" type="hidden" name="order_header_add[service][groupps][][name]" required="required" value="' + name + '">';

            $(this).before(button);
            $(this).before(hidden);
            $(this).val('');
        }
    });
    
    /* WORKMANS */

    $(document).on('click', '.main-form .multiselect .selector', function()
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

    $(document).on('click', '.main-form .multiselect .content ul li:not(.active)', function()
    {
        $(this).addClass('active');

        var id = $(this).data('id');

        var input = '<input type="hidden" name="order_service[workmans][]" value="' + id + '">';

        $('#workmans .ids').append(input);

    });

    $(document).on('click', '.main-form .multiselect .content ul li.active', function()
    {
        $(this).removeClass('active');

        var id = $(this).data('id');

        var input = $('#workmans .ids input[value=' + id + ']');

        input.remove();
    });


});

/* FUNCTIONS - CUSTOMER */

function getServiceSortableParameters()
{

    sortableParameters = {
        "search": $('#searchable-service > input').val(),
        "limit": 15,
        "sortColumnName": $('#searchable-service footer .sortColumnName').val(),
        "sortOrder": $('#searchable-service footer .sortOrder').val(),
        "currentPage": $('#searchable-service footer .currentPage').val(),
        "requestedPage": 1,
    };

    return sortableParameters;
}

function serviceRequest(sortableParameters)
{
    $.ajax({
        type: "POST",
        url: $('#searchable-service footer .retrievePath').val(),
        data: {
            sortableParameters: JSON.stringify(sortableParameters)
        },
        success: function(data)
        {
            if(!data['error'])
            {
                $('#searchable-service > div').html(data);
            }
        }
    });
}

function removeServiceErrors()
{
    $("input[name*='order_service[service]'] + ul").remove();
    $("select[name*='order_service[service]'] + ul").remove();
    $("textarea[name*='order_service[service]'] + ul").remove();

    return null;
}

function clearServiceForm()
{
    $("input[name*='order_service[service]']").val('').change();
    $("select[name*='order_service[service]']").val('').change();
    $("textarea[name*='order_service[service]']").val('').change();

    return null;
}
