<?php

class Favorite implements ActiveRecord{

    private int $idProduct;
    private int $idUser;
    private string $date_time;

    public function __construct(){
    }

    public function getIdProduct(): int{
        return $this->idProduct;
    }
    public function  setIdProduct(int $idProduct): void{
        $this->idProduct = $idProduct;
    }
    public function getIdUser(): int{
        return $this->idUser;
    }
    public function  setIdUser(int $idUser): void{
        $this->idUser = $idUser;
    }
    public function getDate_time(): string{
        return $this->date_time;
    }
    public function  setDate_time(string $date_time): void{
        $this->date_time = $date_time;
    }

    public function save():bool{
        $conexao = new MySQL();
        $sql = "INSERT INTO favorite (idUser,idProduct,date_time) VALUES ('{$this->idUser}','{$this->idProduct}',NOW()";
        return $conexao->executa($sql);
    }
    public function delete():bool{
        $conexao = new MySQL();
        $sql = "DELETE FROM favorite WHERE idProduct = {$this->idProduct} AND idUser = {$this->idUser}";
        return $conexao->executa($sql);

    }
    public static function find($idFavorite):Favorite{
        $conexao = new MySQL();
        $sql = "SELECT * FROM favorite WHERE idProduct = {$idProduct} AND idUser = {$idUser}";
        $resultado = $conexao->consulta($sql);
        $p = new Favorite();
        $p->setDate_time($resultado[0]['date_time']);
        $p->setIdUser($resultado[0]['idUser']);
        $p->setIdProduct($resultado[0]['idProduct']);
        return $p;
    }
}