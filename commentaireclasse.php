<?php
class Commentaire {
    private int $id;
    private int $submission_id;
    private int $user_id;
    private string $content;
    private DateTime $created_at;

    public function create(): bool {
        // Logique de création
    }


    public function delete(): bool {
        // Logique de suppression
    }

    public static function getBySubmission(int $submission_id): array {
        // Logique de récupération par soumission
    }

    public static function getByUser(int $user_id): array {
        // Logique de récupération par utilisateur
    }
}
?>