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
    $id = $session->getId();
    User::updateUserInfo($db,$id,$_POST['city'],$_POST['country'],$_POST['phone']);
    header('Location: ../pages');
}
?>