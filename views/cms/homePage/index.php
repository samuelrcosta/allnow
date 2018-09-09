<div class="card">
  <form id="bannerForm">
    <div class="card-header bg-light">
      Informações do Banner da Página Inicial
    </div>
    <div class="card-body">
      <div class="form-group">
        <label for="banner_text" class="form-control-label">Texto do Banner</label>
        <textarea rows="3" class="form-control" name="banner_text" id="banner_text" style="max-width: 400px" data-validation="required" data-validation-error-msg="Digite o texto do Banner" maxlength="94"></textarea>
      </div>
      <div class="form-group">
        <label for="banner_text" class="form-control-label">Palavras que repetem</label>
        <br>
        <label for="banner_repeat" class="form-control-label"><input type="checkbox" name="banner_repeat" id="banner_repeat" value="True">&nbsp;Ativo</label>
        <div class="row container-repeat-words">
          <div class="col-md-12" style="margin-bottom: 10px;">
            <div class="row">
              <div class="col-md-4">
                <input class="form-control repeat_words" id="repeat_words" maxlength="25" name="repeat_words[]" style="max-width: 400px" data-validation="" data-validation-error-msg="Digite uma palavra"/>
              </div>
              <div class="col-md-1">
                <button type="button" id="btnAddWord" class="btn btn-success"><i class="fa fa-plus"></i></button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label for="banner_text" class="form-control-label">Imagem do Banner</label>
        <div class="progress">
          <div class="progress-bar progress-bar-success progresso" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"> Nenhum arquivo enviado
          </div>
        </div>

        <label for="image" class="form-control-label">Arquivo da Imagem</label>
        <input type="file" class="form-control" id="image" name="image" data-validation-allowing="jpg, png, jpeg" data-validation-max-size="2M" data-validation-error-msg="Insira um arquivo de imagem válido de até 2Mb"/>
        <div class="image-area" style="width: 100%;max-width: 100%;text-align: center;">

        </div>

      </div>
      <div class="container-notices"></div>
    </div>
    <div class="card-footer bg-light text-right">
      <button type="submit" class="btn btn-success save-button"><i class="fas fa-save"></i> Salvar</button>
    </div>
  </form>
</div>
<div class="card">
  <form id="pageForm">
    <div class="card-header bg-light">
      Informações da Página Inicial
    </div>
    <div class="card-body">
      <div class="checkbox">
        <label>
          Desmarque a opção abaixo caso queira deixar de exibir estas informações na tela inicial<br>
          <input type="checkbox" name="active_radio" id="active_radio" value="True">&nbsp;Funcionalidade ativada
        </label>
      </div>

      <div class="form-group">
        <label for="title" class="form-control-label">Texto acima da mídia</label>
        <input class="form-control" name="title" id="title" style="max-width: 400px" data-validation="" data-validation-error-msg="Digite um texto"/>
      </div>

      <div class="form-group">
        <label for="title" class="form-control-label">Texto ao lado da mídia</label>
        <textarea class="form-control" name="text" id="text" style="max-width: 400px; resize: none" rows="5" data-validation="" data-validation-error-msg="Digite um texto"></textarea>
      </div>

      <div class="form-group">
        <label for="media_type" class="form-control-label">Tipo de Mídia</label>
        <select class="form-control" id="media_type" name="media_type" style="max-width: 400px;background-position-x: 95%;" data-validation="" data-validation-error-msg="Selecione o tipo da mídia">
          <option value=""></option>
          <option value="1">Youtube</option>
          <option value="2">Vimeo</option>
        </select>
      </div>
      <div class="form-group div-link">
        <label for="media_link" class="form-control-label">Link da Mídia</label>
        <input class="form-control" id="media_link" name="media_link" style="max-width: 400px" data-validation="" data-validation-error-msg="Insira o link de uma mídia"/>
      </div>

      <div class="container-notices"></div>
    </div>

    <div class="card-footer bg-light text-right">
      <button type="submit" class="btn btn-success save-button"><i class="fas fa-save"></i> Salvar</button>
    </div>
  </form>
</div>
<script src="<?php echo BASE_URL ?>assets/js/resize_image.js"></script>
<script src="<?php echo BASE_URL ?>assets/js/controllers/homePageCMSController.js?v=1.0.1"></script>
<script type="text/template" id="template-repeat-word">
  {{#.}}
  <div class="col-md-12 template_repeat_word_add" style="margin-bottom: 10px;">
    <div class="row">
      <div class="col-md-4">
        <input class="form-control repeat_words" name="repeat_words[]" maxlength="25" style="max-width: 400px" data-validation="required" data-validation-error-msg="Digite uma palavra" value="{{.}}"/>
      </div>
      <div class="col-md-1">
        <button type="button" class="btn btn-danger btnRemoveWord"><i class="fa fa-minus"></i></button>
      </div>
    </div>
  </div>
  {{/.}}
</script>
<script type="text/template" id="template-add-word">
  <div class="col-md-12 template_repeat_word_add" style="margin-bottom: 10px;">
    <div class="row">
      <div class="col-md-4">
        <input class="form-control repeat_words" name="repeat_words[]" maxlength="25" style="max-width: 400px" data-validation="required" data-validation-error-msg="Digite uma palavra"/>
      </div>
      <div class="col-md-1">
        <button type="button" class="btn btn-danger btnRemoveWord"><i class="fa fa-minus"></i></button>
      </div>
    </div>
  </div>
</script>
<script>
  $(document).ready(function(){
    PageController.start(<?= json_encode($configData); ?>);
  });
</script>