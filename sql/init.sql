-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mer. 17 juin 2026 à 09:39
-- Version du serveur : 8.0.46-0ubuntu0.24.04.2
-- Version de PHP : 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `vite_et_gourmand`
--

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

CREATE TABLE `avis` (
  `Id_avis` int NOT NULL,
  `Id_user` int NOT NULL,
  `contenu` text NOT NULL,
  `statut_avis` enum('en_attente','valide','refuse') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'en_attente',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `note` tinyint DEFAULT '5'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `avis`
--

INSERT INTO `avis` (`Id_avis`, `Id_user`, `contenu`, `statut_avis`, `created_at`, `note`) VALUES
(20, 21, 'incr', 'valide', '2026-06-10 17:10:17', 5),
(21, 21, 'r\"raear', 'valide', '2026-06-10 17:10:31', 5),
(22, 21, 'Belle qualité de produit.\r\n\r\nMontage plus long que prévu. Nous l’avons monté à 2 mais c’est du sport. La notice est globalement bien expliqué mais certaines étapes nous ont demandé réflexion malgré les dessins qui auraient mérité un peu plus de détails ou de \"gros plan\".\r\n\r\nPrévoir un escabeau pour pouvoir fixer les plaques du milieu du toit entre elles. Il faut faire \"jouer\" la tôle par endroit pour aligner les trous et visser. Le plastique situé sur certaines pièces protège bien mais il est long et fastidieux à enlever... anticipez...\r\n\r\nJe suis contente de mon achat. A voir si la cabanon aura toujours aussi belle allure dans quelques années...', 'valide', '2026-06-10 17:17:17', 4),
(23, 21, 'Publicité mensongère le cabanon est plus petit que désigné dans le descriptif.En plus pas solide du se tord comme du carton, vous le monter la tôle se froisse des sue vous visser un peu trop fort.les trous ne correspondent Pas. Très dessus de mon achat je fait pas la Publicité de se commerçant. J\'ai intérêt de bien le fixer au sol car vu la solidité il pourrait s envolée. Je c\'est pas où il ont vu abrit xl.je recommande pas du tout', 'valide', '2026-06-10 17:17:23', 1),
(24, 21, 'Très simple à monté de très bonne qualité et manuel de montage bien expliqué', 'valide', '2026-06-10 17:17:28', 5);

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `Id_commande` int NOT NULL,
  `Id_user` int NOT NULL,
  `date_livraison` datetime NOT NULL,
  `statut` enum('en_attente','accepte','en_preparation','en_cours_de_livraison','livre','en_attente_retour_materiel','terminee','annulee') NOT NULL DEFAULT 'en_attente',
  `mode_paiement` enum('devis','carte_bancaire') NOT NULL,
  `ville_livraison` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `adresse_livraison` varchar(200) NOT NULL,
  `motif_annulation` text,
  `mode_contact` enum('appel','mail') DEFAULT NULL,
  `date_commande` date DEFAULT NULL,
  `complement` text,
  `distance_km` decimal(10,2) NOT NULL DEFAULT '0.00',
  `frais_livraison` decimal(10,2) NOT NULL DEFAULT '0.00',
  `materiel_prete` tinyint(1) DEFAULT '0',
  `materiel_restitue` tinyint(1) DEFAULT '0',
  `date_pret` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`Id_commande`, `Id_user`, `date_livraison`, `statut`, `mode_paiement`, `ville_livraison`, `adresse_livraison`, `motif_annulation`, `mode_contact`, `date_commande`, `complement`, `distance_km`, `frais_livraison`, `materiel_prete`, `materiel_restitue`, `date_pret`) VALUES
