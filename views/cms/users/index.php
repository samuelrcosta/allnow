<div class="card">
    <div class="card-header bg-light">
        Usuários Cadastrados
    </div>

    <div class="card-body">
        <?php if(isset($_GET['notification'])):?>
            <div class='alert <?php echo $_GET['status']; ?> notification'>
                <?php echo urldecode($_GET['notification']); ?>
            </div>
        <?php endif; ?>
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
                    <th>E-mail</th>
                    <th>Anúncios</th>
                    <th>Editar</th>
                    <th>Excluir</th>
                </tr>
                </thead>
                <tbody id="users_result">
                </tbody>
            </table>
        </div>
    </div>
</div>
<div id="background-dark" style="display: none"></div>
<div id="confirm-delete" style="display: none">
    <p>Tem certeza que deseja excluir o usuário e <strong>todos os seus anúncios</strong>?</p>
    <button class="btn btn-danger" onclick="yesDelete()">Sim</button>
    <button class="btn btn-success" onclick="notDelete()">Não</button>
</div>
<script>
    window.onload = function (){
        insertUsers();
    };

    var idUser;
    function deleteUser(id){
        $("#background-dark").show();
        $("#confirm-delete").show('fast');
        idUser = id;
    }
    function notDelete(){
        $("#confirm-delete").hide('fast');
        $("#background-dark").hide();
    }

    function yesDelete(){
        window.location.href = '<?php echo BASE_URL ?>usersCMS/deleteUser/' + idUser;
    }

    var usersList = <?php echo json_encode($usersData) ?>;

    function insertUsers(){
        for(var id in usersList){
            $("#users_result").append(
                "<tr>" +
                    "<td>" + usersList[id].name +"</td>" +
                    "<td>" + usersList[id].email +"</td>" +
                    "<td>" + usersList[id].count_ads +"</td>" +
                    "<td><a href='" + BASE_URL + "usersCMS/editUser/" +  btoa(btoa(usersList[id].id)) + "' class='btn btn-info'><i class='icon icon-pencil'></i></a></td>" +
                    "<td><button class='btn btn-danger' onclick=" + 'deleteUser("' + btoa(btoa(usersList[id].id)) + '")' + "><i class='icon icon-trash'></i></button></td>" +
                "</tr>"
            );
        }
    }

    function search(){
        if($("#search").val() == ''){
            $("#users_result").html('');
            insertUsers();
        }else{
            $("#users_result").html('');
            var word = $("#search").val().toLowerCase();
            for(var id in usersList){
                if((usersList[id].name.toLowerCase().search(word) !== -1) || (usersList[id].email.toLowerCase().search(word) !== -1)){
                    $("#users_result").append(
                        "<tr>" +
                            "<td>" + usersList[id].name +"</td>" +
                            "<td>" + usersList[id].email +"</td>" +
                            "<td>" + usersList[id].count_ads +"</td>" +
                            "<td><a href='" + BASE_URL + "usersCMS/editUser/" +  btoa(btoa(usersList[id].id)) + "' class='btn btn-info'><i class='icon icon-pencil'></i></a></td>" +
                            "<td><button class='btn btn-danger' onclick=" + 'deleteUser("' + btoa(btoa(usersList[id].id)) + '")' + "><i class='icon icon-trash'></i></button></td>" +
                        "</tr>"
                    );
                }
            }
        }
    }
</script>