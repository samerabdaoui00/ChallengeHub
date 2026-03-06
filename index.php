<?php
session_start();

// Cherche la classe dans Model/ ou dans le meme dossier
function chargerClasse($classname) {
    $model = __DIR__ . '/Model/' . $classname . '.class.php';
    $flat  = __DIR__ . '/' . $classname . '.class.php';
    if (file_exists($model)) {
        require $model;
    } elseif (file_exists($flat)) {
        require $flat;
    }
}
spl_autoload_register('chargerClasse');

// configuration.php aussi cherche dans Model/ ou meme dossier
if (file_exists(__DIR__ . '/Model/configuration.php')) {
    require_once __DIR__ . '/Model/configuration.php';
} else {
    require_once __DIR__ . '/configuration.php';
}

$action = isset($_GET['action']) ? $_GET['action'] : 'home';


if ($action === 'register' && isset($_POST['name'], $_POST['email'], $_POST['password'])) {
    $user = new User([
        'name'     => $_POST['name'],
        'email'    => $_POST['email'],
        'password' => $_POST['password']
    ]);
    if ($user->register()) {
        header('Location: index.php?action=login&success=1');
        exit();
    } else {
        $erreur = "Email deja utilise ou erreur d'inscription";
    }
}


if ($action === 'login' && isset($_POST['email'], $_POST['password'])) {
    $user = new User([]);
    if ($user->login($_POST['email'], $_POST['password'])) {
        header('Location: index.php?action=profil');
        exit();
    } else {
        $erreur = "Email ou mot de passe incorrect";
    }
}

// ==================== UPDATE PROFIL ====================
if ($action === 'profil' && isset($_POST['update'])) {
    if (!isset($_SESSION['user_id'])) { header('Location: index.php?action=login'); exit(); }
    $user = new User([]);
    if ($user->update($_POST)) {
        $success = "Profil mis a jour !";
    } else {
        $erreur = "Mot de passe actuel incorrect";
    }
}

// ==================== DELETE COMPTE ====================
if ($action === 'profil' && isset($_POST['delete'])) {
    if (!isset($_SESSION['user_id'])) { header('Location: index.php?action=login'); exit(); }
    $user = new User([]);
    $user->delete();
}

// ==================== LOGOUT ====================
if ($action === 'logout') {
    $user = new User([]);
    $user->logout();
}

// ==================== PROTECTION PROFIL ====================
if ($action === 'profil' && !isset($_SESSION['user_id'])) {
    header('Location: index.php?action=login');
    exit();
}

// ==================== CHARGEMENT VUE ====================
// Cherche la vue dans View/ ou dans le meme dossier
$vue = __DIR__ . '/View/' . $action . '.php';
if (!file_exists($vue)) {
    $vue = __DIR__ . '/' . $action . '.php';
}
require $vue;
?>
