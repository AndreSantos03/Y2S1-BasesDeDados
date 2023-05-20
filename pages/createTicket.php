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
    <div class = "big_box">
        <form action="/../actions/action_login.php" method="post">
            <div class="titleBox">
                <input type="text" name="title" id="title" placeholder="Enter Title">
            </div>
            <div>
                <input type="text" name="description" id="description">
            </div>
        </form>
    </div>
</body>