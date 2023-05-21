<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/user.class.php');

$session = new Session();
$db = getDatabaseConnection();
$user_privilege = User::privilegeFromId($db, $session->getId());
if($user_privilege != 'Admin'){
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
            <p class="box_header_title">Users</p>
        </div>
        <div class="users">
            <div class="clients">
                <p class="users_title">Clients</p>
                <div class="user">
                        <div>Id</div>
                        <div>Name</div>
                        <div>City</div>
                        <div>Country</div>
                        <div>Phone</div>
                        <div>Email</div>
                        <div>Privilege</div>
                        <div>Department</div>

                    <?php foreach ($clients as $client) {
                        echo '<div>' . $client->id . '</div>';
                        echo '<div>' . $client->name() . '</div>';
                        echo '<div>' . $client->city . '</div>';
                        echo '<div>' . $client->country . '</div>';
                        echo '<div>' . $client->phone . '</div>';
                        echo '<div>' . $client->email . '</div>';
                        echo '<div>' . $client->privilege . '</div>';
                        echo '<div>' . $client->department . '</div>';
                        echo '<div id="promote"><button class="comment_send" type="submit">
        <a href="../actions/action_promote_client.php?id=' . $client->id . '">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l7.5-7.5 7.5 7.5m-15 6l7.5-7.5 7.5 7.5" />
            </svg>                      
        </a>
    </button></div>';

                        }?>
                </div>
            </div>
            <div class="agents">
                <p class="users_title">Agents</p>
                <div class="user">
                        <div>Id</div>
                        <div>Name</div>
                        <div>City</div>
                        <div>Country</div>
                        <div>Phone</div>
                        <div>Email</div>
                        <div>Privilege</div>
                        <div>Department</div>
                    <?php foreach ($agents as $agent) {
                            echo '<div>' . $agent->id . '</div>';
                            echo '<div>' . $agent->name() . '</div>';
                            echo '<div>' . $agent->city . '</div>';
                            echo '<div>' . $agent->country . '</div>';
                            echo '<div>' . $agent->phone . '</div>';
                            echo '<div>' . $agent->email . '</div>';
                            echo '<div>' . $agent->privilege . '</div>';
                            echo '<div>' . $agent->department . '</div>';
                            echo '<div id="promote"><button class="comment_send" type="submit">
        <a href="../actions/action_promote_agent.php?id=' . $agent->id .'">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l7.5-7.5 7.5 7.5m-15 6l7.5-7.5 7.5 7.5" />
            </svg>                      
        </a>
    </button></div>';

                        }?>
                </div>
            </div>
            <div class="admins">
                <p class="users_title">Admins</p>
                <div class="user">
                        <div>Id</div>
                        <div>Name</div>
                        <div>City</div>
                        <div>Country</div>
                        <div>Phone</div>
                        <div>Email</div>
                        <div>Privilege</div>
                        <div>Department</div>
                    <?php foreach ($admins as $admin) {
                        echo '<div>' . $admin->id . '</div>';
                        echo '<div>' . $admin->name() . '</div>';
                        echo '<div>' . $admin->city . '</div>';
                        echo '<div>' . $admin->country . '</div>';
                        echo '<div>' . $admin->phone . '</div>';
                        echo '<div>' . $admin->email . '</div>';
                        echo '<div>' . $admin->privilege . '</div>';
                        echo '<div>' . $admin->department . '</div>';
                        echo '<div id="promote"></div>';
                        }?>
                </div>
            </div>
        </div>
    </div>
</body>