<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../database/ticket.class.php');

if ($_SESSION['csrf'] !== $_POST['csrf']) {
    error_log('CSRF token verification failed for user ' . $_POST['email']);
} else {
    $db = getDatabaseConnection();
    $available_agents = User::getDepartmentAgents($db,$_POST['department']);
    $available_admins = User::getAdmins($db);
    $admin = $available_admins[random_int(0,count($available_admins)-1)];
    $ticket = new Ticket(null,$session->getId(), $_POST['title'], $_POST['description'], date('Y-m-d H:i:s'),$available_agents[random_int(0,count($available_agents)-1)],$admin->id,'Active',$_POST['department']);
    $ticket->save($db);
    header('Location: ../pages');
}
?>