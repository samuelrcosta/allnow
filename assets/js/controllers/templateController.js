const TemplateController = {

    INSCRIBE_FORM: '.inscribeForm',
    INSCRIBE_BUTTON: '.inscribe-button',
    INSCRIBE_INPUT: '.inscribe-email',

    _listeners: function _listeners(){
        $(TemplateController.INSCRIBE_FORM).on('keyup keypress', function(event){
            if(event.keyCode === 13) {
                event.preventDefault();
                PageController._subscribe();
                return false;
            }
        });

        $(TemplateController.INSCRIBE_BUTTON).click(function(){
            let $input = $(this).parent().find('input');
            TemplateController._subscribe($(this), $input);
        });
    },

    _subscribe: function _subscribe($button, $input) {
        let email = $input.val();
        console.log(email);
        if(email !== ''){
            $.ajax({
                url: BASE_URL + 'home/inscribeRegister',
                type: 'POST',
                data: {'email': email},
                beforeSend: function() {
                    if($button.attr('data-type') === 'footer'){
                        $button.attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Aguarde');
                    }else{
                        $button.attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
                    }
                },
                success: function(result){
                    result = JSON.parse(result);
                    if(result.status === 'subscribed'){
                        if($button.attr('data-type') === 'footer') {
                            $button.html('<i class="fa fa-check"></i> Inscrito!').css("background-color", "#28a745");
                        }else{
                            $button.html('<i class="fa fa-check"></i>').css("background-color", "#28a745");
                        }
                        $input.val('').attr("placeholder", "Inscrição feita com sucesso!");
                        $input.attr('readonly', true);
                    }else{
                        if($button.attr('data-type') === 'footer') {
                            $button.attr('disabled', false).html('Inscrever-se');
                        }else{
                            $button.attr('disabled', false).html('<i class="fa fa-envelope"></i>');
                        }
                        $input.val('').attr("placeholder", "Erro: E-mail inválido");
                    }
                }
            });
        }else{
            $input.attr("placeholder", "Digite um e-mail válido");
        }
    },

    start: function start(){
        // Activate listeners functions
        this._listeners();
    }
};