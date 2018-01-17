<div class="container" style="margin-top: 30px;margin-bottom: 30px">
    <form method="POST" style="margin: auto;margin-top: 20px;max-width: 450px" id="recoverPassword">
        <h1>Recupere sua senha</h1>
        <div style="margin-top: 30px" class="form-group">
            <label for="nome" style="display: none"><span>*</span> E-mail cadastrado</label>
            <input data-validation="email" data-validation-error-msg="Digite o e-mail cadastrado" type="text" name="email" id="email" class="form-control" placeholder="Digite seu E-mail" value="<?php echo(isset($email))?$email:''; ?>">
        </div>
        <?php
        if(!empty($notice)){
            echo $notice;
        }
        ?>
        <input type="submit" value="Enviar" class="btn btn-primary" style="cursor: pointer">
    </form>
</div>
<script>
    $.validate({
        form : '#recoverPassword'
    });
</script>