<?php
class Participation {
    private int $id;
    private int $challenge_id;
    private int $user_id;
    private string $description;
    private ?string $image;
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

    public static function getById(int $id): ?Participation {
        // Logique de récupération par ID
        //fhemtech
    }

    public static function getByChallenge(int $challenge_id): array {
        // Logique de récupération par challenge
        //fhemtech
    }

    public static function getByUser(int $user_id): array {
        // Logique de récupération par utilisateur
        //fhemtechs
    }
}
?>