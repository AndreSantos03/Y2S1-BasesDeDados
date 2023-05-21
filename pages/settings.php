<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/user.class.php');

$session = new Session();
$db = getDatabaseConnection();
$user = User::getUser($db,$session->getId());

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
        <div class="box_header_ticket">
            <p class="box_header_title">Settings</p>
        </div>
            <form action="../actions/action_updateInfo.php" method="POST">
                <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
                <div class="op_box">
                    <p>First Name</p>
                    <output id="firstName" name="firstName"><?= $user->firstName ?></output>
                </div>
                <div class="op_box">
                    <p>Last Name</p>
                    <output id="lastName" name="lastName"><?= $user->lastName ?></output>
                </div>
                <div class="op_box">
                    <p>Country</p>
                    <input type="text" id="country" name="country" placeholder="<?= $user->country ?>">
                </div>
                <div class="op_box">
                    <p>City</p>
                    <input type="text" id="city" name="city" placeholder="<?= $user->city ?>">
                </div>
                <div class="op_box">
                    <p>Phone</p>
                    <input type="text" id="phone" name="phone" placeholder="<?= $user->phone ?>">
                </div>
                <div class="op_box">
                    <p>Email</p>
                    <output id="email" name="email"><?= $user->email ?></output>
                </div>
                <?php
                if ($user->privilege == "Agent" || $user->privilege == "Admin") {
                    echo "<div class='op_box'>";
                    echo "<p>Department</p>";
                    echo             '<select name="department" id="select_settings">
                    <option value="" disabled selected>' . $user->department .'</option>
                    <option value="Accounting">Accounting</option>
                    <option value="Human Resources">Human Resources</option>
                    <option value="Marketing">Marketing</option>
                    <option value="Development">Development</option>
                    <option value="Quality Control">Quality Control</option>
                </select>';
                    echo "</div>";
                }
                ?>
                <div class="save_button_settings">
                    <div class="btnSubmit">
                        <button type="submit" id="login_btnSubmit">SAVE</button>
                    </div>
                </div>
            </form>
    </div>
</body>