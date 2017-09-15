$(document).ready(function()
{
    $(document).on('click', '.form-options', function()
    {
        console.log('dfdsf');
        $('#registration_user_forename').val('Jan');
        $('#registration_user_surname').val('Kowalski');
        $('#registration_workshop_name').val('Przykładowy Warsztat');
        $('#registration_user_email').val('jan.kowalski@warsztatowiec.pl');
    });
});

