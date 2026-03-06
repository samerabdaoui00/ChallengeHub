<?php
require_once(__DIR__ . "/../../config/configuration.php");

// This class represents a participation = when a user submits something to a challenge
// In the database the table is called "submissions" (same thing, different name)
// A participation can have a description and an image
class Participation
{
    private ?int    $id           = null; // null before saving to DB
    private int     $challenge_id;        // which challenge this is for
    private int     $user_id;             // who submitted this
    private ?string $description;         // what the user wrote about their submission
    private ?string $image;               // optional image they attached
    private ?string $created_at = null;   // set by MySQL

    public function __construct(int $challenge_id, int $user_id, ?string $description = null, ?string $image = null, ?int $id = null)
    {
        $this->id           = $id;
        $this->challenge_id = $challenge_id;
        $this->user_id      = $user_id;
        $this->description  = $description;
        $this->image        = $image;
    }

    // --- Getters ---
    public function getId(): ?int           { return $this->id; }
    public function getChallengeId(): int   { return $this->challenge_id; }
    public function getUserId(): int        { return $this->user_id; }
    public function getDescription(): ?string { return $this->description; }
    public function getImage(): ?string     { return $this->image; }
    public function getCreatedAt(): ?string { return $this->created_at; }

    // Inserts this participation into the submissions table
    public function create(): bool
    {
        $connexion = connect_bd();

        $sql = "INSERT INTO submissions (challenge_id, user_id, description, image) 
                VALUES (:challenge_id, :user_id, :description, :image)";
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':challenge_id', $this->challenge_id);
        $stmt->bindParam(':user_id',      $this->user_id);
        $stmt->bindParam(':description',  $this->description);
        $stmt->bindParam(':image',        $this->image);

        if ($stmt->execute()) {
            $this->id = $connexion->lastInsertId();
            return true;
        }

        return false;
    }

    // Updates the description and image of an existing participation
    public function update(array $data): bool
    {
        $connexion = connect_bd();

        $sql = "UPDATE submissions 
                SET description = :description, image = :image 
                WHERE id = :id";
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':image',       $data['image']);
        $stmt->bindParam(':id',          $this->id);

        return $stmt->execute();
    }

    // Deletes this participation from the database
    public function delete(): bool
    {
        $connexion = connect_bd();

        $sql  = "DELETE FROM submissions WHERE id = :id";
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }

    // --- Static methods to fetch participations ---

    // Returns one participation by ID, or null if not found
    public static function getById(int $id): ?Participation
    {
        $connexion = connect_bd();

        $sql  = "SELECT * FROM submissions WHERE id = :id";
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            $participation = new Participation(
                $data['challenge_id'],
                $data['user_id'],
                $data['description'],
                $data['image'],
                $data['id']
            );
            $participation->created_at = $data['created_at'];
            return $participation;
        }

        return null;
    }

    // Returns all participations for a specific challenge, newest first
    public static function getByChallenge(int $challenge_id): array
    {
        $connexion = connect_bd();

        $sql  = "SELECT * FROM submissions WHERE challenge_id = :challenge_id ORDER BY created_at DESC";
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':challenge_id', $challenge_id);
        $stmt->execute();

        $participations = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $participation = new Participation(
                $data['challenge_id'],
                $data['user_id'],
                $data['description'],
                $data['image'],
                $data['id']
            );
            $participation->created_at = $data['created_at'];
            $participations[] = $participation;
        }

        return $participations;
    }

    // Returns all participations made by a specific user
    public static function getByUser(int $user_id): array
    {
        $connexion = connect_bd();

        $sql  = "SELECT * FROM submissions WHERE user_id = :user_id ORDER BY created_at DESC";
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        $participations = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $participation = new Participation(
                $data['challenge_id'],
                $data['user_id'],
                $data['description'],
                $data['image'],
                $data['id']
            );
            $participation->created_at = $data['created_at'];
            $participations[] = $participation;
        }

        return $participations;
    }

    // Returns the top participations ranked by number of votes
    // We use LEFT JOIN so participations with 0 votes still show up
    // COUNT(v.id) counts how many vote rows match each submission
    public static function getRanking(int $limit = 10): array
    {
        $connexion = connect_bd();

        $sql = "SELECT s.*, COUNT(v.id) as vote_count 
                FROM submissions s 
                LEFT JOIN votes v ON s.id = v.submission_id 
                GROUP BY s.id 
                ORDER BY vote_count DESC 
                LIMIT :limit";
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT); // PDO_PARAM_INT needed for LIMIT
        $stmt->execute();

        $results = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $participation = new Participation(
                $data['challenge_id'],
                $data['user_id'],
                $data['description'],
                $data['image'],
                $data['id']
            );
            $participation->created_at = $data['created_at'];

            // we return both the object and the vote count so the view can display it
            $results[] = [
                'participation' => $participation,
                'vote_count'    => $data['vote_count']
            ];
        }

        return $results;
    }
}
?>
