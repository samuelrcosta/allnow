<style>
    .box-minha-conta{
        border: 1px solid;
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .box-minha-conta-titulo{
        height: 60px;
        line-height: 60px;
        padding-left: 20px;
        background-color: #292b2c;
        color: white;
    }

    .box-minha-conta-conteudo{
        padding-left: 20px;
        padding-top: 20px;
        padding-right: 40px;
    }

    .box-minha-conta-conteudo label{
        margin: 0;
        font-weight: bold;
    }

    #bgbox{
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        position: fixed;
        z-index: 10;
    }

    #confirm{
        border-radius: 10px;
        position: fixed;
        left: 50%;
        top: 50%;
        width: auto;
        background-color: white;
        padding: 20px;
        transform: translate(-50%, -50%);
        z-index: 11;
    }
</style>
<div class="container">
    <div class="grupo-botoes" style="margin-top: 20px">
        <a class="btn btn-secondary" href="<?php echo BASE_URL?>user/account">Voltar</a>
    </div>
    <div class="box-minha-conta">
        <div class="box-minha-conta-titulo">Dados Cadastrais</div>
        <div class="box-minha-conta-conteudo">
            <form method="POST" id="updateAccount">
                <div class="row">
                    <div class="col-sm-6">
                        <h5>Informações Pessoais</h5>
                        <hr>
                        <div class="form-group">
                            <label for="name"><span style="color: red;font-weight: bold">*</span> Nome</label>
                            <input class="form-control" id="name" name="name" data-validation="required" data-validation-error-msg="Digite seu nome" value="<?php echo $userData['name']?>">
                        </div>
                        <div class="form-group">
                            <label for="cpf">CPF</label>
                            <input class="form-control" id="cpf" name="cpf" value="<?php echo $userData['cpf']?>">
                        </div>
                        <div class="form-group">
                            <label for="email"><span style="color: red;font-weight: bold">*</span> E-mail</label>
                            <input class="form-control" id="email" name="email" data-validation="email" data-validation-error-msg="Digite um e-mail válido" value="<?php echo $userData['email']?>">
                        </div>
                        <div class="form-group">
                            <label for="telephone">Telefone</label>
                            <input class="form-control" id="telephone" name="telephone" value="<?php echo $userData['telephone']?>">
                        </div>
                        <div class="form-group">
                            <label for="cellphone">Celular</label>
                            <input class="form-control" id="cellphone" name="cellphone" value="<?php echo $userData['cellphone']?>">
                        </div>
                        <div class="form-group">
                            <label for="password">Senha atual</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="form-group">
                        <label for="newPassword">Nova Senha</label>
                        <input type="password" class="form-control" id="newPassword" name="newPassword">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <h5>Informações de Endereço</h5>
                        <hr>
                        <div class="form-group">
                            <label for="street">Endereço</label>
                            <input class="form-control" id="street" name="street" value="<?php echo $userData['street']?>">
                        </div>
                        <div class="form-group">
                            <label for="number">Número</label>
                            <input class="form-control" id="number" name="number" value="<?php echo $userData['number']?>">
                        </div>
                        <div class="form-group">
                            <label for="complement">Complemento</label>
                            <input class="form-control" id="complement" name="complement" value="<?php echo $userData['complement']?>">
                        </div>
                        <div class="form-group">
                            <label for="neighborhood">Bairro</label>
                            <input class="form-control" id="neighborhood" name="neighborhood" value="<?php echo $userData['neighborhood']?>">
                        </div>
                        <div class="form-group">
                            <label for="zip_code">CEP</label>
                            <input class="form-control" id="zip_code" name="zip_code" value="<?php echo $userData['zip_code']?>">
                        </div>
                        <div class="form-group">
                            <label for="id_state"><span style="color: red;font-weight: bold">*</span> Estado:</label>
                            <select class="form-control" name="id_state" id="id_state" data-validation="required" data-validation-error-msg="Selecione o seu estado">
                                <?php foreach ($states as $state):?>
                                    <option <?php if($state['id'] == $userData['id_state']) echo 'selected' ?> value="<?php echo $state['id'] ?>"><?php echo $state['name'] ?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="id_city"><span style="color: red;font-weight: bold">*</span> Cidade:</label>
                            <select class="form-control" name="id_city" id="id_city" data-validation="required" data-validation-error-msg="Selecione a sua cidade">
                                <?php foreach ($cities as $city):?>
                                    <option <?php if($city['id'] == $userData['id_city']) echo 'selected' ?> value="<?php echo $city['id'] ?>"><?php echo $city['name'] ?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                </div>
                <p>Caso queira alterar a senha, basta preencher os campos Senha atual e Nova Senha.</p>
                <?php if(isset($notice) && !empty($notice)):?>
                    <?php echo $notice; ?>
                <?php endif; ?>
                <p id="infocampos">Obs.: Campos com <label><span style="color: red;font-weight: bold">*</span></label> são de preenchimento obrigatório.</p>
                <input type="submit" value="Salvar" style="cursor:pointer;margin-bottom: 20px" class="btn btn-md btn-success">
            </form>
        </div>
    </div>

    <div class="box-minha-conta">
        <div class="box-minha-conta-titulo">Zona de Risco</div>
        <div class="box-minha-conta-conteudo">
            <label>Excluir conta</label><br>
            <button class="btn btn-danger" style="cursor: pointer;margin-left: 15px;margin-bottom: 15px" id="delete">Excluir</button>
        </div>
    </div>

    <div id="bgbox" style="display: none"></div>
    <div id="confirm" style="display: none">
        <p>Tem certeza que deseja excluir sua conta?</p>
        <span id="n" style="display: none"><?php echo $dados['id']?>></span>
        <a class="btn btn-danger" style="cursor: pointer" href="<?php echo BASE_URL ?>user/deleteAccount">Sim</a>
        <button style="cursor: pointer" class="btn btn-success" onclick="ndelete()">Não</button>
    </div>
</div>
<script>
    $.validate({
        form : '#updateAccount'
    });
    window.onload = function () {
        $("#cellphone").mask("(00) 0000-#0000");
        $("#telephone").mask("(00) 0000-0000");
        $("#cpf").mask("000.000.000-00");
        $("#zip_code").mask("00000-000");
    };

    $(function () {
        $("#delete").bind("click", function () {
            $("#bgbox").show();
            $("#confirm").show('fast');
        })
    });

    function ndelete() {
        $("#confirm").hide('fast');
        $("#bgbox").hide();
    }

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