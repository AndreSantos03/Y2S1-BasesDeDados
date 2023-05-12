<?php
declare(strict_types=1);

class User
{
    public int $id;
    public string $username;
    public string $firstName;
    public string $lastName;
    public string $city;
    public string $country;
    public string $phone;
    public string $email;
    public string $privilege;
    public string $department;


    public function __construct(
        int $id,
        string $username,
        string $firstName,
        string $lastName,
        string $city,
        string $country,
        string $phone,
        string $email,
        string $privilege,
        string $department
    ) {
        $this->id = $id;
        $this->username = $username;
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

    function save($db)
    {
        $stmt = $db->prepare('
        UPDATE User SET FirstName = ?, LastName = ?
        WHERE UserId = ?
      ');

        $stmt->execute(array($this->firstName, $this->lastName, $this->id));
    }

    static function getUserWithPassword(PDO $db, string $email, string $password): ?User
    {
        $stmt = $db->prepare('
        SELECT UserId, FirstName, LastName, City, Country, Phone, Username, Email, Privilege,Department
        FROM User
        WHERE lower(email) = ? AND password = ?
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
                $user['Username'],
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
        SELECT UserId, FirstName, LastName, City, Country, Phone, Username, Email, Privilege,Department
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
            $user['Username'],
            $user['Email'],
            $user['Privilege'],
            $user['Department']
        );
    }

}
?>