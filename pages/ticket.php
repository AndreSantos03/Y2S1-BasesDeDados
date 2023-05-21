<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');

  require_once(__DIR__ . '/../database/ticket.class.php');
  require_once(__DIR__ . '/../database/user.class.php');
  require_once(__DIR__ . '/../database/comment.class.php');

  require_once(__DIR__ . '/../templates/common.tpl.php');

  $db = getDatabaseConnection();

  $ticket = Ticket::getTicket($db, $_GET['id']);
  $comments = Comment::GetComments($db, $_GET['id']);
  $client_name = User::nameFromId($db, $ticket->client_id);
  $user
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
        <div class="main_box_ticket">
            <div class="box_header_ticket">
                <div class="ticket_status">
                    <?php
                        if(User::privilegeFromId($db,$session->getId())=="Agent" || User::privilegeFromId($db,$session->getId())=="Admin"){
                            if($ticket->status == "Active"){
                                echo '<form action="../actions/action_close_ticket.php" method="POST">' .
                                '<input type="hidden" name="ticket_id" value="' . $_GET['id'] . '">' .
                                '<input type="hidden" name="csrf" value="' . $_SESSION['csrf'] . '"><button class="ticket_status_button" type="submit">Active</button></form>';
                            } else {
                                echo '<form action="../actions/action_open_ticket.php" method="POST">' .
                                '<input type="hidden" name="ticket_id" value="' . $_GET['id'] . '">' .
                                '<input type="hidden" name="csrf" value="' . $_SESSION['csrf'] . '"><button class="ticket_status_button" type="submit">Closed</button></form>';
                            }
                        } else {
                            echo '<p>' . $ticket->status . '</p>';
                        }
                    ?>
                    </div>
                <div class="ticket_title">
                    <p><?=$ticket->title?></p>
                </div>
                <div class="ticket_info">
                    <p>Asked by <?=$client_name?>, <?=$ticket->datetime?></p>
                </div>
            </div>
            <div class="ticket_desc_page">
                <p><?=$ticket->desc?></p>
                <p class="ticket_comments_title">Comments</p>
                <div class="ticket_comment">
                    <?php 
                        if(count($comments) == 0){
                            echo '<div class="comments_empty"><img src="../assets/homepage.png"><p>No comments yet...</p></div>';
                        }
                        foreach($comments as $comment) {
                            $sender_name = User::nameFromId($db, $comment->sender_id);
                            $sender_privilege = User::privilegeFromId($db, $comment->sender_id);
                            if($sender_privilege == 'Admin' || $sender_privilege == 'Agent'){
                                echo '<div class="ticket_comment_author"><p>' . $sender_name . '</p><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                <path fill-rule="evenodd" d="M9.661 2.237a.531.531 0 01.678 0 11.947 11.947 0 007.078 2.749.5.5 0 01.479.425c.069.52.104 1.05.104 1.59 0 5.162-3.26 9.563-7.834 11.256a.48.48 0 01-.332 0C5.26 16.564 2 12.163 2 7c0-.538.035-1.069.104-1.589a.5.5 0 01.48-.425 11.947 11.947 0 007.077-2.75zm4.196 5.954a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                </svg></div>';
                                echo '<p class="ticket_comment_content">' . $comment->message . '</p>';
                            } else {
                                echo '<div class="ticket_comment_author"><p>' . $sender_name . '</p></div>';
                                echo '<p class="ticket_comment_content">' . $comment->message . '</p>';
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
        <?php
        if ($ticket->status == 'Active') {
            echo '
            <div class="ticket_comment_box">
                <form action="../actions/action_sendcomment.php" method="POST">
                    <input type="hidden" name="csrf" value="' . $_SESSION['csrf'] . '">
                    <input type="hidden" name="ticket_id" value="' . $_GET['id'] . '">
                    <input id="comment" name="comment" placeholder="Make a comment"></input>
                    <button class="comment_send" type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                        </svg>
                    </button>
                </form>
            </div>';
        }else if($ticket->status == 'Closed'){
            echo '
            <div class="ticket_comment_box">
                <form action="../actions/action_sendcomment.php" method="POST">
                    <input type="hidden" name="csrf" value="' . $_SESSION['csrf'] . '">
                    <input type="hidden" name="ticket_id" value="' . $_GET['id'] . '">
                    <input id="comment" name="comment" placeholder="Can\'t make a comment" disabled></input>
                    <button class="comment_send" type="submit" disabled>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                        </svg>
                    </button>
                </form>
            </div>';
        }
        ?>
    </div>
</body>