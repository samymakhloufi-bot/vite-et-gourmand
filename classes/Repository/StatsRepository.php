<?php
// classes/Repository/StatsRepository.php

class StatsRepository {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function create(
        int $commandeId,
        int $menuId,
        string $menuTitre,
        float $montantTotal,
        int $nombrePersonnes,
        float $reduction,
        float $fraisLivraison,
        string $statut = 'en_attente'
    ): int {
        $stmt = $this->pdo->prepare(
            "INSERT INTO commandes_stats (commande_id, menu_id, menu_titre, montant_total, nombre_personnes, reduction, frais_livraison, statut, date)
            VALUES (:commande_id, :menu_id, :menu_titre, :montant_total, :nombre_personnes, :reduction, :frais_livraison, :statut, :date)"
        );
        $stmt->execute([
            'commande_id'      => $commandeId,
            'menu_id'          => $menuId,
            'menu_titre'       => $menuTitre,
            'montant_total'    => $montantTotal,
            'nombre_personnes' => $nombrePersonnes,
            'reduction'        => $reduction,
            'frais_livraison'  => $fraisLivraison,
            'statut'           => $statut,
            'date'             => date('Y-m-d H:i:s')
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    public function updateStatut(int $commandeId, string $statut): void {
        $stmt = $this->pdo->prepare("UPDATE commandes_stats SET statut = :statut WHERE commande_id = :commande_id");
        $stmt->execute(['statut' => $statut, 'commande_id' => $commandeId]);
    }

    public function getCATotalDepuis(string $depuis): float {
        $stmt = $this->pdo->prepare(
            "SELECT SUM(montant_total) AS total FROM commandes_stats WHERE date >= :depuis AND statut = 'terminee'"
        );
        $stmt->execute(['depuis' => $depuis]);
        return (float)($stmt->fetch()['total'] ?? 0);
    }

    public function findAll(array $filters = []): array {
        $sql = "SELECT * FROM commandes_stats WHERE 1=1";
        $params = [];

        if (!empty($filters['menu_titre'])) {
            $sql .= " AND menu_titre = :menu_titre";
            $params['menu_titre'] = $filters['menu_titre'];
        }
        if (!empty($filters['date_debut'])) {
            $sql .= " AND date >= :date_debut";
            $params['date_debut'] = $filters['date_debut'] . ' 00:00:00';
        }
        if (!empty($filters['date_fin'])) {
            $sql .= " AND date <= :date_fin";
            $params['date_fin'] = $filters['date_fin'] . ' 23:59:59';
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getMenusDistincts(): array {
        return $this->pdo->query("SELECT DISTINCT menu_titre FROM commandes_stats")->fetchAll(PDO::FETCH_COLUMN);
    }
}