<div class="container" style="margin-top: 30px;margin-bottom: 30px">
    <form method="POST" style="margin: auto;margin-top: 20px;max-width: 450px" id="recoverPassword">
        <h1>Recuperar Senha</h1>
        <div class="form-group">
            <label for="nome" style="display: none"><span>*</span> Nova Senha</label>
            <input data-validation="required" data-validation-error-msg="Digite sua nova senha" type="password" name="password" id="password" placeholder="Nova senha" class="form-control">
        </div>
        <div class="form-group">
            <label for="nome" style="display: none"><span>*</span> Repita Nova Senha</label>
            <input data-validation="confirmation" data-validation-confirm="password" data-validation-error-msg="As duas senhas devem ser iguais" type="password" name="confirmPassword" id="confirmPassword" placeholder="Repeta Nova senha" class="form-control">
        </div>
        <?php
        if(!empty($notice)){
            echo $notice;
        }
        ?>
        <input type="submit" value="Alterar Senha" class="btn btn-primary" style="cursor: pointer">
    </form>
</div>
<script>
    $.validate({
        modules : 'security',
        form : '#recoverPassword'
    });
</script>