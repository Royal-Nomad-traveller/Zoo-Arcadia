<?php
session_start();
require_once '../model/User.php';
require_once '../model/Employes.php'; // Ajout du modèle pour les employés

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $userModel = new User();
    $user = $userModel->getUserByEmail($email);

    // Vérifier si c'est un admin
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] === 'admin') {
            header("Location: ../view/admin.php");
        } else {
            header("Location: ../view/dashboard.php");
        }
        exit();
    }

    // Vérifier si c'est un employé ou vétérinaire
    $employeeModel = new Employee();
    $employee = $employeeModel->getEmployeeByEmail($email);

    if ($employee && password_verify($password, $employee['password'])) {
        $_SESSION['user_id'] = $employee['id'];
        $_SESSION['employe_id'] = $employee['id'];
        $_SESSION['role'] = $employee['role'];
        $_SESSION['prenom'] = $employee['prenom'];
        $_SESSION['nom'] = $employee['nom'];

        if ($employee['role'] === 'vétérinaire') {
            header("Location: ../view/veterinaire.php");
        } else {
            header("Location: ../view/employer.php");
        }
        exit();
    }

    // Si l'authentification échoue
    $_SESSION['error'] = "Email ou mot de passe incorrect";
    header("Location: ../index.php");
    exit();
}


