<?php
if (file_exists(__DIR__ . '/configuration.php')) { require_once __DIR__ . '/configuration.php'; } elseif (file_exists(__DIR__ . '/../configuration.php')) { require_once __DIR__ . '/../configuration.php'; }

/**
 * Classe User - PHP OO
 * Respecte le principe d'hydratation du cours (Chapitre 3)
 * Contient toutes les fonctionnalités de gestion utilisateur :
 *   - Inscription (register)
 *   - Connexion (login)
 *   - Déconnexion (logout)
 *   - Gestion de session
 *   - Hashage sécurisé du mot de passe (password_hash)
 *   - Modification du profil (update)
 *   - Suppression de compte (delete)
 */
class User {

    /** Identification unique */
    protected $id;
    /** Nom de l'utilisateur */
    protected $name;
    /** Email de l'utilisateur */
    protected $email;
    /** Mot de passe (hashé en BD, brut à l'inscription) */
    protected $password;

   

    public function __construct(array $donnees = []) {
        $this->hydrate($donnees);
    }

    /**
     * HYDRATATION : pour chaque clé du tableau on cherche
     * le setter correspondant et on l'appelle automatiquement.
     * Ex : clé 'name' => appelle setName($value)
     */
    public function hydrate(array $donnees) {
        foreach ($donnees as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }
    
    //  SETTERS

    public function setId($id)             { $this->id       = (int)$id;     }
    public function setName($name)         { $this->name     = trim($name);  }
    public function setEmail($email)       { $this->email    = trim($email); }
    public function setPassword($password) { $this->password = $password;   }

    //  GETTERS

    public function getId()       { return $this->id;       }
    public function getName()     { return $this->name;     }
    public function getEmail()    { return $this->email;    }
    public function getPassword() { return $this->password; }

    
    //  A. INSCRIPTION
    //  - Hashe le mot de passe avec password_hash
    //  - Insere en BD
    //  - Retourne true si succes, false si email deja utilise
  
    public function register(): bool {
        $con = connect_bd();

        // Verifier si l'email existe deja
        $check = $con->prepare('SELECT id FROM users WHERE email = :email');
        $check->execute([':email' => $this->email]);
        if ($check->fetch()) {
            return false;
        }

        $q = $con->prepare(
            'INSERT INTO users (name, email, password)
             VALUES (:name, :email, :password)'
        );
        $q->bindValue(':name',     $this->name);
        $q->bindValue(':email',    $this->email);
        $q->bindValue(':password', password_hash($this->password, PASSWORD_DEFAULT));
        return $q->execute();
    }

  
    //  B. CONNEXION
    //  - Cherche l'utilisateur par email
    //  - Verifie le mot de passe avec password_verify
    //  - Cree la SESSION si correct
    //  - Retourne true si connexion reussie, false sinon
    
    public function login(string $email, string $password): bool {
        $con = connect_bd();

        $q = $con->prepare('SELECT * FROM users WHERE email = :email');
        $q->execute([':email' => $email]);
        $donnees = $q->fetch(PDO::FETCH_ASSOC);

        if ($donnees && password_verify($password, $donnees['password'])) {
            // GESTION DE SESSION
            $_SESSION['user_id']    = $donnees['id'];
            $_SESSION['user_name']  = $donnees['name'];
            $_SESSION['user_email'] = $donnees['email'];
            return true;
        }
        return false;
    }


    //  C. DECONNEXION
    //  - Detruit la session
    //  - Redirige vers la page de connexion

    public function logout(): void {
        session_destroy();
        header('Location: index.php?action=login');
        exit();
    }

 
    //  D. MODIFICATION DU PROFIL
    //  - Verifie le mot de passe actuel avant de modifier
    //  - Met a jour nom, email, et mot de passe si fourni
    //  - Met a jour la SESSION
    //  - Retourne true si succes, false si mot de passe incorrect

    public function update(array $data): bool {
        $con = connect_bd();

        // Recuperer le mot de passe actuel en BD
        $q = $con->prepare('SELECT password FROM users WHERE id = :id');
        $q->execute([':id' => $_SESSION['user_id']]);
        $row = $q->fetch(PDO::FETCH_ASSOC);

        // Verification du mot de passe actuel
        if (!$row || !password_verify($data['current_password'], $row['password'])) {
            return false;
        }

        // Nouveau mot de passe ? on le hashe, sinon on garde l'ancien
        $newHash = !empty($data['new_password'])
            ? password_hash($data['new_password'], PASSWORD_DEFAULT)
            : $row['password'];

        $q = $con->prepare(
            'UPDATE users
             SET name = :name, email = :email, password = :password
             WHERE id = :id'
        );
        $q->bindValue(':name',     $data['name']);
        $q->bindValue(':email',    $data['email']);
        $q->bindValue(':password', $newHash);
        $q->bindValue(':id',       $_SESSION['user_id']);

        if ($q->execute()) {
            // MISE A JOUR DE LA SESSION
            $_SESSION['user_name']  = $data['name'];
            $_SESSION['user_email'] = $data['email'];
            return true;
        }
        return false;
    }

    //  E. SUPPRESSION DE COMPTE
    //  - Supprime l'utilisateur de la BD
    //  - Detruit la session
    //  - Redirige vers l'inscription

    public function delete(): void {
        $con = connect_bd();

        $q = $con->prepare('DELETE FROM users WHERE id = :id');
        $q->bindValue(':id', $_SESSION['user_id']);
        $q->execute();

        session_destroy();
        header('Location: index.php?action=register');
        exit();
    }


    //  AFFICHAGE (cours page 5)

    public function afficheUser(): void {
        echo "Utilisateur n°" . $this->getId()
           . " : " . $this->getName()
           . " (" . $this->getEmail() . ")";
    }
}
?>
