<div class="card">
    <div class="card-header bg-light">
        Sub-Categorias
    </div>

    <div class="card-body">
        <?php if(isset($_GET['notification'])):?>
            <div class='alert <?php echo $_GET['status']; ?> notification'>
                <?php echo urldecode($_GET['notification']); ?>
            </div>
        <?php endif; ?>
        <a href="<?php echo BASE_URL ?>subcategoriesCMS/newSubCategory" class="btn btn-success" style="margin-bottom: 20px;">Nova Sub-Categoria</a>
        <div class="input-group" style="margin-bottom: 20px">
            <input type="text" class="form-control" id="search" placeholder="Digite o nome de uma Sub-Categoria ou Categoria" onkeyup="search()">
            <span class="input-group-btn">
                <button type="button" class="btn btn-default" style="background-color: #CCCCCC;"><i class="fa fa-search"></i> Pesquisar</button>
            </span>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Categoria Principal</th>
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
    <p>Tem certeza que deseja excluir a Sub-Categoria <strong>e todos os seus anúncios</strong>?</p>
    <button class="btn btn-danger" onclick="yesDelete()">Sim</button>&nbsp;
    <button class="btn btn-success" onclick="notDelete()">Não</button>
</div>
<script>
    window.onload = function (){
        insertSubcategories();
    };

    var idSubcategory;
    function deleteSubcategory(id){
        $("#background-dark").show();
        $("#confirm-delete").show('fast');
        idSubcategory = id;
    }
    function notDelete(){
        $("#confirm-delete").hide('fast');
        $("#background-dark").hide();
    }

    function yesDelete(){
        window.location.href = '<?php echo BASE_URL ?>subcategoriesCMS/deleteSubCategory/' + idSubcategory;
    }

    var subcategoryList = <?php echo json_encode($subcategoriesData) ?>;

    function insertSubcategories(){
        for(var id in subcategoryList){
            for(var sub in subcategoryList[id].subs){
                $("#categories_result").append(
                    "<tr>" +
                        "<td>" + subcategoryList[id].subs[sub].name +"</td>" +
                        "<td>" + subcategoryList[id].name +"</td>" +
                        "<td><a href='" + BASE_URL + "subcategoriesCMS/editSubCategory/" +  btoa(btoa(subcategoryList[id].subs[sub].id)) + "' class='btn btn-info'><i class='icon icon-pencil'></i></a></td>" +
                        "<td><button class='btn btn-danger' onclick=" + 'deleteSubcategory("' + btoa(btoa(subcategoryList[id].subs[sub].id)) + '")' + "><i class='icon icon-trash'></i></button></td>" +
                    "</tr>"
                );
            }
        }
    }

    function search(){
        if($("#search").val() == ''){
            $("#categories_result").html('');
            insertSubcategories();
        }else{
            $("#categories_result").html('');
            var word = $("#search").val().toLowerCase();
            for(var id in subcategoryList){
                for(var sub in subcategoryList[id].subs){
                    if((subcategoryList[id].subs[sub].name.toLowerCase().search(word) !== -1) || (subcategoryList[id].name.toLowerCase().search(word) !== -1)){
                        $("#categories_result").append(
                            "<tr>" +
                            "<td>" + subcategoryList[id].subs[sub].name +"</td>" +
                            "<td>" + subcategoryList[id].name +"</td>" +
                            "<td><a href='" + BASE_URL + "subcategoriesCMS/editSubCategory/" +  btoa(btoa(subcategoryList[id].subs[sub].id)) + "' class='btn btn-info'><i class='icon icon-pencil'></i></a></td>" +
                            "<td><button class='btn btn-danger' onclick=" + 'deleteSubcategory("' + btoa(btoa(subcategoryList[id].subs[sub].id)) + '")' + "><i class='icon icon-trash'></i></button></td>" +
                            "</tr>"
                        );
                    }
                }
            }
        }
    }
</script>