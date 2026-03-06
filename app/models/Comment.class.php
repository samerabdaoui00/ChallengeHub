<?php
require_once(__DIR__ . "/../../config/configuration.php");

// This class handles comments left on participations (submissions)
// A comment belongs to one submission and one user
class Comment
{
    private ?int    $id            = null; // null until saved in DB
    private int     $submission_id;        // which participation this comment is on
    private int     $user_id;              // who wrote the comment
    private string  $content;              // the actual comment text
    private ?string $created_at = null;    // set by MySQL automatically

    public function __construct(int $submission_id, int $user_id, string $content, ?int $id = null)
    {
        $this->id            = $id;
        $this->submission_id = $submission_id;
        $this->user_id       = $user_id;
        $this->content       = $content;
    }

    // --- Getters ---
    public function getId(): ?int          { return $this->id; }
    public function getSubmissionId(): int { return $this->submission_id; }
    public function getUserId(): int       { return $this->user_id; }
    public function getContent(): string   { return $this->content; }
    public function getCreatedAt(): ?string { return $this->created_at; }

    // Inserts the comment into the database
    public function create(): bool
    {
        $connexion = connect_bd();

        $sql = "INSERT INTO comments (submission_id, user_id, content) 
                VALUES (:submission_id, :user_id, :content)";
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':submission_id', $this->submission_id);
        $stmt->bindParam(':user_id',       $this->user_id);
        $stmt->bindParam(':content',       $this->content);

        if ($stmt->execute()) {
            $this->id = $connexion->lastInsertId();
            return true;
        }

        return false;
    }

    // Deletes this comment from the database
    public function delete(): bool
    {
        $connexion = connect_bd();

        $sql  = "DELETE FROM comments WHERE id = :id";
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }

    // Returns all comments for a given submission, newest first
    public static function getBySubmission(int $submission_id): array
    {
        $connexion = connect_bd();

        $sql  = "SELECT * FROM comments WHERE submission_id = :submission_id ORDER BY created_at DESC";
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':submission_id', $submission_id);
        $stmt->execute();

        $comments = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $comment = new Comment($data['submission_id'], $data['user_id'], $data['content'], $data['id']);
            $comment->created_at = $data['created_at'];
            $comments[] = $comment;
        }

        return $comments;
    }

    // Gets one comment by its ID — used mainly to check ownership before deleting
    public static function getById(int $id): ?Comment
    {
        $connexion = connect_bd();

        $sql  = "SELECT * FROM comments WHERE id = :id";
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        if ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $comment = new Comment($data['submission_id'], $data['user_id'], $data['content'], $data['id']);
            $comment->created_at = $data['created_at'];
            return $comment;
        }

        return null; // comment not found
    }
}
?>
