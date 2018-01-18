<div class="container" style="margin-top: 30px;margin-bottom: 30px">
    <?php if(isset($_GET['notification'])):?>
        <div class='alert <?php echo $_GET['status']; ?> notification'>
            <?php echo urldecode($_GET['notification']); ?>
        </div>
    <?php endif; ?>
    <h1 style="text-align: center">Faça seu login ou crie uma conta gratuita!</h1>
    <p style="text-align: center">Veja todos os seus anúncios em um só lugar. Edite e exclua seus anúncios de forma rápida e fácil, altere seu perfil com segurança.</p>
    <div class="row">
        <div class="col-sm-6">
            <form  id="login" method="POST" style="margin: auto;margin-top: 20px;max-width: 450px">
                <h4 style="text-align: center;margin-bottom: 10px">Acessar meus anúncios</h4>
                <div class="form-group">
                    <label for="login[email]" style="display: none">E-mail</label>
                    <input data-validation="email" data-validation-error-msg="Digite um e-mail válido" type="text" name="login[email]" id="email" placeholder="E-mail" class="form-control" value="<?php echo(isset($login['email']))?$login['email']:''; ?>">
                </div>
                <div class="form-group" style="margin-bottom: 5px">
                    <label for="login[password]" style="display: none">Senha</label>
                    <input data-validation="required" data-validation-error-msg="Digite sua senha" type="password" name="login[password]" id="password"  placeholder="Senha" class="form-control">
                </div>
                <div class="form-group">
                    <input type="checkbox" name="login[keepLogged]" > Manter conectado
                </div>
                <a href="<?php echo BASE_URL?>login/recoverPassword" style="display: block;margin-bottom: 15px">Esqueci minha senha</a>
                <?php if(!empty($login['notice'])):?>
                    <?php echo $login['notice'] ?>
                <?php endif; ?>
                <input type="submit" value="Entrar" class="btn btn-primary" style="cursor: pointer;width: 100%">
            </form>
        </div>
        <div class="col-sm-6">
            <form method="POST" style="margin: auto;margin-top: 20px;max-width: 500px" id="register">
                <h4 style="text-align: center;margin-bottom: 10px">Ainda não tenho cadastro</h4>
                <?php if(!empty($register['notice'])):?>
                    <?php echo $register['notice'] ?>
                <?php endif; ?>
                <div class="form-group">
                    <label for="register[name]" style="display: none"><span>*</span> Nome</label>
                    <input data-validation="required" data-validation-error-msg="Digite seu nome" type="text" name="register[name]" id="name"  placeholder="Nome" class="form-control" value="<?php echo(isset($register['name']))?$register['name']:''; ?>">
                </div>
                <div class="form-group">
                    <label for="register[email]" style="display: none"><span>*</span> E-mail</label>
                    <input data-validation="email" data-validation-error-msg="Digite um email válido" type="text" name="register[email]" id="email" class="form-control"  placeholder="E-mail" value="<?php echo(isset($register['email']))?$register['email']:''; ?>">
                </div>
                <div class="form-group">
                    <label for="register[password]" style="display: none"><span>*</span> Senha</label>
                    <input data-validation="required" data-validation-error-msg="Digite sua senha" type="password" name="register[password]" id="password"  placeholder="Senha" class="form-control">
                </div>
                <div class="form-group">
                    <label for="register[confirmPassword]" style="display: none"><span>*</span> Confirmar Senha</label>
                    <input data-validation="confirmation" data-validation-confirm="register[password]" data-validation-error-msg="As duas senhas devem ser iguais" type="password" name="register[confirmPassword]"  placeholder="Digite novamente a senha" id="confirmPassword" class="form-control">
                </div>
                <div class="form-group">
                    <label for="register[id_state]" style="display: none"><span>*</span> Estado:</label>
                    <select data-validation="required" data-validation-error-msg="Selecione o seu estado" class="form-control" name="register[id_state]" id="id_state">
                        <option value="">Escolha um estado</option>
                        <?php foreach ($states as $state):?>
                            <option <?php echo(isset($register['id_state']) && $register['id_state'] == $state['id'])?'selected="selected"':''; ?> value="<?php echo $state['id'] ?>"><?php echo $state['name'] ?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="register[id_city]" style="display: none"><span>*</span> Cidade:</label>
                    <select data-validation="required" data-validation-error-msg="Selecione a sua cidade" class="form-control" name="register[id_city]" id="id_city">
                        <?php if(isset($register['id_state'])): ?>
                            <?php foreach ($cities as $city): ?>
                                <option <?php echo(isset($register['id_city']) && $register['id_city'] == $city['id'])?'selected="selected"':''; ?> value="<?php echo $city['id']; ?>"><?php echo $city['name']; ?></option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="">Escolha um estado</option>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="g-recaptcha" data-sitekey="6LctTUAUAAAAAGtBW4FIqEkT-SAgygxKHfe9PT4J"></div>

                <input type="submit" value="Cadastrar" class="btn btn-md btn-primary" style="cursor: pointer;width: 100%;margin-top: 10px" data-alt="Botão" data-ob="0">
                <p style="font-size: 12px;margin-top: 10px">Ao se cadastrar, eu concordo com os <a href="#">Termos de Uso</a> e a <a href="#">Política de Privacidade</a> da ---, e também, em receber comunicações da OLX, por exemplo, mensagens via e-mail de compradores interessados, promoções da ---, dicas e recomendações sobre produtos e serviços</p>
            </form>
        </div>
    </div>
    <p style="text-align: center;font-weight: bold;font-size: 16px">Ou</p>
    <a class="btn btn-primary loginBtn loginBtn--facebook" style="display: block;" href="<?php echo htmlspecialchars($loginFbUrl); ?>">Entrar usando o Facebook</a>
</div>
<script>
    $.validate({
        form : '#login'
    });
    $.validate({
        modules : 'security',
        form: '#register'
    });
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