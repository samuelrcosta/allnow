<div class="card">
    <div class="card-header bg-light">
        Editar Usuário
    </div>

    <div class="card-body">
        <a href="<?php echo BASE_URL; ?>usersCMS" class="btn btn-primary" style="margin-bottom: 20px;"><i class="icon icon-arrow-left-circle"></i>&nbsp;Voltar</a>
        <form method="POST" id="edit">
            <div class="row">
                <div class="col-sm-6">
                    <h5>Informações Pessoais</h5>
                    <hr>
                    <div class="form-group">
                        <label for="name"><span style="color: red;font-weight: bold">*</span> Nome</label>
                        <input class="form-control" id="name" name="name" data-validation="required" data-validation-error-msg="Digite seu nome" value="<?php echo $usData['name']?>">
                    </div>
                    <div class="form-group">
                        <label for="cpf">CPF</label>
                        <input class="form-control" id="cpf" name="cpf" value="<?php echo $usData['cpf']?>">
                    </div>
                    <div class="form-group">
                        <label for="email"><span style="color: red;font-weight: bold">*</span> E-mail</label>
                        <input class="form-control" id="email" name="email" data-validation="email" data-validation-error-msg="Digite um e-mail válido" value="<?php echo $usData['email']?>">
                    </div>
                    <div class="form-group">
                        <label for="telephone">Telefone</label>
                        <input class="form-control" id="telephone" name="telephone" value="<?php echo $usData['telephone']?>">
                    </div>
                    <div class="form-group">
                        <label for="cellphone">Celular</label>
                        <input class="form-control" id="cellphone" name="cellphone" value="<?php echo $usData['cellphone']?>">
                    </div>
                </div>
                <div class="col-sm-6">
                    <h5>Informações de Endereço</h5>
                    <hr>
                    <div class="form-group">
                        <label for="street">Endereço</label>
                        <input class="form-control" id="street" name="street" value="<?php echo $usData['street']?>">
                    </div>
                    <div class="form-group">
                        <label for="number">Número</label>
                        <input class="form-control" id="number" name="number" value="<?php echo $usData['number']?>">
                    </div>
                    <div class="form-group">
                        <label for="complement">Complemento</label>
                        <input class="form-control" id="complement" name="complement" value="<?php echo $usData['complement']?>">
                    </div>
                    <div class="form-group">
                        <label for="neighborhood">Bairro</label>
                        <input class="form-control" id="neighborhood" name="neighborhood" value="<?php echo $usData['neighborhood']?>">
                    </div>
                    <div class="form-group">
                        <label for="zip_code">CEP</label>
                        <input class="form-control" id="zip_code" name="zip_code" value="<?php echo $usData['zip_code']?>">
                    </div>
                    <div class="form-group">
                        <label for="id_state"><span style="color: red;font-weight: bold">*</span> Estado:</label>
                        <select class="form-control" name="id_state" id="id_state" data-validation="required" data-validation-error-msg="Selecione o seu estado">
                            <?php foreach ($states as $state):?>
                                <option <?php if($state['id'] == $usData['id_state']) echo 'selected' ?> value="<?php echo $state['id'] ?>"><?php echo $state['name'] ?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_city"><span style="color: red;font-weight: bold">*</span> Cidade:</label>
                        <select class="form-control" name="id_city" id="id_city" data-validation="required" data-validation-error-msg="Selecione a sua cidade">
                            <?php foreach ($cities as $city):?>
                                <option <?php if($city['id'] == $usData['id_city']) echo 'selected' ?> value="<?php echo $city['id'] ?>"><?php echo $city['name'] ?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
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
    window.onload = function () {
        $("#cellphone").mask("(00) 0000-#0000");
        $("#telephone").mask("(00) 0000-0000");
        $("#cpf").mask("000.000.000-00");
        $("#zip_code").mask("00000-000");
    };
    $(function(){
        $('#id_state').change(function(){
            if( $(this).val() ) {
                $('#id_city').html('<option value="">Carregando</option>');
                $.getJSON('<?php echo BASE_URL ?>login/cities/' + $(this).val(), function(j){
                    var options = '<option value=""></option>';
                    for (var i = 0; i < j.length; i++) {
                        options += '<option value="' + j[i].id + '">' + j[i].name + '</option>';
                    }
                    $('#id_city').html(options);
                });
            } else {
                $('#id_city').html('<option value="">-- Escolha um estado --</option>');
            }
        });
    });
</script>