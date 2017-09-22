function displaySuccess(submit, msg)
{
    submit.text(msg).addClass('btn-success');

    window.setTimeout(function()
    {
        submit.text('zapisz').removeClass('btn-success');
        addIcon();
    }, 1500);
}