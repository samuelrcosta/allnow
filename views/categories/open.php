<div class="container-fluid" style="margin-bottom: 30px">
    <div class="site-map">
        <?php echo $site_map; ?>
    </div>
    <br>
    <div class="row">
        <div class="col-sm-12">
            <h2 style="margin-bottom: 10px; font-family: 'montserratlight', sans-serif;"><?php echo $activeCategory['name'] ?></h2>
            <div class='row'>
                <?php foreach ($advertisementsData as $ad): ?>
                    <div class="col-md-4" style="padding-bottom: 15px;padding-top: 15px;">
                        <div class="ad-container">
                            <div class="medias_container">
                                <?php foreach ($ad['medias'] as $media): ?>
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
                            <div class="promo-box">
                                <?php foreach ($ad['badges'] as $bagde): ?>
                                    <div class="promo <?php echo $bagde['class'] ?>">
                                        <span class="promo-text"><?php echo $bagde['name'] ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <a class="ad-description" href="<?php echo BASE_URL; ?>advertisements/open/<?php echo $ad['slug']; ?>">
                                <h5 class='ad-description-title'><?php echo $ad['title'] ?></h5>
                                <p class='ad-description-abstract'><?php echo $ad['abstract'] ?></p>
                                <?php if(!empty($ad['rating'])): ?>
                                    <div class="rating-image rating-stars-<?php echo $ad['rating'] ?>"></div>
                                <?php endif; ?>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo BASE_URL; ?>assets/js/controllers/slidesController.js"></script>
<script>
    $(document).ready(function(){
        SlidesController.start();
        $('.responsive-categories-title').click(function(){
            if($('.filterarea-categories-container').hasClass('opened')){
                $(this).find('i').removeClass('fa-angle-up').addClass('fa-angle-down');
                $('.filterarea-categories-container').removeClass('opened');
                $('.filterarea-categories-container').slideUp();
            }else{
                $(this).find('i').removeClass('fa-angle-down').addClass('fa-angle-up');
                $('.filterarea-categories-container').addClass('opened');
                $('.filterarea-categories-container').slideDown();
            }
        });
    });
</script>