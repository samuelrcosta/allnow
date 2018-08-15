<div style="clear: both"></div>
<div class="container-home-image">
  <div id="init" class="effect-phrase"><h1>A maior plataforma de produtos digitais do país:&nbsp;<span id="phrase-repeat"> </span></h1><br>
  </div>
</div>
<div class="container-fluid container-content-homepage">
  <section>
    <div class="newsletter-top">
      <div class="container">
        <div class="row">
          <div class="col-md-2"></div>
          <div class="col-md-8">
            <form class="inscribeForm">
              <input type="text" autocomplete="off" placeholder="Registre na nossa Newsletter" class="email subemail inscribe-email">
              <button type="button" data-type="home" class="button inscribe-button"><i class="fa fa-envelope"></i></button>
            </form>
          </div>
          <div class="col-md-2"></div>
        </div>
      </div>
    </div>
    <?php if($tutorialData['status'] == 'on'): ?>
      <div class="tutorial-container">
        <div class="tutorial-title">
          <h2><?= $tutorialData['data']['title']; ?></h2>
        </div>
        <div class="row">
          <div class="<?= (!empty($tutorialData['data']['text'])) ? 'col-md-5' : 'col-md-6' ?> offset-3 tutorial-video">
            <div class="tutorial_media_container">
              <div class="tutorial-ad-media-container media-type-<?= $tutorialData['data']['media_type'] ?>" data-type="<?= $tutorialData['data']['media_type'] ?>" data-media="<?= $tutorialData['data']['media'] ?>" >
                <div class="play-button principal-play-button"></div>
              </div>
            </div>
          </div>
          <?php if(!empty($tutorialData['data']['text'])): ?>
          <div class="col-md-3">
            <div class="tutorial-text"><?= $tutorialData['data']['text'] ?></div>
          </div>
          <?php endif; ?>
        </div>
      </div>
    <?php endif; ?>
    <div class="row">
      <div class="col-12">
        <div class="highlights">
          <h3>Destaques</h3>
          <div class="highlights_container">
            <div class="row">
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
    </div>
  </section>
</div>
<script src="<?php echo BASE_URL; ?>assets/js/controllers/slidesController.js"></script>
<script src="<?php echo BASE_URL; ?>assets/js/controllers/homePageController.js"></script>
<script>
  $(document).ready(function(){
    SlidesController.start();
    PageController.start();
  });
</script>