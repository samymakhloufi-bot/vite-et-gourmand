<?php

require_once __DIR__ . '/../Entity/CommandeEntity.php';
require_once __DIR__ . '/../Entity/CommandeDetailEntity.php';

class CommandeRepository {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    private function hydrate(?array $data): ?Commande {
        if (!$data) return null;
        return new Commande($data);
    }

    private function hydrateAll(array $rows): array {
        return array_map(fn($row) => new Commande($row), $rows);
    }

    public function findById(int $id): ?Commande {
        $stmt = $this->pdo->prepare("SELECT * FROM commande WHERE Id_commande = ?");
        $stmt->execute([$id]);
        return $this->hydrate($stmt->fetch());
    }

    public function findByUser(int $userId): array {
        $stmt = $this->pdo->prepare("SELECT * FROM commande WHERE Id_user = ? ORDER BY Id_commande DESC");
        $stmt->execute([$userId]);
        return $this->hydrateAll($stmt->fetchAll());
    }

    public function findByUserWithDetails(int $userId): array{
        $stmt = $this->pdo->prepare("SELECT c.*, m.menu_nom, cd.prix, cd.quantite,cd.prix_total, cd.reduction
        FROM commande c
        JOIN commande_detail cd ON c.Id_commande = cd.Id_commande
        JOIN menu m ON cd.Id_menu = m.Id_menu
        WHERE c.Id_user = ?
        ORDER BY c.Id_commande DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findAll(): array {
        $stmt = $this->pdo->query("SELECT c.*, u.nom, u.prenom, m.menu_nom, cd.prix, cd.quantite
            FROM commande c
            JOIN users u ON c.Id_user = u.Id_user
            JOIN commande_detail cd ON c.Id_commande = cd.Id_commande
            JOIN menu m ON cd.Id_menu = m.Id_menu
            ORDER BY c.Id_commande DESC");
        return $this->hydrateAll($stmt->fetchAll());
    }

    public function findAllWithDetails(): array{
        $stmt = $this->pdo->query("SELECT c.*, u.nom, u.prenom, m.menu_nom, cd.prix, cd.quantite
        FROM commande c
        JOIN users u ON c.Id_user = u.Id_user
        JOIN commande_detail cd ON c.Id_commande = cd.Id_commande
        JOIN menu m ON cd.Id_menu = m.Id_menu
        ORDER BY c.Id_commande DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByStatut(string $statut): array {
        $stmt = $this->pdo->prepare("SELECT * FROM commande WHERE statut = ? ORDER BY Id_commande DESC");
        $stmt->execute([$statut]);
        return $this->hydrateAll($stmt->fetchAll());
    }

    public function create(
        int $userId,
        string $dateLivraison,
        string $modePaiement,
        string $adresse,
        string $ville,
        ?string $complement,
        float $fraisLivraison,
        float $distanceKm
    ): int {
        $stmt = $this->pdo->prepare("INSERT INTO commande 
            (Id_user, date_livraison, statut, mode_paiement, adresse_livraison, ville_livraison, complement, date_commande, frais_livraison, distance_km) 
            VALUES (?, ?, 'en_attente', ?, ?, ?, ?, NOW(), ?, ?)");
        $stmt->execute([$userId, $dateLivraison, $modePaiement, $adresse, $ville, $complement, $fraisLivraison, $distanceKm]);
        return (int)$this->pdo->lastInsertId();
    }

    public function updateStatut(int $id, string $statut): void {
        $stmt = $this->pdo->prepare("UPDATE commande SET statut = ? WHERE Id_commande = ?");
        $stmt->execute([$statut, $id]);
    }

    public function annuler(int $id, string $modeContact, string $motif): void {
        $stmt = $this->pdo->prepare("UPDATE commande SET statut = 'annulee', mode_contact = ?, motif_annulation = ? WHERE Id_commande = ?");
        $stmt->execute([$modeContact, $motif, $id]);
    }

    public function findDetailsByCommande(int $commandeId): array {
        $stmt = $this->pdo->prepare("SELECT * FROM commande_detail WHERE Id_commande = ?");
        $stmt->execute([$commandeId]);
        return array_map(fn($row) => new CommandeDetail($row), $stmt->fetchAll());
    }

    public function createDetail(int $commandeId, int $menuId, int $quantite, float $prix, float $prixTotal, float $reduction): void {
        $stmt = $this->pdo->prepare("INSERT INTO commande_detail (Id_commande, Id_menu, quantite, prix, prix_total, reduction) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$commandeId, $menuId, $quantite, $prix, $prixTotal, $reduction]);
    }

    public function update(int $id, array $data): void {
        $stmt = $this->pdo->prepare("UPDATE commande SET 
            date_livraison = ?, adresse_livraison = ?, ville_livraison = ?, 
            complement = ?, frais_livraison = ?, distance_km = ?
            WHERE Id_commande = ?");
        $stmt->execute([
            $data['date_livraison'],
            $data['adresse_livraison'],
            $data['ville_livraison'],
            $data['complement'],
            $data['frais_livraison'],
            $data['distance_km'],
            $id
        ]);
    }
}