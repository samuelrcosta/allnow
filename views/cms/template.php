<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $viewData['title']; ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>vendor/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>vendor/font-awesome/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/styleCMS.css">
    <script src="<?php echo BASE_URL; ?>vendor/chart.js/chart.min.js"></script>
    <!--!>BASE URL</!-->
    <script type="text/javascript">var BASE_URL = '<?php echo BASE_URL; ?>';</script>
    <!--!>Jquery</!-->
    <script type="text/javascript" src="<?php echo BASE_URL; ?>vendor/components/jquery/jquery.min.js"></script>
    <!--!>Popper</!-->
    <script src="<?php echo BASE_URL; ?>vendor/popper.js/popper.min.js"></script>
    <!--!>Bootstrap 4</!-->
    <script type="text/javascript" src="<?php echo BASE_URL; ?>vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!--!>FormValidator</!-->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
    <link href="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/theme-default.min.css" rel="stylesheet" type="text/css" />
</head>
<body class="sidebar-fixed header-fixed">
<div class="page-wrapper">
    <nav class="navbar page-header">
        <a href="#" class="btn btn-link sidebar-mobile-toggle d-md-none mr-auto">
            <i class="fa fa-bars"></i>
        </a>

        <a class="navbar-brand" href="#">
            <img src="<?php echo BASE_URL; ?>assets/images/logo.jpg" alt="logo">
        </a>

        <a href="#" class="btn btn-link sidebar-toggle d-md-down-none">
            <i class="fa fa-bars"></i>
        </a>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item d-md-down-none">
                <a href="#">
                    <i class="fa fa-bell"></i>
                    <span class="badge badge-pill badge-danger">5</span>
                </a>
            </li>

            <li class="nav-item d-md-down-none">
                <a href="#">
                    <i class="fa fa-envelope-open"></i>
                    <span class="badge badge-pill badge-danger">5</span>
                </a>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="<?php echo BASE_URL; ?>assets/images/avatar_model.png" class="avatar avatar-sm" alt="logo">
                    <span class="small ml-1 d-md-down-none"><?php echo $viewData['userData']['name']; ?></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-header">Minha Conta</div>

                    <a href="#" class="dropdown-item">
                        <i class="fa fa-user"></i> Profile
                    </a>

                    <a href="#" class="dropdown-item">
                        <i class="fa fa-envelope"></i> Messages
                    </a>

                    <div class="dropdown-header">Configurações</div>

                    <a href="#" class="dropdown-item">
                        <i class="fa fa-bell"></i> Notifications
                    </a>

                    <a href="#" class="dropdown-item">
                        <i class="fa fa-wrench"></i> Settings
                    </a>

                    <a href="<?php echo BASE_URL; ?>admin/logoff" class="dropdown-item">
                        <i class="fa fa-lock"></i> Logout (Sair)
                    </a>
                </div>
            </li>
        </ul>
    </nav>

    <div class="main-container">
        <div class="sidebar">
            <nav class="sidebar-nav">
                <ul class="nav">
                    <li class="nav-title">Navegação</li>

                    <li class="nav-item">
                        <a href="<?php echo BASE_URL; ?>admin/dashboard" class="nav-link <?php echo ($viewData['link'] == 'admin/dashboard')?'active':''; ?>">
                            <i class="icon icon-speedometer"></i> Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?php echo BASE_URL; ?>adminAdvertisementsCMS" class="nav-link <?php echo ($viewData['link'] == 'adminAdvertisementsCMS/index')?'active':''; ?>">
                            <i class="icon icon-notebook"></i> Meus Anúncios
                        </a>
                    </li>

                    <li class="nav-item nav-dropdown">
                        <a href="#" class="nav-link nav-dropdown-toggle">
                            <i class="icon icon-settings"></i> Configurações <i class="fa fa-caret-left"></i>
                        </a>

                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a href="<?php echo BASE_URL; ?>categoriesCMS" class="nav-link <?php echo ($viewData['link'] == 'categoriesCMS/index')?'active':''; ?>">
                                    <i class="icon icon-organization"></i> Categorias
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo BASE_URL; ?>subcategoriesCMS" class="nav-link <?php echo ($viewData['link'] == 'subcategoriesCMS/index')?'active':''; ?>">
                                    <i class="icon icon-organization"></i> Sub-Categorias
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-title">More</li>

                    <li class="nav-item nav-dropdown">
                        <a href="#" class="nav-link nav-dropdown-toggle">
                            <i class="icon icon-umbrella"></i> Pages <i class="fa fa-caret-left"></i>
                        </a>

                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="icon icon-umbrella"></i> Blank Page
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="icon icon-umbrella"></i> Login
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="icon icon-umbrella"></i> Register
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="icon icon-umbrella"></i> Invoice
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="icon icon-umbrella"></i> 404
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="icon icon-umbrella"></i> 500
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="icon icon-umbrella"></i> Settings
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>

        <div class="content">
            <div class="container-fluid">
                <?php $this->loadViewInTemplate($viewName, $viewData); ?>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo BASE_URL; ?>assets/js/carbon.js"></script>
<script src="<?php echo BASE_URL; ?>assets/js/scriptCMS.js"></script>
</body>
</html>
