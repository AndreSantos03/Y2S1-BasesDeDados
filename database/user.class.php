<?php
declare(strict_types=1);

class User
{
    public ?int $id;
    public string $firstName;
    public string $lastName;
    public ?string $city;
    public ?string $country;
    public ?string $phone;
    public ?string $email;
    public string $privilege;
    public ?string $department;


    public function __construct(
        ?int $id,
        string $firstName,
        string $lastName,
        ?string $city,
        ?string $country,
        ?string $phone,
        string $email,
        string $privilege,
        ?string $department
    ) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->city = $city;
        $this->country = $country;
        $this->phone = $phone;
        $this->email = $email;
        $this->privilege = $privilege;
        $this->department = $department;
    }

    function name()
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    static function promoteClient(PDO $db, int $id)
    {
        $stmt = $db->prepare('
        UPDATE User
        SET Privilege = "Agent"
        WHERE UserId = ?
      ');

        $stmt->execute(array($id));
    }

    static function promoteAgent(PDO $db, int $id)
    {
        $stmt = $db->prepare('
        UPDATE User
        SET Privilege = "Admin"
        WHERE UserId = ?
      ');

        $stmt->execute(array($id));
    }
    
    static function nameFromId(PDO $db, int $id): string
    {
        $stmt = $db->prepare('
        SELECT FirstName, LastName
        FROM User
        WHERE UserId = ?
      ');

        $stmt->execute(array($id));
        $user = $stmt->fetch();

        return $user['FirstName'] . ' ' . $user['LastName'];
    }

    static function privilegeFromId(PDO $db, int $id): string
    {
        $stmt = $db->prepare('
        SELECT Privilege
        FROM User
        WHERE UserId = ?
      ');

        $stmt->execute(array($id));
        $user = $stmt->fetch();

        return $user['Privilege'];
    }

    function save($db, string $password)
    {
        $stmt = $db->prepare('
        INSERT INTO User (FirstName, LastName, Email,Password,Privilege) VALUES (?,?,?,?,?);
    ');
        $options = ['cost' => 12];
        $stmt->execute(array($this->firstName, $this->lastName, $this->email, password_hash($password, PASSWORD_DEFAULT, $options), $this->privilege));
    }

    static function getUserWithPassword(PDO $db, string $email, string $password): ?User
    {
        $stmt = $db->prepare('
        SELECT UserId, FirstName, LastName, City, Country, Phone, Email, Privilege, Department, Password
        FROM User
        WHERE lower(email) = ?
    ');
        $stmt->execute(array(strtolower($email)));
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['Password'])) {
            return new User(
                $user['UserId'],
                $user['FirstName'],
                $user['LastName'],
                $user['City'],
                $user['Country'],
                $user['Phone'],
                $user['Email'],
                $user['Privilege'],
                $user['Department']
            );
        } else {
            return null;
        }
    }

    static function getUser(PDO $db, int $id): User
    {
        $stmt = $db->prepare('
        SELECT UserId, FirstName, LastName, City, Country, Phone, Email, Privilege,Department
        FROM User 
        WHERE UserId = ?
      ');

        $stmt->execute(array($id));
        $user = $stmt->fetch();

        return new User(
            $user['UserId'],
            $user['FirstName'],
            $user['LastName'],
            $user['City'],
            $user['Country'],
            $user['Phone'],
            $user['Email'],
            $user['Privilege'],
            $user['Department']
        );
    }

    static function getClients(PDO $db){
        $stmt = $db->prepare('
        SELECT UserId, FirstName, LastName, City, Country, Phone, Email, Privilege,Department
        FROM User 
        WHERE Privilege = "Client"
      ');

        $stmt->execute();
        $clients = $stmt->fetchAll();
        $clientsArray = array();

        foreach ($clients as $client) {
            array_push($clientsArray, new User(
                $client['UserId'],
                $client['FirstName'],
                $client['LastName'],
                $client['City'],
                $client['Country'],
                $client['Phone'],
                $client['Email'],
                $client['Privilege'],
                $client['Department']
            ));
        }

        return $clientsArray;
    }
    static function getAgents(PDO $db){
        $stmt = $db->prepare('
        SELECT UserId, FirstName, LastName, City, Country, Phone, Email, Privilege,Department
        FROM User 
        WHERE Privilege = "Agent"
      ');

        $stmt->execute();
        $agents = $stmt->fetchAll();
        $agentsArray = array();

        foreach ($agents as $agent) {
            array_push($agentsArray, new User(
                $agent['UserId'],
                $agent['FirstName'],
                $agent['LastName'],
                $agent['City'],
                $agent['Country'],
                $agent['Phone'],
                $agent['Email'],
                $agent['Privilege'],
                $agent['Department']
            ));
        }

        return $agentsArray;
    }

    static function getAdmins(PDO $db){
        $stmt = $db->prepare('
        SELECT UserId, FirstName, LastName, City, Country, Phone, Email, Privilege,Department
        FROM User 
        WHERE Privilege = "Admin"
      ');

        $stmt->execute();
        $admins = $stmt->fetchAll();
        $adminsArray = array();

        foreach ($admins as $admin) {
            array_push($adminsArray, new User(
                $admin['UserId'],
                $admin['FirstName'],
                $admin['LastName'],
                $admin['City'],
                $admin['Country'],
                $admin['Phone'],
                $admin['Email'],
                $admin['Privilege'],
                $admin['Department']
            ));
        }

        return $adminsArray;
    }
}
?>