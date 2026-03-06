<?php
require_once(__DIR__ . "/../../config/configuration.php");

// This class represents a challenge posted on the platform
// A challenge has a title, description, category, optional image and a deadline
// Other users can submit participations to it
class Challenge
{
    private ?int    $id          = null; // null before it's saved in DB
    private int     $user_id;           // who created this challenge
    private string  $title;
    private string  $description;
    private string  $category;
    private ?string $image;             // optional image for the challenge
    private ?string $deadline;          // deadline can be null if no limit
    private ?string $created_at = null; // set automatically by MySQL

    // We pass the id only when loading from DB (it's null when creating a new challenge)
    public function __construct(int $user_id, string $title, string $description, string $category, ?string $deadline, ?string $image = null, ?int $id = null)
    {
        $this->id          = $id;
        $this->user_id     = $user_id;
        $this->title       = $title;
        $this->description = $description;
        $this->category    = $category;
        $this->deadline    = $deadline;
        $this->image       = $image;
    }

    // --- Getters (we use private properties so we need these) ---
    public function getId(): ?int       { return $this->id; }
    public function getUserId(): int    { return $this->user_id; }
    public function getTitle(): string  { return $this->title; }
    public function getDescription(): string { return $this->description; }
    public function getCategory(): string    { return $this->category; }
    public function getImage(): ?string      { return $this->image; }
    public function getDeadline(): ?string   { return $this->deadline; }
    public function getCreatedAt(): ?string  { return $this->created_at; }

    // Saves this challenge to the database
    // After insert we store the new ID that MySQL generated
    public function create(): bool
    {
        $connexion = connect_bd();

        $sql = "INSERT INTO challenges (user_id, title, description, category, image, deadline) 
                VALUES (:user_id, :title, :description, :category, :image, :deadline)";
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':user_id',     $this->user_id);
        $stmt->bindParam(':title',       $this->title);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':category',    $this->category);
        $stmt->bindParam(':image',       $this->image);
        $stmt->bindParam(':deadline',    $this->deadline);

        if ($stmt->execute()) {
            $this->id = $connexion->lastInsertId(); // save the auto-generated ID
            return true;
        }

        return false;
    }

    // Updates an existing challenge with new data from the edit form
    public function update(array $data): bool
    {
        $connexion = connect_bd();

        $sql = "UPDATE challenges 
                SET title = :title, description = :description, 
                    category = :category, image = :image, deadline = :deadline 
                WHERE id = :id";
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':title',       $data['title']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':category',    $data['category']);
        $stmt->bindParam(':image',       $data['image']);
        $stmt->bindParam(':deadline',    $data['deadline']);
        $stmt->bindParam(':id',          $this->id);

        return $stmt->execute();
    }

    // Deletes this challenge from the database
    public function delete(): bool
    {
        $connexion = connect_bd();

        $sql  = "DELETE FROM challenges WHERE id = :id";
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }

    // --- Static methods: used to fetch challenges from the DB ---

    // Returns one challenge by its ID, or null if not found
    public static function getById(int $id): ?Challenge
    {
        $connexion = connect_bd();

        $sql  = "SELECT * FROM challenges WHERE id = :id";
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            $challenge = new Challenge(
                $data['user_id'],
                $data['title'],
                $data['description'],
                $data['category'],
                $data['deadline'],
                $data['image'],
                $data['id']
            );
            $challenge->created_at = $data['created_at'];
            return $challenge;
        }

        return null;
    }

    // Returns all challenges sorted by newest first
    public static function getAll(): array
    {
        $connexion  = connect_bd();
        $sql        = "SELECT * FROM challenges ORDER BY created_at DESC";
        $stmt       = $connexion->query($sql);
        $challenges = [];

        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $challenge = new Challenge(
                $data['user_id'],
                $data['title'],
                $data['description'],
                $data['category'],
                $data['deadline'],
                $data['image'],
                $data['id']
            );
            $challenge->created_at = $data['created_at'];
            $challenges[] = $challenge;
        }

        return $challenges;
    }

    // Returns all challenges created by a specific user
    public static function getByUser(int $user_id): array
    {
        $connexion = connect_bd();

        $sql  = "SELECT * FROM challenges WHERE user_id = :user_id ORDER BY created_at DESC";
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        $challenges = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $challenge = new Challenge(
                $data['user_id'],
                $data['title'],
                $data['description'],
                $data['category'],
                $data['deadline'],
                $data['image'],
                $data['id']
            );
            $challenge->created_at = $data['created_at'];
            $challenges[] = $challenge;
        }

        return $challenges;
    }

    // Searches challenges by keyword (title or description) and/or category
    // We build the SQL query dynamically depending on which filters are provided
    public static function search(string $keyword = '', string $category = ''): array
    {
        $connexion = connect_bd();

        // start with a base query that always returns something (WHERE 1=1 is a trick
        // so we can safely append AND conditions without worrying about the first one)
        $sql    = "SELECT * FROM challenges WHERE 1=1";
        $params = [];

        if (!empty($keyword)) {
            // search in both title and description
            $sql .= " AND (title LIKE :keyword OR description LIKE :keyword)";
            $params[':keyword'] = '%' . $keyword . '%';
        }

        if (!empty($category)) {
            $sql .= " AND category = :category";
            $params[':category'] = $category;
        }

        $sql .= " ORDER BY created_at DESC";

        $stmt = $connexion->prepare($sql);
        foreach ($params as $key => &$val) {
            $stmt->bindParam($key, $val);
        }
        $stmt->execute();

        $challenges = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $challenge = new Challenge(
                $data['user_id'],
                $data['title'],
                $data['description'],
                $data['category'],
                $data['deadline'],
                $data['image'],
                $data['id']
            );
            $challenge->created_at = $data['created_at'];
            $challenges[] = $challenge;
        }

        return $challenges;
    }
}
?>
