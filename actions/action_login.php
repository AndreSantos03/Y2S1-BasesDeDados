<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/user.class.php');

if ($_SESSION['csrf'] !== $_POST['csrf']) {
    error_log('CSRF token verification failed for user ' . $_POST['email']);
} else {
    $db = getDatabaseConnection();

    $user = User::getUserWithPassword($db, $_POST['email'], $_POST['password']);

    if ($user) {
        $session->setId($user->id);
        $session->setName($user->name());
        $session->addMessage('success', 'Login successful!');
    } else {
        $session->addMessage('error', 'Wrong password!');
    }

    header('Location: ' . $_SERVER['HTTP_REFERER']);
} // This needs to be changed, to go to the home page
?>