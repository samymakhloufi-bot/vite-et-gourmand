<?php

require_once __DIR__ . '/../Entity/MenuEntity.php';

class MenuRepository {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    private function hydrate(array|false|null $data): ?Menu{
    if(!$data) return null;
    return new Menu($data);
}

    private function hydrateAll(array|false|null $rows): array {
    if(!$rows) return [];
    return array_map(fn($row) => new Menu($row), $rows);
}

    public function findAll(bool $actifOnly = true): array {
        $sql = "SELECT * FROM menu";
        if ($actifOnly) $sql .= " WHERE actif = 1";
        $sql .= " ORDER BY menu_nom ASC";
        $stmt = $this->pdo->query($sql);
        return $this->hydrateAll($stmt->fetchAll());
    }

    public function findAllAsArray(bool $actifOnly = true): array {
    $sql = "SELECT * FROM menu";
    if ($actifOnly) $sql .= " WHERE actif = 1";
    $sql .= " ORDER BY menu_nom ASC";
    $stmt = $this->pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function findById(int $id): ?Menu {
        $stmt = $this->pdo->prepare("SELECT * FROM menu WHERE Id_menu = ?");
        $stmt->execute([$id]);
        $data = $stmt ->fetch(PDO::FETCH_ASSOC);
        return $this->hydrate($data);
    }

    public function findByLink(string $link): ?Menu {
        $stmt = $this->pdo->prepare("SELECT * FROM menu WHERE link = ? AND actif = 1 ");
        $stmt->execute([$link]);
        $data = $stmt ->fetch(PDO::FETCH_ASSOC);
        return $this->hydrate($data);
    }

    public function findByFilters(array $filters): array {
        $sql    = "SELECT * FROM menu WHERE actif = 1";
        $params = [];

        if (!empty($filters['theme'])) {
            $sql .= " AND theme = ?";
            $params[] = $filters['theme'];
        }

        if (!empty($filters['regime'])) {
            $sql .= " AND regime = ?";
            $params[] = $filters['regime'];
        }

        if (!empty($filters['prix_max'])) {
            $sql .= " AND prix_menu <= ?";
            $params[] = (float)$filters['prix_max'];
        }

        if (!empty($filters['prix_min'])) {
            $sql .= " AND prix_menu >= ?";
            $params[] = (float)$filters['prix_min'];
        }

        if (!empty($filters['nb_personnes'])) {
            $sql .= " AND nb_perso_min <= ?";
            $params[] = (int)$filters['nb_personnes'];
        }

        $sql .= " ORDER BY menu_nom ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $this->hydrateAll($stmt->fetchAll());
    }

    public function updateStock(int $id, int $quantite): void {
        $stmt = $this->pdo->prepare("UPDATE menu SET quantite_restante = ? WHERE Id_menu = ?");
        $stmt->execute([$quantite, $id]);
    }

    public function update(array $data): void {
        $stmt = $this->pdo->prepare("UPDATE menu SET menu_nom = ?, description = ?, prix_menu = ?, nb_perso_min = ?, conditions = ? WHERE Id_menu = ?");
        $stmt->execute([
            $data['menu_nom'],
            $data['description'],
            $data['prix_menu'],
            $data['nb_perso_min'],
            $data['conditions'],
            $data['id']
        ]);
    }

    public function create(array $data): int {
    $stmt = $this->pdo->prepare("INSERT INTO menu 
        (menu_nom, description, prix_menu, nb_perso_min, conditions, regime, theme, actif, quantite_restante) 
        VALUES (?, ?, ?, ?, ?, ?, ?, 1, ?)");
    $stmt->execute([
        $data['menu_nom'],
        $data['description'],
        $data['prix_menu'],
        $data['nb_perso_min'],
        $data['conditions'] ?? null,
        $data['regime'] ?? null,
        $data['theme'] ?? null,
        $data['quantite_restante'] ?? null,
    ]);
    return (int)$this->pdo->lastInsertId();
}

    public function toggleActif(int $id, int $actif): void {
        $stmt = $this->pdo->prepare("UPDATE menu SET actif = ? WHERE Id_menu = ?");
        $stmt->execute([$actif, $id]);
    }
}