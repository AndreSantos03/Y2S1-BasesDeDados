<?php
class Comment {
    public ?int $id;
    public int $ticket_id;
    public int $sender_id;
    public string $message;
    public string $datetime;

    public function __construct(?int $id, int $ticketId, int $senderId, string $message, string $datetime) {
        $this->id = $id;
        $this->ticket_id = $ticketId;
        $this->sender_id = $senderId;
        $this->message = $message;
        $this->datetime = $datetime;
    }
    function save($db) {
        $stmt = $db->prepare('
            INSERT INTO Message (ticket_id, sender_id, message, `datetime`)
            VALUES (?, ?, ?, ?);
        ');
        $stmt->execute(array($this->ticket_id, $this->sender_id, $this->message, $this->datetime));
    }
    static function GetComments($db,$ticket_id){
        $stmt = $db->prepare('
            SELECT * FROM Message WHERE ticket_id = ?;
        ');
        $stmt->execute(array($ticket_id));
        $comments = $stmt->fetchAll();
        $commentsArray = array();
    
        foreach ($comments as $comment) {
            array_push($commentsArray, new Comment(
                $comment['id'],
                $comment['ticket_id'],
                $comment['sender_id'],
                $comment['message'],
                $comment['datetime']
            ));
        }
    
        return $commentsArray;
    }
}
?>