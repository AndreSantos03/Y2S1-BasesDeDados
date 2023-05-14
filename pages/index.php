<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

if ($session->isLoggedIn()) {
    header('Location: ../pages/main.php');
}
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/user.tpl.php');
?>

<!DOCTYPE html>
<html>

<head>
    <title>Helpline</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="stylesheet" href="/../css/styles.css">
</head>

<body>
    <?php drawIndex(); ?>
    <?php drawLoginForm(); ?>
</body>