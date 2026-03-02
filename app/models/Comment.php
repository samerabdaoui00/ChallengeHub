<?php
class Commentaire {
    private int $id;
    private int $submission_id;
    private int $user_id;
    private string $content;
    private DateTime $created_at;

    public function create(): bool {
    }


    public function delete(): bool {
    }

    public static function getBySubmission(int $submission_id): array {
    }

    public static function getByUser(int $user_id): array {
    }
}
?>