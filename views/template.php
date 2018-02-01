<!DOCTYPE html>
	<head>
		<meta charset="utf-8" />
		<title><?php echo $viewData['title']; ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet" type="text/css">
		<!--!>
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/jquery-ui.min.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/jquery-ui.structure.min.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/jquery-ui.theme.min.css" type="text/css" />
        </!-->
		<!--!>Jquery</!-->
        <script type="text/javascript" src="<?php echo BASE_URL; ?>vendor/components/jquery/jquery.min.js"></script>
		<!--!>FormValidator</!-->
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
		<link href="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/theme-default.min.css"
			  rel="stylesheet" type="text/css" />
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
                google_ad_client: "ca-pub-1497286694536743",
                enable_page_level_ads: true
            });
        </script>
		<!--!>Google Re-captcha</!-->
		<script src='https://www.google.com/recaptcha/api.js?hl=pt-BR'></script>
	</head>
	<body>
		<nav class="navbar-top">
			<div class="container">
				<div class="navbar-top-logo">
					<a href="<?php echo BASE_URL; ?>"><img src="<?php echo BASE_URL; ?>assets/images/logo.jpg"></a>
				</div>
				<div class="navbar-top-icons">
					<ul>
						<li><a href="<?php echo BASE_URL; ?>info/empresa">A empresa</a></li>
						<?php if(isset($_SESSION['idLogin'])): ?>
							<li><a href="<?php echo BASE_URL; ?>user/account">Minha Conta</a></li>
							<li><a href="<?php echo BASE_URL; ?>user/advertisements">Meus Anúncios</a></li>
							<li><a href="<?php echo BASE_URL; ?>login/logoff">Sair</a></li>
						<?php else: ?>
							<li><a href="<?php echo BASE_URL; ?>login">Login/Cadastro</a></li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
		</nav>
		<header>
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
							<!-- Begin MailChimp Signup Form -->
							<form action="https://halfpet.us17.list-manage.com/subscribe/post?u=22576ceff542c54404ea407e4&amp;id=2d4c2b41dc" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
								<input type="email" value="" placeholder="Digite seu E-mail" name="EMAIL" class="required email subemail" id="mce-EMAIL">
								<input type="hidden" name="b_22576ceff542c54404ea407e4_2d4c2b41dc" tabindex="-1" value="">
								<input type="submit" value="Inscrever-se" name="subscribe" id="mc-embedded-subscribe" class="button">
							</form>
							<!--End mc_embed_signup-->
						</div>
						<div class="col-sm-2"></div>
					</div>
	    		</div>
	    	</div>
	    	<div class="links">
	    		<div class="container">
	    			<div class="row">
						<div class="col-sm-4">
							<a href="<?php echo BASE_URL; ?>"><img width="150" src="<?php echo BASE_URL; ?>assets/images/logo.jpg"></a><br/><br/>
							<strong>Slogan da Loja Virtual</strong><br/><br/>
							Endereço da Loja Virtual
						</div>
						<div class="col-sm-8 linkgroups">
							<div class="row">
								<div class="col-sm-4">
									<h3>Categorias</h3>
									<ul>
										<li><a href="#">Categoria X</a></li>
										<li><a href="#">Categoria X</a></li>
										<li><a href="#">Categoria X</a></li>
										<li><a href="#">Categoria X</a></li>
										<li><a href="#">Categoria X</a></li>
										<li><a href="#">Categoria X</a></li>
									</ul>
								</div>
								<div class="col-sm-4">
									<h3>Informações</h3>
									<ul>
										<li><a href="#">Menu 1</a></li>
										<li><a href="#">Menu 2</a></li>
										<li><a href="#">Menu 3</a></li>
										<li><a href="#">Menu 4</a></li>
										<li><a href="#">Menu 5</a></li>
										<li><a href="#">Menu 6</a></li>
									</ul>
								</div>
								<div class="col-sm-4">
									<h3>Informações</h3>
									<ul>
										<li><a href="#">Menu 1</a></li>
										<li><a href="#">Menu 2</a></li>
										<li><a href="#">Menu 3</a></li>
										<li><a href="#">Menu 4</a></li>
										<li><a href="#">Menu 5</a></li>
										<li><a href="#">Menu 6</a></li>
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
						<div class="col-sm-6">© <span>Loja 2.0</span> - Todos os Direitos Reservados.</div>
						<div class="col-sm-6">
							<div class="payments">
								<img src="<?php echo BASE_URL; ?>assets/images/visa.png" />
								<img src="<?php echo BASE_URL; ?>assets/images/visa.png" />
								<img src="<?php echo BASE_URL; ?>assets/images/visa.png" />
								<img src="<?php echo BASE_URL; ?>assets/images/visa.png" />
							</div>
						</div>
					</div>
	    		</div>
	    	</div>
	    </footer>
        <!--!>
        <script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/jquery-ui.min.js"></script>
        </!-->
        <script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/script_menu.js"></script>
		<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/script.js"></script>
	</body>
</html>