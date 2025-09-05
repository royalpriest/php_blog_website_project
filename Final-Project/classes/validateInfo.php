<?php
class ValidateInfo
{
    // Check required fields
    public function checkEmpty($data, $fields)
    {
        $errors = [];
        foreach ($fields as $value) {
            if (empty($data[$value])) {
                $errors[] = "$value field is required";
            }
        }
        return $errors;
    }

    // This is to validate username format -
    public function validateName($name)
    {
        if (!preg_match("/^[a-zA-Z0-9_]{3,20}$/", $name)) {
            return "Name must be 3-20 characters and only contain letters, numbers, and underscores";
        }
        return null;
    }

    // This is to validate email format
    public function validateEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Invalid email format";
        }
        return null;
    }

    // Validate password length
    public function validatePassword($password)
    {
        if (strlen($password) < 8) {
            return "Password must be at least 8 characters";
        }
        return null;
    }

    // This is to check if email exists in database
    public function isEmailExists($email, PDO $pdo)
    {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }
}
?>