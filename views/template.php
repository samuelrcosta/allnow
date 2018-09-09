<html lang="pt-br">
<head>
  <!--=============================================================================================================
  Criado por : Samuel Rocha Costa | email: samu.rcosta@gmail.com
  =====================================================================================================================-->
  <meta charset="utf-8" />
  <title><?php echo $viewData['title']; ?></title>
  <link rel="shortcut icon" href="<?php echo BASE_URL;?>/assets/images/favicon.png" type="image/png" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta property="og:title" content="<?php echo $viewData['title']; ?>"/>
  <meta property="og:site_name" content="Optium Tecnologia"/>
  <meta name="keywords" content="">
  <?php if(isset($viewData['shareData'])):?>
    <meta property="og:description" content="<?php echo $viewData['shareData']['description'];?>"/>
    <meta property="og:image" content="<?php echo $viewData['shareData']['image'];?>"/>
    <meta name="description" content="<?php echo $viewData['shareData']['description']; ?>">
  <?php else: ?>
    <?php if(isset($viewData['shareDescription'])):?>
      <meta property="og:description" content="<?php echo $viewData['shareDescription']; ?>"/>
    <?php else: ?>
      <meta property="og:description" content="<?php echo $viewData['title']; ?>"/>
    <?php endif;?>
    <meta property="og:image" content="<?php echo BASE_URL;?>assets/images/share_image.png"/>
  <?php endif;?>
  <?php if(isset($viewData['shareDescription'])):?>
    <meta name="description" content="<?php echo $viewData['shareDescription']; ?>">
  <?php endif;?>
  <meta name="Distribution" content="Global">
  <meta name="Rating" content="General">
  <meta name="author" content="Samuel R. Costa">
  <meta name="robots" content="index, follow">
  <meta name="robots" content="all">
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800">
  <!--!>BASE URL</!-->
  <script type="text/javascript">const BASE_URL = '<?php echo BASE_URL; ?>';</script>
  <!--!>Jquery</!-->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"
      integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <!--!>Fonts</!-->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.min.css">
  <!--!>Slick</!-->
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css"/>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
  <!--!>Jquery Mask</!-->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
  <!--!>Bootstrap 4</!-->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <!--!>Menu Maker</!-->
  <!--<script type="text/javascript" src="https://s3.amazonaws.com/menumaker/menumaker.min.js"></script>-->
  <!--!>Styles</!-->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css?v=1.0.3" type="text/css" />
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style_menu.css?v=1.1" type="text/css" />
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-116306177-1"></script>
  <script async type='text/javascript' src='//platform-api.sharethis.com/js/sharethis.js#property=5b075ecacbc3900011ee29ff&product=inline-share-buttons'></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-116306177-1');
  </script>
