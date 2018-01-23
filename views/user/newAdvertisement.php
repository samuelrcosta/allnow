<div class="container">
    <h1>Novo anúncio</h1>
    <form method="POST" id="register">
        <a href="<?php echo BASE_URL; ?>user/advertisements" class="btn btn-primary" style="margin-bottom: 20px;"><i class="icon icon-arrow-left-circle"></i>&nbsp;Voltar</a>
        <div class="form-group">
            <label for="title" class="form-control-label">Título do Anúncio</label>
            <input class="form-control" name="title" id="title" style="max-width: 400px" data-validation="required" data-validation-error-msg="Digite um título" value="<?php echo(isset($adtitle))?$adtitle:''; ?>"/>
        </div>
        <div class="form-group">
            <label for="id_category" class="form-control-label">Categoria Principal</label>
            <select class="form-control" name="id_category" id="id_category" style="max-width: 400px" data-validation="required" data-validation-error-msg="Selecione uma Categoria">
                <option></option>
                <?php foreach ($categoryData as $category): ?>
                    <option <?php echo (isset($id_category) && $id_category == $category['id'])?'selected="selected"':''; ?> value="<?php echo $category['id'] ?>"><?php echo $category['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="id_subcategory" class="form-control-label">Sub-Categoria</label>
            <select class="form-control" name="id_subcategory" id="id_subcategory" style="max-width: 400px" data-validation="required" data-validation-error-msg="Selecione uma Sub-Categoria">
                <?php if(isset($id_subcategory)): ?>
                    <?php foreach ($subcategories as $subcategory): ?>
                        <option <?php echo(isset($id_subcategory) && $id_subcategory == $subcategory['id'])?'selected="selected"':''; ?> value="<?php echo $subcategory['id']; ?>"><?php echo $subcategory['name']; ?></option>
                    <?php endforeach; ?>
                <?php else: ?>
                    <option value="">-- Escolha uma categoria Principal --</option>
                <?php endif; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="abstract" class="form-control-label">Resumo do Anúncio</label>
            <textarea class="form-control" name="abstract" id="abstract" data-validation="required" data-validation-error-msg="Digite um resumo para o anúncio"><?php echo(isset($abstract))?$abstract:''; ?></textarea>
        </div>
        <div class="form-group">
            <label for="media_type" class="form-control-label">Tipo de Mídia</label>
            <select class="form-control" name="media_type" id="media_type" style="max-width: 400px" data-validation="required" data-validation-error-msg="Selecione o tipo da mídia">
                <option value=""></option>
                <option value="1" <?php echo(isset($media_type) && $media_type == 1)?'selected="selected"':''; ?>>Youtube</option>
                <option value="2" <?php echo(isset($media_type) && $media_type == 2)?'selected="selected"':''; ?>>Vimeo</option>
                <option value="3" <?php echo(isset($media_type) && $media_type == 3)?'selected="selected"':''; ?>>Imagem</option>
            </select>
        </div>
        <div class="form-group">
            <label for="media" class="form-control-label">Link da Mídia</label>
            <input class="form-control" name="media_link" id="media_link" style="max-width: 400px" data-validation="url" data-validation-error-msg="Insira o link de uma mídia" value="<?php echo(isset($media_link))?$media_link:''; ?>"/>
        </div>
        <div class="form-group">
            <label for="description" class="form-control-label">Descrição</label>
            <textarea class="form-control" name="description" id="description" data-validation="required" data-validation-error-msg="Digite a descrição"><?php echo(isset($description))?$description:''; ?></textarea>
        </div>
        <?php if(!empty($notice)):?>
            <?php echo $notice ?>
        <?php endif; ?>
        <div class="form-group">
            <input class="btn btn-success" type="submit" value="Salvar" />
        </div>
    </form>
</div>
<script src="<?php echo BASE_URL ?>vendor/ckeditor/ckeditor.js"></script>
<script>
    $.validate({
        form : '#register'
    });

    //CKEDITOR
    CKEDITOR.replace( 'description' );

    $(function(){
        $('#id_category').change(function(){
            if( $(this).val() ) {
                $('#id_subcategory').html('<option value="">Carregando</option>');
                $.getJSON('<?php echo BASE_URL ?>categories/getSubcategories/' + btoa(btoa(($(this).val()))), function(j){
                    var options = '<option value=""></option>';
                    for (var i = 0; i < j.length; i++) {
                        options += '<option value="' + j[i].id + '">' + j[i].name + '</option>';
                    }
                    $('#id_subcategory').html(options);
                    //$('.carregando').hide();
                });
            } else {
                $('#id_subcategory').html('<option value="">-- Escolha uma categoria Principal --</option>');
            }
        });
    });
</script>