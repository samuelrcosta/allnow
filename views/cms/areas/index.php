<div class="card">
    <div class="card-header bg-light">
        Áreas
    </div>

    <div class="card-body">
        <a href="<?php echo BASE_URL ?>areasCMS/newArea" class="btn btn-success" style="margin-bottom: 20px;">Nova Área</a>
        <?php if(isset($_GET['notification'])):?>
            <div class='alert <?php echo $_GET['status']; ?> notification'>
                <?php echo urldecode($_GET['notification']); ?>
            </div>
        <?php endif; ?>
        <div class="input-group" style="margin-bottom: 20px">
            <input type="text" class="form-control" id="search" placeholder="Digite uma área">
            <span class="input-group-btn">
                <button type="button" class="btn btn-default" style="background-color: #CCCCCC;"><i class="fa fa-search"></i> Pesquisar</button>
            </span>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr style="text-align: center">
                    <th>Nome</th>
                    <th style="text-align: center">Ações</th>
                </tr>
                </thead>
                <tbody id="areas_result">
                </tbody>
            </table>
        </div>
    </div>
</div>
<div id="background-dark" style="display: none"></div>
<div id="confirm-delete" style="display: none">
    <p>Tem certeza que deseja excluir a Área, <strong>todas as suas Categorias, Subcategorias e todos os seus anúncios?</strong>?</p>
    <button id="btn-confirm-delete" class="btn btn-danger">Sim</button>&nbsp;
    <button id="btn-not-delete" class="btn btn-success">Não</button>
</div>
<script src="<?php echo BASE_URL ?>assets/js/controllers/areasCMSController.js"></script>
<script type="text/template" id="template-table-areas">
    {{#.}}
    <tr style="text-align: center">
        <td>{{name}}</td>
        <td data-id="{{id}}">
            <button class='btn btn-info edit-area' data-toggle="tooltip" data-placement="bottom" title="Editar área"><i class='icon icon-pencil'></i></button>&nbsp;
            <button class='btn btn-danger delete-area' data-toggle="tooltip" data-placement="bottom" title="Excluir área"><i class='icon icon-trash'></i></button>
        </td>
    </tr>
    {{/.}}
</script>
<script type="text/javascript">
    $(document).ready(function(){
        PageController.start(<?php echo json_encode($areasData) ?>);
    });
</script>