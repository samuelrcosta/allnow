<div class="card">
    <div class="card-header bg-light">
        Editar Área
    </div>

    <div class="card-body">
        <a href="<?php echo BASE_URL; ?>areasCMS" class="btn btn-primary" style="margin-bottom: 20px;"><i class="icon icon-arrow-left-circle"></i>&nbsp;Voltar</a>
        <form method="POST" id="edit">
            <div class="form-group">
                <label for="name" class="form-control-label">Nome da Área</label>
                <input class="form-control" name="name" id="name" style="max-width: 400px" data-validation="required" data-validation-error-msg="Digite uma área" value="<?php echo $areaData['name']; ?>"/>
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
        form : '#edit'
    });
</script>