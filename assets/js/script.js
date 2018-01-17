$(function(){
    setTimeout(function(){
        $(".notification").slideUp();
    }, 8000);
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