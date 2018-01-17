<div class="container">
    <h1>Meus Anúncios</h1>
    <a href="<?php echo BASE_URL; ?>user/newAdvertisement" class="btn btn-success">+ Novo Anúncio</a>
    <div class="ad-container">
        <?php if(!empty($adsData)): ?>
        <?php else: ?>
            <div class="empty-ads">
                Nenhum anúncio cadastrado.<br>
                <a href="<?php echo BASE_URL; ?>user/newAdvertisement" class="btn btn-success">Cadastrar anúncio</a>
            </div>
        <?php endif; ?>
    </div>
</div>