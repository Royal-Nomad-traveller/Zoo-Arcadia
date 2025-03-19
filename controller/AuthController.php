<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>


<?php
session_start();
require_once '../model/User.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $userModel = new User();
    $user = $userModel->getUserByEmail($email);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] === 'admin') {
            header("Location: ../view/admin.php");
        } else {
            header("Location: ../view/dashboard.php");
        }
        exit();
    } else {
        $_SESSION['error'] = "Email ou mot de passe incorrect";
        echo "mot de passe";
        header("Location: ../index.php");
        exit();
    }
}
?>
