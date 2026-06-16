<?php

class Commande {
    private int $id_commande;
    private int $id_user;
    private string $date_livraison;
    private string $statut;
    private string $mode_paiement;
    private string $ville_livraison;
    private string $adresse_livraison;
    private ?string $motif_annulation;
    private ?string $mode_contact;
    private ?string $date_commande;
    private ?string $complement;
    private float $distance_km;
    private float $frais_livraison;
    private ?bool $materiel_prete;
    private ?bool $materiel_restitue;
    private ?string $date_pret;

    public function __construct(array $data) {
        $this->id_commande       = (int)$data['Id_commande'];
        $this->id_user           = (int)$data['Id_user'];
        $this->date_livraison    = $data['date_livraison'];
        $this->statut            = $data['statut'];
        $this->mode_paiement     = $data['mode_paiement'];
        $this->ville_livraison   = $data['ville_livraison'];
        $this->adresse_livraison = $data['adresse_livraison'];
        $this->motif_annulation  = $data['motif_annulation'] ?? null;
        $this->mode_contact      = $data['mode_contact'] ?? null;
        $this->date_commande     = $data['date_commande'] ?? null;
        $this->complement        = $data['complement'] ?? null;
        $this->distance_km       = (float)$data['distance_km'];
        $this->frais_livraison   = (float)$data['frais_livraison'];
        $this->materiel_prete    = isset($data['materiel_prete']) ? (bool)$data['materiel_prete'] : null;
        $this->materiel_restitue = isset($data['materiel_restitue']) ? (bool)$data['materiel_restitue'] : null;
        $this->date_pret         = $data['date_pret'] ?? null;
    }

    public function getId(): int                  { return $this->id_commande; }
    public function getIdUser(): int              { return $this->id_user; }
    public function getDateLivraison(): string    { return $this->date_livraison; }
    public function getStatut(): string           { return $this->statut; }
    public function getModePaiement(): string     { return $this->mode_paiement; }
    public function getVilleLivraison(): string   { return $this->ville_livraison; }
    public function getAdresseLivraison(): string { return $this->adresse_livraison; }
    public function getMotifAnnulation(): ?string { return $this->motif_annulation; }
    public function getModeContact(): ?string     { return $this->mode_contact; }
    public function getDateCommande(): ?string    { return $this->date_commande; }
    public function getComplement(): ?string      { return $this->complement; }
    public function getDistanceKm(): float        { return $this->distance_km; }
    public function getFraisLivraison(): float    { return $this->frais_livraison; }
    public function isMaterielPrete(): ?bool      { return $this->materiel_prete; }
    public function isMaterielRestitue(): ?bool   { return $this->materiel_restitue; }
    public function getDatePret(): ?string        { return $this->date_pret; }

    public function isAnnulable(): bool {
        return in_array($this->statut, ['en_attente']);
    }

    public function isModifiable(): bool {
        return $this->statut === 'en_attente';
    }

    public function getStatutLabel(): string {
        return ucfirst(str_replace('_', ' ', $this->statut));
    }
}