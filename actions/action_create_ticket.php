<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/ticket.class.php');

if ($_SESSION['csrf'] !== $_POST['csrf']) {
    error_log('CSRF token verification failed for user ' . $_POST['email']);
} else {
    $db = getDatabaseConnection();
    $ticket = new Ticket(null,$session->getId(), $_POST['title'], $_POST['description'], date('Y-m-d H:i:s'),1,null,'Active',$_POST['department']);
    $ticket->save($db);
    header('Location: ../pages');
}
?>