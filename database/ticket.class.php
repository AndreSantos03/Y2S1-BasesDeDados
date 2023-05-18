<?php
class Ticket {
    public ?int $id;
    public int $clientId;
    public string $title;
    public string $desc;
    public string $datetime;

    public function __construct(?int $id,int $clientId, string $title, string $desc, string $datetime) {
        $this->id = $id;
        $this->clientId = $clientId;
        $this->title = $title;
        $this->desc = $desc;
        $this->datetime = $datetime;
    }
    function save($db) {
        $stmt = $db->prepare('
            INSERT INTO Ticket (client_id, title, desc, datetime)
            VALUES (?, ?, ?, ?);
        ');
    
        $stmt->execute(array($this->clientId, $this->title, $this->desc, $this->datetime));
    }
    static function getTicketById($db, $ticketId) {
        $stmt = $db->prepare('
            SELECT * FROM Ticket WHERE ticket_id = ?
        ');
        $stmt->execute(array($ticketId));
        $ticket = $stmt->fetch();

        return new Ticket(
            $ticket['id'],
            $ticket['client_id'],
            $ticket['title'],
            $ticket['desc'],
            $ticket['datetime']
        );        
    }    
    function getStatus($db) {
        $stmt = $db->prepare('
            SELECT * FROM Status WHERE ticket_id = ? ORDER BY datetime DESC LIMIT 1;
        ');
        $stmt->execute(array($this->id));
        $status = $stmt->fetch();
        return new Status(
            $status['id'],
            $status['ticket_id'],
            $status['agent_id'],
            $status['admin_id'],
            $status['status'],
            $status['priority'],
            $status['datetime']
        );
    }  
}
?>