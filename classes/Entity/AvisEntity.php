<?php 

class Avis{
    private int $id_avis;
    private int $id_user;
    private string $contenu;
    private string $statut_avis;
    private string $created_at;
    private int $note;
    private ?string $nom;
    private ?string $prenom;


    public function __construct(array $data) {
        $this->id_avis  = (int)$data['Id_avis'];
        $this->id_user = (int)$data['Id_user'];
        $this->contenu = (string)$data['contenu'];
        $this->statut_avis = (string)$data['statut_avis'];
        $this->created_at = (string)$data['created_at'];
        $this->note = (int)$data['note'];
        $this->nom = $data['nom'] ?? null;
        $this->prenom = $data['prenom'] ?? null;
    }

    public function getIdAvis(): int          { return $this->id_avis; }
    public function getIdUserAvis(): int      { return $this->id_user; }
    public function getContenuAvis(): string  { return $this->contenu; }
    public function getStatutAvis(): string { return $this->statut_avis; }
    public function getCreatedAtAvis(): string { return $this->created_at; }
    public function getNoteAvis(): int        { return $this->note; }
    public function getNomUserAvis(): ?string     { return $this->nom; }
    public function getPrenomUserAvis(): ?string  { return $this->prenom; }
    }