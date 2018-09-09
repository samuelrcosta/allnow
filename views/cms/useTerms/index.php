<div class="card">
    <form id="pageForm">
        <div class="card-header bg-light">
            Termos de Uso
        </div>
        <div class="card-body">

            <div class="form-group">
                <textarea class="form-control" name="text" id="text" style="max-width: 400px" data-validation="required" data-validation-error-msg="Digite um texto"></textarea>
            </div>

            <div class="container-notices"></div>
        </div>

        <div class="card-footer bg-light text-right">
            <button type="submit" class="btn btn-success save-button"><i class="fas fa-save"></i> Salvar</button>
        </div>
    </form>
</div>
<script src="<?php echo BASE_URL ?>vendor/ckeditor/ckeditor.js"></script>
<script src="<?php echo BASE_URL ?>assets/js/controllers/useTermsCMSController.js?v=1.0.1"></script>
<script>
  $(document).ready(function(){
    PageController.start(<?= json_encode($configData) ?>);
  });
</script>