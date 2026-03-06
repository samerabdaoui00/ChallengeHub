<?php
/**
 * ManagerUser - gère les opérations CRUD sur les Users
 * Respecte le pattern Manager enseigné dans le cours (Chapitre 3, page 11-12)
 * Un manager doit pouvoir : créer, modifier, supprimer, sélectionner (CRUD)
 */
class UserManager {

    private $con; // Instance de PDO (comme dans le cours page 12)

    // Le constructeur reçoit la connexion PDO
    public function __construct($con) {
        $this->setDb($con);
    }

    public function setDb(PDO $con) {
        $this->con = $con;
    }

    // ==================== CREATE ====================
    public function ajouter(User $user) {
        $q = $this->con->prepare(
            'INSERT INTO users (name, email, password) VALUES (:name, :email, :password)'
        );
        $q->bindValue(':name',     $user->getName());
        $q->bindValue(':email',    $user->getEmail());
        $q->bindValue(':password', password_hash($user->getPassword(), PASSWORD_DEFAULT));
        return $q->execute();
    }

    // ==================== READ (un seul par email) ====================
    public function getByEmail(string $email): ?User {
        $q = $this->con->prepare('SELECT * FROM users WHERE email = :email');
        $q->execute([':email' => $email]);
        $donnees = $q->fetch(PDO::FETCH_ASSOC);
        if ($donnees) {
            // Hydratation : on passe le tableau à l'objet User (cours page 7)
            return new User($donnees);
        }
        return null;
    }

    // ==================== READ (un seul par id) ====================
    public function getById(int $id): ?User {
        $q = $this->con->prepare('SELECT * FROM users WHERE id = :id');
        $q->execute([':id' => $id]);
        $donnees = $q->fetch(PDO::FETCH_ASSOC);
        if ($donnees) {
            return new User($donnees);
        }
        return null;
    }

    // ==================== UPDATE ====================
    public function modifier(User $user, string $currentPassword): bool {
        // Vérifier le mot de passe actuel
        $q = $this->con->prepare('SELECT password FROM users WHERE id = :id');
        $q->execute([':id' => $user->getId()]);
        $row = $q->fetch(PDO::FETCH_ASSOC);

        if (!$row || !password_verify($currentPassword, $row['password'])) {
            return false;
        }

        // Si nouveau mot de passe fourni, on le hashe, sinon on garde l'ancien
        $newHash = !empty($user->getPassword())
            ? password_hash($user->getPassword(), PASSWORD_DEFAULT)
            : $row['password'];

        $q = $this->con->prepare(
            'UPDATE users SET name = :name, email = :email, password = :password WHERE id = :id'
        );
        $q->bindValue(':name',     $user->getName());
        $q->bindValue(':email',    $user->getEmail());
        $q->bindValue(':password', $newHash);
        $q->bindValue(':id',       $user->getId());
        return $q->execute();
    }

    // ==================== DELETE ====================
    public function supprimer(int $id): bool {
        $q = $this->con->prepare('DELETE FROM users WHERE id = :id');
        $q->bindValue(':id', $id);
        return $q->execute();
    }
}
?>
