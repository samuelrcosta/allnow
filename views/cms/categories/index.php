<div class="card">
    <div class="card-header bg-light">
        Categorias Principais
    </div>

    <div class="card-body">
        <?php if(isset($_GET['notification'])):?>
            <div class='alert <?php echo $_GET['status']; ?> notification'>
                <?php echo urldecode($_GET['notification']); ?>
            </div>
        <?php endif; ?>
        <a href="<?php echo BASE_URL ?>categoriesCMS/newCategory" class="btn btn-success" style="margin-bottom: 20px;">Nova Categoria</a>
        <div class="input-group" style="margin-bottom: 20px">
            <input type="text" class="form-control" id="search" placeholder="Digite uma categoria">
            <span class="input-group-btn">
                <button type="button" class="btn btn-default" style="background-color: #CCCCCC;"><i class="fa fa-search"></i> Pesquisar</button>
            </span>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Área</th>
                        <th>Editar</th>
                        <th>Excluir</th>
                    </tr>
                </thead>
                <tbody id="categories_result">
                </tbody>
            </table>
        </div>
    </div>
</div>
<div id="background-dark" style="display: none"></div>
<div id="confirm-delete" style="display: none">
    <p>Tem certeza que deseja excluir a Categoria, <strong>todas as suas Subcategorias e todos os seus anúncios?</strong>?</p>
    <button id="btn-confirm-delete" class="btn btn-danger">Sim</button>
    <button id="btn-not-delete" class="btn btn-success" >Não</button>
</div>
<script src="<?php echo BASE_URL ?>assets/js/controllers/categoriesCMSController.js"></script>
<script type="text/template" id="template-table-categories">
    {{#.}}
    <tr>
        <td>{{name}}</td>
        <td>{{description}}</td>
        <td>{{area_name}}</TD>
        <td data-id="{{id}}">
            <button class='btn btn-info edit-category' data-toggle="tooltip" data-placement="bottom" title="Editar a Categoria"><i class='icon icon-pencil'></i></button>
        </td>
        <td data-id="{{id}}">
            <button class='btn btn-danger delete-category' data-toggle="tooltip" data-placement="bottom" title="Excluir a Categoria"><i class='icon icon-trash'></i></button>
        </td>
    </tr>
    {{/.}}
</script>
<script type="text/javascript">
    $(document).ready(function(){
        PageController.start(<?php echo json_encode($categoriesData) ?>);
    });
</script>