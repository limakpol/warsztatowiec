$(document).ready(function()
{
    $(document).on('input', '.input-unit-price-net', function()
    {
        update1();
    });

    $(document).on('input', '.input-quantity', function()
    {
        update1();
    });

    $(document).on('input', '.input-discount-pc', function()
    {
        update2();
    });

    $(document).on('input', '.input-vat-pc', function()
    {
        update3();
    });


    $('.trade-autocomplete').on('click', function()
    {

        $('input + ul').remove();
        $('select + ul').remove();
        $('textarea + ul').remove();

        if($(this).is(':checked'))
        {
            $('.input-total-net-before-discount').val('').attr("disabled", true);
            $('.input-discount').val('').attr("disabled", true);
            $('.input-total-net').val('').attr("disabled", true);
            $('.input-vat').val('').attr("disabled", true);
            $('.input-total-due').val('').attr("disabled", true);
        }
        else
        {
            $('.input-total-net-before-discount').val('').removeAttr("disabled");
            $('.input-discount').val('').removeAttr("disabled");
            $('.input-total-net').val('').removeAttr("disabled");
            $('.input-vat').val('').removeAttr("disabled");
            $('.input-total-due').val('').removeAttr("disabled");
        }
    });


});



function update1()
{

    if($('.economical-autocomplete').length && !$('.economical-autocomplete').is(':checked'))
    {
        return;
    }

    var unitPriceNet = parseFloat(removeComma($('.input-unit-price-net').val()));
    var quantity = parseFloat(removeComma($('.input-quantity').val()));

    if(!isNaN(unitPriceNet) && !isNaN(quantity))
    {
        var totalNetBeforeDiscount = parseFloat(unitPriceNet * quantity);

        $('.input-total-net-before-discount').val(totalNetBeforeDiscount.toFixed(2));

        var discountPc = parseFloat(removeComma($('.input-discount-pc').val()))/100;

        var discount = parseFloat(totalNetBeforeDiscount * discountPc);

        $('.input-discount').val(discount.toFixed(2));

        var totalNet = parseFloat(totalNetBeforeDiscount - discount);

        $('.input-total-net').val(totalNet.toFixed(2));

        var vatPc = parseFloat(removeComma($('.input-vat-pc').val()))/100;

        var vat = parseFloat(totalNet * vatPc);

        $('.input-vat').val(vat.toFixed(2));

        var totalDue = parseFloat(totalNet + vat);

        $('.input-total-due').val(totalDue.toFixed(2));

    }
    else
    {
        $('.input-total-net-before-discount').val('');
        $('.input-discount').val('');
        $('.input-total-net').val('');
        $('.input-vat').val('');
        $('.input-total-due').val('');
    }
}

function update2()
{
    if($('.economical-autocomplete').length && !$('.economical-autocomplete').is(':checked'))
    {
        return;
    }

    var discountPc = max100(parseFloat(removeComma($('.input-discount-pc').val())))/100;

    if(!isNaN(discountPc))
    {
        var totalNetBeforeDiscount = parseFloat($('.input-total-net-before-discount').val());

        var discount = parseFloat(totalNetBeforeDiscount * discountPc);

        $('.input-discount').val(discount.toFixed(2));

        var totalNet = parseFloat(totalNetBeforeDiscount - discount);

        $('.input-total-net').val(totalNet.toFixed(2));

        var vatPc = max100(parseFloat(removeComma($('.input-vat-pc').val())))/100;

        var vat = parseFloat(totalNet*vatPc);

        $('.input-vat').val(vat.toFixed(2));

        var totalDue = parseFloat(totalNet + vat);

        $('.input-total-due').val(totalDue.toFixed(2));

    }
    else
    {
        $('.input-total-net').val('');
        $('.input-vat').val('');
        $('.input-total-due').val('');
    }
}

function update3()
{
    if($('.economical-autocomplete').length && !$('.economical-autocomplete').is(':checked'))
    {
        return;
    }

    var vatPc = parseFloat(removeComma($('.input-vat-pc').val()))/100;

    if(!isNaN(vatPc))
    {
        var totalNet = parseFloat($('.input-total-net').val());

        var vat = parseFloat(totalNet*vatPc);

        $('.input-vat').val(vat.toFixed(2));

        var totalDue = parseFloat(totalNet + vat);

        $('.input-total-due').val(totalDue.toFixed(2));

    }
    else
    {
        $('.input-vat').val('');
        $('.input-total-due').val('');
    }
}

function removeComma(str)
{
    return str.replace(",", ".");
}

function max100(num)
{
    if(num >= 100) return 100;
    else return num;
}