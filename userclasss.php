<?php
//once pour pour éviter des redéfinitions de classes requirepourque le code ne contunue pas si il y a pas de connection
require_once("configuration.php");
class User
{
    private string $name;
    private string $email;
    private string $password; 

    public function __construct($name,$email,$password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }
    

    public function register(): bool 
    {
        //On récupère la connexion à la base de données définie dans configuration.php
        $connexion = connect_bd();

        // Requête SQL simple
        $sql = "INSERT INTO users (name, email, password) 
                VALUES (:name, :email, :password)" ;

        //Ici, la requête est envoyée au serveur sans les données.
        $stmt = $connexion->prepare($sql);

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);

        //verifier si la requête a réussi
        //return mysqli_query($conn, $sql);
        return $stmt->execute();
    }

    public function login(string $email, string $password): bool
    {
        $connexion = connect_bd();

        // Requête préparée
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $connexion->prepare($sql);

        // Lier le paramètre remplace :email par la valeur de $email que l’utilisateur a entrée
        $stmt->bindParam(':email', $email);

        // Exécuter
        $stmt->execute();

        // Vérifier si l'utilisateur existe
        if ($stmt->rowCount() == 1) {
            //récupère les informations de l’utilisateur sous forme de tableau associatif
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Vérifier le mot de passe avec le hash stocké
            if (password_verify($password, $user['password'])) {
                //garder des informations sur l’utilisateur même s’il change de page.
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                return true;
            }
        }

        return false;
    }

    public function logout(): void
    {
        session_start();      // démarrer la session
        session_unset();      // vider toutes les variables de session
        session_destroy();    // détruire la session
        header("Location: connect.html"); // rediriger vers la page de connexion
        exit();
    }
    

    public function update(array $data): bool
    {
        $connexion = connect_bd();

        // On récupère le hash actuel de l'utilisateur
        $sql = "SELECT password FROM users WHERE id = :id";
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':id', $_SESSION['user_id']);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifier le mot de passe actuel
        if (!password_verify($data['current_password'], $user['password'])) {
            return false; // mot de passe incorrect
        }

        // Mise à jour (name, email, password)
        $sql = "UPDATE users SET name = :name, email = :email";
        if(!empty($data['password'])) {
            $sql .= ", password = :password";
        }
        $sql .= " WHERE id = :id";

        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':id', $_SESSION['user_id']);

        if(!empty($data['password'])){
            $hashed = password_hash($data['password'], PASSWORD_DEFAULT);
            $stmt->bindParam(':password', $hashed);
        }

        return $stmt->execute();
    }

        public function delete(): bool
        {
            $connexion = connect_bd();

            $sql = "DELETE FROM users WHERE id = :id";
            $stmt = $connexion->prepare($sql);
            $stmt->bindParam(':id', $_SESSION['user_id']);

            if($stmt->execute()){
                // Supprimer la session après suppression du compte
                $this->logout();
                return true;
            }

            return false;
        }
    

    /*public function getById(int $id): ?User 
    {
        // Logique de récupération par ID
        //Si l’utilisateur existe → on retourne un objet User
        //mafhemtech kifech taawen hatanha
    }

    /* @return User[] 
    public function getAll(): array 
    {
        // Logique de récupération de tous les utilisateurs
        //naarech alech
    }*/
}
?>