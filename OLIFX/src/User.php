<?php

class User implements  ActiveRecord
{
    private int $idUser;
    private string $email;
    private string $cellphone;
    private string $fullName;
    private $profilePic;
    private string $password;
    private string $city;

    public function __construct() {}
    
    public function constructorCreate(
        string $email,
        string $cellphone,
        string $fullName,
        string $password,
        string $city
    ): void
    {
        $this->setEmail($email);
        $this->setCellphone($cellphone);
        $this->setFullName($fullName);
        $this->setPassword($password);
        $this->setCity($city);
    }
    
    public function constructLogin(string $email, string $password): void
    {
        $this->setEmail($email);
        $this->setPassword($password);
    }

    public function setIdUser(int $idUser): void {
        $this->idUser = $idUser;
    }
    
    public function getIdUser(): int {
        return $this->idUser;
    }
    
    public function setProfilePic($profilePic): void {
        $this->profilePic = $profilePic;
    }
    
    public function getProfilePic() {
        return $this->profilePic;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getCellphone(): string {
        return $this->cellphone;
    }

    public function getCity(): string {
        return $this->city;
    }

    public function setCellphone(string $cellphone): void {
        $this->cellphone = $cellphone;
    }

    public function getFullName(): string {
        return $this->fullName;
    }

    public function setFullName(string $fullName): void {
        $this->fullName = $fullName;
    }
    
    public function setCity(string $city): void {
        $this->city = $city;
    }

    public function setPassword(string $password): void {
        $this->password = $password;
    }

    public function getPassword(): string {
        return $this->password;
    }
    

    public function save(): bool 
    {
        $connection = new MySQL();
        $directory = __DIR__ . "/../Database/users/";

        if ($this->getProfilePic()["profilepic"]["name"] != "default.jpg") {
            $file_name = $this->profilePic['profilepic']['name'];
            $info_name = explode(".", $file_name);
            $extension = end($info_name);

            $this->profilePic = uniqid().".".$extension;
            
            if (!move_uploaded_file($_FILES["profilepic"]["tmp_name"], $directory . $this->profilePic)) {
                die("Upload failed.");
            }
        }
        else {
            $this->profilePic = "default.jpg";
        }
        
        
        if(isset($this->idUser)){
            $sql = "UPDATE user SET email = '{$this->email}', fullName = '{$this->fullName}', cellphone = '{$this->cellphone}', city = '{$this->city}', profilePic = '{$this->profilePic}' WHERE idUser = {$this->idUser}";
        }else{
            $this->password = password_hash($this->password,PASSWORD_BCRYPT);
            $sql = "INSERT INTO user (email,password,fullName, cellphone, city, profilePic) VALUES ('{$this->email}','{$this->password}','{$this->fullName}','{$this->cellphone}','{$this->city}','$this->profilePic')";
        }
        return $connection->execute($sql);
    }

    public function delete(): bool
    {
        $connection = new MySQL();
        $sql = "DELETE FROM user WHERE idUser = {$this->idUser}";
        unlink($this->profilePic);
        
        return $connection->execute($sql);
    }
    
    public static function find($id): User
    {
        $connection = new MySQL();
        $sql = "SELECT * FROM user WHERE idUser = {$id}";
        $res = $connection->query($sql);
        $user = new User();
        $user->constructorCreate(
            $res[0]['email'],
            $res[0]['cellphone'],
            $res[0]['fullName'],
            $res[0]['password'],
            $res[0]['city']
        );
        $user->setIdUser($res[0]['idUser']);
        
        return $user;
    }

    public static function findUserFullNameByIdUser($idUser): string
    {
        $connection = new MySQL();
        $sql = "SELECT fullName FROM user WHERE idUser = {$idUser};";
        $result = $connection->query($sql);
        return $result[0]["fullName"];
    }

    public static function findall(): array
    {
        $connection = new MySQL();
        $sql = "SELECT * FROM user";
        $results = $connection->query($sql);
        $users = array();
        
        foreach($results as $result) {
            $u = new User();
            $u->constructorCreate(
                $result['email'],
                $result['cellphone'],
                $result['fullName'],
                $result['password'],
                $result['city']
            );
            $u->setIdUser($result['idUser']);
            $u->setProfilePic($result['profilePic']);
            $users[] = $u;
        }
        
        return $users;
    }

    public function authenticate(): bool
    {
        $connection = new MySQL();
        $sql = "SELECT idUser, email, fullName, password, profilePic FROM user WHERE email = '{$this->email}'";
        $results = $connection->query($sql);
        
        if (password_verify($this->password, $results[0]["password"])) {
            session_start();
            $_SESSION['idUser'] = $results[0]['idUser'];
            $_SESSION['email'] = $results[0]['email'];
            $_SESSION['fullName'] = $results[0]['fullName'];
            $_SESSION['profilePic'] = $results[0]['profilePic'];
            return true;
        } else {
            return false;
        }
    }
}
