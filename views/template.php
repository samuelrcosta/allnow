<html lang="pt-br">
	<head>
		<meta charset="utf-8" />
		<title><?php echo $viewData['title']; ?></title>
        <link rel="shortcut icon" href="<?php echo BASE_URL;?>/assets/images/favicon.png" type="image/png" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet" type="text/css">
        <!--!>BASE URL</!-->
        <script type="text/javascript">var BASE_URL = '<?php echo BASE_URL; ?>';</script>
		<!--!>Jquery</!-->
        <script type="text/javascript" src="<?php echo BASE_URL; ?>vendor/components/jquery/jquery.min.js"></script>
        <!--!>Fonts</!-->
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>vendor/font-awesome/css/fontawesome-all.min.css">
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>vendor/simple-line-icons/css/simple-line-icons.css">
        <!--!>Slick</!-->
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>vendor/slick-1.8.0/slick/slick.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>vendor/slick-1.8.0/slick/slick-theme.css"/>
        <script type="text/javascript" src="<?php echo BASE_URL; ?>vendor/slick-1.8.0/slick/slick.min.js"></script>
		<!--!>Jquery Mask</!-->
        <script type="text/javascript" src="<?php echo BASE_URL; ?>vendor/igorescobar/jquery-mask-plugin/src/jquery.mask.js"></script>
        <!--!>Popper.js</!-->
        <script type="text/javascript" src="<?php echo BASE_URL; ?>vendor/popper.js/popper.min.js"></script>
		<!--!>Bootstrap 4</!-->
		<link rel="stylesheet" href="<?php echo BASE_URL; ?>vendor/twbs/bootstrap/dist/css/bootstrap.min.css" type="text/css" />
		<script type="text/javascript" src="<?php echo BASE_URL; ?>vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
        <!--!>Menu Maker</!-->
        <script type="text/javascript" src="https://s3.amazonaws.com/menumaker/menumaker.min.js"></script>
        <!--!>Styles</!-->
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style_menu.css" type="text/css" />
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-116306177-1"></script>
        <script type='text/javascript' src='//platform-api.sharethis.com/js/sharethis.js#property=5b075ecacbc3900011ee29ff&product=inline-share-buttons' async='async'></script>
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
                                <img style="margin-top: 15px;height: 35px;" src="<?php echo BASE_URL; ?>assets/images/rsz_nome_logo.png">
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
                                            <a href="<?= BASE_URL ?>info/about">Sobre</a>
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
        <script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/controllers/templateController.js"></script>
        <script>
            $(document).ready(function() {
                TemplateController.start();
            });
        </script>
        <script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/script_menu.js"></script>
		<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/script.js"></script>
	</body>
</html>