$(document).ready(function()
{
    $(document).on('click', '.selectable-modal main ul .addable .btn-add:not(.active)', function()
    {
        $(this).addClass('active');
        $('.selectable-modal main ul .addable div').show(400);
        $('.selectable-modal main ul .addable div').css("display", "flex");
        $('.selectable-modal main ul .addable div input:first-child').focus();

    });

});