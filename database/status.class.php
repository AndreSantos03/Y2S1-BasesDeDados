<?php
class Status{
    public int $id;
    public int $agent_id;
    public int $admin_id;
    public string $status;
    public string $priority;
    public string $datetime;

public function __construct(int $id, int $agent_id,int $admin_id, string $status,string $priority, string $datetime ){
    $this->id = $id;
    $this->agent_id = $agent_id;
    $this->admin_id = $admin_id;
    $this->status = $status;
    $this->priority = $priority;
    $this->datetime = $datetime;
}



}



?>
