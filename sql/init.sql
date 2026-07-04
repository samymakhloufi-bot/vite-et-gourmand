-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Jun 26, 2026 at 02:12 PM
-- Server version: 8.0.46
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET NAMES utf8mb4;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
--
-- Database: `vite_gourmand`
--

-- --------------------------------------------------------

--
-- Table structure for table `avis`
--

CREATE TABLE `avis` (
  `Id_avis` int NOT NULL,
  `Id_user` int NOT NULL,
  `contenu` text NOT NULL,
  `statut_avis` enum('en_attente','valide','refuse') NOT NULL DEFAULT 'en_attente',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `note` tinyint DEFAULT '5'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `commande`
--

CREATE TABLE `commande` (
  `Id_commande` int NOT NULL,
  `Id_user` int NOT NULL,
  `date_livraison` datetime NOT NULL,
  `statut` enum('en_attente','accepte','en_preparation','en_cours_de_livraison','livre','en_attente_retour_materiel','terminee','annulee') NOT NULL DEFAULT 'en_attente',
  `mode_paiement` enum('devis','carte_bancaire') NOT NULL,
  `ville_livraison` varchar(100) NOT NULL,
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
-- Dumping data for table `commande`
--

INSERT INTO `commande` (`Id_commande`, `Id_user`, `date_livraison`, `statut`, `mode_paiement`, `ville_livraison`, `adresse_livraison`, `motif_annulation`, `mode_contact`, `date_commande`, `complement`, `distance_km`, `frais_livraison`, `materiel_prete`, `materiel_restitue`, `date_pret`) VALUES
(1, 2, '2026-07-11 19:30:00', 'en_attente', 'devis', 'Quinsac, France', 'chez l\'utilisateur', NULL, NULL, '2026-06-22', '', 156.86, 97.55, 0, 0, NULL);
-- --------------------------------------------------------

--
-- Table structure for table `commande_detail`
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
-- Dumping data for table `commande_detail`
--

INSERT INTO `commande_detail` (`Id_detail`, `Id_commande`, `Id_menu`, `quantite`, `prix`, `prix_total`, `reduction`) VALUES
(1, 1, 2, 15, 600, 637.55, 0.10);

-- --------------------------------------------------------

--
-- Table structure for table `horaires`
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
-- Dumping data for table `horaires`
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
-- Table structure for table `menu`
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
  `img_menu` varchar(255) DEFAULT NULL,
  `link` varchar(100) DEFAULT NULL,
  `description_info` text,
  `img_uploaded` varchar(255) DEFAULT NULL,
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  `quantite_restante` int DEFAULT NULL,
  `conditions` text,
  `mois_debut` int DEFAULT NULL,
  `mois_fin` int DEFAULT NULL,
  `delai_commande_jours` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`Id_menu`, `menu_nom`, `theme`, `regime`, `nb_perso_min`, `nb_perso_max`, `prix_menu`, `entree`, `plat`, `dessert`, `boisson`, `allergene`, `description`, `entree_description`, `plat_description`, `dessert_description`, `boisson_description`, `img_menu`, `link`, `description_info`, `img_uploaded`, `actif`, `quantite_restante`, `conditions`, `mois_debut`, `mois_fin`, `delai_commande_jours` ) VALUES
(1, 'Éclats de Fêtes', 'noel', 'non-vegan', 5, 30, 46, 'Le Foie Gras de Canard Entier.', 'Le Chapon de Ferme & sa Garniture Truffée', 'La Bûche Signature Pralinée', 'Coupe de Bourgogne Pinot Noir|Coupe de Champagne Brut Réserve|Jus de poire artisanal', 'Gluten|Œufs|Lait|Fruits à coque', 'Ce menu est un hommage à la gastronomie bourgeoise de Noël. J\'ai souhaité marier la noblesse du chapon et du foie gras à la puissance de la truffe noire pour créer un moment de partage solennel et hautement savoureux.', 'Médaillon de foie gras de canard du Sud-Ouest, mi-cuit maison au torchon.|Chutney de figues violettes aux éclats de noix, pain brioché artisanal toasté au beurre demi-sel.', 'Suprême de chapon fermier rôti lentement dans son jus de cuisson réduit.|Gratin de pommes de terre façon \"Dauphinois\" à la truffe noire de pays, marrons entiers confits au bouillon et pointes d\'asperges grillées.', 'Biscuit génoise moelleux, mousse légère au praliné à l\'ancienne et cœur fondant aux éclats de noisettes torréfiées.|Glaçage miroir au chocolat noir 70% et billes de chocolat croquantes.', NULL, 'EclatF-max', 'EclatF', 'Plongez dans l\'excellence avec un foie gras onctueux et son chutney acidulé, suivi d\'un chapon fondant accompagné d\'un gratin généreusement truffé. Pour conclure, succombez à notre bûche signature, un écrin de chocolat intense et de noisettes croquantes.', NULL, 1, NULL, NULL, 10,12,7),
(2, 'Forêt d\'Hiver', 'noel', 'vegan', 5, 30, 40, 'Velouté de Châtaignes & Diamant Noir', 'Le Wellington de Potimarron aux Noix', 'La Bûche Chocolat Noir & Poire Confite', 'Vin rouge vegan – Côtes du Rhône sélection|Mocktail agrumes & romarin|Jus de pomme pétillant bio', 'Gluten|Fruits à coque', 'J\'ai conçu ce menu comme une promenade sensorielle sous les bois. L\'enjeu était de travailler les racines et les fruits à coque (châtaigne, panais, noix) pour offrir une richesse de textures capable de rivaliser avec les tables les plus prestigieuses.', 'Crème de châtaignes d\'Ardèche liée au lait de coco, surmontée de brisures de truffe noire fraîche.|Croûtons de pain de campagne frottés à l\'ail et quelques herbes folles.', 'Rôti de potimarron rôti et duxelles de champignons de Paris, enveloppés dans une pâte feuilletée artisanale croustillante.|Jus réduit aux airelles, purée de panais onctueuse et noix de Grenoble torréfiées.', 'Mousse légère au chocolat noir intense (70%), insert de poires caramélisées et biscuit moelleux aux amandes.|Miroir cacao et fines lamelles de poires fraîches.', NULL, 'ForêtH-max', 'ForêtH', 'Découvrez la magie d\'un velouté de châtaignes onctueux parfumé à la truffe, suivi d\'un feuilleté Wellington doré au cœur fondant de potimarron. En apothéose, savourez une bûche aérienne mêlant l\'intensité du chocolat noir à la fraîcheur d\'une poire rôtie.', NULL, 1, NULL, NULL, 10, 12,7),
(3, 'Union Sacré', 'mariage', 'non-vegan', 20, 70, 65, 'Saint-Jacques Snackées au Safran', 'Filet de Bœuf Rossini & Légumes Glacés', 'La Pièce Montée ou Pavlova Signature', 'Coup de Saint-Émilion Grand Cru|Coupe de Champagne Brut Prestige|Cocktail maison fruits rouges sans alcool', 'Gluten|Œufs|Lait|Fruits à coque', 'Pour ce jour unique, j\'ai sélectionné des produits d\'exception. C\'est un menu de \"haute couture\" culinaire où le filet de bœuf Rossini et les Saint-Jacques au safran assurent une élégance intemporelle dans l\'assiette.', 'Noix de Saint-Jacques de la baie de Seine saisies minute, crème légère infusée au safran pur et fondue de poireaux au vin blanc.', 'Cœur de filet de bœuf surmonté d\'une escalope de foie gras poêlée, jus de viande corsé à la truffe.|Un écrasé de pommes de terre à l\'huile de truffe blanche, haricots verts extra-fins et tomates cerises confites.', 'Choux caramélisés à la crème vanille Bourbon ou meringue craquante, crème fouettée et fruits frais selon votre choix.', NULL, 'UnionS-max', 'UnionS', 'Démarrez les festivités avec la finesse des Saint-Jacques au safran, suivies d\'un filet de bœuf Rossini d\'une tendreté royale. Clôturez ce moment inoubliable avec une pièce montée artisanale ou une Pavlova aérienne aux fruits de saison.', NULL, 1, NULL, NULL,1,12,21),
(4, 'Amour Éternel', 'mariage', 'vegan', 20, 70, 55, 'Tartare de Mangue & Avocat', 'Steak de Chou-fleur Rôti Chimichurri', 'Dôme Framboise & Pistache', 'Vin rouge vegan – Bordeaux sélection|Cocktail signature framboise & basilic|Citronnade artisanale maison', 'Gluten|Œufs|Lait|Fruits à coque', 'Ce menu prouve que l\'éthique peut rimer avec chic. J\'ai privilégié le graphisme des plats et l\'exotisme des saveurs (mangue, pistache, chimichurri) pour marquer les esprits et régaler tous vos convives, sans aucun compromis.', 'Dés de mangue fraîche et avocat Haas, assaisonnés au citron vert, huile de sésame et baies roses.|Chutney de figues violettes aux éclats de noix, pain brioché artisanal toasté au beurre demi-sel.', 'Tranche de chou-fleur épaisse rôtie au four, sauce chimichurri aux herbes fraîches, accompagnée d\'un écrasé de patates douces.|Gratin de pommes de terre façon \"Dauphinois\" à la truffe noire de pays, marrons entiers confits au bouillon et pointes d\'asperges grillées.', 'Mousse framboise légère sur un biscuit moelleux à la pistache d\'Iran, nappage miroir aux fruits rouges.', NULL, 'menu_4_1781810374.png', 'AmourE', 'Célébrez votre union avec un tartare de mangue et avocat exotique, suivi d\'un steak de chou-fleur rôti aux épices chimichurri pour une explosion de saveurs. En dessert, un dôme framboise et pistache apportera une touche finale raffinée et colorée.', NULL, 1, NULL, NULL, 1, 12,21),
(5, 'Renouveau', 'paque', 'non-vegan', 5, 30, 39, 'L\'Asperge Verte & l\'Œuf Parfait', 'La Souris d\'Agneau de Sept Heures', 'L\'Entremets Chocolat-Praliné', 'Coupe de Saint-Émilion Grand Cru|Coupe de Champagne Brut Premier Cru|Jus de pomme fermier pressé', 'Gluten|Œufs|Lait', 'Pâques est la fête de la tendresse. Entre la délicatesse de l\'œuf parfait et la patience d\'un agneau confit sept heures, ce menu célèbre le temps long et le retour des produits verts du potager.', 'Asperges vertes de pays simplement grillées, œuf bio cuit à basse température (64°C), émulsion hollandaise légère au citron de Menton.', 'Agneau confit lentement dans son jus au thym et romarin, accompagné d\'une purée de pois frais à la menthe et de pommes grenailles rôties.|Une mousseline de petits pois frais à la menthe douce, pommes grenailles rôties au sel de Guérande et jeunes carottes fanes glacées.', 'Mousse chocolat au lait grand cru, cœur praliné croustillant à la fleur de sel et biscuit dacquoise noisette.', NULL, 'Renouveau-max', 'Renouveau', 'Laissez-vous séduire par la fraîcheur des asperges croquantes et leur œuf mollet, avant de savourer une souris d\'agneau confite pendant sept heures à la tendreté absolue. Terminez sur une note de pur plaisir avec un entremets chocolaté au praliné croustillant.', NULL, 1, NULL, NULL,3,6,7),
(6, 'Printemps Bio', 'paque', 'vegan', 5, 30, 46, 'Carpaccio de Radis Noir & Agrumes', 'Risotto Crémeux aux Morilles', 'Tartelette Fraise & Coco', 'Vin rouge vegan – Domaine du Sud-Ouest|Spritz fruits rouges sans alcool|Jus de pomme bio artisanal', 'Gluten (option sans possible)', 'Ici, la star est le végétal dans ce qu\'il a de plus pur. Je mise sur la puissance aromatique des morilles et la vivacité des agrumes pour proposer un menu printanier léger, équilibré et résolument moderne.', 'Fines lamelles de radis noir marinées au citron vert, suprêmes de pamplemousse rose, baies roses et huile d\'olive vierge.', 'Riz Carnaroli lié à la crème de soja et levure maltée, morilles fraîches sautées à l\'ail des ours et jeunes pousses d\'épinards.|Une fricassée d\'asperges sauvages et de tuiles de parmesan végétal maison.', 'Pâte sablée végétale à l\'amande, crème pâtissière onctueuse à la noix de coco et fraises fraîches de pleine terre.', NULL, 'PrintempsBio-max', 'PrintempsBio', 'Éveillez vos papilles avec un carpaccio de radis noir aux agrumes pétillants, suivi d\'un risotto onctueux aux morilles sauvages, véritable trésor de saison. En conclusion, dégustez une tartelette aux fraises printanières sur une crème de coco veloutée.', NULL, 1, NULL, NULL,3,6,7),
(7, 'Signature Terroir', 'seminaire', 'non-vegan', 5, 40, 30, 'Salade de Saint-Jacques Poêlées', 'Filet de Canette Rôti & Jus de Miel', 'Tarte Tatin Déstructurée', 'Coupe de Côtes du Rhône Village|Bière artisanale blonde locale|Limonade artisanale française', 'Gluten|Crustacés|Lait', 'Avec ce menu, j\'ai voulu célébrer l\'art de vivre à la française. C\'est un équilibre entre la finesse marine de la Saint-Jacques et le caractère de la canette rôtie. Un hommage aux produits de nos régions.', 'Noix de Saint-Jacques saisies au beurre, servies sur un lit de jeunes pousses, vinaigrette aux agrumes et éclats de noisettes torréfiées.', 'Canette rôtie rosée, jus réduit au miel et vinaigre balsamique.|Gratin dauphinois traditionnel à la crème de Normandie et poêlée de champignons de saison persillés.', 'Pommes caramélisées au beurre salé, sablé breton émietté et crème fouettée à la vanille de Madagascar.', NULL, 'SignatureT-max', 'SignatureT', 'Redécouvrez l\'authenticité du terroir avec une poêlée de Saint-Jacques délicate, suivie d\'un filet de canette rôti aux saveurs forestières. Pour finir, laissez-vous surprendre par une tarte Tatin déstructurée, mariage parfait du chaud et du froid.', NULL, 1, NULL, NULL,1,12,7),
(8, 'Végétal Chic', 'seminaire', 'vegan', 5, 40, 25, 'Taboulé de Quinoa aux Herbes Fraîches', 'Curry de Pois Chiches au Lait de Coco', 'Carpaccio d\'Ananas & Sorbet Citron', 'Vin rouge vegan – Languedoc sélection|Mocktail pomme & gingembre|Limonade bio artisanale', 'Sésame (dans le pain)', 'Ce menu est une démonstration que la cuisine végétale peut être aussi graphique que gourmande. J\'ai misé sur la fraîcheur des herbes et la chaleur des épices pour créer un voyage sensoriel léger.', 'Trio de quinoa, menthe ciselée, persil plat, grenades croquantes, zestes de citron jaune et huile d\'olive vierge.', 'Pois chiches fondants mijotés dans un mélange d\'épices douces (curcuma, cumin, gingembre) et lait de coco crémeux.|Riz basmati parfumé à la cardamome, coriandre fraîche et pain plat (Naan végétal) maison.', 'Fines tranches d\'ananas Victoria infusées au sirop de basilic, servies avec un sorbet citron vert artisanal.', NULL, 'VegetalC-max_1782374002.png', 'VegetalC', 'Voyagez au cœur des saveurs végétales avec un quinoa aux herbes fraîches et croquantes, suivi d\'un curry de pois chiches onctueux aux parfums d\'Orient. Terminez en douceur avec un carpaccio d\'ananas rafraîchissant infusé à la coriandre.', NULL, 1, NULL, NULL,1,12,7),
(9, 'Le Gourmand', 'casse-croûte', 'non-vegan', 1, 50, 19, 'Salade piémontaise aux pommes de terre grenaille, cornichons et ciboulette', 'Émincé de rôti de porc fermier, écrasé de carottes au beurre et brocolis', 'Panna cotta à la vanille de Bourbon et son coulis de fruits rouges', NULL, 'Oeufs|Moutarde|Lait', 'Ce casse-croûte est un hommage aux déjeuners généreux et conviviaux de notre région. Conçu pour offrir une vraie pause gourmande et rassasiante au milieu d\'une journée bien remplie, il réinterprète avec simplicité des classiques de la cuisine bourgeoise. Tout le savoir-faire de notre maison traiteur est mis au service de produits locaux rigoureusement sélectionnés pour vous offrir un plat du midi accessible, authentique et sans chichi.', 'Une salade piémontaise à notre façon, mêlant la douceur des pommes de terre grenaille fondantes au croquant des cornichons et à la fraîcheur de la ciboulette, le tout lié par une mayonnaise maison légère.', 'Un tendre émincé de rôti de porc fermier de la région, arrosé de son jus de cuisson réduit au thym et accompagné d\'un écrasé de carottes au beurre et de sommités de brocolis croquants.', 'Une panna cotta onctueuse à la vanille de Bourbon, surmontée d\'un coulis de fruits rouges acidulé pour finir sur une note de fraîcheur.', NULL, 'menu_9_1781810338.png', 'Gourmand', 'Le bon goût du terroir, tout simplement. Un déjeuner réconfortant \"a la bonne franquette\" avec un rôti de porc ultra-tendre et sa salade piémontaise revisitée.', NULL, 1, 50, NULL,1,12, 0),
(10, 'Le Bassin', 'casse-croûte', 'non-vegan', 1, 50, 18, 'Rillettes artisanales de poisson blanc de l\'Atlantique, aneth et citron vert', 'Suprême de poulet rôti au thym, penne au pesto de basilic maison et tomates confites', 'Moelleux au chocolat noir intense et pointe de fleur de sel', NULL, 'Poisson|Lait|Gluten|Fruits à coque', 'Le Casse-croûte \"Le Vignoble\" est notre réponse végétale à la demande de gourmandise et de simplicité. Pensé comme une balade dans nos jardins et vignobles, il sublime les légumes de saison et les céréales rustiques. Ce casse-croûte n\'est pas une simple alternative, mais une proposition culinaire à part entière, où chaque ingrédient est travaillé pour sa saveur et sa texture.', 'Nos rillettes de poisson blanc de l\'Atlantique, travaillées à la main avec une touche de crème fraîche, de l\'aneth et du citron vert, servies avec de petits croûtons de pain croustillants.', 'Un suprême de poulet rôti au thym, escorté de penne rigate généreusement enrobées d\'un pesto de basilic frais maison, de parmesan et de tomates confites fondantes.', 'Un moelleux au chocolat noir intense et sa pointe de fleur de sel de l\'Atlantique, pour une touche finale terriblement gourmande.', NULL, 'Bassin-max', 'Bassin', 'Une brise de fraîcheur iodée dans votre pause dej. Craquez pour nos rillettes maison et l\'incontournable poulet rôti au pesto, un menu frais et savoureux comme un retour du marché.', NULL, 1, 150, NULL,1,12, 0),
(11, 'Le Vignoble', 'casse-croûte', 'vegan', 1, 50, 17, 'Salade de sarrasin grillé, noisettes concassées et brunoise de légumes', 'Tian de légumes d\'été confits sur lit de quinoa bicolore', 'Crumble aux pommes de saison, sarrasin et amandes', NULL, 'Fruit à coque', 'Le Casse-croûte \"Le Vignoble\" est notre réponse végétale à la demande de gourmandise et de simplicité. Pensé comme une balade dans nos jardins et vignobles, il sublime les légumes de saison et les céréales rustiques. Ce casse-croûte n\'est pas une simple alternative, mais une proposition culinaire à part entière, où chaque ingrédient est travaillé pour sa saveur et sa texture. Tout le savoir-faire de nos cuisiniers est utilisé pour créer un plat vegan riche, rassasiant et plein de caractère.', 'Une salade de sarrasin grillé (kasha), mêlée à des noisettes concassées et une brunoise de légumes croquants, relevée d\'une vinaigrette légère aux herbes du jardin.', 'Un tian de légumes d\'été confits (aubergines, courgettes, poivrons, oignons) rôtis lentement au four avec de l\'huile d\'olive et des herbes de Provence, servi sur un lit de quinoa rouge et blanc.', 'Un crumble aux pommes de saison, où le sarrasin et la poudre d\'amande remplacent la farine, servi avec une compote de fruits de saison.', NULL, 'menu_11_1781810354.png', 'Vignoble', 'La richesse du potager dans votre casse-croûte. Une escale végétale gourmande qui met à l\'honneur les légumes rôtis et le sarrasin, pour un midi plein d\'énergie et de saveurs.', NULL, 1, 50, NULL,1,12, 0);

-- --------------------------------------------------------

--
-- Table structure for table `renseignement`
--

CREATE TABLE `renseignement` (
  `adresse` varchar(255) NOT NULL DEFAULT '42 Rue du Pas-Saint-Georges, 33000 Bordeaux',
  `tel_restaurant` varchar(20) NOT NULL DEFAULT '05 56 44 12 89',
  `mail` varchar(250) NOT NULL DEFAULT 'contact@vite-et-gourmand-traiteur.fr'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
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
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nom`, `prenom`, `email`, `password`, `tel`, `code_postal`, `adresse`, `ville`, `complement_adresse`, `created_at`, `role`, `actif`, `remember_token`, `reset_token`, `reset_token_expiry`) VALUES
(1, 'Nom_admin', 'Prénom_admin', 'admin@vite-et-gourmand.fr', '$2y$10$j.UcB3mTfgkgABklHECaz.bWXp2gS2H2z2KPYn6dZy6zf5HoshOji', '01.01.01.01.01', '99999', 'rue de l\'adminstrateur', 'Administrateur', NULL, '2026-06-22 11:27:26', 'admin', 1, '94ec2a93ac81312e53f550a916aea2603da45038f08e635bf4f6a0cc7c4155b8', NULL, NULL),
(2, 'Nom_employé', 'Prénom_employé', 'employe@vite-et-gourmand.fr', '$2y$10$PzpLB0Ad0YaqV309I/ftieoP9R85rI5JZK1LkTu/6nHuyqUvH52CO', NULL, NULL, NULL, NULL, NULL, '2026-06-22 11:28:42', 'employe', 1, NULL, NULL, NULL),
(3, 'Nom_user', 'Prénom_user', 'user@vite-et-gourmand.fr', '$2y$10$F1vqYg0D15spzk4TlokmFeRbzAC9086WqVlwmohC1mLFgYAkasbrW', '02.02.02.02.02', '99999', 'chez l\'utilisateur', 'User', NULL, '2026-06-22 11:30:36', 'user', 1, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `avis`
--
ALTER TABLE `avis`
  ADD PRIMARY KEY (`Id_avis`),
  ADD KEY `user_id` (`Id_user`);

--
-- Indexes for table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`Id_commande`),
  ADD KEY `Id_user` (`Id_user`);

--
-- Indexes for table `commande_detail`
--
ALTER TABLE `commande_detail`
  ADD PRIMARY KEY (`Id_detail`),
  ADD KEY `Id_commande` (`Id_commande`),
  ADD KEY `Id_menu` (`Id_menu`);

--
-- Indexes for table `horaires`
--
ALTER TABLE `horaires`
  ADD PRIMARY KEY (`Id_horaire`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`Id_menu`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `Email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `avis`
--
ALTER TABLE `avis`
  MODIFY `Id_avis` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `commande`
--
ALTER TABLE `commande`
  MODIFY `Id_commande` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `commande_detail`
--
ALTER TABLE `commande_detail`
  MODIFY `Id_detail` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `horaires`
--
ALTER TABLE `horaires`
  MODIFY `Id_horaire` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `Id_menu` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `avis`
--
ALTER TABLE `avis`
  ADD CONSTRAINT `avis_ibfk_1` FOREIGN KEY (`Id_user`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`Id_user`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `commande_detail`
--
ALTER TABLE `commande_detail`
  ADD CONSTRAINT `commande_detail_ibfk_1` FOREIGN KEY (`Id_commande`) REFERENCES `commande` (`Id_commande`),
  ADD CONSTRAINT `commande_detail_ibfk_2` FOREIGN KEY (`Id_menu`) REFERENCES `menu` (`Id_menu`);
COMMIT;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
