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
        <div class="table-responsive" >
            <table class="table display" id="table-advertisements">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Categoria<br>Subcategoria</th>
                        <th>Autor</th>
                        <th>Resumo</th>
                        <th>Ações</th>
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
    <p>Tem certeza que deseja excluir o anúncio <strong><span></span></strong> ?</p>
    <button class="btn btn-danger" onclick="yesDelete()">Sim</button>
    <button class="btn btn-success" onclick="notDelete()">Não</button>
</div>
<script>
    window.onload = function (){
        insertAdvertisements();
    };

    var idAdvertisement;
    var nameAdvertisement;
    function deleteAdvertisement(id, name){
        idAdvertisement = id;
        nameAdvertisement = name;
        $("#background-dark").show();
        $("#confirm-delete").show('fast');
        $("#confirm-delete").find('span').html(nameAdvertisement);
    }
    function notDelete(){
        $("#confirm-delete").hide('fast');
        $("#background-dark").hide();
    }

    function yesDelete(){
        window.location.href = '<?php echo BASE_URL ?>advertisementsCMS/deleteAdvertisement/' + idAdvertisement;
    }

    var advertisementsList = <?php echo json_encode($advertisementsData) ?>;

    function addDataTable(){
        $('#table-advertisements').DataTable( {
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            "order": [[ 0, "asc" ]],
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "Nenhum registro encontrado",
                "info": "Exibindo página _PAGE_ de _PAGES_ páginas",
                "infoEmpty": "Nenhum registro encontrado",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "search": "Pesquisa",
                "paginate": {
                    "first":      "Primeira",
                    "last":       "Última",
                    "next":       ">",
                    "previous":   "<"
                },
            }
        } );
    }

    function insertAdvertisements(){
        for(var id in advertisementsList){
            $("#advertisements_result").append(
                "<tr>" +
                "<td>" + advertisementsList[id].title +"</td>" +
                "<td>" + advertisementsList[id].category_name +"<br>" + advertisementsList[id].subcategory_name +"</td>" +
                "<td>(" + advertisementsList[id].type_name + ")<br>" + advertisementsList[id].user +"</td>" +
                "<td style='white-space: pre;'>" + advertisementsList[id].abstract +"</td>" +
                "<td>" +
                "<a href='" + BASE_URL + "advertisementsCMS/editAdvertisement/" +  btoa(btoa(advertisementsList[id].id)) + "' class='btn btn-info'><i class='icon icon-pencil'></i></a>" +
                "<button class='btn btn-danger' onclick=\"deleteAdvertisement('" +
                btoa(btoa(advertisementsList[id].id)) +
                "'," +
                "'" + advertisementsList[id].title +
                "')\" ><i class='icon icon-trash'></i></button>" +
                "</td>" +
                "</tr>"
            );
        }
        addDataTable();
    }
</script>