<?php 
    $stmt = $pdo -> query("SELECT * FROM menu ORDER BY menu_nom DESC");
    $menus = $stmt -> fetchAll(PDO::FETCH_ASSOC);
    