<div class="card">
    <div class="card-header bg-light">
        Cadastrar Categoria
    </div>

    <div class="card-body">
        <a href="<?php echo BASE_URL; ?>categoriesCMS" class="btn btn-primary" style="margin-bottom: 20px;"><i class="icon icon-arrow-left-circle"></i>&nbsp;Voltar</a>
        <form method="POST" id="register">
            <div class="form-group">
                <label for="name" class="form-control-label">Nome da Categoria</label>
                <input class="form-control" name="name" id="name" style="max-width: 400px" data-validation="required" data-validation-error-msg="Digite uma categoria" value="<?php echo(isset($name))?$name:''; ?>"/>
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
        form : '#register'
    });
</script>