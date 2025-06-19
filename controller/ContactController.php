<?php
require_once __DIR__ . '/../config/Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $title = $_POST['title'] ?? '';
    $message = $_POST['message'] ?? '';

    if (!empty($email) && !empty($title) && !empty($message)) {
        // ✅ Obtenir l'instance PDO depuis la classe Database
        $pdo = Database::getInstance()->getConnection();

        $stmt = $pdo->prepare("INSERT INTO contacts (email, title, message) VALUES (?, ?, ?)");
        $stmt->execute([$email, $title, $message]);

        header("Location: /../index.php?success=1");
        exit();
    } else {
        header("Location: /../index.php?error=1");
        exit();
    }
}
