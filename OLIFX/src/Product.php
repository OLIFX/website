<?php

class Product implements  ActiveRecord{

    private int $idProduct;
    private int $idUser;
    private string $date_time;

    public function __construct(private string $title,private string $description, private float $price){
    }

    public function setIdProduct(int $idProduct):void{
        $this->idProduct = $idProduct;
    }

    public function setIdUser(int $idUser):void{
        $this->idUser = $idUser;
    }

    public function getIdProduct():int{
        return $this->idProduct;
    }

    public function setTitle(string $title):void{
        $this->title = $title;
    }

    public function setDescription(string $description):void{
        $this->description = $description;
    }

    public function getTitle():string{
        return $this->title;
    }

    public function getDescription():string{
        return $this->description;
    }

    public function getPrice(): float{
        return $this->price;
    }
    public function  setPrice(float $price): void{
        $this->price = $price;
    }
    public function getDate_time(): string{
        return $this->date_time;
    }
    public function  setDate_time(string $date_time): void{
        $this->date_time = $date_time;
    }


    public function save():bool{
        $conexao = new MySQL();
        if(isset($this->idProduct)){
            $sql = "UPDATE product SET title = '{$this->title}' ,description = '{$this->description}', price = '{$this->price}' WHERE idProduct = {$this->idProduct}";
        }else{
            $sql = "INSERT INTO product (title,description,idUser,price,date_time) VALUES ('{$this->title}','{$this->description}',{$this->idUser},'{$this->price}'),NOW()";
        }
        return $conexao->executa($sql);
    }

    public function delete():bool{
        $conexao = new MySQL();
        $sql = "DELETE FROM product WHERE idProduct = {$this->idProduct}";
        return $conexao->executa($sql);
    }


    public static function find($idProduct):Product{
        $conexao = new MySQL();
        $sql = "SELECT * FROM product WHERE idProduct = {$idProduct}";
        $resultado = $conexao->consulta($sql);
        $p = new Product($resultado[0]['title'],$resultado[0]['description'],$resultado[0]['price']);
        $p->setDate_time($resultado[0]['date_time']);
        $p->setIdUser($resultado[0]['idUser']);
        $p->setIdProduct($resultado[0]['idProduct']);
        return $p;
    }

    public static function findall():array{
        $conexao = new MySQL();
        $sql = "SELECT * FROM product";
        $resultados = $conexao->consulta($sql);
        $products = array();
        foreach($resultados as $resultado){
            $p = new Product($resultado['title'],$resultado['description'],$resultado['price']);
            $p->setIdUser($resultado['idUser']);
            $p->setDate_time($resultado['date_time']);
            $p->setIdProduct($resultado['idProduct']);
            $products[] = $p;
        }
        return $products;
    }

    public static function findallByUser($idUser):array{
        $conexao = new MySQL();
        $sql = "SELECT * FROM product WHERE idUser = {$idUser}";
        $resultados = $conexao->consulta($sql);
        $products = array();
        foreach($resultados as $resultado){
            $p = new Product($resultado['title'],$resultado['description'],$resultado['price']);
            $p->setIdUser($resultado['idUser']);
            $p->setDate_time($resultado['date_time']);
            $p->setIdProduct($resultado['idProduct']);
            $products[] = $p;
        }
        return $products;
    }
}

