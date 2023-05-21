<?php
declare(strict_types=1);

require_once __DIR__ . '/../utils/session.php';
require_once __DIR__ . '/../templates/common.tpl.php';
require_once __DIR__ . '/../database/connection.db.php';
require_once __DIR__ . '/../database/user.class.php';

$session = new Session();
$db = getDatabaseConnection();
$user_privilege = User::privilegeFromId($db, $session->getId());
if ($user_privilege != 'Admin') {
    header('Location: ../pages/main.php');
}
$clients = User::getClients($db);
$agents = User::getAgents($db);
$admins = User::getAdmins($db);
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
    <?php
    drawSideBar();
    if (User::privilegeFromId($db, $session->getId()) == 'Admin') {
        echo '<div class="sidebar_button">
            <button>
                <a href="../pages/users.php">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
              </svg>
              
                </a>
            </button>
            <p>Users</p></div>';
    }
    ?>
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
            <p class="box_header_title">Users</p>
        </div>
            <p class="users_title">Clients</p>
                <div class="user">
                    <div class="user-row">
                        <div>Id</div>
                        <div>Name</div>
                        <div>City</div>
                        <div>Country</div>
                        <div>Phone</div>
                        <div>Email</div>
                        <div>Privilege</div>
                        <div>Department</div>
                        <div></div>
                    </div>
                    <?php foreach ($clients as $client) {
                        echo '<div class="user-row">';
                        echo '<div>' . $client->id . '</div>';
                        echo '<div>' . $client->name() . '</div>';
                        echo '<div>' . $client->city . '</div>';
                        echo '<div>' . $client->country . '</div>';
                        echo '<div>' . $client->phone . '</div>';
                        echo '<div>' . $client->email . '</div>';
                        echo '<div>' . $client->privilege . '</div>';
                        echo '<div>' . $client->department . '</div>';
                        echo '<div id="promote">
        <form action="../actions/action_promote_client.php" method="post">
            <input type="hidden" name="id" value="' .
                            $client->id .
                            '">
            <button class="comment_send" type="submit">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l7.5-7.5 7.5 7.5m-15 6l7.5-7.5 7.5 7.5" />
                </svg>                      
            </button>
        </form>
    </div>';
                        echo '</div>';
                    } ?>
                </div>
                <p class="users_title">Agents</p>
                <div class="user">
                <div class="user-row">
                        <div>Id</div>
                        <div>Name</div>
                        <div>City</div>
                        <div>Country</div>
                        <div>Phone</div>
                        <div>Email</div>
                        <div>Privilege</div>
                        <div>Department</div>
                        <div></div>
                    </div>
                    <?php foreach ($agents as $agent) {
                        echo '<div class="user-row">';
                        echo '<div>' . $agent->id . '</div>';
                        echo '<div>' . $agent->name() . '</div>';
                        echo '<div>' . $agent->city . '</div>';
                        echo '<div>' . $agent->country . '</div>';
                        echo '<div>' . $agent->phone . '</div>';
                        echo '<div>' . $agent->email . '</div>';
                        echo '<div>' . $agent->privilege . '</div>';
                        echo '<div>' . $agent->department . '</div>';
                        echo '<div id="promote">
        <form action="../actions/action_promote_agent.php" method="post">
            <input type="hidden" name="id" value="' .
                            $agent->id .
                            '">
            <button class="comment_send" type="submit">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l7.5-7.5 7.5 7.5m-15 6l7.5-7.5 7.5 7.5" />
                </svg>                      
            </button>
        </form>
    </div>';
                        echo '</div>';
                    } ?>
                </div>
                <p class="users_title">Admins</p>
                <div class="user">
                    <div class="user-row">
                        <div>Id</div>
                        <div>Name</div>
                        <div>City</div>
                        <div>Country</div>
                        <div>Phone</div>
                        <div>Email</div>
                        <div>Privilege</div>
                        <div>Department</div>
                        <div></div>
                    </div>
                    <?php foreach ($admins as $admin) {
                        echo '<div class="user-row">';
                        echo '<div>' . $admin->id . '</div>';
                        echo '<div>' . $admin->name() . '</div>';
                        echo '<div>' . $admin->city . '</div>';
                        echo '<div>' . $admin->country . '</div>';
                        echo '<div>' . $admin->phone . '</div>';
                        echo '<div>' . $admin->email . '</div>';
                        echo '<div>' . $admin->privilege . '</div>';
                        echo '<div>' . $admin->department . '</div>';
                        echo '<div id="promote"></div>';
                        echo '</div>';
                    } ?>
                </div>
        </div>
</body>