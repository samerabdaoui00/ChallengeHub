<?php
// We need the database connection function from config
require_once(__DIR__ . "/../../config/configuration.php");

// This class handles everything related to a user account
// register, login, logout, update profile, delete account
class User
{
    private string $name;
    private string $email;
    private string $password; // we never store the plain password, always hashed

    // When we create a User object we hash the password right away
    // BUT if the value passed is a numeric ID (like from session), we skip hashing
    // otherwise it would break things when loading a user from session
    public function __construct($name, $email, $password)
    {
        $this->name  = $name;
        $this->email = $email;

        if (!empty($password) && !is_numeric($password)) {
            $this->password = password_hash($password, PASSWORD_DEFAULT);
        } else {
            $this->password = '';
        }
    }

    // Inserts the new user into the database
    // Throws an exception if the email is already taken (MySQL error code 23000)
    public function register(): bool
    {
        $connexion = connect_bd();

        $sql = "INSERT INTO users (name, email, password) 
                VALUES (:name, :email, :password)";
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':name',     $this->name);
        $stmt->bindParam(':email',    $this->email);
        $stmt->bindParam(':password', $this->password);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            // code 23000 means unique constraint failed = email already exists
            if ($e->getCode() === '23000') {
                throw new Exception("This email is already used. Please choose another one.");
            }
            throw $e;
        }
    }

    // Checks email + password and starts a session if correct
    // We use password_verify() because the password in DB is hashed
    public function login(string $email, string $password): bool
    {
        $connexion = connect_bd();

        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // compare the plain password with the hash stored in DB
            if (password_verify($password, $user['password'])) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                // save useful info in session so we can access it anywhere
                $_SESSION['user_id']    = $user['id'];
                $_SESSION['user_name']  = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                return true;
            }
        }

        return false; // wrong email or password
    }

    // Destroys the session and redirects to login page
    public function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();

        header("Location: index.php?action=login");
        exit();
    }

    // Updates the user's name, email and optionally their password
    // We first verify the current password before allowing any change
    public function update(array $data): bool
    {
        $connexion = connect_bd();

        // get the current hashed password from DB to verify it
        $sql  = "SELECT password FROM users WHERE id = :id";
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':id', $_SESSION['user_id']);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // if the current password is wrong, we stop here
        if (!password_verify($data['current_password'], $user['password'])) {
            return false;
        }

        // build the query dynamically — only update password if a new one was provided
        $sql = "UPDATE users SET name = :name, email = :email";
        if (!empty($data['password'])) {
            $sql .= ", password = :password";
        }
        $sql .= " WHERE id = :id";

        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':name',  $data['name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':id',    $_SESSION['user_id']);

        if (!empty($data['password'])) {
            $hashed = password_hash($data['password'], PASSWORD_DEFAULT);
            $stmt->bindParam(':password', $hashed);
        }

        return $stmt->execute();
    }

    // Deletes the account from DB then logs the user out automatically
    public function delete(): bool
    {
        $connexion = connect_bd();

        $sql  = "DELETE FROM users WHERE id = :id";
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':id', $_SESSION['user_id']);

        if ($stmt->execute()) {
            $this->logout(); // session cleanup after delete
            return true;
        }

        return false;
    }
}
?>
