<?php $activePage = 'menus'; ?>
<!DOCTYPE html >
<html lang="fr">
    
        <?php include __DIR__.'/../includes/head.php';?>
    
    <body>
        <?php include __DIR__.'/../includes/header.php';?>

        <main>
            <?php 
            require __DIR__.'/../includes/Constants_menus.php';
            $id = $_GET['id'];
            $menu_actif = null;
            foreach ($Menus as $menu){
                if($menu['link'] === $id){
                    $menu_actif =$menu;
                    break;
                }
            } ?>

            <article class="menu-detail">
                <div class="menu-detail-header">
                    <picture>
                        <source media="(min-width:750px)" srcset="../Images/<?php echo $menu_actif['img_desktop'];?>.png">
                        <img src="../Images/<?php echo $menu_actif['img_mobile'];?>.png" alt="image du menu Amour Éternel" class="menu-detail-img">        
                    </picture>
                    <div class="menu-detail-headline">
                        <h2><?php echo $menu_actif['name'];?></h2>
                        <p class="menu-chef-note"><em>Note du Chef :</em> 
                        <?php echo $menu_actif['description'];?></p>
                    </div>
                </div>

                <h3>Entrée : <?php echo $menu_actif['entree'];?></h3>
                <ul><?php foreach ($menu_actif['entree_description'] as $ligne):?>
                
                    <li><?php echo $ligne; ?></li>
                    <?php endforeach;?>
                </ul>

                <h3>Plat : <?php echo $menu_actif['plat'];?></h3>
                <ul><?php foreach ($menu_actif['plat_description'] as $ligne):?>
                    <li><?php echo $ligne; ?></li>
                    <?php endforeach;?>
                </ul>

                <h3>Boisson :</h3>
                <ul><?php foreach($menu_actif['boisson'] as $ligne):?>
                    <li><?php echo $ligne; ?></li>
                    <?php endforeach;?>
                </ul>

                <h3>Dessert : <?php echo $menu_actif['dessert'];?></h3>
                <ul><?php foreach ($menu_actif['dessert_description'] as $ligne):?>
                    <li><?php echo $ligne;?></li>
                    <?php endforeach;?>
                </ul>

                <h3>Allergènes :</h3>
                <ul>
                <li><?php echo implode(', ',$menu_actif['allergene']);?></li>
                </ul>

                <div class="menu-detail-footer">
                    <em class="menu-price">Prix : <?php echo $menu_actif['price'];?> €/ personne - Min : <?php echo $menu_actif['min_pers'];?> Personnes</em>
                    <a href="../commande.php" class="btn-order">Commander</a>
                </div>
            </article>
        </main>

        <?php include __DIR__.'/../includes/footer.php' ;?>

    </body>
</html>
