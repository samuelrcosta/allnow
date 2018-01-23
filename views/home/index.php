<div class="top_img_back">
    <div class="top_frase_img">
        IMAGEM + FRASE
    </div>
</div>
<div style="clear: both"></div>
<div class="container">
    <div class="home_category_container">
        <ul class="nav justify-content-center">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home</a>
            </li>
            <?php foreach ($categoryData as $category): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL."categories/open/".$category['slug']; ?>"><?php echo $category['name'] ?></a>
                </li>
            <?php endforeach; ?>
            <li class="nav-item" style="padding-left: 10px;padding-right: 10px">
                <input class="form-control" placeholder="Pesquisar">
            </li>
        </ul>
    </div>
    <div class="instructions">
        <a href="#">Como Anunciar</a>
    </div>
    <section>
        <div class="row">
            <div class="col-10">
                <div class="destaques">
                    <h3>Destaques</h3>
                    <div class="destaques_container">
                        <?php foreach ($advertisementsData as $ad): ?>
                        <div class="advertisement-container" style="padding-bottom: 20px">
                            <div class="row">
                                <div class="col-sm-5">
                                    <div <?php if($ad['media_type'] != 3) echo 'class="embed-container"';?> >
                                        <?php echo $ad['media'] ?>
                                    </div>
                                </div>
                                <div class="col-sm-7">
                                    <h5><?php echo $ad['title'] ?></h5>
                                    <p style="white-space: pre;"><?php echo $ad['abstract'] ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="destaques">
                    <h3>Testemunhos</h3>
                    <div class="destaques_container">
                        Este local irá receber videos
                    </div>
                </div>
            </div>
            <div class="col-2">Anúncios</div>
        </div>
    </section>
    <div>
        Redes sociais
    </div>
</div>
<?php if(isset($_SESSION['idLogin'])) echo $_SESSION['idLogin']; ?>