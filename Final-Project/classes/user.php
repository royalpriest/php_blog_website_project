<?php
require_once 'database.php';

class User {
    private $conn;
    private $table = 'usersInfo';  // Database table name

    // Initialize with database connection
    public function __construct($db) {
        $this->conn = $db;
    }

    // This is to check if user exists by name or email
    public function exists($name, $email = null) {
        $sql = "SELECT id FROM {$this->table} WHERE name = :name";
        $params = [':name' => $name];
        if ($email) {  // Optional email check
            $sql .= " OR email = :email";
            $params[':email'] = $email;
        }
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    // This is to register a new user
    public function register($name, $email, $password, $profile_picture = null) {
        if ($this->exists($name, $email)) return false;  // Check if user exists
        $hash = hash("sha512", $password);  // Hash password
        $sql = "INSERT INTO {$this->table} (name, email, password, profile_picture) VALUES (:name, :email, :password, :profile_picture)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':password' => $hash,
            ':profile_picture' => $profile_picture
        ]);
    }

    // This is for users login
    public function login($email, $password) {
        $hash = hash("sha512", $password);  // Hash provided password
        $sql = "SELECT * FROM {$this->table} WHERE email = :email AND password = :password";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':email' => $email, ':password' => $hash]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get all users
    public function readAll() {
        try {
            $sql = "SELECT id, name, email, profile_picture, created_at FROM {$this->table}";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    // Update user info - password and profile pic optional
    public function update($id, $name, $email, $password = null, $profile_picture = null) {
        $params = [':name' => $name, ':email' => $email, ':id' => $id];
        $sql = "UPDATE {$this->table} SET name = :name, email = :email";
        if ($password !== null) {  // Only update password if provided
            $sql .= ", password = :password";
            $params[':password'] = hash("sha512", $password);
        }
        if ($profile_picture !== null) {  // Only update image if provided
            $sql .= ", profile_picture = :profile_picture";
            $params[':profile_picture'] = $profile_picture;
        }
        $sql .= " WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params);
    }

    // Delete user by ID
    public function delete($id) {
        try {
            $sql = "DELETE FROM {$this->table} WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch(PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    // Get single user by ID
    public function getById($id) {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
?>