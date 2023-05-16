<?php 
  declare(strict_types = 1); 

  require_once(__DIR__ . '/../database/ticket.class.php');
?>

<?php function drawSmallTicket(Ticket $ticket) { ?>
    <div class="ticket">
        <div class="ticket_status_spacer">
            <div class="ticket_status">
                <p><?=$ticket->status?></p>
            </div>
        </div>
        <div class="ticket_content">
            <div class="ticket_title">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM8.94 6.94a.75.75 0 11-1.061-1.061 3 3 0 112.871 5.026v.345a.75.75 0 01-1.5 0v-.5c0-.72.57-1.172 1.081-1.287A1.5 1.5 0 108.94 6.94zM10 15a1 1 0 100-2 1 1 0 000 2z"
                        clip-rule="evenodd" />
                </svg>
                <p><?=$ticket->title?></p>
            </div>
            <div class="ticket_desc">
                <p><?=$ticket->desc?>...</p>
            </div>
        </div>
        <div class="ticket_info">
            <p>Asked by <?=$ticket->client_id?><?=$ticket->datetime?></p>
        </div>
    </div>
    <?php } ?>

    <?php function drawSmallTickets(array $tickets) { ?>
        <div class="tickets">
          <?php foreach ($tickets as $ticket) { ?>
            <?php drawSmallTicket($ticket); ?>
          <?php } ?>
        </div>
      <?php } ?>