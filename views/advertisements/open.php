<div class="container" style="margin-bottom: 30px">
    <h1 style="text-align: center;margin-bottom: 30px;margin-top: 20px"><?php echo $advertisementData['title'] ?></h1>
    <div class="row">
        <div class="col-sm-3">
            <h4 style="text-align: center;margin-bottom: 15px">Categorias</h4>
            <div class="list-group">
                <?php foreach ($categoriesData as $item): ?>
                    <a href="<?php echo BASE_URL."categories/open/".$item['slug']; ?>" class="list-group-item list-group-item-action <?php if($categoryData['id'] == $item['id']) echo 'active' ?>">
                        <strong><?php echo $item['name']; ?></strong>
                    </a>
                    <?php foreach ($item['subs'] as $sub): ?>
                        <a href="<?php echo BASE_URL."categories/open/".$sub['slug']; ?>" class="list-group-item list-group-item-action <?php if($categoryData['id'] == $sub['id']) echo 'active' ?>">
                            &nbsp;&nbsp;&nbsp;<?php echo $sub['name'] ?>
                            <span style="float: right" class="badge badge-dark badge-pill"><?php echo $sub['count_ads'] ?></span>
                        </a>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="col-sm-7">
            <?php echo $advertisementData['description'] ?>

            <?php if(isset($advertisementData['userData'])): ?>
                <h4>Contato:</h4>
                <p><strong>E-mail: </strong><?php echo $advertisementData['userData']['email'] ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>
