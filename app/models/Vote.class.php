<?php
require_once(__DIR__ . "/../../config/configuration.php");

// This class handles votes on participations
// The vote system works like a toggle: click once to vote, click again to remove it
// The DB has a unique constraint on (submission_id, user_id) so one user = one vote per submission
class Vote
{
    private ?int    $id            = null;
    private int     $submission_id; // which participation was voted on
    private int     $user_id;       // who voted
    private ?string $created_at = null;

    public function __construct(int $submission_id, int $user_id, ?int $id = null)
    {
        $this->id            = $id;
        $this->submission_id = $submission_id;
        $this->user_id       = $user_id;
    }

    // --- Getters ---
    public function getId(): ?int           { return $this->id; }
    public function getSubmissionId(): int  { return $this->submission_id; }
    public function getUserId(): int        { return $this->user_id; }
    public function getCreatedAt(): ?string { return $this->created_at; }

    // Saves the vote to the database
    // If the user already voted (duplicate), PDO throws an exception — we catch it and return false
    public function create(): bool
    {
        $connexion = connect_bd();

        $sql = "INSERT INTO votes (submission_id, user_id) VALUES (:submission_id, :user_id)";
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':submission_id', $this->submission_id);
        $stmt->bindParam(':user_id',       $this->user_id);

        try {
            if ($stmt->execute()) {
                $this->id = $connexion->lastInsertId();
                return true;
            }
        } catch (PDOException $e) {
            // this happens if the user already voted (unique constraint)
            return false;
        }

        return false;
    }

    // Removes the vote from the database (un-vote)
    // We target the vote by both submission_id and user_id, not just id
    public function delete(): bool
    {
        $connexion = connect_bd();

        $sql = "DELETE FROM votes WHERE submission_id = :submission_id AND user_id = :user_id";
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':submission_id', $this->submission_id);
        $stmt->bindParam(':user_id',       $this->user_id);

        return $stmt->execute();
    }

    // Counts how many votes a submission has received
    public static function countBySubmission(int $submission_id): int
    {
        $connexion = connect_bd();

        $sql  = "SELECT COUNT(*) FROM votes WHERE submission_id = :submission_id";
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':submission_id', $submission_id);
        $stmt->execute();

        return (int)$stmt->fetchColumn();
    }

    // Checks if a user has already voted for a submission
    // Used to decide whether to show "Vote" or "Remove vote" button
    // SELECT 1 is faster than SELECT * when we only need to check existence
    public static function hasVoted(int $submission_id, int $user_id): bool
    {
        $connexion = connect_bd();

        $sql  = "SELECT 1 FROM votes WHERE submission_id = :submission_id AND user_id = :user_id";
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':submission_id', $submission_id);
        $stmt->bindParam(':user_id',       $user_id);
        $stmt->execute();

        return $stmt->fetch() !== false;
    }
}
?>
