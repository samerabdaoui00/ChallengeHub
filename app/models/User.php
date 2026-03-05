<?php
require_once(__DIR__ . "/../../config/configuration.php");
class User
{
    private ?int $id = null;
    private string $name;
    private string $email;
    private string $password;
    private ?string $created_at = null;
    public function __construct(string $name = "", string $email = "", string $password = "")
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = !empty($password) ? password_hash($password, PASSWORD_DEFAULT) : "";
    }
    public function hydrate(array $data): void
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
    public function register(): bool 
    {
        $connexion = connect_bd();
        $sql = "INSERT INTO users (name, email, password) 
                VALUES (:name, :email, :password)" ;
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);
        return $stmt->execute();
    }
    public function login(string $email, string $password): bool
    {
        $connexion = connect_bd();
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        if ($stmt->rowCount() == 1) {
            $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $user_data['password'])) {
                $this->hydrate($user_data);
                $_SESSION['user_id'] = $this->id;
                $_SESSION['user_name'] = $this->name;
                $_SESSION['user_email'] = $this->email;
                return true;
            }
        }
        return false;
    }
    public function logout(): void
    {
        session_unset();
        session_destroy();
        header("Location: index.php?action=login");
        exit();
    }
    public function update(array $data): bool
    {
        $connexion = connect_bd();
        $sql = "SELECT password FROM users WHERE id = :id";
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':id', $_SESSION['user_id']);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!password_verify($data['current_password'], $user['password'])) {
            return false;
        }
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
            $this->logout();
            return true;
        }
        return false;
    }
}
