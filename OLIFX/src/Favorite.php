<?php

class Favorite implements ActiveRecord
{
    private int $idProduct;
    private int $idUser;
    private string $date_time;

    public function __construct() {}

    public function getIdProduct(): int {
        return $this->idProduct;
    }
    
    public function setIdProduct(int $idProduct): void {
        $this->idProduct = $idProduct;
    }
    
    public function getIdUser(): int {
        return $this->idUser;
    }
    
    public function setIdUser(int $idUser): void {
        $this->idUser = $idUser;
    }
    
    public function getDate_time(): string {
        return $this->date_time;
    }
    
    public function setDate_time(string $date_time): void {
        $this->date_time = $date_time;
    }

    
    public function save(): bool
    {
        $connection = new MySQL();
        $sql = "INSERT INTO favorite (idUser,idProduct,date_time) VALUES ({$this->idUser},{$this->idProduct},CURRENT_DATE())";
        
        return $connection->execute($sql);
    }
    
    public function delete(): bool
    {
        $connection = new MySQL();
        $sql = "DELETE FROM favorite WHERE idProduct = {$this->idProduct} AND idUser = {$this->idUser}";
        
        return $connection->execute($sql);
    }
    
    public static function find($id): Object
    {
        // ***OBS*** This method is deprecated in this case because the database has a different approach in
        // getting and saving this type of object.
        return new Favorite();
    }

    public static function findFavorite($idProduct, $idUser): Favorite
    {
        $connection = new MySQL();
        $sql = "SELECT * FROM favorite WHERE idProduct = {$idProduct} AND idUser = {$idUser}";
        $result = $connection->query($sql);
        
        $p = new Favorite();
        $p->setDate_time($result[0]['date_time']);
        $p->setIdUser($result[0]['idUser']);
        $p->setIdProduct($result[0]['idProduct']);
        
        return $p;
    }
    
    public static function findall(): array
    {
        $connection = new MySQL();
        $sql = "SELECT * FROM favorite";
        $results = $connection->query($sql);
        
        $favorites = array();
        foreach ($results as $result) {
            $fav = new Favorite();
            $fav->setIdUser($result['idUser']);
            $fav->setIdProduct($result['idProduct']);
            $fav->setDate_time($result['date_time']);
            
            $favorites[] = $fav;
        }
        
        return $favorites;
    }
    
    public static function findallByUser($idUser): array
    {
        $connection = new MySQL();
        $sql = "SELECT * FROM favorite WHERE idUser = {$idUser}";
        $results = $connection->query($sql);

        $favorites = array();
        foreach ($results as $result) {
            $fav = new Favorite();
            $fav->setIdUser($result['idUser']);
            $fav->setIdProduct($result['idProduct']);
            $fav->setDate_time($result['date_time']);

            $favorites[] = $fav;
        }

        return $favorites;
    }
}
