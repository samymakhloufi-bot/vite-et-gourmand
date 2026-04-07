<?php $activePage = 'Nos Menus'; ?>
<!DOCTYPE html >
<html lang="fr">
    
        <?php include __DIR__.'/includes/head.php';?>
    
    <body>
        <?php include __DIR__.'/includes/header.php';?>

        <div class="nos-menus-banner">
            <div class="nos-menus-banner_diag"></div>
            <div class="nos-menus-banner_dark_diag"></div>
            <div class="nos-menus-banner_text">
            <h2>Nos menus <em> & formules</em></h2></div>
        </div>

        <div class="page-menu-wrapper">

            <section class="filters-sidebar"> 
                
                <button class="filter-toggle" id="filter-toggle" aria-label="Afficher les filtres"> FILTRES
                    <span class="toggle-chevron">></span>
                </button>
        
                <div class="sidebar-wrapper"> 

                    <div class="filter-name"><h3>Filtres</h3>
                <button type="button" class="filter-reset">Réinitialiser</button></div>

                    <div class="filter">
                        <label for="select-theme">THÈME</label>
                        <select name="theme" id="select-theme">
                            <option value=""> Tous les Thèmes </option>
                            <option value="noel">Noël</option>
                            <option value="paque">Pâques</option>
                            <option value="mariage">Mariage</option>
                            <option value="seminaire">Séminaire</option>
                        </select>
                    </div>

                    <div class="filter" id="tags-regime">
                        <label for="select-regime">RÉGIME</label>
                        <button class="tag on" data-value="">Tous</button>
                        <button class="tag" data-value="non-vegan">Non-Vegan</button>
                        <button class="tag" data-value="vegan">Vegan</button>
                    
                    </div>

                    <div class="filter">
                        <label for="select-nb-personnes">NOMBRE DE PERSONNES</label>
                        <input type="number" class="counter-val" name="nb-personnes" id="select-nb-personnes" placeholder="Ex. 10">
                    </div>

                    <div class="filter">
                        <label for="select-prix">PRIX MAX. (€/pers)</label>
                        <input type="number" class="counter-val" name="prix-max" id="select-prix" placeholder="Ex. 50">
                        
                    </div>

                    <div class="filter">
                        <label for="select-price-fork">Budget</label>
                        <select name="theme" id="select-price-fork">
                            <option value=""> Tous les budgets </option>
                            <option value="[20,30]"> 20 - 30 </option>
                            <option value="[30,40]">30 - 40</option>
                            <option value="[40,50]">40 - 50</option>
                            <option value="[50,100]">+ 50</option>
                        </select>
                    </div>

                </div>
            </section>            

            <section class="menu-grid">
                <?php require './includes/Constants_menus.php';?>
                    <?php foreach ($Menus as $menu) {
                        $title = $menu['name'];
                        $link = $menu['link'];
                        $img_mobile = $menu['img_mobile'];
                        $img_desktop = $menu['img_desktop'];
                        $regime = $menu['regime'];
                        $theme = $menu['theme'];
                        $description_info = $menu['description_info'];
                        $price = $menu['price'];
                        $min_pers = $menu['nb_pers'][0];
                    ?> 
                
                <article class="menu-card" id="menu-card-menu"
                    data-regime="<?php echo $regime;?>"
                    data-theme="<?php echo $theme;?>"
                    data-prix="<?php echo $price;?>"
                    data-nb-max="<?php echo $menu['nb_pers'][1];?>">
                        
                    <picture>
                    <source media="(min-width:750px)" srcset="./Images/<?php echo $img_desktop;?>.png">
                    <img src="./Images/img/<?php echo $img_mobile;?>.png" alt="<?php echo $title;?>">        
                    </picture>
                    <div class="info-menu">
                        
                        <h3><?php echo $title;?></h3>
                        <span><?php echo $theme;?> - <?php echo $regime;?></span>
                        <span><?php echo $price;?>.€ /PERS.</span>
                    </div>
                    <div>
                        <form action="./commande.php" method="POST">
                            <input type="hidden"name="menu_id" value="<?php echo $menu['link']?>">
                            <input type="hidden"name="menu_name" value="<?php echo $menu['name']?>">
                            <input type="hidden"name="menu_prix" value="<?php echo $menu['price']?>">
            
                            <div class="menu-card-footer">
                        
                                <div class="nb-person">
                                    <span for="nbr-commande">NB. <br>PERSONNES</span>
                                    <button type="button"class="counter-btn" onclick="change(this, -1)">-</button>
                                    <input type="number" class="counter-val" name="nbr-commande" value="1" min="1">
                                    <button type="button" class="counter-btn" onclick="change(this, 1)">+</button>
                                </div>
                                    
                                <div class="btn-footer-card-menu">
                                    <button type="submit" class="btn-direct-order">Commander</button>
                                    <a href="./data/menu.php?id=<?php echo $link;?>" class="btn-details">Détails</a>
                                </div>

                            </div>
                        </form>
                    </div>
            

                </article>
                    <?php };?>
            </section>
        </div>

        <?php include __DIR__.'/includes/footer.php' ; ?>
        <script src="./js/commande.js"></script>
        <script src="./js/filtre.js"></script>
    </body>
</html>
