$(function(){
    setTimeout(function(){
        $(".notification").slideUp();
    }, 8000);

    $('.filterarea').find('input').on('change', function () {
        $('.filterarea form').submit();
    });
    $('.filterarea').find('select').on('change', function () {
        $('.filterarea form').submit();
    });
});

function limpar() {
    var input = $("#image");
    input.replaceWith(input.val('').clone(true));
    location.reload();
}

function validateFilters(){
    if(parseFloat($('#precoMin').val()) > parseFloat($('#precoMax').val())){
        msg = 'O mínimo deve ser menor que o máximo.';
        $("#retorno").slideDown().html(msg);
        return false;
    }else{
        return true;
    }
}