<div class="container" style="margin-bottom: 30px">
    <div class="site-map">
        <?php echo $site_map; ?>
    </div>
    <hr>
    <div class="row">
        <div class="col-sm-4 filterarea">
            <h4><?php echo $categoryData['name'] ?></h4>
            <ul class="list-subcategories">
                <?php foreach ($categoryData['subs'] as $sub): ?>
                    <li><a href="<?php echo BASE_URL; ?>categories/open/<?php echo $sub['slug']; ?>"><?php echo $sub['name']; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="col-sm-8">
            <h1 style="margin-bottom: 30px"><?php echo $advertisementData['title'] ?></h1>
            <?php echo $advertisementData['description'] ?>

            <?php if(isset($advertisementData['userData'])): ?>
                <h4>Contato:</h4>
                <p><strong>E-mail: </strong><?php echo $advertisementData['userData']['email'] ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>
