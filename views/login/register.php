<div class="container" style="margin-top: 30px;margin-bottom: 30px">
    <form method="POST" style="margin: auto;margin-top: 20px;max-width: 500px" onsubmit="return validateFildsRecoverPassword(this)">
        <h1>Cadastre-se</h1>
        <?php if(!empty($notice)):?>
            <?php echo $notice ?>
        <?php endif; ?>
        <div class="form-group">
            <label for="name"><span>*</span> Nome</label>
            <input type="text" name="name" id="name" class="form-control" data-alt="Nome" data-ob="1" value="<?php echo(isset($name))?$name:''; ?>">
        </div>
        <div class="form-group">
            <label for="email"><span>*</span> E-mail</label>
            <input type="text" name="email" id="email" class="form-control" data-alt="Email" data-ob="1" value="<?php echo(isset($email))?$email:''; ?>">
        </div>
        <div class="form-group">
            <label for="password"><span>*</span> Senha</label>
            <input type="password" name="password" id="password" class="form-control" data-alt="Senha" data-ob="1">
        </div>
        <div class="form-group">
            <label for="password"><span>*</span> Confirmar Senha</label>
            <input type="password" name="confirmPassword" id="confirmPassword" class="form-control" data-alt="Confirmar Senha" data-ob="1">
        </div>
        <div class="form-group">
            <label for="id_state"><span>*</span> Estado:</label>
            <select class="form-control" name="id_state" id="id_state" data-alt="Estado" data-ob="1">
                <option value=""></option>
                <?php foreach ($states as $state):?>
                    <option <?php echo(isset($id_state) && $id_state == $state['id'])?'selected="selected"':''; ?> value="<?php echo $state['id'] ?>"><?php echo $state['name'] ?></option>
                <?php endforeach;?>
            </select>
        </div>
        <div class="form-group">
            <label for="id_city"><span>*</span> Cidade:</label>
            <select class="form-control" name="id_city" id="id_city" data-alt="Cidade" data-ob="1">
                <?php if(isset($id_state)): ?>
                    <?php foreach ($cities as $city): ?>
                        <option <?php echo(isset($id_city) && $id_city == $city['id'])?'selected="selected"':''; ?> value="<?php echo $city['id']; ?>"><?php echo $city['name']; ?></option>
                    <?php endforeach; ?>
                <?php else: ?>
                    <option value="">Escolha um estado</option>
                <?php endif; ?>
            </select>
        </div>

        <div class="g-recaptcha" data-sitekey="6LctTUAUAAAAAGtBW4FIqEkT-SAgygxKHfe9PT4J"></div>

        <div id='return' style='margin-bottom: 15px;margin-top: 5px;display: none'></div>

        <p id="infocampos">Obs.: Campos com <label><span style="color: red;font-weight: bold">*</span></label> são de preenchimento obrigatório.</p>
        <input type="submit" value="Cadastrar" class="btn btn-md btn-primary" style="cursor: pointer" data-alt="Botão" data-ob="0">
    </form>
</div>
<script>
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
                    //$('.carregando').hide();
                });
            } else {
                $('#id_city').html('<option value="">-- Escolha um estado --</option>');
            }
        });
    });
</script>