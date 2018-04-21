<div class="container-fluid" style="margin-bottom: 30px">
    <div class="site-map">
        <?php echo $site_map; ?>
    </div>
    <br>
    <div class="row">
        <div class="col-md-2 filterarea">
            <h4><?php echo $categoryData['name'] ?></h4>
            <ul class="list-subcategories">
                <?php foreach ($categoryData['subs'] as $sub): ?>
                    <li><a href="<?php echo BASE_URL; ?>categories/open/<?php echo $sub['slug']; ?>"><i class="fas fa-angle-double-right"></i>&nbsp<?php echo $sub['name']; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="col-md-10">
            <h2 style="margin-bottom: 30px; padding-bottom: 5px; border-bottom: 2px solid #F79321;"><?php echo $advertisementData['title'] ?></h2>
            <?php foreach($advertisementData['medias'] as $media): ?>
                <div style="margin-top: 20px" <?php if($media['media_type'] != 3) echo 'class="embed-container"';?> >
                    <?php echo $media['media'] ?>
                </div>
            <?php endforeach; ?>
            <br>

            <?php echo $advertisementData['description'] ?>

            <?php if(isset($advertisementData['userData'])): ?>
                <h4>Contato:</h4>
                <p><strong>E-mail: </strong><?php echo $advertisementData['userData']['email'] ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>
