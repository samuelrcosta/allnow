<div class="container" style="margin-bottom: 30px">
    <div class="site-map">
        <?php echo $site_map; ?>
    </div>
    <hr>
    <div class="row">
        <div class="col-sm-4 filterarea">
            <h4><?php echo $activePrincipalCategory['name'] ?></h4>
            <ul class="list-subcategories">
                <?php foreach ($activePrincipalCategory['subs'] as $sub): ?>
                    <li><a href="<?php echo BASE_URL; ?>categories/open/<?php echo $sub['slug']; ?>"><?php echo $sub['name']; ?></a></li>
                <?php endforeach; ?>
            </ul>
            <?php if($activePrincipalCategory['presential'] == '1'): ?>
                <form method="GET">
                    <div class="form-group">
                        <label for="filters[id_state]">Filtre por Estado</label>
                        <select class="form-control" name="filters[id_state]" id="id_state">
                            <option value="">Escolha uma opção</option>
                            <?php foreach ($statesData as $state): ?>
                                <option <?php if(isset($filters['id_state']) && $filters['id_state'] == $state['id']) echo "selected='selected'" ?> value="<?php echo $state['id']; ?>"><?php echo $state['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php if(isset($filters['id_state'])): ?>
                        <div class="form-group">
                            <label for="filters[id_city]">Filtre por Cidade</label>
                            <select class="form-control" name="filters[id_city]" id="id_city">
                                <option value="">Escolha uma opção</option>
                                <?php foreach ($citiesData as $city): ?>
                                    <option <?php if(isset($filters['id_city']) && $filters['id_city'] == $city['id']) echo "selected='selected'" ?> value="<?php echo $city['id']; ?>"><?php echo $city['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                </form>
            <?php endif; ?>
        </div>
        <div class="col-sm-8">
            <h1 style="margin-bottom: 30px"><?php echo $activeCategory['name'] ?></h1>
            <?php foreach ($advertisementsData as $ad): ?>
                <div style="padding-bottom: 20px">
                    <a href="<?php echo BASE_URL."advertisements/open/".base64_encode(base64_encode($ad['id_ad'])) ?>" style="display: block;color: black">
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