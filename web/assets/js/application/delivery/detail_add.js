$(document).ready(function()
{

    /* PRODUCER */
    $('#delivery_detail_add_indexx_producer option:first-child').after('<option value="new">-- nowy --</option>');

    $(document).on('change', '#delivery_detail_add_indexx_producer', function()
    {
        $('#delivery_detail_add_indexx_producer + ul').remove();

        if($(this).find('option:selected').val() == 'new')
        {
            $('#new-producer').slideDown();

            $('#new-producer input').focus();
        }
        else
        {
            $('#new-producer').slideUp();
        }
    });

    $(document).on('click', '#new-producer .btn-add', function(event)
    {
        event.preventDefault();

        var name = $('#new-producer input').val();

        if(!name) return;

        $.ajax({
            type: "POST",
            url: "/ajax/producer-add",
            data: {
                name: name,
            },
            success: function(data) {
                if(!data['errors'])
                {
                    var option = '<option value="' + data['producerId'] + '">' + data['producerName'] + '</option>';

                    $('#delivery_detail_add_indexx_producer option:nth-child(2)').after(option);

                    $('#delivery_detail_add_indexx_producer').val(data['producerId']).change();
                }
            }
        });
    });


    /* GOOD */
    $(document).on('click', '#searchable-good > input', function()
    {
        $('#searchable-good > div').slideDown();
    });

    $(document).on('keyup', '#searchable-good > input', function()
    {
        $('#searchable-good > div').slideDown();
    });

    $(document).on('dblclick', '#searchable-good > input', function()
    {
        $('#searchable-good > div').slideUp();
    });

    $(document).on('click', '#searchable-good .prev', function(event){
        event.preventDefault();

        var sortableParameters = getGoodSortableParameters();
        sortableParameters.requestedPage = 0;
        goodRequest(sortableParameters);
    });

    $(document).on('click', '#searchable-good .next', function(event){
        event.preventDefault();

        var sortableParameters = getGoodSortableParameters();
        sortableParameters.requestedPage = 2;
        goodRequest(sortableParameters);
    });

    $(document).on('click', '#searchable-good th.sort-column', function(){
        var sortableParameters = getGoodSortableParameters();

        sortableParameters.sortColumnName = $(this).data('column');

        var sortOrder = $('#searchable-good footer .sortOrder').val();
        if(sortOrder == 'DESC')
        {
            sortOrder = 'ASC';
        }
        else
        {
            sortOrder = 'DESC';
        }

        sortableParameters.sortOrder = sortOrder;

        goodRequest(sortableParameters);
    });

    var globalTimeout = null;
    $(document).on('keyup', '#searchable-good > input', function()
    {
        if(globalTimeout != null)
        {
            clearTimeout(globalTimeout);
        }

        globalTimeout = setTimeout(function()
        {
            globalTimeout = null;

            var sortableParameters = getGoodSortableParameters();
            goodRequest(sortableParameters);

        }, 1000);
    });


    $(document).on('click', '#good-new', function()
    {
        $('#delivery_detail_add_indexx_good_name').focus();

        removeGoodErrors();
        clearGoodForm();

        $('.h-enum.selected-good').text('2. Wpisz dane nowego towaru');

        $('#delivery_detail_add_indexx_good_id').val('');

        $('#searchable-good > div').slideUp();

        var indexxSortableParameters = getIndexxSortableParameters();
        indexxRequest(indexxSortableParameters);

        var goodSortableParameters = getGoodSortableParameters();
        goodRequest(goodSortableParameters);
    });

    $(document).on('click', '#searchable-good tr:not(:first-child)', function()
    {
        var goodId = $(this).data('id');

        $.ajax({
            type: "POST",
            url: "/warehouse/get-one-good",
            data: {
                goodId: goodId,
            },
            success: function(data)
            {
                removeGoodErrors();
                clearGoodForm();

                $('.h-enum.selected-good').text('2. Możesz przejrzeć lub zmienić dane towaru');

                $('#delivery_detail_add_indexx_good_id').val(data[0].id);
                $('#delivery_detail_add_indexx_good_name').val(data[0].name);
                $('#delivery_detail_add_indexx_good_measure').val(data[0].measure_id);
                $('#delivery_detail_add_indexx_good_quantity').val(data[0].quantity);
                $('#delivery_detail_add_indexx_good_remarks').val(data[0].remarks);

                $('#categories-form-selectable-modal .content .names').html('');
                $('#categories-form-selectable-modal .content .ids').html('');

                data[1].forEach(function(category)
                {
                    var input = '<input type="hidden" ' +
                        'name="delivery_detail_add[indexx][good][categories][]" ' +
                        'value="' + category[0] + '">';

                    var label = '<label>' +  category[1] + '</label>';

                    $('#categories-form-selectable-modal .content .names').append(label);
                    $('#categories-form-selectable-modal .content .ids').append(input);
                });

                data[2].forEach(function(carModel)
                {
                    var input = '<input type="hidden" ' +
                        'name="delivery_detail_add[indexx][good][car_models][]" ' +
                        'value="' + carModel[0] + '">';

                    var label = '<label>' +  carModel[1] + '</label>';

                    $('#models-form-selectable-modal .content .names').append(label);
                    $('#models-form-selectable-modal .content .ids').append(input);
                });

                $('#searchable-good > div').slideUp();

                var indexxSortableParameters = getIndexxSortableParameters();
                indexxSortableParameters.filterGoodIds = [goodId];
                indexxRequest(indexxSortableParameters);
            }
        });
    });

    
    /* INDEXX */

    $(document).on('click', '#searchable-indexx > input', function()
    {
        $('#searchable-indexx > div').slideDown();
    });

    $(document).on('keyup', '#searchable-indexx > input', function()
    {
        $('#searchable-indexx > div').slideDown();
    });

    $(document).on('dblclick', '#searchable-indexx > input', function()
    {
        $('#searchable-indexx > div').slideUp();
    });

    $(document).on('click', '#searchable-indexx .prev', function(event){
        event.preventDefault();

        var sortableParameters = getIndexxSortableParameters();
        sortableParameters.requestedPage = 0;

        indexxRequest(sortableParameters);
    });

    $(document).on('click', '#searchable-indexx .next', function(event){
        event.preventDefault();

        var sortableParameters = getIndexxSortableParameters();
        sortableParameters.requestedPage = 2;

        indexxRequest(sortableParameters);
    });

    $(document).on('click', '#searchable-indexx th.sort-column', function(){
        var sortableParameters = getIndexxSortableParameters();

        sortableParameters.sortColumnName = $(this).data('column');

        var sortOrder = $('#searchable-indexx footer .sortOrder').val();

        if(sortOrder == 'DESC')
        {
            sortOrder = 'ASC';
        }
        else
        {
            sortOrder = 'DESC';
        }

        sortableParameters.sortOrder = sortOrder;

        indexxRequest(sortableParameters);
    });

    $(document).on('keyup', '#searchable-indexx > input', function()
    {
        if(globalTimeout != null)
        {
            clearTimeout(globalTimeout);
        }

        globalTimeout = setTimeout(function()
        {
            globalTimeout = null;

            var sortableParameters = getIndexxSortableParameters();
            indexxRequest(sortableParameters);

        }, 1000);
    });

    $(document).on('click', '#indexx-new', function()
    {
        $('#delivery_detail_add_indexx_name').focus();

        removeIndexxErrors();
        clearIndexxForm();

        $('.h-enum.selected-good').text('4. Wpisz dane nowego indeksu');

        $('#delivery_detail_add_indexx_id').val('');

        $('#searchable-indexx > div').slideUp();

        var goodSortableParameters = getGoodSortableParameters();
        goodRequest(goodSortableParameters);

        var indexxSortableParameters = getIndexxSortableParameters();
        indexxRequest(indexxSortableParameters);
    });

    $(document).on('click', '#searchable-indexx tr:not(:first-child)', function()
    {
        var indexxId = $(this).data('id');

        $.ajax({
            type: "POST",
            url: "/warehouse/get-one-indexx",
            data: {
                indexxId: indexxId,
            },
            success: function(data)
            {
                removeIndexxErrors();
                clearIndexxForm();

                $('.h-enum.selected-indexx').text('4. Możesz przejrzeć lub zmienić dane indeksu');

                $('#delivery_detail_add_indexx_id').val(data.id);
                $('#delivery_detail_add_indexx_name').val(data.name);
                $('#delivery_detail_add_indexx_producer').val(data.producer_id);
                $('#delivery_detail_add_indexx_quantity').val(data.quantity);
                $('#delivery_detail_add_indexx_unit_price_net').val(data.unit_price_net);
                $('#delivery_detail_add_unit_price_net').val(data.unit_price_net);

                $('#searchable-indexx > div').slideUp();

                var goodSortableParameters = getGoodSortableParameters();
                goodSortableParameters.filterIndexxIds = [indexxId];
                goodRequest(goodSortableParameters);

                var measureShortcut = $('#delivery_detail_add_indexx_good_measure option:selected').data('shortcut');

                $('label[for=delivery_detail_add_quantity]').text('Ilość [' + measureShortcut + ']');

                getLastPrices(indexxId);
            }
        });

    });

    /* CATEGORIES */

    $(document).on('click', '.selectable-modal header i', function()
    {
        $('.selectable-modal').remove();
    });

    $(document).on('click', '#categories-form-selectable-modal .btn-choose', function(event)
    {
        event.preventDefault();

        $.ajax({
            type: "POST",
            url: "/warehouse/selectable/get-categories",
            success: function(data) {
                if(!data['error'])
                {
                    $('.selectable-modal').remove();

                    var modal = '<div id="categories-selectable-modal" class="selectable-modal"></div>';

                    $('main.section-inner').before(modal);

                    $('#categories-selectable-modal').html(data);

                    var selectedInputs = $('#categories-form-selectable-modal .ids input');
                    var categoryLis = $('#categories-selectable-modal main ul li');

                    selectedInputs.each(function()
                    {
                        var selectedId = $(this).val();

                        categoryLis.each(function()
                        {
                            if($(this).find('label').data('id') == selectedId)
                            {
                                $(this).addClass('active');
                            }
                        });

                    });
                }
            },
        });
    });

    $(document).on('click', '#categories-selectable-modal main li', function()
    {
        var li = $(this);

        if(li.hasClass('active'))
        {
            li.removeClass('active');
        }
        else
        {
            li.addClass('active');
        }
    });

    $(document).on('click', '#categories-selectable-modal footer .btn-save', function()
    {
        var selectedLabels = $('#categories-selectable-modal main li.active label');

        $('#categories-form-selectable-modal .content .names').html('');
        $('#categories-form-selectable-modal .content .ids').html('');

        selectedLabels.each(function()
        {
            var input = '<input type="hidden" ' +
                'name="delivery_detail_add[indexx][good][categories][]" ' +
                'value="' +  $(this).data('id') + '">';

            var label = '<label>' +  $(this).text() + '</label>';

            $('#categories-form-selectable-modal .content .names').append(label);
            $('#categories-form-selectable-modal .content .ids').append(input);

        });

        $('#categories-selectable-modal').remove();
    });

    $(document).on('click', '#categories-selectable-modal main ul .addable .btn-add.active', function()
    {
        $(this).removeClass('active');
        $('.selectable-modal main ul .addable div').hide(400);

        var name = $('.selectable-modal main ul .addable div input').val();

        if(!name) return;

        var goodId = $('#delivery_detail_add_indexx_good_id').val();

        var url = $('#add-category-path').val();

        $.ajax({
            type: "POST",
            url: url,
            data: {
                name: name,
                goodId: goodId,
            },
            success: function(data) {
                $('#categories-selectable-modal').html(data);
            }
        });
    });

    /* MODELS */

    $(document).on('click', '.selectable-modal header i', function()
    {
        $('.selectable-modal').remove();
    });

    $(document).on('click', '#models-form-selectable-modal .btn-choose', function(event)
    {
        event.preventDefault();

        $.ajax({
            type: "POST",
            url: "/warehouse/selectable/get-models",
            success: function(data) {
                if(!data['error'])
                {
                    $('.selectable-modal').remove();

                    var modal = '<div id="models-selectable-modal" class="selectable-modal"></div>';

                    $('main.section-inner').before(modal);

                    $('#models-selectable-modal').html(data);

                    var selectedInputs = $('#models-form-selectable-modal .ids input');
                    var modelLis = $('#models-selectable-modal main ul li');

                    selectedInputs.each(function()
                    {
                        var selectedId = $(this).val();

                        modelLis.each(function()
                        {
                            if($(this).find('label').data('id') == selectedId)
                            {
                                $(this).addClass('active');
                            }
                        });

                    });
                }
            },
        });
    });

    $(document).on('click', '#models-selectable-modal main li', function()
    {
        var li = $(this);

        if(li.hasClass('active'))
        {
            li.removeClass('active');
        }
        else
        {
            li.addClass('active');
        }
    });

    $(document).on('click', '#models-selectable-modal footer .btn-save', function()
    {
        var selectedLabels = $('#models-selectable-modal main li.active label');

        $('#models-form-selectable-modal .content .names').html('');
        $('#models-form-selectable-modal .content .ids').html('');

        selectedLabels.each(function()
        {
            var input = '<input type="hidden" ' +
                'name="delivery_detail_add[indexx][good][car_models][]" ' +
                'value="' +  $(this).data('id') + '">';

            var label = '<label>' +  $(this).text() + '</label>';

            $('#models-form-selectable-modal .content .names').append(label);
            $('#models-form-selectable-modal .content .ids').append(input);

        });

        $('#models-selectable-modal').remove();
    });

    $(document).on('click', '#models-selectable-modal main ul .addable .btn-add.active', function()
    {
        $(this).removeClass('active');
        $('.selectable-modal main ul .addable div').hide(400);

        var brand = $('.selectable-modal main ul .addable div input:first-child').val();
        var model = $('.selectable-modal main ul .addable div input:last-child').val();

        if(!brand || !model) return;

        var goodId = $('#delivery_detail_add_indexx_good_id').val();

        var url = $('#add-car-model-path').val();

        $.ajax({
            type: "POST",
            url: url,
            data: {
                brand: brand,
                model: model,
                goodId: goodId,
            },
            success: function(data) {
                $('#models-selectable-modal').html(data);
            }
        });
    });

});
/* FUNTIONS - GOOD */