(7, 21, '2026-07-17 11:30:00', 'en_attente_retour_materiel', 'carte_bancaire', 'autre', '6 Résidence de l\'Oreuse', NULL, NULL, '2026-06-05', '', 252.21, 153.80, 0, 0, NULL),
(8, 21, '2026-07-17 11:30:00', 'accepte', 'carte_bancaire', 'autre', '6 Résidence de l\'Oreuse', NULL, NULL, '2026-06-05', '', 563.65, 337.56, 0, 0, NULL),
(9, 21, '2026-07-08 18:21:00', 'annulee', 'carte_bancaire', 'autre', '6 Résidence de l\'Oreuse', NULL, NULL, '2026-06-07', '', 610.84, 365.39, 0, 0, NULL),
(10, 21, '2026-07-02 19:18:00', 'en_attente_retour_materiel', 'carte_bancaire', 'autre', '6 Résidence de l\'Oreuse', NULL, NULL, '2026-06-07', '', 610.84, 365.39, 0, 0, NULL),
(11, 21, '2026-06-26 12:20:00', 'annulee', 'carte_bancaire', 'Thorigny-sur-Oreuse, France', '6 Résidence de l\'Oreuse', NULL, NULL, '2026-06-07', '', 610.84, 365.39, 0, 0, NULL),
(17, 21, '2026-07-05 03:50:00', 'en_cours_de_livraison', 'carte_bancaire', 'Talence, France', '6 Résidence de l\'Oreuse', NULL, NULL, '2026-06-08', 'Aucun complement d\'adresse', 5.84, 8.45, 0, 0, NULL),
(18, 21, '2026-07-10 02:57:00', 'en_attente', 'carte_bancaire', 'Marseille, France', '6 Résidence de l\'Oreuse', NULL, NULL, '2026-06-08', '', 644.77, 385.41, 0, 0, NULL),
(19, 21, '2026-07-29 17:58:00', 'en_attente', 'carte_bancaire', 'Argelès-sur-Mer, France', '6 Résidence de l\'Oreuse', NULL, NULL, '2026-06-08', '', 475.27, 285.41, 0, 0, NULL),
(20, 21, '2026-10-29 20:30:00', 'en_attente', 'carte_bancaire', 'Sainte-Geneviève-des-Bois, France', '6 Résidence de l\'Oreuse', NULL, NULL, '2026-06-08', '', 565.06, 338.39, 0, 0, NULL),
(21, 21, '2026-07-10 21:01:00', 'terminee', 'carte_bancaire', 'Bordeaux', '6 Résidence de l\'Oreuse', NULL, NULL, '2026-06-09', '', 0.00, 0.00, 0, 0, NULL),
(22, 21, '2026-07-03 19:03:00', 'annulee', 'devis', 'Bordeaux', '6 Résidence de l\'Oreuse', NULL, NULL, '2026-06-09', '', 0.00, 0.00, 0, 0, NULL),
(23, 18, '2026-06-19 12:48:00', 'en_preparation', 'carte_bancaire', 'Saint-Malo, France', '6 Résidence de l\'Oreuse', NULL, NULL, '2026-06-12', '', 530.14, 317.78, 0, 0, NULL),
(24, 21, '2026-06-26 11:10:00', 'annulee', 'devis', 'Thorigny-sur-Oreuse, France', '6 Résidence de l\'Oreuse', NULL, NULL, '2026-06-16', '', 610.84, 365.40, 0, 0, NULL),
(25, 21, '2026-06-30 11:31:00', 'en_attente', 'carte_bancaire', 'Thorigny-sur-Oreuse, France', '6 Résidence de l\'Oreuse', NULL, NULL, '2026-06-16', '', 610.84, 365.40, 0, 0, NULL),
(26, 21, '2026-07-03 16:30:00', 'en_attente', 'carte_bancaire', 'Thorigny-sur-Oreuse, France', '6 Résidence de l\'Oreuse', NULL, NULL, '2026-06-16', '', 610.84, 365.40, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `commande_detail`
--

CREATE TABLE `commande_detail` (
  `Id_detail` int NOT NULL,
  `Id_commande` int NOT NULL,
  `Id_menu` int NOT NULL,
  `quantite` int NOT NULL,
  `prix` decimal(10,0) NOT NULL,
  `prix_total` decimal(10,2) DEFAULT '0.00',
  `reduction` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `commande_detail`
--

INSERT INTO `commande_detail` (`Id_detail`, `Id_commande`, `Id_menu`, `quantite`, `prix`, `prix_total`, `reduction`) VALUES
(2, 7, 2, 15, 600, 0.00, 0.00),
(3, 8, 2, 15, 600, 0.00, 0.00),
(4, 9, 1, 15, 690, 0.00, 0.00),
(5, 10, 1, 15, 690, 0.00, 0.00),
(6, 11, 7, 15, 450, 0.00, 0.00),
(7, 17, 3, 26, 1690, 1529.45, 0.00),
(8, 18, 6, 15, 690, 1006.41, 0.00),
(9, 19, 4, 27, 1337, 1621.91, 0.10),
(10, 20, 1, 10, 460, 752.39, 0.10),
(11, 21, 2, 15, 600, 540.00, 0.10),
(12, 22, 2, 25, 900, 900.00, 0.10),
(13, 23, 1, 14, 644, 897.38, 0.10),
(14, 24, 2, 51, 2040, 2201.40, 0.10),
(15, 25, 2, 14, 560, 869.40, 0.10),
(16, 26, 6, 27, 1118, 1483.20, 0.10);

-- --------------------------------------------------------

--
-- Structure de la table `horaires`
--

CREATE TABLE `horaires` (
  `Id_horaire` int NOT NULL,
  `jour` varchar(20) NOT NULL,
  `ouverture_matin` time DEFAULT NULL,
  `fermeture_matin` time DEFAULT NULL,
  `ouverture_apm` time DEFAULT NULL,
  `fermeture_apm` time DEFAULT NULL,
  `ferme` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `horaires`
--

INSERT INTO `horaires` (`Id_horaire`, `jour`, `ouverture_matin`, `fermeture_matin`, `ouverture_apm`, `fermeture_apm`, `ferme`) VALUES
(1, 'Lundi', '09:00:00', '12:30:00', '13:30:00', '19:00:00', 0),
(2, 'Mardi', '09:00:00', '12:30:00', '13:30:00', '19:00:00', 0),
(3, 'Mercredi', '09:00:00', '12:30:00', '13:30:00', '19:00:00', 0),
(4, 'Jeudi', '09:00:00', '12:30:00', '13:30:00', '19:00:00', 0),
(5, 'Vendredi', '09:00:00', '12:30:00', '13:30:00', '21:00:00', 0),
(6, 'Samedi', NULL, NULL, NULL, NULL, 1),
(7, 'Dimanche', NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `menu`
--

CREATE TABLE `menu` (
  `Id_menu` int NOT NULL,
  `menu_nom` varchar(100) NOT NULL,
  `theme` varchar(100) NOT NULL,
  `regime` varchar(100) NOT NULL,
  `nb_perso_min` int DEFAULT NULL,
  `nb_perso_max` int DEFAULT NULL,
  `prix_menu` decimal(10,0) NOT NULL,
  `entree` text NOT NULL,
  `plat` text NOT NULL,
  `dessert` text NOT NULL,
  `boisson` text,
  `allergene` text,
  `description` text,
  `entree_description` text,
  `plat_description` text,
  `dessert_description` text,
  `boisson_description` text,
  `img_desktop` varchar(255) DEFAULT NULL,
  `img_mobile` varchar(2555) DEFAULT NULL,
  `link` varchar(100) DEFAULT NULL,
  `description_info` text,
  `img_uploaded` varchar(255) DEFAULT NULL,
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  `quantite_restante` int DEFAULT NULL,
  `conditions` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `menu`
--

INSERT INTO `menu` (`Id_menu`, `menu_nom`, `theme`, `regime`, `nb_perso_min`, `nb_perso_max`, `prix_menu`, `entree`, `plat`, `dessert`, `boisson`, `allergene`, `description`, `entree_description`, `plat_description`, `dessert_description`, `boisson_description`, `img_desktop`, `img_mobile`, `link`, `description_info`, `img_uploaded`, `actif`, `quantite_restante`, `conditions`) VALUES
(1, 'Éclats de Fêtes', 'noel', 'non-vegan', 5, 30, 46, 'Le Foie Gras de Canard Entier.', 'Le Chapon de Ferme & sa Garniture Truffée', 'La Bûche Signature Pralinée', 'Coupe de Bourgogne Pinot Noir|Coupe de Champagne Brut Réserve|Jus de poire artisanal', 'Gluten|Œufs|Lait|Fruits à coque', 'Ce menu est un hommage à la gastronomie bourgeoise de Noël. J\'ai souhaité marier la noblesse du chapon et du foie gras à la puissance de la truffe noire pour créer un moment de partage solennel et hautement savoureux.', 'Médaillon de foie gras de canard du Sud-Ouest, mi-cuit maison au torchon.|Chutney de figues violettes aux éclats de noix, pain brioché artisanal toasté au beurre demi-sel.', 'Suprême de chapon fermier rôti lentement dans son jus de cuisson réduit.|Gratin de pommes de terre façon \"Dauphinois\" à la truffe noire de pays, marrons entiers confits au bouillon et pointes d\'asperges grillées.', 'Biscuit génoise moelleux, mousse légère au praliné à l\'ancienne et cœur fondant aux éclats de noisettes torréfiées.|Glaçage miroir au chocolat noir 70% et billes de chocolat croquantes.', NULL, 'EclatF-max', 'EclatF', 'EclatF', 'Plongez dans l\'excellence avec un foie gras onctueux et son chutney acidulé, suivi d\'un chapon fondant accompagné d\'un gratin généreusement truffé. Pour conclure, succombez à notre bûche signature, un écrin de chocolat intense et de noisettes croquantes.', NULL, 1, NULL, NULL),
(2, 'Forêt d\'Hiver', 'noel', 'vegan', 5, 30, 40, 'Velouté de Châtaignes & Diamant Noir', 'Le Wellington de Potimarron aux Noix', 'La Bûche Chocolat Noir & Poire Confite', 'Vin rouge vegan – Côtes du Rhône sélection|Mocktail agrumes & romarin|Jus de pomme pétillant bio', 'Gluten|Fruits à coque', 'J\'ai conçu ce menu comme une promenade sensorielle sous les bois. L\'enjeu était de travailler les racines et les fruits à coque (châtaigne, panais, noix) pour offrir une richesse de textures capable de rivaliser avec les tables les plus prestigieuses.', 'Crème de châtaignes d\'Ardèche liée au lait de coco, surmontée de brisures de truffe noire fraîche.|Croûtons de pain de campagne frottés à l\'ail et quelques herbes folles.', 'Rôti de potimarron rôti et duxelles de champignons de Paris, enveloppés dans une pâte feuilletée artisanale croustillante.|Jus réduit aux airelles, purée de panais onctueuse et noix de Grenoble torréfiées.', 'Mousse légère au chocolat noir intense (70%), insert de poires caramélisées et biscuit moelleux aux amandes.|Miroir cacao et fines lamelles de poires fraîches.', NULL, 'ForêtH-max', 'ForêtH', 'ForêtH', 'Découvrez la magie d\'un velouté de châtaignes onctueux parfumé à la truffe, suivi d\'un feuilleté Wellington doré au cœur fondant de potimarron. En apothéose, savourez une bûche aérienne mêlant l\'intensité du chocolat noir à la fraîcheur d\'une poire rôtie.', NULL, 1, NULL, NULL),
(3, 'Union Sacré', 'mariage', 'non-vegan', 20, 70, 65, 'Saint-Jacques Snackées au Safran', 'Filet de Bœuf Rossini & Légumes Glacés', 'La Pièce Montée ou Pavlova Signature', 'Coup de Saint-Émilion Grand Cru|Coupe de Champagne Brut Prestige|Cocktail maison fruits rouges sans alcool', 'Gluten|Œufs|Lait|Fruits à coque', 'Pour ce jour unique, j\'ai sélectionné des produits d\'exception. C\'est un menu de \"haute couture\" culinaire où le filet de bœuf Rossini et les Saint-Jacques au safran assurent une élégance intemporelle dans l\'assiette.', 'Noix de Saint-Jacques de la baie de Seine saisies minute, crème légère infusée au safran pur et fondue de poireaux au vin blanc.', 'Cœur de filet de bœuf surmonté d\'une escalope de foie gras poêlée, jus de viande corsé à la truffe.|Un écrasé de pommes de terre à l\'huile de truffe blanche, haricots verts extra-fins et tomates cerises confites.', 'Choux caramélisés à la crème vanille Bourbon ou meringue craquante, crème fouettée et fruits frais selon votre choix.', NULL, 'UnionS-max', 'UnionS', 'UnionS', 'Démarrez les festivités avec la finesse des Saint-Jacques au safran, suivies d\'un filet de bœuf Rossini d\'une tendreté royale. Clôturez ce moment inoubliable avec une pièce montée artisanale ou une Pavlova aérienne aux fruits de saison.', NULL, 1, NULL, NULL),
(4, 'Amour Éternel', 'mariage', 'vegan', 20, 70, 55, 'Tartare de Mangue & Avocat', 'Steak de Chou-fleur Rôti Chimichurri', 'Dôme Framboise & Pistache', 'Vin rouge vegan – Bordeaux sélection|Cocktail signature framboise & basilic|Citronnade artisanale maison', 'Gluten|Œufs|Lait|Fruits à coque', 'Ce menu prouve que l\'éthique peut rimer avec chic. J\'ai privilégié le graphisme des plats et l\'exotisme des saveurs (mangue, pistache, chimichurri) pour marquer les esprits et régaler tous vos convives, sans aucun compromis.', 'Dés de mangue fraîche et avocat Haas, assaisonnés au citron vert, huile de sésame et baies roses.|Chutney de figues violettes aux éclats de noix, pain brioché artisanal toasté au beurre demi-sel.', 'Tranche de chou-fleur épaisse rôtie au four, sauce chimichurri aux herbes fraîches, accompagnée d\'un écrasé de patates douces.|Gratin de pommes de terre façon \"Dauphinois\" à la truffe noire de pays, marrons entiers confits au bouillon et pointes d\'asperges grillées.', 'Mousse framboise légère sur un biscuit moelleux à la pistache d\'Iran, nappage miroir aux fruits rouges.', NULL, 'AmourE-max', 'AmourE', 'AmourE', 'Célébrez votre union avec un tartare de mangue et avocat exotique, suivi d\'un steak de chou-fleur rôti aux épices chimichurri pour une explosion de saveurs. En dessert, un dôme framboise et pistache apportera une touche finale raffinée et colorée.', NULL, 1, NULL, NULL),
(5, 'Renouveau', 'paque', 'non-vegan', 5, 30, 39, 'L\'Asperge Verte & l\'Œuf Parfait', 'La Souris d\'Agneau de Sept Heures', 'L\'Entremets Chocolat-Praliné', 'Coupe de Saint-Émilion Grand Cru|Coupe de Champagne Brut Premier Cru|Jus de pomme fermier pressé', 'Gluten|Œufs|Lait', 'Pâques est la fête de la tendresse. Entre la délicatesse de l\'œuf parfait et la patience d\'un agneau confit sept heures, ce menu célèbre le temps long et le retour des produits verts du potager.', 'Asperges vertes de pays simplement grillées, œuf bio cuit à basse température (64°C), émulsion hollandaise légère au citron de Menton.', 'Agneau confit lentement dans son jus au thym et romarin, accompagné d\'une purée de pois frais à la menthe et de pommes grenailles rôties.|Une mousseline de petits pois frais à la menthe douce, pommes grenailles rôties au sel de Guérande et jeunes carottes fanes glacées.', 'Mousse chocolat au lait grand cru, cœur praliné croustillant à la fleur de sel et biscuit dacquoise noisette.', NULL, 'Renouveau-max', 'Renouveau', 'Renouveau', 'Laissez-vous séduire par la fraîcheur des asperges croquantes et leur œuf mollet, avant de savourer une souris d\'agneau confite pendant sept heures à la tendreté absolue. Terminez sur une note de pur plaisir avec un entremets chocolaté au praliné croustillant.', NULL, 1, NULL, NULL),
(6, 'Printemps Bio', 'paque', 'vegan', 5, 30, 46, 'Carpaccio de Radis Noir & Agrumes', 'Risotto Crémeux aux Morilles', 'Tartelette Fraise & Coco', 'Vin rouge vegan – Domaine du Sud-Ouest|Spritz fruits rouges sans alcool|Jus de pomme bio artisanal', 'Gluten (option sans possible)', 'Ici, la star est le végétal dans ce qu\'il a de plus pur. Je mise sur la puissance aromatique des morilles et la vivacité des agrumes pour proposer un menu printanier léger, équilibré et résolument moderne.', 'Fines lamelles de radis noir marinées au citron vert, suprêmes de pamplemousse rose, baies roses et huile d\'olive vierge.', 'Riz Carnaroli lié à la crème de soja et levure maltée, morilles fraîches sautées à l\'ail des ours et jeunes pousses d\'épinards.|Une fricassée d\'asperges sauvages et de tuiles de parmesan végétal maison.', 'Pâte sablée végétale à l\'amande, crème pâtissière onctueuse à la noix de coco et fraises fraîches de pleine terre.', NULL, 'PrintempsBio-max', 'PrintempsBio', 'PrintempsBio', 'Éveillez vos papilles avec un carpaccio de radis noir aux agrumes pétillants, suivi d\'un risotto onctueux aux morilles sauvages, véritable trésor de saison. En conclusion, dégustez une tartelette aux fraises printanières sur une crème de coco veloutée.', NULL, 1, NULL, NULL),
(7, 'Signature Terroir', 'seminaire', 'non-vegan', 5, 40, 30, 'Salade de Saint-Jacques Poêlées', 'Filet de Canette Rôti & Jus de Miel', 'Tarte Tatin Déstructurée', 'Coupe de Côtes du Rhône Village|Bière artisanale blonde locale|Limonade artisanale française', 'Gluten|Crustacés|Lait', 'Avec ce menu, j\'ai voulu célébrer l\'art de vivre à la française. C\'est un équilibre entre la finesse marine de la Saint-Jacques et le caractère de la canette rôtie. Un hommage aux produits de nos régions.', 'Noix de Saint-Jacques saisies au beurre, servies sur un lit de jeunes pousses, vinaigrette aux agrumes et éclats de noisettes torréfiées.', 'Canette rôtie rosée, jus réduit au miel et vinaigre balsamique.|Gratin dauphinois traditionnel à la crème de Normandie et poêlée de champignons de saison persillés.', 'Pommes caramélisées au beurre salé, sablé breton émietté et crème fouettée à la vanille de Madagascar.', NULL, 'SignatureT-max', 'SignatureT', 'SignatureT', 'Redécouvrez l\'authenticité du terroir avec une poêlée de Saint-Jacques délicate, suivie d\'un filet de canette rôti aux saveurs forestières. Pour finir, laissez-vous surprendre par une tarte Tatin déstructurée, mariage parfait du chaud et du froid.', NULL, 1, NULL, NULL),
(8, 'Végétal Chic', 'seminaire', 'vegan', 5, 40, 25, 'Taboulé de Quinoa aux Herbes Fraîches', 'Curry de Pois Chiches au Lait de Coco', 'Carpaccio d\'Ananas & Sorbet Citron', 'Vin rouge vegan – Languedoc sélection|Mocktail pomme & gingembre|Limonade bio artisanale', 'Sésame (dans le pain)', 'Ce menu est une démonstration que la cuisine végétale peut être aussi graphique que gourmande. J\'ai misé sur la fraîcheur des herbes et la chaleur des épices pour créer un voyage sensoriel léger.', 'Trio de quinoa, menthe ciselée, persil plat, grenades croquantes, zestes de citron jaune et huile d\'olive vierge.', 'Pois chiches fondants mijotés dans un mélange d\'épices douces (curcuma, cumin, gingembre) et lait de coco crémeux.|Riz basmati parfumé à la cardamome, coriandre fraîche et pain plat (Naan végétal) maison.', 'Fines tranches d\'ananas Victoria infusées au sirop de basilic, servies avec un sorbet citron vert artisanal.', NULL, 'VegetalC-max', 'VegetalC', 'VegetalC', 'Voyagez au cœur des saveurs végétales avec un quinoa aux herbes fraîches et croquantes, suivi d\'un curry de pois chiches onctueux aux parfums d\'Orient. Terminez en douceur avec un carpaccio d\'ananas rafraîchissant infusé à la coriandre.', NULL, 0, NULL, NULL),
(9, 'Le Gourmand', 'casse-croûte', 'non-vegan', 1, 50, 19, 'Salade piémontaise aux pommes de terre grenaille, cornichons et ciboulette', 'Émincé de rôti de porc fermier, écrasé de carottes au beurre et brocolis', 'Panna cotta à la vanille de Bourbon et son coulis de fruits rouges', NULL, 'Oeufs|Moutarde|Lait', 'Ce casse-croûte est un hommage aux déjeuners généreux et conviviaux de notre région. Conçu pour offrir une vraie pause gourmande et rassasiante au milieu d\'une journée bien remplie, il réinterprète avec simplicité des classiques de la cuisine bourgeoise. Tout le savoir-faire de notre maison traiteur est mis au service de produits locaux rigoureusement sélectionnés pour vous offrir un plat du midi accessible, authentique et sans chichi.', 'Une salade piémontaise à notre façon, mêlant la douceur des pommes de terre grenaille fondantes au croquant des cornichons et à la fraîcheur de la ciboulette, le tout lié par une mayonnaise maison légère.', 'Un tendre émincé de rôti de porc fermier de la région, arrosé de son jus de cuisson réduit au thym et accompagné d\'un écrasé de carottes au beurre et de sommités de brocolis croquants.', 'Une panna cotta onctueuse à la vanille de Bourbon, surmontée d\'un coulis de fruits rouges acidulé pour finir sur une note de fraîcheur.', NULL, NULL, NULL, NULL, 'Le bon goût du terroir, tout simplement. Un déjeuner réconfortant \"a la bonne franquette\" avec un rôti de porc ultra-tendre et sa salade piémontaise revisitée.', NULL, 1, 50, NULL),
(10, 'Le Bassin', 'casse-croûte', 'non-vegan', 1, 50, 18, 'Rillettes artisanales de poisson blanc de l\'Atlantique, aneth et citron vert', 'Suprême de poulet rôti au thym, penne au pesto de basilic maison et tomates confites', 'Moelleux au chocolat noir intense et pointe de fleur de sel', NULL, 'Poisson|Lait|Gluten|Fruits à coque', 'Le Casse-croûte \"Le Vignoble\" est notre réponse végétale à la demande de gourmandise et de simplicité. Pensé comme une balade dans nos jardins et vignobles, il sublime les légumes de saison et les céréales rustiques. Ce casse-croûte n\'est pas une simple alternative, mais une proposition culinaire à part entière, où chaque ingrédient est travaillé pour sa saveur et sa texture.', 'Nos rillettes de poisson blanc de l\'Atlantique, travaillées à la main avec une touche de crème fraîche, de l\'aneth et du citron vert, servies avec de petits croûtons de pain croustillants.', 'Un suprême de poulet rôti au thym, escorté de penne rigate généreusement enrobées d\'un pesto de basilic frais maison, de parmesan et de tomates confites fondantes.', 'Un moelleux au chocolat noir intense et sa pointe de fleur de sel de l\'Atlantique, pour une touche finale terriblement gourmande.', NULL, NULL, NULL, NULL, 'Une brise de fraîcheur iodée dans votre pause dej. Craquez pour nos rillettes maison et l\'incontournable poulet rôti au pesto, un menu frais et savoureux comme un retour du marché.', NULL, 1, 150, NULL),
(11, 'Le Vignoble', 'casse-croûte', 'vegan', 1, 50, 17, 'Salade de sarrasin grillé, noisettes concassées et brunoise de légumes', 'Tian de légumes d\'été confits sur lit de quinoa bicolore', 'Crumble aux pommes de saison, sarrasin et amandes', NULL, 'Fruit à coque', 'Le Casse-croûte \"Le Vignoble\" est notre réponse végétale à la demande de gourmandise et de simplicité. Pensé comme une balade dans nos jardins et vignobles, il sublime les légumes de saison et les céréales rustiques. Ce casse-croûte n\'est pas une simple alternative, mais une proposition culinaire à part entière, où chaque ingrédient est travaillé pour sa saveur et sa texture. Tout le savoir-faire de nos cuisiniers est utilisé pour créer un plat vegan riche, rassasiant et plein de caractère.', 'Une salade de sarrasin grillé (kasha), mêlée à des noisettes concassées et une brunoise de légumes croquants, relevée d\'une vinaigrette légère aux herbes du jardin.', 'Un tian de légumes d\'été confits (aubergines, courgettes, poivrons, oignons) rôtis lentement au four avec de l\'huile d\'olive et des herbes de Provence, servi sur un lit de quinoa rouge et blanc.', 'Un crumble aux pommes de saison, où le sarrasin et la poudre d\'amande remplacent la farine, servi avec une compote de fruits de saison.', NULL, NULL, NULL, NULL, 'La richesse du potager dans votre casse-croûte. Une escale végétale gourmande qui met à l\'honneur les légumes rôtis et le sarrasin, pour un midi plein d\'énergie et de saveurs.', NULL, 1, 50, NULL);
-- --------------------------------------------------------

--
-- Structure de la table `renseignement`
--

CREATE TABLE `renseignement` (
  `adresse` varchar(255) NOT NULL DEFAULT '42 Rue du Pas-Saint-Georges, 33000 Bordeaux',
  `tel_restaurant` varchar(20) NOT NULL DEFAULT '05 56 44 12 89',
  `mail` varchar(250) NOT NULL DEFAULT 'contact@vite-et-gourmand-traiteur.fr'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(255) NOT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `code_postal` varchar(5) DEFAULT NULL,
  `adresse` varchar(100) DEFAULT NULL,
  `ville` varchar(100) DEFAULT NULL,
  `complement_adresse` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `role` enum('user','employe','admin') NOT NULL DEFAULT 'user',
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(64) DEFAULT NULL,
  `reset_token` varchar(64) DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `nom`, `prenom`, `email`, `password`, `tel`, `code_postal`, `adresse`, `ville`, `complement_adresse`, `created_at`, `role`, `actif`, `remember_token`, `reset_token`, `reset_token_expiry`) VALUES
(1, 'MAKHLOUFI', 'Samy', 'samy917@hotmail.Fr', '$2y$10$nSlj7mIKQ7PsXg2dNZHzQuQHSIyC3pYebz4IZ/8RaGLKA6G2KaYBS', '0664083178', '89260', '6 Résidence de l\'Oreuse', 'THORIGNY SUR OREUSE', NULL, '2026-04-13 14:15:50', 'admin', 1, 'f400a1d88f9209175af2febebd3a17e8d4add2e66273094c175297296be27523', 'f010d4ca747534b8bbd5f148bf459ca8863a921d3167094a3ae7caf5f674ee09', '2026-05-28 11:09:18'),
(2, 'nom', 'prénom', 'email@email.fr', '$2y$10$FrxRDS3n.2UU.UcrKY1bk.clEZ0apA5mJ4dntW/MLPmYrJOT588ym', '0606060606', '91919', '35 rue de l\'adresse', 'ville', NULL, '2026-04-13 14:37:14', 'employe', 0, NULL, NULL, NULL),
(3, 'prenom', 'nom', 'email@mail.fr', '$2y$10$Beu60B7oeYbHopPv7dGmiOftSAcc6eKdu7pvcO7XVmMGWbQ3ixBBe', '0707070707', '1914', 'adresse', 'ville', NULL, '2026-04-13 15:26:00', 'admin', 1, NULL, NULL, NULL),
(6, 'samy', 'samy', 'samy@samy.fr', '$2y$10$q8NAbHMxuyV/TCdqpCacWe.MZFUQU.talccWQN2mveqT1PWJzcOEO', '06.06.06.06.06', '27119', '6 rue de chez moi', 'chez moi', NULL, '2026-05-28 12:07:08', 'user', 1, NULL, NULL, NULL),
(7, 'samy', 'samy', 'samy@mysa.fr', '$2y$10$327zXR/EnjsgsH3Fq87mPeotex10hghbQDPwAMuwQ1aYbcAdEuu5e', '07.07.07.07.07', '27119', '9 rue de chez moi', 'Chez moi', NULL, '2026-05-28 12:08:56', 'user', 1, NULL, NULL, NULL),
(8, 'samy', 'samy', 'mysa@mysa.fr', '$2y$10$qNBW7DiD.l3MeVOM88NYv.UXNff8tQIaromvCjRS9B/xWIIoKQzG2', '08.08.08.08.08', '27119', '8 rue de chez moi', 'Chez moi', NULL, '2026-05-28 12:17:45', 'user', 1, NULL, NULL, NULL),
(9, 'mysa', 'mysa', 'mysa@samy.fr', '$2y$10$G2vGgs33MK6SdgEPPXiPkuGzd2hiR4BE4nj5djSqTm3QjF.3bDHba', '09.09.09.09.09', '27119', '9 rue chez moi', 'chez moi', NULL, '2026-05-28 12:18:31', 'user', 1, NULL, NULL, NULL),
(10, 'kremade', 'misuka', 'kremade@krem.fr', '$2y$10$wh0Dzr5TyOn5aSCzdFx5O.mtdpj.z6mhcBocuGtqzPQyH8cKpXMJa', '05.05.05.05.05', '8', 'Ultia', 'Yggdrasil', NULL, '2026-05-28 13:59:13', 'user', 1, NULL, NULL, NULL),
(11, 'Samy MAKHLOUFI', 'Samy', 'test2@test.fr', '$2y$10$U.F.3u4/J4abjJK.qN6kieA6.Nj.Qk2Dna4YvOk2qk7nu8qLBvcl6', '0664083178', '89260', '6 Résidence de l\'Oreuse', 'THORIGNY SUR OREUSE', NULL, '2026-05-28 14:06:42', 'user', 1, NULL, NULL, NULL),
(12, 'Samy MAKHLOUFI', 'Samy', 'test3@test.fr', '$2y$10$MT044fwbteDa366m0LJbYu2B7ZT7hnHIqBBaY3iRLPVadyp7N4ur6', '0664083178', '89260', '6 Résidence de l\'Oreuse', 'THORIGNY SUR OREUSE', NULL, '2026-05-28 14:07:48', 'user', 1, NULL, NULL, NULL),
(13, 'MAKHLOUFI', 'Samy', 'test4@test.fr', '$2y$10$3UGSoaX/ZdsgNnR36kcbZO4MvMxUn3ZuvPVmX9PJ2EUiiuuPAHoJe', '0664083178', '89260', '6 Résidence de l\'Oreuse', 'THORIGNY SUR OREUSE', NULL, '2026-05-28 14:09:29', 'user', 1, NULL, NULL, NULL),
(14, 'test', 'test', 'test5@test.fr', '$2y$10$l/b8/AxiQo4.nnaX2jrckO/GTtF7dlZvQaqMWSfEpztOZN9.yqgLK', '09.09.09.09.09', '98490', 'chez moi', 'chez moi', NULL, '2026-05-29 10:41:37', 'user', 1, NULL, NULL, NULL),
(18, 'makhloufi', 'malica', 'malicamak_lou@hotmail.fr', '$2y$10$zAx748PPgJwey229JI0ELuxRYCdhlmjtqOCcdZewcn9mi2cawCuXi', '558285372', '91700', '28 rue simone signoret', 'sainte geneviève des bois', NULL, '2026-06-05 14:11:45', 'user', 1, NULL, NULL, NULL),
(21, 'MAKHLOUFI', 'Samy', 'samymakhloufi@gmail.com', '$2y$10$9LccQlnviuz.UaKTaxC/D.L6OBP/8oVPOHt1lBt/xRhAlY4jhtHuS', '0664083178', '89260', '6 Résidence de l\'Oreuse', 'THORIGNY SUR OREUSE', 'pas trop', '2026-06-05 22:31:19', 'user', 1, '35d177a6a8aa065a2ec753659687d31034710fbc6b808794ebc7c993c96d3558', '38b9d30278be4770de16dfef8edf46f19b758b4ae9898e00e043fe7a72ad90db', '2026-06-15 13:07:09'),
(22, 'BELLIL', 'Orlane', 'orlane77210@gmail.com', '$2y$10$/O.TmluWuYcYZTlKzLDcr.QcPEyRZm3MaOCxDii0R6ewgC4UySLSS', NULL, NULL, NULL, NULL, NULL, '2026-06-11 11:08:18', 'employe', 1, NULL, NULL, NULL),
(28, 'misuka', 'kremade', 'misuka04@hotmail.fr', '$2y$10$Ig3FR8.Lussr2FLrbfdAx.uw9dOYquIzk.DBStgR26JtJ/vG4Od7a', NULL, NULL, NULL, NULL, NULL, '2026-06-14 16:01:07', 'employe', 1, NULL, NULL, NULL),
(32, 'kremade', 'misuka', 'misuka05@hotmail.fr', '$2y$10$662DXgePNlnrH1FAhlgz..2MSgvhh0qlYiuIRt6oHXfFjrMTJGMxm', NULL, NULL, NULL, NULL, NULL, '2026-06-14 16:11:41', 'employe', 0, NULL, NULL, NULL),
(36, 'moi', 'moi', 'moi@moi.fr', '$2y$10$IsfKfLz4YLXXb/94X3OL.uAwBy4RAjKTnwKje7GlJqKEyP9zax7.O', NULL, NULL, NULL, NULL, NULL, '2026-06-14 16:24:20', 'employe', 1, NULL, NULL, NULL),
(41, 'gmail', 'outlook', 'outlook@gmail.fr', '$2y$10$Y/pBzChAAwz8PE185OeDceT4ahmGwn7pj.IdAgkyD9bDy4TlwLQCG', NULL, NULL, NULL, NULL, NULL, '2026-06-14 22:26:44', 'employe', 1, NULL, NULL, NULL),
(43, 'pasmoi', 'moi', 'moi@pasmoi.fr', '$2y$10$ZDkQxiSwawMuhRMtU2peiOGYwKe4mpDSUKMGAnKES2l4abkCG0B5G', NULL, NULL, NULL, NULL, NULL, '2026-06-14 22:27:10', 'employe', 1, NULL, NULL, NULL),
(45, 'test', 'test', 'test@test.fr', '$2y$10$6r0EINJUM66xmWpTMvYMX.8zMCWs2UDNvLyj76FR/0YUulsbXjrW.', NULL, NULL, NULL, NULL, NULL, '2026-06-14 22:31:54', 'employe', 1, NULL, NULL, NULL),
(50, 'test', 'test', 'test@encore.fr', '$2y$10$yQQPwvmFSTnKae8nfgHqXuL08YWu3BDIfDYO8ofenbOxwO/O/PVvS', NULL, NULL, NULL, NULL, NULL, '2026-06-14 22:44:59', 'employe', 1, NULL, NULL, NULL),
(52, 'finis', 'enfin', 'finis@jespere.fr', '$2y$10$6W1EntvSF7.5Hx8P6VC9t.cfdP.hCgx60sYgbyS2.Gx8jB5QUl.hG', NULL, NULL, NULL, NULL, NULL, '2026-06-14 22:47:28', 'employe', 1, NULL, NULL, NULL),
(53, 'test', 'encore', 'encore@test.fr', '$2y$10$Ay18/cj90rEWmMFOyAKeJu1ILcv5UlIiXNhSyk9x83gg95HQ.PJkG', NULL, NULL, NULL, NULL, NULL, '2026-06-14 22:49:04', 'employe', 1, NULL, NULL, NULL),
(54, 'MAKHLOUFI', 'Samy', 'test16@test.fr', '$2y$10$yMDyEfaLT1w8Fy5ZHiVhh.RBYXkM2f49knleJyUOzO6muQm5h2z8a', '0664083178', '89260', '6 Résidence de l\'Oreuse', 'THORIGNY SUR OREUSE', NULL, '2026-06-16 10:55:03', 'user', 1, NULL, NULL, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `avis`
--
ALTER TABLE `avis`
  ADD PRIMARY KEY (`Id_avis`),
  ADD KEY `user_id` (`Id_user`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`Id_commande`),
  ADD KEY `Id_user` (`Id_user`);

--
-- Index pour la table `commande_detail`
--
ALTER TABLE `commande_detail`
  ADD PRIMARY KEY (`Id_detail`),
  ADD KEY `Id_commande` (`Id_commande`),
  ADD KEY `Id_menu` (`Id_menu`);

--
-- Index pour la table `horaires`
--
ALTER TABLE `horaires`
  ADD PRIMARY KEY (`Id_horaire`);

--
-- Index pour la table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`Id_menu`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `Email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `avis`
--
ALTER TABLE `avis`
  MODIFY `Id_avis` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `Id_commande` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pour la table `commande_detail`
--
ALTER TABLE `commande_detail`
  MODIFY `Id_detail` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `horaires`
--
ALTER TABLE `horaires`
  MODIFY `Id_horaire` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `menu`
--
ALTER TABLE `menu`
  MODIFY `Id_menu` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `avis`
--
ALTER TABLE `avis`
  ADD CONSTRAINT `avis_ibfk_1` FOREIGN KEY (`Id_user`) REFERENCES `users` (`id_user`);

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`Id_user`) REFERENCES `users` (`id_user`);

--
-- Contraintes pour la table `commande_detail`
--
ALTER TABLE `commande_detail`
  ADD CONSTRAINT `commande_detail_ibfk_1` FOREIGN KEY (`Id_commande`) REFERENCES `commande` (`Id_commande`),
  ADD CONSTRAINT `commande_detail_ibfk_2` FOREIGN KEY (`Id_menu`) REFERENCES `menu` (`Id_menu`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;