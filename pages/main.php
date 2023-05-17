<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../templates/common.tpl.php');

$session = new Session();

if (!$session->isLoggedIn()) {
    header('Location: ../pages');
}
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
    </div>
    <div class="main_box">
        <div class="box_header">
            <div class="box_title">
                <p id="tickets">Tickets</p>
            </div>
            <div class="search_box">
                <img src="../assets/search.png" alt="search">
                <input type="text" class="input" placeholder="Search...">
            </div>
            <div class="sort">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                    <path fill-rule="evenodd"
                        d="M2 3.75A.75.75 0 012.75 3h11.5a.75.75 0 010 1.5H2.75A.75.75 0 012 3.75zM2 7.5a.75.75 0 01.75-.75h7.508a.75.75 0 010 1.5H2.75A.75.75 0 012 7.5zM14 7a.75.75 0 01.75.75v6.59l1.95-2.1a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 111.1-1.02l1.95 2.1V7.75A.75.75 0 0114 7zM2 11.25a.75.75 0 01.75-.75h4.562a.75.75 0 010 1.5H2.75a.75.75 0 01-.75-.75z"
                        clip-rule="evenodd" />
                </svg>
                <p>Sort by : Most Recent</p>
                <button class="sort_remove">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path
                            d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                    </svg>
                </button>
            </div>
            <div class="sort">
                <img src="../assets/chat.png" alt="active">
                <p>Active</p>
                <button class="sort_remove">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path
                            d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                    </svg>
                </button>
            </div>
            <div class="sort">
                <img src="../assets/check.png" alt="closed">
                <p>Closed</p>
                <button class="sort_remove">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path
                            d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                    </svg>
                </button>
            </div>
            <button class="filtersbtn" id="filtersButton">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6 13.5V3.75m0 9.75a1.5 1.5 0 010 3m0-3a1.5 1.5 0 000 3m0 3.75V16.5m12-3V3.75m0 9.75a1.5 1.5 0 010 3m0-3a1.5 1.5 0 000 3m0 3.75V16.5m-6-9V3.75m0 3.75a1.5 1.5 0 010 3m0-3a1.5 1.5 0 000 3m0 9.75V10.5" />
                </svg>
            </button>
        </div>
        <div class="ticket_list" id="ticket_list">
        </div>
    </div>
    <div class="pagenumbers" id="pagination">
    </div>
    <div id="filters_menu" class="filters_menu">
        <p>Tags</p>
        <hr class="divider">
        <button id="active">Active</button>
        <button id="closed">Closed</button>
        <hr class="divider">
        <p>Sort by</p>
        <hr class="divider">
        <button id="most_recent">Most Recent</button>
        <button id="oldest">Oldest</button>
    </div>
    <script src="../js/main.js"></script>
</body>