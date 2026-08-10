<?php

use MongoDB\BSON\UTCDateTime;
use MongoDB\Collection;
class StatsRepository {
    private Collection $collection;

    public function __construct(Collection $collection) {
        $this->collection = $collection;
    }

    public function create(
        int $commandeId,
        int $menuId,
        string $menuTitre,
        float $montantTotal,
        int $nombrePersonnes,
        float $reduction,
        float $fraisLivraison,
        string $statut = 'en_attente',
        ?DateTimeInterface $dateCommande = null
    ): void {
        $this->synchroniserCommande([
            'commande_id' => $commandeId,
            'menu_id' => $menuId,
            'menu_titre' => $menuTitre,
            'montant_total' => $montantTotal,
            'nombre_personnes' => $nombrePersonnes,
            'reduction' => $reduction,
            'frais_livraison' => $fraisLivraison,
            'statut' => $statut,
            'date' => $dateCommande ?? new DateTimeImmutable(),
        ]);
    }

    public function synchroniserCommande(array $commande): void {
        $date = $commande['date'] ?? new DateTimeImmutable();

        if (!$date instanceof DateTimeInterface) {
            $date = new DateTimeImmutable((string) $date);
        }

        $this->collection->updateOne(
            ['commande_id' => (int) $commande['commande_id']],
            [
                '$set' => [
                    'menu_id' => (int) $commande['menu_id'],
                    'menu_titre' => (string) $commande['menu_titre'],
                    'montant_total' => (float) $commande['montant_total'],
                    'nombre_personnes' => (int) $commande['nombre_personnes'],
                    'reduction' => (float) $commande['reduction'],
                    'frais_livraison' => (float) $commande['frais_livraison'],
                    'statut' => (string) $commande['statut'],
                    'date' => $this->toUtcDateTime($date),
                    'updated_at' => new UTCDateTime(),
                ],
            ],
            ['upsert' => true]
        );
    }

    public function updateStatut(int $commandeId, string $statut): void {
        $result = $this->collection->updateOne(
            ['commande_id' => $commandeId],
            ['$set' => ['statut' => $statut, 'updated_at' => new UTCDateTime()]]
        );

        if ($result->getMatchedCount() === 0) {
            throw new RuntimeException("Commande NoSQL #{$commandeId} introuvable.");
        }
    }

    public function updateMontant(
        int $commandeId,
        float $montantTotal,
        int $nombrePersonnes,
        float $reduction
    ): void {
        $result = $this->collection->updateOne(
            ['commande_id' => $commandeId],
            ['$set' => [
                'montant_total' => $montantTotal,
                'nombre_personnes' => $nombrePersonnes,
                'reduction' => $reduction,
                'updated_at' => new UTCDateTime(),
            ]]
        );

        if ($result->getMatchedCount() === 0) {
            throw new RuntimeException("Commande NoSQL #{$commandeId} introuvable.");
        }
    }

    public function getCATotalDepuis(string $depuis): float {
        $resultats = $this->collection->aggregate([
            ['$match' => [
                'date' => ['$gte' => $this->toUtcDateTime(new DateTimeImmutable($depuis))],
                'statut' => 'terminee',
            ]],
            ['$group' => ['_id' => null, 'total' => ['$sum' => '$montant_total']]],
        ]);

        foreach ($resultats as $resultat) {
            return (float) ($resultat['total'] ?? 0);
        }

        return 0.0;
    }

    public function findAll(array $filters = []): array {
        $query = [];

        if (!empty($filters['menu_titre'])) {
            $query['menu_titre'] = $filters['menu_titre'];
        }

        if (!empty($filters['date_debut'])) {
            $query['date']['$gte'] = $this->toUtcDateTime(
                new DateTimeImmutable($filters['date_debut'] . ' 00:00:00')
            );
        }

        if (!empty($filters['date_fin'])) {
            $query['date']['$lte'] = $this->toUtcDateTime(
                new DateTimeImmutable($filters['date_fin'] . ' 23:59:59')
            );
        }

        $documents = [];
        foreach ($this->collection->find($query, ['sort' => ['date' => -1]]) as $document) {
            $documents[] = $document instanceof ArrayObject
                ? $document->getArrayCopy()
                : (array) $document;
        }

        return $documents;
    }

    public function getMenusDistincts(): array {
        $menus = $this->collection->distinct('menu_titre');
        sort($menus, SORT_NATURAL | SORT_FLAG_CASE);

        return $menus;
    }

    public function ensureIndexes(): void {
        $this->collection->createIndex(['commande_id' => 1], ['unique' => true]);
        $this->collection->createIndex(['date' => 1, 'statut' => 1]);
        $this->collection->createIndex(['menu_titre' => 1]);
    }

    private function toUtcDateTime(DateTimeInterface $date): UTCDateTime {
        return new UTCDateTime($date->getTimestamp() * 1000);
    }
}
