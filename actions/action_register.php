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

    $stmt = $db->prepare('
    INSERT INTO User (FirstName, LastName, Email,Password,Privilege) VALUES (?,?,?,?,"client");
');

    $stmt->execute(array($_POST['firstName'], $_POST['lastName'], $_POST['email'], password_hash($_POST['password'], PASSWORD_DEFAULT)));


    header('Location: ../pages');
}
?>