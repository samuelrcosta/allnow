<div class="card">
    <div class="card-header bg-light">
        Meus anúncios
    </div>

    <div class="card-body">
        <?php if(isset($_GET['notification'])):?>
            <div class='alert <?php echo $_GET['status']; ?> notification'>
                <?php echo urldecode($_GET['notification']); ?>
            </div>
        <?php endif; ?>
        <a href="<?php echo BASE_URL ?>advertisementsCMS/new" class="btn btn-success" style="margin-bottom: 20px">Novo Anúncio</a>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Categoria</th>
                        <th>Subcategoria</th>
                        <th>Resumo</th>
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
    <button class="btn btn-danger" onclick="yesDelete()">Sim</button>
    <button class="btn btn-success" onclick="notDelete()">Não</button>
</div>
<script>
    window.onload = function (){
        insertAdvertisements();
    };

    var idAdvertisement;
    function deleteAdvertisement(id){
        $("#background-dark").show();
        $("#confirm-delete").show('fast');
        idAdvertisement = id;
    }
    function notDelete(){
        $("#confirm-delete").hide('fast');
        $("#background-dark").hide();
    }

    function yesDelete(){
        window.location.href = '<?php echo BASE_URL ?>adminAdvertisementsCMS/deleteAdvertisement/' + idSubcategory;
    }

    var advertisementsList = <?php echo json_encode($advertisementsData) ?>;

    function insertAdvertisements(){
        for(var id in advertisementsList){
            $("#advertisements_result").append(
                "<tr>" +
                    "<td>" + advertisementsList[id].title +"</td>" +
                    "<td>" + advertisementsList[id].id_category +"</td>" +
                    "<td>" + advertisementsList[id].id_subcategory +"</td>" +
                    "<td><a href='" + BASE_URL + "adminAdvertisementsCMS/editAdvertisement/" +  btoa(btoa(advertisementsList[id].id)) + "' class='btn btn-info'><i class='icon icon-pencil'></i></a></td>" +
                    "<td><button class='btn btn-danger' onclick=" + 'deleteAdvertisement("' + btoa(btoa(advertisementsList[id].id)) + '")' + "><i class='icon icon-trash'></i></button></td>" +
                "</tr>"
            );
        }
    }

    function search(){
        if($("#search").val() == ''){
            $("#categories_result").html('');
            insertAdvertisements();
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