<style>
    .embed-container iframe, .embed-container object, .embed-container embed {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
    .embed-container {
        position: relative;
        padding-bottom: 56.25%;
        height: 0;
        overflow: hidden;
        max-width: 100%;
    }
    .embed-container iframe, .embed-container object, .embed-container embed {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
</style>
<div class="container">
    <h1>Meus Anúncios</h1>
    <?php if(isset($_GET['notification'])):?>
        <div class='alert <?php echo $_GET['status']; ?> notification'>
            <?php echo urldecode($_GET['notification']); ?>
        </div>
    <?php endif; ?>
    <a href="<?php echo BASE_URL; ?>user/newAdvertisement" class="btn btn-success">+ Novo Anúncio</a>
    <div class="ad-container">
        <?php if(!empty($adsData)): ?>
            <table class="table table-hover table-bordered" style="margin: 0">
                <thead>
                    <tr>
                        <th style="min-width: 200px">Mídia</th>
                        <th>Título</th>
                        <th>Categoria</th>
                        <th>Resumo</th>
                        <th>Editar</th>
                        <th>Excluir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($adsData as $ad): ?>
                    <tr>
                        <td>
                            <div <?php if($ad['media_type'] != 3) echo 'class="embed-container"';?> >
                                <?php echo $ad['media'] ?>
                            </div>
                        </td>
                        <td><?php echo $ad['title']; ?></td>
                        <td><?php echo $ad['category_name']; ?><br><?php echo $ad['subcategory_name']; ?></td>
                        <td style="white-space: pre;"><?php echo $ad['abstract']; ?></td>
                        <td><a class="btn btn-warning" href="<?php echo BASE_URL."user/editAdvertisement/".base64_encode(base64_encode($ad['id'])); ?>"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABoAAAAaCAYAAACpSkzOAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAJTSURBVEhLtZVNS5RxFMVnmjIVSintFdR2EVQfQCgsgnatog8QLlsJgV/AVZuQkiAiRNq0cpO6CdyUvVBqqRVlfgC3bRJm+p0/58bwME3PM44HDvf+79xzDo/Pi6V2oVqt3oCz8GGtVjvhcXuB+SisEpBA+5My5J93D8zKsBPjy/CXQgIKg4NebR14VTB6Ahfpu6l7E4bBhTCmRthIzAKcv8Auy/IDbRnhbWoH9UoYUyPs7yzA+brl+YBGIZMWT2lWb0yNsKsxE+gvJoM8YF8hDyzcgmfgYY77qY3CrmkGJ23xfyBUyJSNUghtL3xP/5z6r7Dz1LJtmkOLCB7ZYIsyBHvo32km0I9rl1ofNp0M8oD9fQgeW5heQpgNWaB0wz4YD8gSPGmb5kCU3hNqNuStZgL9AuyCx+AanGXcAXP/uSrwKUwhcJA2GzIPI+SzZ98o+b5zLOpKpi3chBHyRjOBPkL6YYR8hadt0xzsK2TGwvqQJc0E+nmKvm/1IXr7T9mmOdjXI/rMwk3KAMyGzFEi5JNnGzDfjRdYnrDwByVCXmsm0DcKWacU+9+D6LvF5ygKeaWzQD8HD0KFrHqmp+y45fmA7qzFGzpT70C9nJq9gBGy4tmqzklcBIjGbHDPI82GYaOQZZ29VgwIX9pkxCNdpd52vekKWfbvHyl9XikGhLofv6G+UQc81ryX2S0Y9+QDPOqfiwOPmzISMLoP78JFuOOx5uvwiCWtAZ/0qckC4204A3VVh7zeOjBZs7fMV+AEHOZY8Up7gOklOIrxgEd7gFLpD5qyXoVJ4aGvAAAAAElFTkSuQmCC"></a></td>
                        <td><button class="btn btn-danger" onclick="deleteAdvertisement('<?php echo base64_encode(base64_encode($ad['id'])); ?>')"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABoAAAAaCAYAAACpSkzOAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAEySURBVEhL7ZE9SgNRFIVHmxSJCZPCBaSwswmW2UFqIcsw2AiSMmQJEgub4BbcgH2KNClCwCFICkHERtQwyfd454ETzc9kJtjMB4c757777hlmvE2EYVhFffQ1/80b/TuU0/jusORJS9dxpfHt4MIh8p0IOaHOqe+Uius70W9SzfnDUv9IK6NweMBhGY14TgV2tVBeERb6JXucLgTdK8JCo4he96BbRUThJcw/Mv8ikQg41sq/YSiVT0hQ9JMtw8z/BHHhG43RRP5T/ln+Q35qvAMfOygwfeqp/EBzNflHndeNd+CzoCzIgs+CsiALPnbQC+WceikfyLfkh/Id4x34jUEFO5oMgnpauRqGzFsngh3XWrcahhpopjux4e6Y4mvdehg+Q23UjaEbdIGKWvMDz1sAYAaUcy/r9NoAAAAASUVORK5CYII="></button></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-ads">
                Nenhum anúncio cadastrado.<br>
                <a href="<?php echo BASE_URL; ?>user/newAdvertisement" class="btn btn-success">Cadastrar anúncio</a>
            </div>
        <?php endif; ?>
    </div>
</div>
<div id="background-dark" style="display: none"></div>
<div id="confirm-delete" style="display: none">
    <p>Tem certeza que deseja excluir o anúncio?</p>
    <button class="btn btn-danger" onclick="yesDelete()">Sim</button>
    <button class="btn btn-success" onclick="notDelete()">Não</button>
</div>
<script>
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
        window.location.href = '<?php echo BASE_URL ?>user/deleteAdvertisement/' + idAdvertisement;
    }
</script>