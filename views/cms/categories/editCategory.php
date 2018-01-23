<div class="card">
    <div class="card-header bg-light">
        Editar Categoria
    </div>

    <div class="card-body">
        <a href="<?php echo BASE_URL; ?>categoriesCMS" class="btn btn-primary" style="margin-bottom: 20px;"><i class="icon icon-arrow-left-circle"></i>&nbsp;Voltar</a>
        <form method="POST" id="edit">
            <div class="form-group">
                <label for="name" class="form-control-label">Nome da Categoria</label>
                <input class="form-control" name="name" id="name" style="max-width: 400px" data-validation="required" data-validation-error-msg="Digite uma categoria" value="<?php echo $categoryData['name']; ?>"/>
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <input type="checkbox" name="presential" id="presential" class="filter_brand" style="margin-right: 5px" <?php echo(isset($categoryData['presential']) && $categoryData['presential'] == 1)?'checked':''; ?>> <label for="presential">Presencial? (Habilita o filtro de cidade e estado)</label>
            </div>
            <div class="form-group">
                <input type="checkbox" name="for_user" id="for_user" class="filter_brand" style="margin-right: 5px" <?php echo(isset($categoryData['for_user']) && $categoryData['for_user'] == 1)?'checked':''; ?>> <label for="for_user">Visível para os usuários?</label>
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