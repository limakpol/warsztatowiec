$(document).ready(function()
{
    $(document).on('click', '#vehicle_car_brand', function(){
        $('#selectable-brand .content').slideDown();
    });

    $(document).on('dblclick', '#vehicle_car_brand', function(){
        $('#selectable-brand .content').slideUp();
    });

    $(document).on('click', '#vehicle_car_model', function(){

        var brandName = $('#vehicle_car_brand').val();

        if(brandName == '') return;

        getModels(brandName);

        $('#selectable-model .content').slideDown();
        $('#selectable-brand .content').slideUp();
    });

    $(document).on('dblclick', '#vehicle_car_model', function(){
        $('#selectable-model .content').slideUp();
    });

    $(document).on('click', '#selectable-brand .content div', function(){

        var brandName = $(this).text();

        $('#vehicle_car_brand').val(brandName);

        $('#selectable-brand .content').slideUp();

        getModels(brandName);

        $('#selectable-model .content').slideDown();
    });

    $(document).on('click', '#selectable-model .content div', function(){

        var modelName = $(this).text();

        $('#vehicle_car_model').val(modelName);

        $('#selectable-brand .content').slideUp();
        $('#selectable-model .content').slideUp();
    });

    var globalTimeout = null;
    $(document).on('keyup', '#vehicle_car_brand', function()
    {
        if(globalTimeout != null)
        {
            clearTimeout(globalTimeout);
        }

        globalTimeout = setTimeout(function()
        {
            globalTimeout = null;

            var brandName = $('#vehicle_car_brand').val();

            getModels(brandName);

        }, 1000);
    });

    $(document).on('keyup', '#vehicle_engine_displacement_l', function()
    {

        $('#vehicle_engine_displacement_l + ul').remove();

        var ed = parseFloat($('#vehicle_engine_displacement_l').val().replace(",", "."));

        if(ed == '') return;

        if(ed < 0.5 || (ed > 20 && ed < 500) || ed > 20000)
        {
            $('label[for="vehicle_engine_displacement_l"]').text('Pojemność silnika');
            $('#vehicle_engine_displacement_l').after('<ul><li>Błędna wartość</li></ul>');
        }
        else
        {
            if(ed < 50)
            {
                $('label[for="vehicle_engine_displacement_l"]').text('Pojemność silnika [l]');
            }
            else
            {
                $('label[for="vehicle_engine_displacement_l"]').text('Pojemność silnika [cm3]');
            }
        }
    });
});

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