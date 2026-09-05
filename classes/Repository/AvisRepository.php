<?php 
require_once __DIR__ .'/../Entity/AvisEntity.php';

class AvisRepository{
    private PDO $pdo;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    private function hydrate(array|false|null $data): ?Avis{
    if(!$data) return null;
    return new Avis($data);
}

private function hydrateAll(array $rows): array{
    return array_map(fn($row) => new Avis($row), $rows);
}

    public function findAvisByIdAvis(int $id): ?Avis{
        $stmt = $this->pdo->prepare("SELECT * FROM avis WHERE id_avis = ?");
        $stmt->execute([$id]);
        $data = $stmt ->fetch(PDO::FETCH_ASSOC);
        return $this->hydrate($data);
    }

    public function findAvisByIdUser(int $id): array{
        $stmt = $this->pdo->prepare("SELECT * FROM avis WHERE id_user = ?");
        $stmt->execute([$id]);
        $data = $stmt ->fetchAll(PDO::FETCH_ASSOC);
        return $this->hydrateAll($data);
    }

    public function findAvisByStatut(string $statut): array{
        $stmt = $this->pdo->prepare("SELECT a.Id_avis, a.Id_user, a.contenu, a.statut_avis, a.created_at, a.note, u.nom, u.prenom
                                    FROM avis a JOIN users u 
                                    ON a.id_user = u.id_user
                                    WHERE a.statut_avis = ? 
                                    ORDER BY a.note DESC, a.created_at 
                                    DESC LIMIT 3");
        $stmt->execute([$statut]);
        $data = $stmt ->fetchAll(PDO::FETCH_ASSOC);
        return $this->hydrateAll($data);
    }

    public function updateAvis(Avis $avis): void{
        $stmt = $this->pdo->prepare("UPDATE avis SET  statut_avis = ? WHERE id_avis = ? ");
        $stmt->execute([
            $avis->getStatutAvis(),
            $avis->getIdAvis()
        ]);
    }

    public function findAllAvis(): array{
        $stmt = $this->pdo->query("SELECT a.*, u.nom, u.prenom 
        FROM avis a 
        JOIN users u ON a.Id_user = u.Id_user 
        WHERE a.statut_avis
        ORDER BY a.created_at DESC");
        return $stmt ->fetchAll(PDO::FETCH_ASSOC);
    }
}