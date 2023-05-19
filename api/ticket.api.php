<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/ticket.class.php');

  $db = getDatabaseConnection();
  $active = $_GET['active'];
  $closed = $_GET['closed'];
  $recent = $_GET['recent'];
  $search = $_GET['search'];
  $tickets = Ticket::getClientTickets($db, $session->getId(),$search,$active,$closed,$recent);
  echo json_encode($tickets);
?>