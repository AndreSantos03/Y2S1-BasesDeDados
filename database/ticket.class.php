<?php
class Ticket {
    public ?int $id;
    public int $client_id;
    public string $title;
    public string $desc;
    public string $datetime;
    public int $agent_id;
    public ?int $admin_id;
    public string $status;
    public string $priority;

    public function __construct(?int $id, int $clientId, string $title, string $desc, string $datetime, int $agentId, ?int $adminId, string $status, string $priority) {
        $this->id = $id;
        $this->client_id = $clientId;
        $this->title = $title;
        $this->desc = $desc;
        $this->datetime = $datetime;
        $this->agent_id = $agentId;
        $this->admin_id = $adminId;
        $this->status = $status;
        $this->priority = $priority;
    }

    public function save($db) {
        $stmt = $db->prepare('
            INSERT INTO Ticket (client_id, title, `desc`, `datetime`, agent_id, admin_id, status, priority)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?);
        ');
        $stmt->execute(array($this->client_id, $this->title, $this->desc, $this->datetime, $this->agent_id, $this->admin_id, $this->status, $this->priority));
    }  

    static function getClientTickets($db, $clientId) {
        $stmt = $db->prepare('
            SELECT * FROM Ticket WHERE client_id = ? ORDER BY `datetime` DESC;
        ');
        $stmt->execute(array($clientId));
        $tickets = $stmt->fetchAll();
        $ticketsArray = array();
        foreach ($tickets as $ticket) {
            array_push($ticketsArray, new Ticket(
                $ticket['id'],
                $ticket['client_id'],
                $ticket['title'],
                $ticket['desc'],
                $ticket['datetime'],
                $ticket['agent_id'],
                $ticket['admin_id'],
                $ticket['status'],
                $ticket['priority']
            ));
        }
        return $ticketsArray;
    }
}
?>