function getGoodSortableParameters()
{
    var filterCategoryIds = [];
    var filterModelIds = [];
    var filterIndexxIds = [];

    sortableParameters = {
        "search": $('#searchable-good > input').val(),
        "limit": 15,
        "sortColumnName": $('#searchable-good footer .sortColumnName').val(),
        "sortOrder": $('#searchable-good footer .sortOrder').val(),
        "currentPage": $('#searchable-good footer .currentPage').val(),
        "requestedPage": 1,
        "filterCategoryIds": filterCategoryIds,
        "filterModelIds": filterModelIds,
        "filterIndexxIds": filterIndexxIds,
    };

    return sortableParameters;
}
function goodRequest(sortableParameters)
{
    $.ajax({
        type: "POST",
        url: $('#searchable-good footer .retrievePath').val(),
        data: {
            sortableParameters: JSON.stringify(sortableParameters)
        },
        success: function(data)
        {
            if(!data['error'])
            {
                $('#searchable-good > div').html(data);
            }
        }
    });
}
function removeGoodErrors()
{
    $("input[name*='delivery_detail_add[indexx][good]'] + ul").remove();
    $("select[name*='delivery_detail_add[indexx][good]'] + ul").remove();
    $("textarea[name*='delivery_detail_add[indexx][good]'] + ul").remove();

    return null;
}

