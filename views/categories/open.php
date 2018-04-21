<div class="container-fluid" style="margin-bottom: 30px">
    <div class="site-map">
        <?php echo $site_map; ?>
    </div>
    <br>
    <div class="row">
        <div class="col-sm-2 filterarea">
            <h4 class="responsive-categories-title">Categorias <i class="fas fa-angle-down"></i></h4>
            <div class="filterarea-categories-container">
                <h4><?php echo $activePrincipalCategory['name'] ?></h4>
                <ul class="list-subcategories">
                    <?php foreach ($activePrincipalCategory['subs'] as $sub): ?>
                        <li><a href="<?php echo BASE_URL; ?>categories/open/<?php echo $sub['slug']; ?>"><i class="fas fa-angle-double-right"></i>&nbsp<?php echo $sub['name']; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="col-sm-10">
            <h2 style="margin-bottom: 30px; padding-bottom: 5px; border-bottom: 2px solid #F79321;"><?php echo $activeCategory['name'] ?></h2>
            <div class='row'>
                <?php foreach ($advertisementsData as $ad): ?>
                <div class="col-md-6" style="padding-bottom: 15px;padding-top: 15px;">
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
<script>
    $(document).ready(function(){
        $('.medias_container').slick({
            //autoplay: true,
            //autoplaySpeed: 15000,
            infinite: true
        });

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