<div class="container-fluid" style="margin-bottom: 30px">
    <div class="site-map">
        <?php echo $site_map; ?>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <h2 style="margin-top: 20px;margin-bottom: 10px; font-family: 'montserratlight', sans-serif;"><?php echo $advertisementData['title'] ?></h2>
            <div class="card-block">
                <div class="row">
                    <div class="col-md-6 offset-3 offset-media">
                        <div class="medias_container">
                            <?php foreach ($advertisementData['medias'] as $media): ?>
                                <div class="ad-media-container media-type-<?= $media['media_type'] ?>" data-type="<?= $media['media_type'] ?>" data-media="<?= ($media['media_type'] != 3) ? $media['media'] : '' ?>" >
                                    <?php if($media['media_type'] == 1): ?>
                                        <div class="play-button"></div>
                                    <?php elseif($media['media_type'] == 2): ?>
                                        <div class="play-button"></div>
                                    <?php elseif($media['media_type'] == 3): ?>
                                        <?= $media['media'] ?>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <br>
                <div class="card-block-description">
                    <?php echo $advertisementData['description'] ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo BASE_URL; ?>assets/js/controllers/slidesController.js"></script>
<script>
    $(document).ready(function(){
        SlidesController.start();
    });
</script>
