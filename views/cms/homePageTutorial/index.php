<div class="card">
    <form id="pageForm">
        <div class="card-header bg-light">
            Informações da Página Inicial
        </div>

        <div class="card-body">

            <div class="checkbox">
                <label>
                    Desmarque a opção abaixo caso queira deixar de exibir estas informações na tela inicial<br>
                    <input type="checkbox" name="active_radio" id="active_radio" value="True">&nbsp;Funcionalidade ativada</label>
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
<script src="<?php echo BASE_URL ?>assets/js/controllers/homeTutorialSitePageController.js"></script>
<script>
    $(document).ready(function(){
        PageController.start(<?= $configData ?>);
    });
</script>