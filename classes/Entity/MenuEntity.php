<?php 

class Menu {
    private int $id_menu;
    private string $menu_nom;
    private float $prix_menu;
    private int $nb_perso_min;
    private string $description;
    private ?string $img_desktop;
    private ?string $img_mobile;
    private ?string $img_uploaded;
    private ?int $quantite_restante;
    private int $actif;
    private ?string $conditions;
    private ?string $regime;
    private ?string $theme;
    private ?string $link;
    private ?string $entree;
    private ?string $entree_description;
    private ?string $plat;
    private ?string $plat_description;
    private ?string $boisson;
    private ?string $dessert;
    private ?string $dessert_description;
    private ?string $allergene;


    public function __construct(array $data) {
        $this->id_menu           = (int)$data['Id_menu'];
        $this->menu_nom          = $data['menu_nom'];
        $this->prix_menu         = (float)$data['prix_menu'];
        $this->nb_perso_min      = (int)$data['nb_perso_min'];
        $this->description       = $data['description'] ?? '';
        $this->quantite_restante = isset($data['quantite_restante']) ? (int)$data['quantite_restante'] : null;
        $this->img_desktop       = $data['img_desktop'] ?? null;
        $this->img_mobile        = $data['img_mobile'] ?? null;
        $this->img_uploaded      = $data['img_uploaded'] ?? null;
        $this->conditions        = $data['conditions'] ?? null;
        $this->regime            = $data['regime'] ?? null;
        $this->theme             = $data['theme'] ?? null;
        $this->link              = $data['link'] ?? null;
        $this->entree            = $data['entree'] ?? null;           
        $this->entree_description = $data['entree_description']?? null;
        $this->plat              = $data['plat']?? null;
        $this->plat_description  = $data['plat_description']?? null;
        $this->boisson           = $data['boisson']?? null;
        $this->dessert           = $data['dessert']?? null;
        $this->dessert_description = $data['dessert_description']?? null;
        $this->allergene         = $data['allergene']?? null;
    
        }

    public function getId(): int             { return $this->id_menu; }
    public function getNom(): string         { return $this->menu_nom; }
    public function getPrix(): float         { return $this->prix_menu; }
    public function getNbPersoMin(): int     { return $this->nb_perso_min; }
    public function getDescription(): string { return $this->description; }
    public function getImgDesktop(): ?string  { return $this->img_desktop; }
    public function getImgMobile(): ?string   { return $this->img_mobile; }
    public function getImgUploaded(): ?string { return $this->img_uploaded; }
    public function getStock(): ?int         { return $this->quantite_restante; }
    public function isActif(): bool          { return $this->actif === 1; }
    public function getConditions(): ?string { return $this->conditions; }
    public function getRegime(): ?string     { return $this->regime; }
    public function getTheme(): ?string      { return $this->theme; }
    public function getLink(): ?string       { return $this->link; }
    public function getEntree(): ?string     { return $this->entree;}
    public function getEntreeDescription(): ?string     { return $this->entree_description;}
    public function getPlat(): ?string     { return $this->plat;}
    public function getPlatDescription(): ?string     { return $this->plat_description;}
    public function getDessert(): ?string     { return $this->dessert;}
    public function getDessertDescription(): ?string     { return $this->dessert_description;}
    public function getBoisson(): ?string     { return $this->boisson;}
    public function getAllergene(): ?string     { return $this->allergene;}


    public function hasStock(): bool {
    if ($this->quantite_restante === null) return true;
    return $this->quantite_restante > 0;
    }

    public function getPrixFormatted(): string {
        return number_format($this->prix_menu, 2, ',', ' ') . ' €';
    }

    public function appliquerReduction(int $nbPersonnes): float {
        $prix = $this->prix_menu * $nbPersonnes;
        if ($nbPersonnes >= $this->nb_perso_min + 5) {
            $prix *= 0.90;
        }
        return round($prix, 2);
    }

    public function getImgDesktopUrl(): string{
        $img = $this ->img_desktop ?? '';
        return pathinfo($img, PATHINFO_EXTENSION) ? $img : $img .'.png';
    }

    public function getImgMobileUrl(): string{
        $img = $this ->img_mobile ?? '';
        return pathinfo($img, PATHINFO_EXTENSION) ? $img : $img .'.png';
    }
    }