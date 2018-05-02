<!--!>FormValidator</!-->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
<link href="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/theme-default.min.css" rel="stylesheet" type="text/css" />
<h1 style="font-family: 'montserratlight', sans-serif;margin-left: 20px;">Contato</h1>
<div class="contact-container">
    <div class="contact-message">
        Preencha os campos e nos envie uma mensagem. Responderemos em X dias úteis.
    </div>
    <form method="POST" id="contactForm">
        <div class="form-group">
            <label for="name" class="form-control-label" style="display: none">Nome</label>
            <input class="form-control" name="name" id="name" placeholder="Nome" style="max-width: 400px" data-validation="required" data-validation-error-msg="Digite seu nome"/>
        </div>
        <div class="form-group">
            <label for="email" class="form-control-label" style="display: none">Email</label>
            <input class="form-control" name="email" id="email" placeholder="E-mail" style="max-width: 400px" data-validation="required email" data-validation-error-msg="Digite um E-mail válido"/>
        </div>
        <div class="form-group">
            <label for="telephone" class="form-control-label" style="display: none">Celular</label>
            <input class="form-control" name="phone" id="phone" placeholder="Telefone" style="max-width: 400px" data-validation="required" data-validation-error-msg="Digite seu Telefone"/>
        </div>
        <div class="form-group">
            <label for="subject" class="form-control-label" style="display: none">Assunto</label>
            <input class="form-control" name="subject" id="subject" placeholder="Assunto" data-validation="required" data-validation-error-msg="Digite o Assunto"/>
        </div>
        <div class="form-group">
            <label for="message" class="form-control-label" style="display: none">Mensagem</label>
            <textarea class="form-control" name="message" id="message" placeholder="Mensagem" data-validation="required" data-validation-error-msg="Digite a Mensagem" rows="6"></textarea>
        </div>
        <div class="container-notices"></div>
        <div class="form-group" style="margin: 0">
            <button type="submit" class="btn btn-lg btn-success save-contact-button"><i class="fa fa-envelope"></i> Enviar</button>
        </div>
        <div class="container-success-notice" style="margin-top: 20px"></div>
    </form>
</div>
<script src="<?php echo BASE_URL; ?>assets/js/controllers/contactPageController.js"></script>
<script>
    $(document).ready(function(){
        PageController.start();
    });
</script>