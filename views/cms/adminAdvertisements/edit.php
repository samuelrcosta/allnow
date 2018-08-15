<div class="card">
    <div class="card-header bg-light">
        Editar Anúncio
    </div>

    <div class="card-body">
        <a href="<?php echo BASE_URL; ?>adminAdvertisementsCMS" class="btn btn-primary" style="margin-bottom: 20px;"><i class="icon icon-arrow-left-circle"></i>&nbsp;Voltar</a>
        <form method="POST" id="editForm">
            <div class="form-group">
                <label for="title" class="form-control-label">Título do Anúncio</label>
                <input class="form-control" name="title" id="title" style="max-width: 400px" data-validation="required" data-validation-error-msg="Digite um título" />
            </div>
            <div class="form-group">
                <label for="id_category" class="form-control-label">Categoria Principal</label>
                <select class="form-control" name="id_category" id="id_category" style="max-width: 400px" data-validation="required" data-validation-error-msg="Selecione uma Categoria">
                    <option></option>
                    <?php foreach ($categoryData as $category): ?>
                        <option value="<?php echo $category['id'] ?>"><?php echo $category['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="id_subcategory" class="form-control-label">Sub-Categoria</label>
                <select class="form-control" name="id_subcategory" id="id_subcategory" style="max-width: 400px" data-validation="required" data-validation-error-msg="Selecione uma Sub-Categoria">
                        <option value="">-- Escolha uma categoria Principal --</option>
                </select>
            </div>
            <div class="form-group">
                <label for="abstract" class="form-control-label">Resumo do Anúncio</label>
                <textarea class="form-control" name="abstract" id="abstract" data-validation="required" data-validation-error-msg="Digite um resumo para o anúncio"></textarea>
            </div>
            <div class="form-group">
                <label for="description" class="form-control-label">Descrição</label>
                <textarea class="form-control" name="description" id="description" data-validation="required" data-validation-error-msg="Digite a descrição"></textarea>
            </div>
            <div class="form-group">
                <label for="rating" class="form-control-label">Avaliação</label>
                <select class="form-control" name="rating" id="rating" style="max-width: 400px">
                    <option value="0">Sem avaliação</option>
                    <option value="2_0">2 Estrelas</option>
                    <option value="2_5">2,5 Estrelas</option>
                    <option value="3_0">3 Estrelas</option>
                    <option value="3_5">3,5 Estrelas</option>
                    <option value="4_0">4 Estrelas</option>
                    <option value="4_5">4,5 Estrelas</option>
                    <option value="5_0">5 Estrelas</option>
                </select>
            </div>
            <div class="form-group" style="margin-bottom: 0">
                <input type="checkbox" name="highlight" id="highlight" class="filter_brand" style="margin-right: 5px"> <label for="highlight">Irá aparecer nos destaques?</label>
            </div>
            <div class="form-group" style="margin-bottom: 0">
                <input type="checkbox" name="new" id="new" class="filter_brand" style="margin-right: 5px"> <label for="new">Novo</label>
            </div>
            <div class="form-group" style="margin-bottom: 0">
                <input type="checkbox" name="bestseller" id="bestseller" class="filter_brand" style="margin-right: 5px"> <label for="bestseller">Mais vendidos</label>
            </div>
            <div class="form-group">
                <input type="checkbox" name="sale" id="sale" class="filter_brand" style="margin-right: 5px"> <label for="sale">Promoção</label>
            </div>
            <label style="font-weight: bold">Mídias</label>
            <div id="media_containers" style="margin-bottom: 20px">
                <div class="media-container" data-id="" style="border: 1px solid;padding: 10px;">
                    <div class="form-group">
                        <label for="media_type" class="form-control-label">Tipo de Mídia</label>
                        <select class="form-control" name="media_type" style="max-width: 400px;background-position-x: 95%;" data-validation="required" data-validation-error-msg="Selecione o tipo da mídia">
                            <option value=""></option>
                            <option value="1">Youtube</option>
                            <option value="2">Vimeo</option>
                            <option value="3">Arquivo de Imagem</option>
                        </select>
                    </div>
                    <div class="form-group div-image div-invisible">
                        <div class="progress">
                            <div class="progress-bar progress-bar-success progresso" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"> Nenhum arquivo enviado
                            </div>
                        </div>

                        <label for="image" class="form-control-label">Arquivo da Imagem</label>
                        <input type="file" class="form-control" name="image" style="max-width: 400px" data-validation-allowing="jpg, png, jpeg" data-validation-max-size="2M" data-validation-error-msg="Insira um arquivo de imagem válido de até 2Mb"/>

                        <div class="image-area">

                        </div>
                    </div>
                    <div class="form-group div-link">
                        <label for="media" class="form-control-label">Link da Mídia</label>
                        <input class="form-control" name="media_link" style="max-width: 400px" data-validation-error-msg="Insira o link de uma mídia"/>
                    </div>
                    <div>
                        <button type="button" class="btn btn-sm btn-success" id="button-add-media"><i class="fa fa-plus"></i> Acrescentar Mídia</button>
                    </div>
                </div>
            </div>
            <div class="container-notices"></div>
            <div class="form-group">
                <button type="submit" class="btn btn-success save-advertisement"><i class="fa fa-save"></i> Salvar</button>
            </div>
        </form>
    </div>
</div>
<script src="<?php echo BASE_URL ?>vendor/ckeditor/ckeditor.js"></script>
<script src="<?php echo BASE_URL ?>assets/js/resize_image.js"></script>
<script src="<?php echo BASE_URL ?>assets/js/controllers/adsEditPageController.js?v=1.0.1"></script>
<script type="text/template" id="template-new-media">
    <div class="media-container" data-id="" style="border: 1px solid;padding: 10px;margin-top: 15px">
        <div class="form-group">
            <label for="media_type" class="form-control-label">Tipo de Mídia</label>
            <select class="form-control" name="media_type" style="max-width: 400px;background-position-x: 95%;" data-validation="required" data-validation-error-msg="Selecione o tipo da mídia">
                <option value=""></option>
                <option value="1">Youtube</option>
                <option value="2">Vimeo</option>
                <option value="3">Arquivo de Imagem</option>
            </select>
        </div>
        <div class="form-group div-image div-invisible">
            <div class="progress">
                <div class="progress-bar progress-bar-success progresso" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"> Nenhum arquivo enviado
                </div>
            </div>

            <label for="image" class="form-control-label">Arquivo da Imagem</label>
            <input type="file" class="form-control" name="image" style="max-width: 400px" data-validation-allowing="jpg, png, jpeg" data-validation-max-size="2M" data-validation-error-msg="Insira um arquivo de imagem válido de até 2Mb"/>

            <div class="image-area">

            </div>
        </div>
        <div class="form-group div-link">
            <label for="media" class="form-control-label">Link da Mídia</label>
            <input class="form-control" name="media_link" style="max-width: 400px" data-validation-error-msg="Insira o link de uma mídia"/>
        </div>
        <div>
            <button type="button" class="btn btn-sm btn-danger button-remove-media"><i class="fa fa-minus"></i> Remover Mídia</button>
        </div>
    </div>
</script>
<script>
    PageController.start('<?php echo BASE_URL; ?>', '<?php echo $advertisementId; ?>');
</script>