<div class="card">
    <div class="card-header bg-light">
        Editar Anúncio
    </div>

    <div class="card-body">
        <a href="<?php echo BASE_URL; ?>adminAdvertisementsCMS" class="btn btn-primary" style="margin-bottom: 20px;"><i class="icon icon-arrow-left-circle"></i>&nbsp;Voltar</a>
        <form method="POST" id="register">
            <div class="form-group">
                <label for="title" class="form-control-label">Título do Anúncio</label>
                <input class="form-control" name="title" id="title" style="max-width: 400px" data-validation="required" data-validation-error-msg="Digite um título" value="<?php echo(isset($advertisementData['title']))?$advertisementData['title']:''; ?>"/>
            </div>
            <div class="form-group">
                <label for="id_category" class="form-control-label">Categoria Principal</label>
                <select class="form-control" name="id_category" id="id_category" style="max-width: 400px" data-validation="required" data-validation-error-msg="Selecione uma Categoria">
                    <option></option>
                    <?php foreach ($categoryData as $category): ?>
                        <option <?php echo (isset($advertisementData['id_category']) && $advertisementData['id_category'] == $category['id'])?'selected="selected"':''; ?> value="<?php echo $category['id'] ?>"><?php echo $category['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="id_subcategory" class="form-control-label">Sub-Categoria</label>
                <select class="form-control" name="id_subcategory" id="id_subcategory" style="max-width: 400px" data-validation="required" data-validation-error-msg="Selecione uma Sub-Categoria">
                    <?php if(isset($advertisementData['id_subcategory'])): ?>
                        <?php foreach ($subcategoryData as $subcategory): ?>
                            <option <?php echo(isset($advertisementData['id_subcategory']) && $advertisementData['id_subcategory'] == $subcategory['id'])?'selected="selected"':''; ?> value="<?php echo $subcategory['id']; ?>"><?php echo $subcategory['name']; ?></option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="">-- Escolha uma categoria Principal --</option>
                    <?php endif; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="abstract" class="form-control-label">Resumo do Anúncio</label>
                <textarea class="form-control" name="abstract" id="abstract" data-validation="required" data-validation-error-msg="Digite um resumo para o anúncio"><?php echo(isset($advertisementData['abstract']))?$advertisementData['abstract']:''; ?></textarea>
            </div>
            <div class="form-group">
                <label for="media" class="form-control-label">Mídia (Youtube,Vimeo, Imagem)</label>
                <input class="form-control" name="media" id="media" style="max-width: 400px" data-validation="url" data-validation-error-msg="Insira o link de uma mídia" value="<?php echo(isset($advertisementData['media']))?$advertisementData['media']:''; ?>"/>
            </div>
            <div class="form-group">
                <label for="description" class="form-control-label">Descrição</label>
                <textarea class="form-control" name="description" id="description" data-validation="required" data-validation-error-msg="Digite a descrição"><?php echo(isset($advertisementData['description']))?$advertisementData['description']:''; ?></textarea>
            </div>
            <div class="form-group">
                <label for="rating" class="form-control-label">Avaliação</label>
                <select class="form-control" name="rating" id="rating" style="max-width: 400px">
                    <option value="0" <?php echo(isset($advertisementData['rating']) && $advertisementData['rating'] == 0)?'selected="selected"':''; ?>>Sem avaliação</option>
                    <option value="1" <?php echo(isset($advertisementData['rating']) && $advertisementData['rating'] == 1)?'selected="selected"':''; ?>>1 Estrela</option>
                    <option value="2" <?php echo(isset($advertisementData['rating']) && $advertisementData['rating'] == 2)?'selected="selected"':''; ?>>2 Estrelas</option>
                    <option value="3" <?php echo(isset($advertisementData['rating']) && $advertisementData['rating'] == 3)?'selected="selected"':''; ?>>3 Estrelas</option>
                    <option value="4" <?php echo(isset($advertisementData['rating']) && $advertisementData['rating'] == 4)?'selected="selected"':''; ?>>4 Estrelas</option>
                    <option value="5" <?php echo(isset($advertisementData['rating']) && $advertisementData['rating'] == 5)?'selected="selected"':''; ?>>5 Estrelas</option>
                </select>
            </div>
            <div class="form-group" style="margin-bottom: 0">
                <input type="checkbox" name="new" id="new" class="filter_brand" style="margin-right: 5px" <?php echo(isset($advertisementData['new']) && $advertisementData['new'] == 1)?'checked':''; ?>> <label for="new">Novo</label>
            </div>
            <div class="form-group" style="margin-bottom: 0">
                <input type="checkbox" name="bestseller" id="bestseller" class="filter_brand" style="margin-right: 5px" <?php echo(isset($advertisementData['bestseller']) && $advertisementData['bestseller'] == 1)?'checked':''; ?>> <label for="bestseller">Mais vendidos</label>
            </div>
            <div class="form-group">
                <input type="checkbox" name="sale" id="sale" class="filter_brand" style="margin-right: 5px" <?php echo(isset($advertisementData['sale']) && $advertisementData['sale'] == 1)?'checked':''; ?>> <label for="sale">Promoção</label>
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
                $.getJSON('<?php echo BASE_URL ?>subcategoriesCMS/getSubcategories/' + btoa(btoa(($(this).val()))), function(j){
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