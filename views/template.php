<!DOCTYPE html>
	<head>
		<meta charset="utf-8" />
		<title><?php echo $viewData['title']; ?></title>
        <link rel="shortcut icon" href="<?php echo BASE_URL;?>/assets/images/favicon.png" type="image/png" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet" type="text/css">
		<!--!>Jquery</!-->
        <script type="text/javascript" src="<?php echo BASE_URL; ?>vendor/components/jquery/jquery.min.js"></script>
		<!--!>FormValidator</!-->
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
		<link href="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/theme-default.min.css" rel="stylesheet" type="text/css" />
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
        <!--!>Bootstrap Select</!-->
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>vendor/bootstrap-select/dist/css/bootstrap-select.css" type="text/css" />
        <script type="text/javascript" src="<?php echo BASE_URL; ?>vendor/bootstrap-select/dist/js/bootstrap-select.js"></script>
        <!--!>Menu Maker</!-->
        <script type="text/javascript" src="https://s3.amazonaws.com/menumaker/menumaker.min.js"></script>
        <!--!>Styles</!-->
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style_menu.css" type="text/css" />
		<!--!>Google Ads</!-->
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({
                google_ad_client: "ca-pub-6611541867419246",
                enable_page_level_ads: true
            });
        </script>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-116306177-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'UA-116306177-1');
        </script>
        <!--!>Google Re-captcha</!-->
		<script src='https://www.google.com/recaptcha/api.js?hl=pt-BR'></script>
	</head>
	<body>
		<header>
            <nav class="navbar-top">
                <div class="container">
                    <div style="display: flex">
                        <div style="flex: 1">
                            <a href="<?php echo BASE_URL; ?>"><img src="<?php echo BASE_URL; ?>assets/images/medium_logo.png"></a>
                        </div>
                        <div style="flex: 7; align-self: center;">
                            <div class="container">
                                <div id='cssmenu'>
                                    <ul>
                                        <li <?php if(isset($viewData['menuOptions']['url']) && $viewData['menuOptions']['url'] == 'home') echo "class='active'" ?> ><a href='<?php echo BASE_URL; ?>'>Home</a></li>
                                        <?php foreach ($viewData['categoryMenuData'] as $category): ?>
                                            <?php if(empty($category['subs'])): ?>
                                                <li <?php if(isset($viewData['menuOptions']['url']) && $viewData['menuOptions']['url'] == $category['slug']) echo "class='active'" ?> ><a href='<?php echo BASE_URL."categories/open/".$category['slug']; ?>'><?php echo $category['name'] ?></a></li>
                                            <?php else: ?>
                                                <li class='has-sub <?php if(isset($viewData['menuOptions']['url']) && $viewData['menuOptions']['url'] == $category['slug']) echo "active" ?>'><a href='<?php echo BASE_URL."categories/open/".$category['slug']; ?>'><?php echo $category['name'] ?></a>
                                                    <ul>
                                                        <?php foreach ($category['subs'] as $sub): ?>
                                                            <li><a href='<?php echo BASE_URL."categories/open/".$sub['slug']; ?>'><?php echo $sub['name'] ?></a></li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </li>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
		</header>
		<section>
            <?php $this->loadViewInTemplate($viewName, $viewData); ?>
	    </section>
	    <footer>
	    	<div class="subarea">
	    		<div class="container">
	    			<div class="row">
						<div class="col-sm-2"></div>
						<div class="col-sm-8">
							<form>
								<input type="text" id="inscribe-email" placeholder="Registre no nosso Newsletter" class="email subemail">
                                <button type="button" id="inscribe-button" class="button">Inscrever-se</button>
							</form>
						</div>
						<div class="col-sm-2"></div>
					</div>
	    		</div>
	    	</div>
	    	<div class="links">
	    		<div class="container">
	    			<div class="row">
						<div class="col-sm-4">
							<a href="<?php echo BASE_URL; ?>"><img width="150" src="<?php echo BASE_URL; ?>assets/images/logo2.png"></a><br/><br/>
							<strong>Slogan da empresa</strong><br/><br/>
							Endereço da Empresa
						</div>
						<div class="col-sm-8 linkgroups">
							<div class="row">
								<div class="col-sm-4">
									<h3>Categorias</h3>
									<ul>
                                        <?php foreach ($viewData['categoryMenuData'] as $category): ?>
                                            <li><a href="<?php echo BASE_URL."categories/open/".$category['slug']; ?>"><?php echo $category['name'] ?></a></li>
                                        <?php endforeach; ?>
									</ul>
								</div>
								<div class="col-sm-4">
									<h3>Informações</h3>
									<ul>
										<li><a href="#">Sobre a empresa</a></li>
                                        <li><a href="#">Facebook</a></li>
                                        <li><a href="#">Sobre a empresa</a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
	    		</div>
	    	</div>
	    	<div class="copyright">
	    		<div class="container">
	    			<div class="row">
						<div class="col-sm-6">© <span>Optium</span> - Todos os Direitos Reservados.</div>
						<div class="col-sm-6">
						</div>
					</div>
	    		</div>
	    	</div>
	    </footer>
        <!--!>
        <script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/jquery-ui.min.js"></script>
        </!-->
        <!--ALERT MODAL -->
        <div class="modal alert-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Sucesso</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Seu e-mail foi cadastrado em nossa lista. Em breve receberá atualizações</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-orange" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $("#inscribe-button").click(function(){
                var email = $('#inscribe-email').val();
                if(email != ''){
                    $.ajax({
                        url: '<?php echo BASE_URL; ?>home/inscribeRegister',
                        type: 'POST',
                        data: {'email': email},
                        success: function(result){
                            if(result == 'true'){
                                $('#inscribe-email').val('');
                                $('.alert-modal').modal('show');
                            }
                        }
                    });
                }
            });
        </script>
        <script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/script_menu.js"></script>
		<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/script.js"></script>
	</body>
</html>