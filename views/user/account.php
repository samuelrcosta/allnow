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
    }

    .box-minha-conta-conteudo label{
        margin: 0;
        font-weight: bold;
    }

    .box-minha-conta-conteudo p{
        margin-left: 10px;
    }
</style>
<div class="container">
    <div class="grupo-botoes" style="margin-top: 20px;margin-bottom: 10px">
        <a class="btn btn-dark" href="<?php echo BASE_URL?>">Voltar</a>
        <a class="btn btn-primary" href="<?php echo BASE_URL?>user/editAccount">Editar dados</a>
    </div>
    <?php if(isset($_GET['notification'])):?>
        <div class='alert <?php echo $_GET['status']; ?> notification'>
            <?php echo urldecode($_GET['notification']); ?>
        </div>
    <?php endif; ?>
    <div class="box-minha-conta">
        <div class="box-minha-conta-titulo">Dados Cadastrais</div>
        <div class="box-minha-conta-conteudo">
            <div class="row">
                <div class="col-sm-6">
                    <h5>Informações Pessoais</h5>
                    <hr>
                    <label>Nome</label>
                    <p><?php echo $userData['name']?></p>
                    <label>CPF</label>
                    <p><?php echo (!empty($userData['cpf']))?$userData['cpf']:'-';?></p>
                    <label>E-mail</label>
                    <p><?php echo $userData['email']?></p>
                    <label>Telefone</label>
                    <p><?php echo (!empty($userData['telephone']))?$userData['telephone']:'-';?></p>
                    <label>Celular</label>
                    <p><?php echo (!empty($userData['cellphone']))?$userData['cellphone']:'-';?></p>
                </div>
                <div class="col-sm-6">
                    <h5>Informações de Endereço</h5>
                    <hr>
                    <label>Endereço</label>
                    <p><?php echo (!empty($userData['street']))?$userData['street']:'-'; ?></p>
                    <label>Número</label>
                    <p><?php echo (!empty($userData['number']))?$userData['number']:'-';?></p>
                    <label>Complemento</label>
                    <p><?php echo (!empty($userData['complement']))?$userData['complement']:'-';?></p>
                    <label>Bairro</label>
                    <p><?php echo (!empty($userData['neighborhood']))?$userData['neighborhood']:'-';?></p>
                    <label>CEP</label>
                    <p><?php echo (!empty($userData['zip_code']))?$userData['zip_code']:'-';?></p>
                    <label>Estado</label>
                    <p><?php echo (!empty($userData['state']))?$userData['state']:'-';?></p>
                    <label>Cidade</label>
                    <p><?php echo (!empty($userData['city']))?$userData['city']:'-';?></p>
                </div>
            </div>
        </div>
    </div>
</div>