<?php 

class CommandeDetail{
    private int $id_detail;
    private int $id_commande;
    private int $id_menu;
    private int $quantite;
    private float $prix;
    private float $prix_total;
    private float $reduction;

    public function __construct(array $data) {
        $this->id_detail  = (int)$data['Id_detail'];
        $this->id_commande = (int)$data['Id_commande'];
        $this->id_menu    = (int)$data['Id_menu'];
        $this->quantite   = (int)$data['quantite'];
        $this->prix       = (float)$data['prix'];
        $this->prix_total = (float)$data['prix_total'];
        $this->reduction  = (float)$data['reduction'];
    }

    public function getId(): int          { return $this->id_detail; }
    public function getIdCommande(): int  { return $this->id_commande; }
    public function getIdMenu(): int      { return $this->id_menu; }
    public function getQuantite(): int    { return $this->quantite; }
    public function getPrix(): float      { return $this->prix; }
    public function getPrixTotal(): float { return $this->prix_total; }
    public function getReduction(): float { return $this->reduction; }

    public function hasReduction(): bool {
        return $this->reduction > 0;
    }

    }