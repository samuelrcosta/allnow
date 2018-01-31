<div class="container-fluid" style="margin-bottom: 30px">
    <h1 style="text-align: center;margin-bottom: 30px;margin-top: 20px"><?php echo $activeCategory['name'] ?></h1>
    <div class="row">
        <div class="col-sm-12">
            <?php foreach ($advertisementsData as $ad): ?>
                <div style="padding-bottom: 20px">
                    <a href="<?php echo BASE_URL."advertisements/open/".base64_encode(base64_encode($ad['id'])) ?>" style="display: block;color: black">
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
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>