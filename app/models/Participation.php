<?php
class Participation {
    private int $id;
    private int $challenge_id;
    private int $user_id;
    private string $description;
    private ?string $image;
    private DateTime $created_at;

    public function create(): bool {
    }

    public function update(array $data): bool {
    }

    public function delete(): bool {
    }

    public static function getById(int $id): ?Participation {
    }

    public static function getByChallenge(int $challenge_id): array {
    }

    public static function getByUser(int $user_id): array {
    }
}
?>