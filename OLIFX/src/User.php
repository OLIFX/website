<?php

class User implements  ActiveRecord{

    private  int $idUser;
    private $foto;

    public function __construct(private string $email, private string $cellphone, private string $fullname, private string $password, private string $city)
    {
    }

    public function setIdUser(int $idUser):void{
        $this->idUser = $idUser;
    }
    public function getIdUser():int{
        return $this->idUser;
    }

    public function setPassword(string $password):void{
        $this->password = $password;
    }

    public function setEmail(string $email):void{
        $this->email = $email;
    }

    public function getPassword():string{
        return $this->password;
    }

    public function getEmail():string{
        return $this->email;
    }
    public function setFoto($foto):void{
        $this->foto = $foto;
    }

    public function getFoto():string{
        return $this->foto;
    }

    public function save():bool{
        $conexao = new MySQL();
        $diretorio = "xxxxxxxxxxx";
        $nome_arquivo = $this->foto['foto']['name'];
        $info_name = explode(".",$nome_arquivo);
        $extensao = end($info_name);
        $this->foto = $diretorio.uniqid().".".$extensao;
        move_uploaded_file($_FILES["foto"]["tmp_name"],$this->foto);
        $this->password = password_hash($this->password,PASSWORD_BCRYPT);
        if(isset($this->idUser)){
            $sql = "UPDATE user SET email = '{$this->email}', password = '{$this->password}', fullName = '{$this->fullname}', cellphone = '{$this->cellphone}', city = '{$this->city}',  WHERE idUser = {$this->idUser}";
        }else{
            $sql = "INSERT INTO user (email,password,fullName, cellphone, city, profilePic) VALUES ('{$this->email}','{$this->password}','{$this->fullname}','{$this->cellphone}','{$this->city}','$this->foto')";
        }
        return $conexao->executa($sql);
    }

    public static function find($idUser):User{
        $conexao = new MySQL();
        $sql = "SELECT * FROM user WHERE idUser = {$idUser}";
        $resultado = $conexao->consulta($sql);
        $u = new User($resultado[0]['email'],$resultado[0]['cellphone'],$resultado[0]['fullName'],$resultado[0]['password'], $resultado[0]['city']);
        $u->setIdUser($resultado[0]['idUser']);
        $u->setFoto($resultado[0]['profilePic']);
        return $u;
    }

    public function delete():bool{
        $conexao = new MySQL();
        $sql = "DELETE FROM user WHERE idUser = {$this->idUser}";
        unlink($this->foto);
        return $conexao->executa($sql);
    }

    public static function findall():array{
        $conexao = new MySQL();
        $sql = "SELECT * FROM user";
        $resultados = $conexao->consulta($sql);
        $users = array();
        foreach($resultados as $resultado){
            $u = new User($resultado[0]['email'],$resultado[0]['cellphone'],$resultado[0]['fullName'],$resultado[0]['password'], $resultado[0]['city']);
            $u->setIdUser($resultado['idUser']);
            $u->setFoto($resultado['profilePic']);
            $users[] = $u;
        }
        return $users;
    }




}