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
    public string $department;

    public function __construct(?int $id, int $clientId, string $title, string $desc, string $datetime, int $agentId, ?int $adminId, string $status, string $priority) {
        $this->id = $id;
        $this->client_id = $clientId;
        $this->title = $title;
        $this->desc = $desc;
        $this->datetime = $datetime;
        $this->agent_id = $agentId;
        $this->admin_id = $adminId;
        $this->status = $status;
        $this->department = $priority;
    }

    public function save($db) {
        $stmt = $db->prepare('
            INSERT INTO Ticket (client_id, title, `desc`, `datetime`, agent_id, admin_id, status, department)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?);
        ');
        $stmt->execute(array($this->client_id, $this->title, $this->desc, $this->datetime, $this->agent_id, $this->admin_id, $this->status, $this->department));
    }
    
    static function changeStatus($db,$ticket_id,$status) {
        $stmt = $db->prepare('
            UPDATE Ticket SET status = ? WHERE id = ?;
        ');
        $stmt->execute(array($status,$ticket_id));
    }

    static function getTicket($db,$id){
        $stmt = $db->prepare('
            SELECT * FROM Ticket WHERE id = ?;
        ');
        $stmt->execute(array($id));
        $ticket = $stmt->fetch();
        return new Ticket(
            $ticket['id'],
            $ticket['client_id'],
            $ticket['title'],
            $ticket['desc'],
            $ticket['datetime'],
            $ticket['agent_id'],
            $ticket['admin_id'],
            $ticket['status'],
            $ticket['department']
        );
    }

    static function getClientTickets($db,$clientId,$search,$closed, $active, $recent) {
        $query = 'SELECT * FROM Ticket WHERE client_id = ?';
        $params = array($clientId);

        if ($search!="") {
            $query = $query . ' AND (title LIKE ? OR `desc` LIKE ?)';
            array_push($params, '%'.$search.'%');
            array_push($params, '%'.$search.'%');
        }

        if ($closed=="true" and $active=="false") {
            $query = $query . ' AND status = "Closed"';
        } else if ($closed=="false" and $active=="true") {
            $query = $query . ' AND status = "Active"';
        }

        if($recent=="true") {
            $query = $query . ' ORDER BY `datetime` DESC';
        } else {
            $query = $query . ' ORDER BY `datetime` ASC';
        }
    
        $stmt = $db->prepare($query);
        $stmt->execute($params);
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
                $ticket['department']
            ));
        }
    
        return $ticketsArray;
    }

    static function getAgentTickets($db,$agentId,$search,$closed, $active, $recent) {
        $query = 'SELECT * FROM Ticket WHERE agent_id = ?';
        $params = array($agentId);

        if ($search!="") {
            $query = $query . ' AND (title LIKE ? OR `desc` LIKE ?)';
            array_push($params, '%'.$search.'%');
            array_push($params, '%'.$search.'%');
        }

        if ($closed=="true" and $active=="false") {
            $query = $query . ' AND status = "Closed"';
        } else if ($closed=="false" and $active=="true") {
            $query = $query . ' AND status = "Active"';
        }

        if($recent=="true") {
            $query = $query . ' ORDER BY `datetime` DESC';
        } else {
            $query = $query . ' ORDER BY `datetime` ASC';
        }
    
        $stmt = $db->prepare($query);
        $stmt->execute($params);
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
                $ticket['department']
            ));
        }
    
        return $ticketsArray;
    }

    static function getAdminTickets($db,$adminId,$search,$closed, $active, $recent) {
        $query = 'SELECT * FROM Ticket WHERE admin_id = ?';
        $params = array($adminId);

        if ($search!="") {
            $query = $query . ' AND (title LIKE ? OR `desc` LIKE ?)';
            array_push($params, '%'.$search.'%');
            array_push($params, '%'.$search.'%');
        }

        if ($closed=="true" and $active=="false") {
            $query = $query . ' AND status = "Closed"';
        } else if ($closed=="false" and $active=="true") {
            $query = $query . ' AND status = "Active"';
        }

        if($recent=="true") {
            $query = $query . ' ORDER BY `datetime` DESC';
        } else {
            $query = $query . ' ORDER BY `datetime` ASC';
        }
    
        $stmt = $db->prepare($query);
        $stmt->execute($params);
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
                $ticket['department']
            ));
        }
    
        return $ticketsArray;
    }
}
?>