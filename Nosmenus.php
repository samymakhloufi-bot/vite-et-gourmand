<?php $activePage = 'menus'; ?>
<!DOCTYPE html >
<html lang="fr">
    
        <?php include __DIR__.'/index/head.php';?>
    
    <body>
        <?php include __DIR__.'/index/header.php';?>


        <div class="page-menu-wrapper">

            <section class="filters-sidebar"> 

                <label for="select-theme">THÈME</label>
                <select name="theme" id="select-theme">
                    <option value="">--Choisissez votre Thème--</option>
                    <option value="noel">Noël</option>
                    <option value="paque">Pâque</option>
                    <option value="mariage">Mariage</option>
                </select>

                <label for="select-regime">RÉGIME</label>
                <select name="regime" id="select-regime">
                    <option value="">--Choisissez votre Régime--</option>
                    <option value="nonvegan">Non-Vegan</option>
                    <option value="vegan">Vegan</option>
                </select>

                <label for="select-nb-personnes">NOMBRE DE PERSONNES</label>
                <select name="nb-personnes" id="select-nb-personnes">
                    <option value="">--Sélectionnez le nombre de personne--</option>
                    <option value="0-20">0 - 20</option>
                    <option value="20-30">20 - 30</option>
                    <option value="30-40">30 - 40</option>
                    <option value="40-50">40 - 50</option>
                    <option value="+50">+ 50</option>
                </select>

                <label for="select-prix">PRIX MAXIMUM</label>
                <select name="prix-max" id="select-prix">
                    <option value="">--Sélectionnez le prix de personne--</option>
                    <option value="20-30">20 - 30</option>
                    <option value="30-40">30 - 40</option>
                    <option value="40-50">40 - 50</option>
                    <option value="+50">+ 50</option>
                </select>

            </section>

            <section class="menu-grid">
                <?php require './index/Constants_menus.php';?>
                    <?php foreach ($Menus as $menu) {
                        $title = $menu['name'];
                        $link = $menu['link'];
                        $img_mobile = $menu['img_mobile'];
                        $img_desktop = $menu['img_desktop'];
                        $regime = $menu['regime'];
                        $theme = $menu['theme'];
                        $description_info = $menu['description_info'];
                        $price = $menu['price'];
                        $min_pers = $menu['min_pers'];
                    ?> 
                
                <article class="menu-card"> 
                        
                    <picture>
                    <source media="(min-width:750px)" srcset="./Images/<?php echo $img_desktop;?>.png">
                    <img src="./Images/<?php echo $img_mobile;?>.png" alt="<?php echo $title;?>">        
                    </picture>

                    <h3><?php echo $title;?></h3>
                    <p><?php echo $description_info;?>.</p>
                    
                    <div class="menu-card-footer">
                        <span>MIN : <?php echo $min_pers;?>. PERS. - <?php echo $price;?>.€ /PERS.</span>
                        <a href="./Menus/menu.php" class="btn-details">Détails du Menu</a>
                    </div>

                </article>
            <?php };?>
                

            </section>

        </div>

        <?php include __DIR__.'/index/footer.php' ; ?>

    </body>
</html>
