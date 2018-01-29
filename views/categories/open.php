<div class="container-fluid" style="margin-bottom: 30px">
    <h1 style="text-align: center;margin-bottom: 30px;margin-top: 20px"><?php echo $activeCategory['name'] ?></h1>
    <div class="row">
        <div class="col-sm-4 filterarea">
            <h4 style="text-align: center;margin-bottom: 15px">Categorias</h4>
            <form method="GET">
                <div class="form-group">
                    <label for="category">Categoria</label><br>
                    <select name="filters[category]" id="category" class="selectpicker" data-live-search="true" data-live-search-placeholder="Pesquisa" title="Escolha uma categoria">
                        <?php foreach ($categoriesData as $item): ?>
                            <option value="<?php echo $item['slug']; ?>" <?php if($categoryData['id'] == $item['id']) echo 'selected="selected"' ?>><?php echo $item['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group" id="form-subcategory">
                    <label for="subcategory">Sub-Categoria</label><br>
                    <?php if(isset($filters['category'])): ?>
                    <select name="filters[subcategory]" id="subcategory" class="selectpicker" data-live-search="true" data-live-search-placeholder="Pesquisa" title="Selecione">
                        <?php foreach ($subcategoriesData as $subcategory): ?>
                            <option <?php echo(isset($subcategoryData) && $subcategoryData['id'] == $subcategory['id'])?'selected="selected"':''; ?> value="<?php echo $subcategory['slug']; ?>"><?php echo $subcategory['name']; ?></option>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <select name="subcategory_id" id="subcategory_id" class="selectpicker" data-live-search="true" disabled>
                            <option value="" selected="selected">Escolha uma categoria</option>
                            <?php endif; ?>
                        </select>
                </div>
            </form>

            <div class="list-group">
                <?php foreach ($categoriesData as $item): ?>
                    <a href="<?php echo BASE_URL."categories/open/".$item['slug']; ?>" class="list-group-item list-group-item-action <?php if($activeCategory['id'] == $item['id']) echo 'active' ?>">
                        <strong><?php echo $item['name']; ?></strong>
                    </a>
                    <?php foreach ($item['subs'] as $sub): ?>
                        <a href="<?php echo BASE_URL."categories/open/".$sub['slug']; ?>" class="list-group-item list-group-item-action <?php if($activeCategory['id'] == $sub['id']) echo 'active' ?>">
                            &nbsp;&nbsp;&nbsp;<?php echo $sub['name'] ?>
                            <span style="float: right" class="badge badge-dark badge-pill"><?php echo $sub['count_ads'] ?></span>
                        </a>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="col-sm-8">
            <?php foreach ($advertisementsData as $ad): ?>
                <div class="advertisement-container" style="padding-bottom: 20px">
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