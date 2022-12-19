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
    
    public function getIdUser(): int {
        return $this->idUser;
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
            $connection = new MySQL();
            $sqli = "SELECT COUNT(*) + 1 as numero FROM product";
            $result = $connection->query($sqli);
            $c = $result[0]['numero'];
            $sql = "INSERT INTO `product`".
                "(`idProduct`, `idUser`, `title`, `description`, `price`, `date_time`) ".
                "VALUES ($c, {$this->idUser}, '{$this->title}', '{$this->description}', {$this->price}, now())";
        }
        
        return $connection->execute($sql);
    }

    public function delete(): bool
    {
        $connection = new MySQL();
        $sql2 = "DELETE FROM favorite where idProduct = {$this->idProduct}";
        $sql = "DELETE FROM product WHERE idProduct = {$this->idProduct}";
        $teste2 = $connection->execute($sql2);
        $teste =  $connection->execute($sql);
        return true;
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

    public static function findByTitle($title): array {
        $connection = new MySQL();
        $sql = "SELECT * FROM product WHERE title LIKE '{$title}'";
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

    public static function findallByUser($idUser): array
    {
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
    
    public static function countProducts() : int
    {
        $connection = new MySQL();
        $sql = "SELECT COUNT(*) as numero FROM product";
        $result = $connection->query($sql);
        $c = $result[0]['numero'];
        return $c;
    }
    
    public function verifyIfUserHasFavorite($idUser): bool
    {
        $connection = new MySQL();
        $sql = "select count(1) as count from favorite where idUser=$idUser AND idProduct=$this->idProduct;";
        $res = $connection->query($sql);
        return $res[0]["count"];
    }

    public static function whatsApp($id) : string {
        $connection = new MySQL();
        $sql = "SELECT cellphone FROM user,product WHERE user.idUser = {$id}";
        $res = $connection->query($sql);
        $number = $res[0]['cellphone'];
        $formatednumber = preg_replace("/[^0-9]/", "",$number);
        $link = "https://wa.me/55".$formatednumber;
        return $link;
    }
}

