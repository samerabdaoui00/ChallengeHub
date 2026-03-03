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
    }

    public function update(array $data): bool {
    }

    public function delete(): bool {
    }

    public static function getById(int $id): ?Challenge {
    }

    public static function getAll(): array {
    }

    public static function getByUser(int $user_id): array {
    }
}
?>