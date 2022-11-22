<?php

class Product implements  ActiveRecord
{
    private int $idProduct;
    private int $idUser;
    private string $date_time;

    public function __construct(
        private string $title,
        private string $description,
        private float $price
    ) {}

    public function setIdProduct(int $idProduct): void {
        $this->idProduct = $idProduct;
    }

    public function setIdUser(int $idUser): void {
        $this->idUser = $idUser;
    }

    public function getIdProduct(): int {
        return $this->idProduct;
    }

    public function setTitle(string $title): void {
        $this->title = $title;
    }

    public function setDescription(string $description): void {
        $this->description = $description;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getPrice(): float {
        return $this->price;
    }
    
    public function  setPrice(float $price): void {
        $this->price = $price;
    }
    
    public function getDate_time(): string {
        return $this->date_time;
    }
    
    public function  setDate_time(string $date_time): void {
        $this->date_time = $date_time;
    }

    
    public function save(): bool
    {
        $connection = new MySQL();
        if (isset($this->idProduct)) {
            $sql = "UPDATE product SET title = '{$this->title}' ,description = '{$this->description}', price = '{$this->price}' WHERE idProduct = {$this->idProduct}";
        } else {
            $sql = "INSERT INTO product (title,description,idUser,price,date_time) VALUES ('{$this->title}','{$this->description}',{$this->idUser},'{$this->price}', NOW())";
        }
        
        return $connection->execute($sql);
    }

    public function delete(): bool
    {
        $connection = new MySQL();
        $sql = "DELETE FROM product WHERE idProduct = {$this->idProduct}";
        
        return $connection->execute($sql);
    }

    public static function find($idProduct): Product
    {
        $connection = new MySQL();
        $sql = "SELECT * FROM product WHERE idProduct = {$idProduct}";
        $result = $connection->query($sql);
        $p = new Product($result[0]['title'],$result[0]['description'],$result[0]['price']);
        $p->setDate_time($result[0]['date_time']);
        $p->setIdUser($result[0]['idUser']);
        $p->setIdProduct($result[0]['idProduct']);
        
        return $p;
    }

    public static function findall():array{
        $connection = new MySQL();
        $sql = "SELECT * FROM product";
        $results = $connection->query($sql);
        
        $products = array();
        foreach($results as $result){
            $p = new Product($result['title'],$result['description'],$result['price']);
            $p->setIdUser($result['idUser']);
            $p->setDate_time($result['date_time']);
            $p->setIdProduct($result['idProduct']);
            $products[] = $p;
        }
        
        return $products;
    }

    public static function findallByUser($idUser):array{
        $connection = new MySQL();
        $sql = "SELECT * FROM product WHERE idUser = {$idUser}";
        $results = $connection->query($sql);
        
        $products = array();
        foreach($results as $result){
            $p = new Product($result['title'],$result['description'],$result['price']);
            $p->setIdUser($result['idUser']);
            $p->setDate_time($result['date_time']);
            $p->setIdProduct($result['idProduct']);
            $products[] = $p;
        }
        
        return $products;
    }
}

