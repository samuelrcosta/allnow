<div class="card">
    <div class="card-header bg-light">
        Editar Usuário
    </div>

    <div class="card-body">
        <a href="<?php echo BASE_URL; ?>usersCMS" class="btn btn-primary" style="margin-bottom: 20px;"><i class="icon icon-arrow-left-circle"></i>&nbsp;Voltar</a>
        <form method="POST" id="edit">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="name"><span style="color: red;font-weight: bold">*</span> Nome</label>
                        <input class="form-control" id="name" name="name" data-validation="required" data-validation-error-msg="Digite seu nome" value="<?php echo $usData['name']?>">
                    </div>
                    <div class="form-group">
                        <label for="email"><span style="color: red;font-weight: bold">*</span> E-mail</label>
                        <input class="form-control" id="email" name="email" data-validation="required email" data-validation-error-msg="Digite um e-mail válido" value="<?php echo $usData['email']?>">
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation"> Nova Senha</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>

                    <div class="form-group">
                        <label for="password"> Confirme nova senha</label>
                        <input type="password" class="form-control" id="password" name="password" data-validation="confirmation" data-validation-error-msg="Confirmação de senha inválida">
                    </div>
                    <div class="form-group">
                        <label>Caso queira alterar a senha preencha o campo, caso queira alterar apenas outras informações, deixe os campos de senha em branco.</label>
                    </div>
                </div>
            </div>
            <?php if(!empty($notice)):?>
                <?php echo $notice ?>
            <?php endif; ?>
            <div class="form-group">
                <input class="btn btn-success" type="submit" value="Salvar" />
            </div>
        </form>
    </div>
</div>
<script>
    $.validate({
        form : '#edit',
        modules: 'security'
    });
</script>