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
        <a href="<?php echo BASE_URL ?>adminAdvertisementsCMS/newAdvertisement" class="btn btn-success" style="margin-bottom: 20px">Novo Anúncio</a>
        <div class="input-group" style="margin-bottom: 20px">
            <input type="text" class="form-control" id="search" placeholder="Busque por título, categoria, subcategoria ou resumo" onkeyup="search()">
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
        window.location.href = '<?php echo BASE_URL ?>adminAdvertisementsCMS/deleteAdvertisement/' + idAdvertisement;
    }

    var advertisementsList = <?php echo json_encode($advertisementsData) ?>;

    function insertAdvertisements(){
        for(var id in advertisementsList){
            $("#advertisements_result").append(
                "<tr>" +
                    "<td>" + advertisementsList[id].title +"</td>" +
                    "<td>" + advertisementsList[id].category_name +"</td>" +
                    "<td>" + advertisementsList[id].subcategory_name +"</td>" +
                    "<td style='white-space: pre;'>" + advertisementsList[id].abstract +"</td>" +
                    "<td><a href='" + BASE_URL + "adminAdvertisementsCMS/editAdvertisement/" +  btoa(btoa(advertisementsList[id].id)) + "' class='btn btn-info'><i class='icon icon-pencil'></i></a></td>" +
                    "<td><button class='btn btn-danger' onclick=" + 'deleteAdvertisement("' + btoa(btoa(advertisementsList[id].id)) + '")' + "><i class='icon icon-trash'></i></button></td>" +
                "</tr>"
            );
        }
    }

    function search(){
        if($("#search").val() == ''){
            $("#advertisements_result").html('');
            insertAdvertisements();
        }else{
            $("#advertisements_result").html('');
            var word = $("#search").val().toLowerCase();
            for(var id in advertisementsList){
                if((advertisementsList[id].title.toLowerCase().search(word) !== -1) || (advertisementsList[id].category_name.toLowerCase().search(word) !== -1) || (advertisementsList[id].subcategory_name.toLowerCase().search(word) !== -1) || (advertisementsList[id].abstract.toLowerCase().search(word) !== -1)){
                    $("#advertisements_result").append(
                        "<tr>" +
                        "<td>" + advertisementsList[id].title +"</td>" +
                        "<td>" + advertisementsList[id].category_name +"</td>" +
                        "<td>" + advertisementsList[id].subcategory_name +"</td>" +
                        "<td style='white-space: pre;'>" + advertisementsList[id].abstract +"</td>" +
                        "<td><a href='" + BASE_URL + "adminAdvertisementsCMS/editAdvertisement/" +  btoa(btoa(advertisementsList[id].id)) + "' class='btn btn-info'><i class='icon icon-pencil'></i></a></td>" +
                        "<td><button class='btn btn-danger' onclick=" + 'deleteAdvertisement("' + btoa(btoa(advertisementsList[id].id)) + '")' + "><i class='icon icon-trash'></i></button></td>" +
                        "</tr>"
                    );
                }
            }
        }
    }
</script>