function clearGoodForm()
{
    $("input[name*='delivery_detail_add[indexx][good]']").val('').change();
    $("select[name*='delivery_detail_add[indexx][good]']").val('').change();
    $("textarea[name*='delivery_detail_add[indexx][good]']").val('').change();

    $('#categories-form-selectable-modal .names').html('');
    $('#categories-form-selectable-modal .ids').html('');

    $('#models-form-selectable-modal .names').html('');
    $('#models-form-selectable-modal .ids').html('');

    return null;
}
/* FUNCTIONS - INDEXX */
function indexxRequest(sortableParameters)
{
    $.ajax({
        type: "POST",
        url: $('#searchable-indexx footer .retrievePath').val(),
        data: {
            sortableParameters: JSON.stringify(sortableParameters)
        },
        success: function(data)
        {
            if(!data['error'])
            {
                $('#searchable-indexx > div').html(data);
            }
        }
    });
}
function getIndexxSortableParameters()
{
    var filterGoodIds = [];

    sortableParameters = {
        "search": $('#searchable-indexx > input').val(),
        "limit": 15,
        "sortColumnName": $('#searchable-indexx footer .sortColumnName').val(),
        "sortOrder": $('#searchable-indexx footer .sortOrder').val(),
        "currentPage": $('#searchable-indexx footer .currentPage').val(),
        "requestedPage": 1,
        "filterGoodIds": filterGoodIds,
    };

    return sortableParameters;
}
function removeIndexxErrors()
{
    $('#delivery_detail_add_indexx_name + ul').remove();
    $('#delivery_detail_add_indexx_producer + ul').remove();
    $('#delivery_detail_add_indexx_quantity + ul').remove();
    $('#delivery_detail_add_indexx_unit_price_net + ul').remove();

    return null;
}

function clearIndexxForm()
{
    $('#delivery_detail_add_indexx_name').val('').change();
    $('#delivery_detail_add_indexx_producer').val('').change();
    $('#delivery_detail_add_indexx_quantity').val('').change();
    $('#delivery_detail_add_indexx_unit_price_net').val('').change();

    return null;
}

function getLastPrices(indexxId)
{
    $.ajax({
        type: "POST",
        url: "/warehouse/get-last-prices",
        data: {
            indexxId: indexxId,
        },
        success: function(data)
        {
          $('.last-prices').html(data);
        }
    });
}