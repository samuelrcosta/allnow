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
            <input type="text" class="form-control" id="search" placeholder="Digite uma categoria" onkeyup="search()">
            <span class="input-group-btn">
                <button type="button" class="btn btn-default" style="background-color: #CCCCCC;"><i class="fa fa-search"></i> Pesquisar</button>
            </span>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nome</th>
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
    <button class="btn btn-danger" onclick="yesDelete()">Sim</button>&nbsp;
    <button class="btn btn-success" onclick="notDelete()">Não</button>
</div>
<script>
    window.onload = function (){
        insertCategories();
    };

    var idCategory;
    function deleteCategory(id){
        $("#background-dark").show();
        $("#confirm-delete").show('fast');
        idCategory = id;
    }
    function notDelete(){
        $("#confirm-delete").hide('fast');
        $("#background-dark").hide();
    }

    function yesDelete(){
        window.location.href = '<?php echo BASE_URL ?>categoriesCMS/deleteCategory/' + idCategory;
    }

    var categoryList = <?php echo json_encode($categoriesData) ?>;

    function insertCategories(){
        for(var id in categoryList){
            $("#categories_result").append(
                "<tr>" +
                    "<td>" + categoryList[id].name +"</td>" +
                    "<td>" + categoryList[id].area_name +"</td>" +
                    "<td><a href='" + BASE_URL + "categoriesCMS/editCategory/" +  btoa(btoa(categoryList[id].id)) + "' class='btn btn-info'><i class='icon icon-pencil'></i></a></td>" +
                    "<td><button class='btn btn-danger' onclick=" + 'deleteCategory("' + btoa(btoa(categoryList[id].id)) + '")' + "><i class='icon icon-trash'></i></button></td>" +
                "</tr>"
            );
        }
    }

    function search(){
        if($("#search").val() == ''){
            $("#categories_result").html('');
            insertCategories();
        }else{
            $("#categories_result").html('');
            var word = $("#search").val().toLowerCase();
            for(var id in categoryList){
                if(categoryList[id].name.toLowerCase().search(word) !== -1 || categoryList[id].area_name.toLowerCase().search(word) !== -1){
                    $("#categories_result").append(
                        "<tr>" +
                            "<td>" + categoryList[id].name +"</td>" +
                            "<td>" + categoryList[id].area_name +"</td>" +
                            "<td><a href='" + BASE_URL + "categoriesCMS/editCategory/" +  btoa(btoa(categoryList[id].id)) + "' class='btn btn-info'><i class='icon icon-pencil'></i></a></td>" +
                            "<td><button class='btn btn-danger' onclick=" + 'deleteCategory("' + btoa(btoa(categoryList[id].id)) + '")' + "><i class='icon icon-trash'></i></button></td>" +
                        "</tr>"
                    );
                }
            }
        }
    }
</script>