<div class="container" style="margin-bottom: 30px">
    <h1 style="text-align: center;margin-bottom: 30px;margin-top: 20px"><?php echo $advertisementData['title'] ?></h1>
    <div class="row">
        <div class="col-sm-12">
            <?php echo $advertisementData['description'] ?>

            <?php if(isset($advertisementData['userData'])): ?>
                <h4>Contato:</h4>
                <p><strong>E-mail: </strong><?php echo $advertisementData['userData']['email'] ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>
