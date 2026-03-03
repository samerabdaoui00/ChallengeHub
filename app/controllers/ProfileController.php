<?php
session_start();
require_once(__DIR__ . "/../models/User.php");
if(!isset($_SESSION['user_id'])){
    header("Location: index.php?action=login");
    exit();
}
$user = new User("", "", "");
$message = "";
if(isset($_POST['update'])){
    if($user->update($_POST)){
        $message = "Profil mis à jour ✅";
        $_SESSION['user_name'] = $_POST['name'];
        $_SESSION['user_email'] = $_POST['email'];
    } else {
        $message = "Erreur lors de la mise à jour ❌";
    }
}
if(isset($_POST['delete'])){
    $user->delete();
    exit();
}
if(isset($_POST['logout'])){
    $user->logout();
    exit();
}
require_once(__DIR__ . "/../views/user/profile.php");