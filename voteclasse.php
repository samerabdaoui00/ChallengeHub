<?php
class Vote {
    private int $id;
    private int $submission_id;
    private int $user_id;
    private int $value;
    private DateTime $created_at;

    public function create(): bool {
        // Logique de création
    }

    public static function getBySubmission(int $submission_id): array {
        // Logique de récupération par soumission
    }

    public static function getByUser(int $user_id): array {
        // Logique de récupération par utilisateur
    }
}
?>