</head>
<body>
  <header>
    <nav class="navbar-top">
      <div class="container-fluid">
        <div class='menu-container'>
          <div class='img-top-logo-big' style="flex: 1">
            <a href="<?php echo BASE_URL; ?>">
              <img src="<?php echo BASE_URL; ?>assets/images/rsz_fav.png">
              <span>OPTIUM</span>
            </a>
          </div>
          <div class="menu-container-int">
            <div>
              <div id='cssmenu'>
                <ul>
                  <li class="<?= ($viewData['menuUrlActive'] == 'home') ? 'active' : '' ?>" >
                    <a href='<?php echo BASE_URL; ?>'>Home</a>
                  </li>
                  <?php foreach ($viewData['categoryMenuData'] as $category): ?>
                    <?php if(empty($category['subs'])): ?>
                      <li class="<?= ($viewData['menuUrlActive'] == $category['id']) ? 'active' : '' ?>">
                        <a href='<?php echo BASE_URL."areas/open/".$category['slug']; ?>'><?php echo $category['name'] ?></a>
                      </li>
                    <?php else: ?>
                      <li class='has-sub <?= ($viewData['menuUrlActive'] == $category['id']) ? 'active' : '' ?>'>
                        <a class="link-has-sub" href='<?php echo BASE_URL."areas/open/".$category['slug']; ?>'><?php echo $category['name'] ?></a>
                        <ul>
                          <?php foreach ($category['subs'] as $sub): ?>
                            <?php if(empty($sub['subs'])): ?>
                              <li>
                                <a href='<?php echo BASE_URL."categories/open/".$sub['slug']; ?>'><?php echo $sub['name'] ?></a>
                              </li>
                            <?php else: ?>
                              <li class='has-sub'>
                                <a class="link-has-sub" href='<?php echo BASE_URL."categories/open/".$sub['slug']; ?>'><?php echo $sub['name'] ?></a>
                                <ul>
                                  <?php foreach ($sub['subs'] as $catSub): ?>
                                    <li>
                                      <a href='<?php echo BASE_URL."categories/open/".$catSub['slug']; ?>'><?php echo $catSub['name'] ?></a>
                                    </li>
                                  <?php endforeach; ?>
                                </ul>
                              </li>
                            <?php endif; ?>
                          <?php endforeach; ?>
                        </ul>
                      </li>
                    <?php endif; ?>
                  <?php endforeach; ?>
                  <li class="<?= ($viewData['menuUrlActive'] == 'sobre') ? 'active' : '' ?>">
                    <a href="<?= BASE_URL ?>info/about">A Empresa</a>
                  </li>
                  <li class="<?= ($viewData['menuUrlActive'] == 'blog') ? 'active' : '' ?>">
                    <a target="_blank" href="<?= BLOG_URL ?>">Blog</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="menu-search-container">
            <form class="nav-search" role="search">
              <input type="text" id="search-input" name="word" value="<?=(isset($viewData['word']))? $viewData['word'] : '' ?>" autocomplete="off" placeholder="Pesquisa...">
              <button type="submit" class="nav-search-btn">
                <i class="icon-magnifier"><span>Buscar</span></i>
              </button>
            </form>
          </div>
          <div class="search-mobile-button">
            <i class="icon-magnifier"></i>
          </div>
        </div>
      </div>
    </nav>
  </header>
  <section class="site-container">
    <?php $this->loadViewInTemplate($viewName, $viewData); ?>
  </section>
  <div class="share-area">
    <div class="sharethis-inline-share-buttons"></div>
  </div>
  <footer>
    <div class="subarea">
      <div class="container">
        <div class="row">
          <div class="col-md-2"></div>
          <div class="col-md-8">
            <form class="inscribeForm">
              <input type="text" placeholder="Registre na nossa Newsletter" class="email subemail inscribe-email">
              <button type="button" data-type="footer" class="button inscribe-button">Inscrever-se</button>
            </form>
          </div>
          <div class="col-md-2"></div>
        </div>
      </div>
    </div>
    <div class="links">
      <div class="container">
        <div class="row">
          <div class="col-sm-4 footer-corporation-info" style="text-align: center">
            <a href="<?php echo BASE_URL; ?>"><img width="100" src="<?php echo BASE_URL; ?>assets/images/fav.png"></a><br/>
            <strong>Você no seu próximo nível</strong><br/>
            Algumas informações...
          </div>
          <div class="col-sm-8 linkgroups">
            <div class="row">
              <div class="col-sm-5">
                <h3>Informações</h3>
                <ul>
                  <li><a href="<?php echo BASE_URL; ?>info/about">Sobre a empresa</a></li>
                  <li><a href="<?php echo BASE_URL; ?>info/contact">Entre em contato</a></li>
                  <li><a href="<?php echo BASE_URL; ?>info/PrivacyPolicy">Política de privacidade</a></li>
                  <li><a href="<?php echo BASE_URL; ?>info/termsOfUse">Termos de uso</a></li>
                </ul>
              </div>
              <div class="col-sm-7">
                <h3>Redes Sociais</h3>
                <ul>
                  <li><a href="#">Facebook</a></li>
                  <li><a href="#">Instagram</a></li>
                  <li><a href="#">Twitter</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="copyright">
      <div class="container">
        © <span>Optium</span> - Todos os Direitos Reservados.
      </div>
    </div>
  </footer>
  <!--!>Popper.js</!-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script defer type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/controllers/templateController.js"></script>
  <script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/script_menu.js"></script>
  <script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/script.js"></script>
  <script>
    $(document).ready(function() {
      TemplateController.start();
    });
  </script>
</body>
</html>