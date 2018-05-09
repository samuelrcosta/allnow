<div class="container-fluid" style="margin-bottom: 30px">
    <div class="site-map">
        <?php echo $site_map; ?>
    </div>
    <br>
    <div class="row">
        <div class="col-12">
            <h5 style="font-family: 'montserratlight', sans-serif;">Pesquisa</h5>
        </div>
        <div class="col-12">
            <form class="nav-search" role="search">
                <input type="text" id="search-input" name="word" placeholder="Digite o que você procura" value="<?php echo $word ?>">

                <button type="submit" class="nav-search-btn">
                    <i class="fas fa-search"><span>Buscar</span></i>
                </button>
            </form>
        </div>
        <div class="col-sm-12">
            <h2 style="margin-bottom: 10px; font-family: 'montserratlight', sans-serif;">Resultados de '<?php echo $word ?>'</h2>
            <div class='row'>
                <?php foreach ($advertisementsData as $ad): ?>
                    <div class="col-md-4" style="padding-bottom: 15px;padding-top: 15px;">
                        <div class="item-container">
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
                                <div class="rating-image rating-stars-<?php echo $ad['rating'] ?>"></div>
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
        // On search submit
        $('.nav-search').on('submit', function (e) {
            e.preventDefault();
            let word = $("#search-input").val();
            if(word !== ''){
                word = encodeURI(word);
                window.location.replace(BASE_URL + 'home/search/' + word);
            }
        });
    });
</script>