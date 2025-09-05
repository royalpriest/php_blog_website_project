<?php
require_once 'database.php';

class Content {
    private $conn;
    private $table = 'content';

    // database constructor
    public function __construct($db) {
        $this->conn = $db;
    }

    //This is for the Creation of  new content
    public function create($user_id, $title, $body, $image = null) {
        $sql = "INSERT INTO {$this->table} (user_id, title, body, image) VALUES (:user_id, :title, :body, :image)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':user_id' => $user_id,
            ':title' => $title,
            ':body' => $body,
            ':image' => $image
        ]);
    }

    // This id to get single content by ID
    public function getById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // This is to get all content
    public function readAll() {
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update content - image is optional
    public function update($id, $title, $body, $image = null) {
        $params = [':title' => $title, ':body' => $body, ':id' => $id];
        $sql = "UPDATE {$this->table} SET title = :title, body = :body";
        if ($image !== null) {  // Only update image if provided
            $sql .= ", image = :image";
            $params[':image'] = $image;
        }
        $sql .= " WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params);
    }

    // Delete content by ID - returns true on success
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
?>