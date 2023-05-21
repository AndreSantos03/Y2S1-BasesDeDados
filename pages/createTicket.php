<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../templates/common.tpl.php');

$session = new Session();

?>
<!DOCTYPE html>
<html>

<head>
    <title>Helpline</title>
    <link rel="stylesheet" href="/../css/style2.css">
    <link rel="icon" type="image/x-icon" href="../assets/icon.ico">
</head>

<body>
    <div class="sidebar">
        <?php drawSideBar(); ?>
        <div class="sidebar_button">
            <button>
                <a href="../pages/main.php">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11.25 9l-3 3m0 0l3 3m-3-3h7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </a>
            </button>
            <p>Return</p>
        </div>
    </div>
    <div class="main_box">
        <div class="box_header_create">
            <p class="box_header_title">Create Ticket</p>
        </div>
        <form id="form_create_ticket"action="../actions/action_create_ticket.php" method="POST">
            <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
            <input id="create_ticket_title" type="text" name="title" placeholder="Enter the title" required>
            <select name="department">
                <option value="Accounting">Accounting</option>
                <option value="Human Resources">Human Resources</option>
                <option value="Marketing">Marketing</option>
                <option value="Development">Development</option>
                <option value="Quality Control">Quality Control</option>
            </select>
            <textarea type="text" id="create_ticket_desc" name="description" placeholder="Enter the description" required></textarea>
            <div class="btnSubmit">
                    <button type="submit" id="login_btnSubmit">CREATE</button>
                </div>
        </form>
    </div>
</body>