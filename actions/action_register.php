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
    $user = new User(null, $_POST['firstName'], $_POST['lastName'], null, null, null, $_POST['email'], 'client', null);
    $user->save($db, $_POST['password']);
    header('Location: ../pages');
}
?>