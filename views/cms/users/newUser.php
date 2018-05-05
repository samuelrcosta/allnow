<div class="card">
    <div class="card-header bg-light">
        Novo usuário
    </div>

    <div class="card-body">
        <a href="<?php echo BASE_URL; ?>usersCMS" class="btn btn-primary" style="margin-bottom: 20px;"><i class="icon icon-arrow-left-circle"></i>&nbsp;Voltar</a>
        <form id="register">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="name"><span style="color: red;font-weight: bold">*</span> Nome</label>
                        <input class="form-control" id="name" name="name" data-validation="required" data-validation-error-msg="Digite seu nome">
                    </div>
                    <div class="form-group">
                        <label for="email"><span style="color: red;font-weight: bold">*</span> E-mail</label>
                        <input class="form-control" id="email" name="email" data-validation="required email" data-validation-error-msg="Digite um e-mail válido">
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation"><span style="color: red;font-weight: bold">*</span> Nova Senha</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>

                    <div class="form-group">
                        <label for="password"><span style="color: red;font-weight: bold">*</span> Confirme nova senha</label>
                        <input type="password" class="form-control" id="password" name="password" data-validation="confirmation" data-validation-error-msg="Confirmação de senha inválida">
                    </div>
                </div>
            </div>
            <div class="notice-container">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success" id="save-button"><i class="fas fa-save"></i> Salvar</button>
            </div>
        </form>
    </div>
</div>
<script src="<?php echo BASE_URL ?>assets/js/controllers/userRegisterController.js"></script>
<script>
    PageController.start();
</script>