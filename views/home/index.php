<div style="clear: both"></div>
<div class="container-fluid">
    <section>
        <div class="row">
            <div class="col-12">
                <div class="destaques">
                    <h3>Destaques</h3>
                    <div class="destaques_container">
                        <div class="row">
                            <?php foreach ($advertisementsData as $ad): ?>
                            <div class="col-md-4" style="padding-bottom: 15px;padding-top: 15px;">
                                <div class="ad-container">
                                    <div class="medias_container">
                                        <?php foreach ($ad['medias'] as $media): ?>
                                            <div <?php if($media['media_type'] != 3) echo 'class="embed-container"'; else echo 'class="ad-image-container"';;?> >
                                                <?php echo $media['media'] ?>
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
        </div>
    </section>
</div>
<script>

    $(document).ready(function(){
        $('.medias_container').slick({
            //autoplay: true,
            //autoplaySpeed: 15000,
            infinite: true
        });
    });

</script>