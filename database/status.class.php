<?php
class Status {
    public ?int $id;
    public int $ticketId;
    public int $agentId;
    public ?int $adminId;
    public string $status;
    public string $priority;
    public string $datetime;

    public function __construct(
        ?int $id,
        int $ticketId, 
        int $agentId, 
        ?int $adminId, 
        string $status, 
        string $priority, 
        string $datetime
        ) {
        $this->id = $id;
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
            VALUES (?, ?, ?, ?, ?, ?);
        ');
        
        $stmt->execute(array($this->ticketId, $this->agentId, $this->adminId, $this->status, $this->priority, $this->datetime));
    } 
}
?>
