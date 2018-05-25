<div class="card">
    <div class="card-header bg-light">
        Cadastrar Sub-Categoria
    </div>

    <div class="card-body">
        <a href="<?php echo BASE_URL; ?>subcategoriesCMS" class="btn btn-primary" style="margin-bottom: 20px;"><i class="icon icon-arrow-left-circle"></i>&nbsp;Voltar</a>
        <form method="POST" id="register">
            <div class="form-group">
                <label for="name" class="form-control-label">Nome da Sub-Categoria</label>
                <input class="form-control" name="name" id="name" style="max-width: 400px" data-validation="required" data-validation-error-msg="Digite um nome para Sub-Categoria" value="<?php echo(isset($name))?$name:''; ?>"/>
            </div>
            <div class="form-group">
                <label for="id_principal" class="form-control-label">Categoria Principal</label>
                <select class="form-control" name="id_principal" id="id_principal" data-validation="required" data-validation-error-msg="Selecione uma categoria principal" style="max-width: 400px">
                    <option></option>
                    <?php foreach ($categoryData as $category): ?>
                        <option <?php echo (isset($id_principal) && $id_principal == $category['id'])?'selected="selected"':''; ?> value="<?php echo $category['id'] ?>"><?php echo $category['name'] ?></option>
                    <?php endforeach; ?>
                </select>
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
    $(function(){
        $('#id_principal').change(function(){
            var options = $(this).find('option');
            var data_presential = 0;
            var data_for_user = 0;
            for(var i = 0; i < options.length; i++){
                if(options[i].getAttribute('value') == $('#id_principal').val()){
                    data_presential = options[i].getAttribute('data-presential');
                    data_for_user = options[i].getAttribute('data-for_user');
                }
            }
            $("#presential").removeAttr('checked');
            $("#for_user").removeAttr('checked');
            if(data_presential == '1'){
                $("#presential").attr("checked","checked");
            }
            if(data_for_user == '1'){
                $("#for_user").attr("checked","checked");
            }
        });
    });
</script>