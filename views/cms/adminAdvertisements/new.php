<div class="card">
    <div class="card-header bg-light">
        Cadastrar Anúncio
    </div>

    <div class="card-body">
        <a href="<?php echo BASE_URL; ?>adminAdvertisementsCMS" class="btn btn-primary" style="margin-bottom: 20px;"><i class="icon icon-arrow-left-circle"></i>&nbsp;Voltar</a>
        <form method="POST" id="register">
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
                    <option value="3" <?php echo(isset($media_type) && $media_type == 3)?'selected="selected"':''; ?>>Arquivo de Imagem</option>
                    <option value="4" <?php echo(isset($media_type) && $media_type == 4)?'selected="selected"':''; ?>>Link de Imagem</option>
                </select>
            </div>
            <div class="form-group <?php echo(!isset($image))?'div-invisible':''; ?>" id="div-image">
                <div class="progress">
                    <div id="progresso" class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"> Nenhum arquivo enviado
                    </div>
                </div>

                <label for="image" class="form-control-label">Arquivo da Imagem</label>
                <input type="file" class="form-control" name="image" id="image" style="max-width: 400px" data-validation-allowing="jpg, png, jpeg" data-validation-max-size="2M" data-validation-error-msg="Insira um arquivo de imagem válido de até 2Mb" value="<?php echo(isset($image))?$image:''; ?>"/>

                <div class="image-area">

                </div>
            </div>
            <div class="form-group <?php echo(isset($image))?'div-invisible':''; ?>" id="div-link">
                <label for="media" class="form-control-label">Link da Mídia</label>
                <input class="form-control" name="media_link" id="media_link" style="max-width: 400px" data-validation-error-msg="Insira o link de uma mídia" value="<?php echo(isset($media_link))?$media_link:''; ?>"/>
            </div>
            <div class="form-group">
                <label for="description" class="form-control-label">Descrição</label>
                <textarea class="form-control" name="description" id="description" data-validation="required" data-validation-error-msg="Digite a descrição"><?php echo(isset($description))?$description:''; ?></textarea>
            </div>
            <div class="form-group">
                <label for="rating" class="form-control-label">Avaliação</label>
                <select class="form-control" name="rating" id="rating" style="max-width: 400px">
                    <option value="0" <?php echo(isset($rating) && $rating == 0)?'selected="selected"':''; ?>>Sem avaliação</option>
                    <option value="1" <?php echo(isset($rating) && $rating == 1)?'selected="selected"':''; ?>>1 Estrela</option>
                    <option value="2" <?php echo(isset($rating) && $rating == 2)?'selected="selected"':''; ?>>2 Estrelas</option>
                    <option value="3" <?php echo(isset($rating) && $rating == 3)?'selected="selected"':''; ?>>3 Estrelas</option>
                    <option value="4" <?php echo(isset($rating) && $rating == 4)?'selected="selected"':''; ?>>4 Estrelas</option>
                    <option value="5" <?php echo(isset($rating) && $rating == 5)?'selected="selected"':''; ?>>5 Estrelas</option>
                </select>
            </div>
            <div class="form-group" style="margin-bottom: 0">
                <input type="checkbox" name="highlight" id="highlight" class="filter_brand" style="margin-right: 5px" <?php echo(isset($highlight) && $highlight == 1)?'checked':''; ?>> <label for="highlight">Irá aparecer nos destaques?</label>
            </div>
            <div class="form-group" style="margin-bottom: 0">
                <input type="checkbox" name="new" id="new" class="filter_brand" style="margin-right: 5px" <?php echo(isset($new) && $new == 1)?'checked':''; ?>> <label for="new">Novo</label>
            </div>
            <div class="form-group" style="margin-bottom: 0">
                <input type="checkbox" name="bestseller" id="bestseller" class="filter_brand" style="margin-right: 5px" <?php echo(isset($bestseller) && $bestseller == 1)?'checked':''; ?>> <label for="bestseller">Mais vendidos</label>
            </div>
            <div class="form-group">
                <input type="checkbox" name="sale" id="sale" class="filter_brand" style="margin-right: 5px" <?php echo(isset($sale) && $sale == 1)?'checked':''; ?>> <label for="sale">Promoção</label>
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
<script src="<?php echo BASE_URL ?>assets/js/resize_image.js"></script>
<script>
    $.validate({
        form : '#register',
        modules : 'file'
    });

    //CKEDITOR
    CKEDITOR.replace( 'description' );

    $(function(){
        $('#media_type').change(function(){
            if( $(this).val() == "3" ) {
                $("#div-image").slideDown();
                $('#image').attr("data-validation", "required mime size");
                $(".image-area").html("");
                $.validate({
                    form : '#register',
                    modules : 'file'
                });
                $("#div-link").slideUp();
            }else{
                $("#div-image").slideUp();
                $('#image').removeAttr("data-validation");
                $('#media_link').attr("data-validation", "url").val("");
                $.validate({
                    form : '#register',
                    modules : 'file'
                });
                $("#div-link").slideDown();
            }
        });

        // -------------------------------------- Image rendering -------------------------------------- //
        // Initializing resize library
        var resize = new window.resize();
        resize.init();

        // When choose a image
        $('#image').on('change', function () {
            renderizeImage();
        });

        // Renderiza a imagem
        function renderizeImage() {
            // Verify if the navegator have capacity
            if (!window.File || !window.FileReader || !window.FileList || !window.Blob) {
                alert('O navegador não suporta os recursos utilizados pelo aplicativo');
                return;
            }

            // Saving the image
            var image = $('#image')[0].files;

            // If send at least one image
            if (image.length > 0) {
                // Set 0% in progress bar
                $('#progresso').attr('aria-valuenow', 0).css('width', '0%');

                // Hinding image input
                $('#image').hide();

                // Start the image resizing
                if(resizeImage(image)){
                    // Shows the finish image
                    $('#progresso').append('Imagen(s) enviada(s) com sucesso');

                    // Showing the image input
                    $('#image').show();
                }else{
                    // Refresh the progress bar
                    var progress = 100;
                    $('#progresso').text(Math.round(progress) + '%').attr('aria-valuenow', progress).css('width', progress + '%');

                    // Shows the error
                    $('#progresso').append('Arquivo de imagem inválido');
                }
            }
        }

        function resizeImage(image) {
            // If is not a valid image
            if ((typeof image[0] !== 'object') || (image[0] == null)) {
                // Returns error
                return false;
            }else{
                // Resizing the image
                resize.photo(image[0], 800, 'dataURL', function (imagem) {
                    // Creating the image tag
                    var mediaInput = "<h5>Pré-visulização da imagem:</h5><img width='100%' src='" + imagem + "' >";

                    // Triggering the media_link input
                    $("#media_link").val(imagem);

                    // Show the selected image
                    $(".image-area").html(mediaInput);

                    // Refresh the progress bar
                    var progress = 100;
                    $('#progresso').text(Math.round(progress) + '%').attr('aria-valuenow', progress).css('width', progress + '%');
                });

                // Return success
                return true;
            }
        }


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