<?php
class Challenge {
    private int $id;
    private int $user_id;
    private string $title;
    private string $description;
    private string $category;
    private ?string $image;
    private DateTime $deadline;
    private DateTime $created_at;

    public function create(): bool {
        // Logique de création
    }

    public function update(array $data): bool {
        // Logique de mise à jour
    }

    public function delete(): bool {
        // Logique de suppression
    }

    public static function getById(int $id): ?Challenge {
        // Logique de récupération par ID
        //naarech alech
    }

    public static function getAll(): array {
        // Logique de récupération de tous les challenges
        //naarech alech
    }

    public static function getByUser(int $user_id): array {
        // Logique de récupération par utilisateur
        //naarech alech
    }
}
?>