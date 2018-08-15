<div class="card">
    <div class="card-header bg-light">
        Anúncios
    </div>

    <div class="card-body">
        <?php if(isset($_GET['notification'])):?>
            <div class='alert <?php echo $_GET['status']; ?> notification'>
                <?php echo urldecode($_GET['notification']); ?>
            </div>
        <?php endif; ?>
        <a href="<?php echo BASE_URL ?>adminAdvertisementsCMS/newAdvertisementPage" class="btn btn-success" style="margin-bottom: 20px">Novo Anúncio</a>
        <div class="input-group" style="margin-bottom: 20px">
            <input type="text" class="form-control" id="search" placeholder="Busque por título, categoria, subcategoria ou resumo">
            <span class="input-group-btn">
                <button type="button" class="btn btn-default" style="background-color: #CCCCCC;"><i class="fa fa-search"></i> Pesquisar</button>
            </span>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>Título</th>
                    <th>Categoria</th>
                    <th>Subcategoria</th>
                    <th>Resumo</th>
                    <th>Editar</th>
                    <th>Excluir</th>
                </tr>
                </thead>
                <tbody id="advertisements_result">
                </tbody>
            </table>
        </div>
    </div>
</div>
<div id="background-dark" style="display: none"></div>
<div id="confirm-delete" style="display: none">
    <p>Tem certeza que deseja excluir o anúncio?</p>
    <button id="btn-confirm-delete" class="btn btn-danger">Sim</button>
    <button id="btn-not-delete" class="btn btn-success" >Não</button>
</div>
<script src="<?php echo BASE_URL ?>assets/js/controllers/adsCMSController.js"></script>
<script type="text/template" id="template-table-advertisements">
    {{#.}}
    <tr>
        <td>{{title}}</td>
        <td>{{category_name}}</td>
        <td>{{subcategory_name}}</td>
        <td style='white-space: pre-wrap; word-wrap: break-word;'>{{abstract}}</td>
        <td data-id="{{id}}">
            <button class='btn btn-info edit-ad' data-toggle="tooltip" data-placement="bottom" title="Editar o anúncio"><i class='icon icon-pencil'></i></button>
        </td>
        <td data-id="{{id}}">
            <button class='btn btn-danger delete-ad' data-toggle="tooltip" data-placement="bottom" title="Excluir o anúncio"><i class='icon icon-trash'></i></button>
        </td>
    </tr>
    {{/.}}
</script>
<script type="text/javascript">
    $(document).ready(function(){
        PageController.start(<?php echo json_encode($advertisementsData) ?>);
    });
</script>