<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

if ($_SESSION['csrf'] !== $_POST['csrf']) {
    error_log('CSRF token verification failed for user ' . $_POST['email']);
} else {
    $session->logout();
    header('Location: ../pages');
}