<?php
class Status {
    private int $id;
    private int $ticketId;
    private int $agentId;
    private ?int $adminId;
    private string $status;
    private string $priority;
    private string $datetime;

    public function __construct(
        int $ticketId, 
        int $agentId, 
        ?int $adminId, 
        string $status, 
        string $priority, 
        string $datetime
        ) {
        $this->ticketId = $ticketId;
        $this->agentId = $agentId;
        $this->adminId = $adminId;
        $this->status = $status;
        $this->priority = $priority;
        $this->datetime = $datetime;
    }
    function save($db) {
        $stmt = $db->prepare('
            INSERT INTO Status (ticket_id, agent_id, admin_id, status, priority, datetime)
            VALUES (?, ?, ?, ?, ?, ?)
        ');
        
        $stmt->execute(array($this->ticketId, $this->agentId, $this->adminId, $this->status, $this->priority, $this->datetime));
    }
    static function getStatusByTicketId($db, $ticketId) {
        $stmt = $db->prepare('
            SELECT * FROM Status WHERE ticket_id = ? ORDER BY datetime DESC LIMIT 1
        ');
        $stmt->execute(array($ticketId));
        $status = $stmt->fetch(PDO::FETCH_ASSOC);
        return $status;
    }    
}
?>
