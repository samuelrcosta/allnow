<div style="clear: both"></div>
<div class="container">
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
                        <div style="padding-bottom: 20px">
                            <div class="row">
                                <div class="col-sm-5">
                                    <div <?php if($ad['media_type'] != 3) echo 'class="embed-container"';?> >
                                        <?php echo $ad['media'] ?>
                                    </div>
                                </div>
                                <div class="col-sm-7">
                                    <a href="<?php echo BASE_URL; ?>advertisements/open/<?php echo base64_encode(base64_encode($ad['id'])); ?>" style="display: block">
                                        <h5><?php echo $ad['title'] ?></h5>
                                        <p style="white-space: pre;"><?php echo $ad['abstract'] ?></p>
                                    </a>
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