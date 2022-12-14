<?php

class Media implements ActiveRecord
{

    private int $idProduct;
    private $path;
    private int $idMedia;

    public function __construct()
    {

    }

    public function setIdProduct(int $idProduct): void
    {
        $this->idProduct = $idProduct;
    }

    public function getIdProduct(): int
    {
        return $this->idProduct;
    }

    public function setIdMedia(int $idMedia): void
    {
        $this->idMedia = $idMedia;
    }

    public function getIdMedia(): int
    {
        return $this->idMedia;
    }

    public function setPath($path): void
    {
        $this->path = $path;
    }

    public function getPath()
    {
        return $this->path;
    }


    public function save(): bool
    {
        $connection = new MySQL();
        $directory = __DIR__ . "/../Database/media/";

        if ($this->getPath() != "default.jpg") {
            $file_name = $this->path['media']['name'];
            $info_name = explode(".", $file_name);
            $extension = end($info_name);

            $this->path = uniqid() . "." . $extension;

            if (!move_uploaded_file($_FILES["media"]["tmp_name"], $directory . $this->path)) {
                die("Upload failed.");
            }
        } else {
            $this->path = "default.jpg";
        }
        if (isset($this->idMedia)) {
            $sql = "UPDATE media SET idProduct = '{$this->idProduct}' ,path = '{$this->path}' WHERE idMedia = {$this->idMedia}";
        } else {
            $sql = "INSERT INTO media (idProduct,path) VALUES ('{$this->idProduct}','{$this->path}')";
        }

        return $connection->execute($sql);
    }

    public function delete(): bool
    {
        $connection = new MySQL();
        $sql = "DELETE FROM media WHERE idMedia = {$this->idMedia}";
        unlink($this->path);

        return $connection->execute($sql);
    }

    public static function find($id): Media
    {
        $connection = new MySQL();
        $sql = "SELECT * FROM media WHERE idMedia = {$id}";
        $res = $connection->query($sql);
        $media = new Media();
        $media->setIdProduct($res[0]['idProduct']);
        $media->setIdMedia($res[0]['idMedia']);
        $media->setPath($res[0]['path']);

        return $media;
    }


    public static function findall(): array
    {
        $connection = new MySQL();
        $sql = "SELECT * FROM media";
        $results = $connection->query($sql);
        $media = array();

        foreach ($results as $result) {
            $u = new Media();
            $u->setIdProduct($result['idProduct']);
            $u->setIdMedia($result['idMedia']);
            $u->setPath($result['path']);
            $media[] = $u;
        }

        return $media;
    }

    public static function findMediaByProduct($id): Media
    {
        $connection = new MySQL();
        $sql = "SELECT * FROM media WHERE idProduct = {$id}";
        $res = $connection->query($sql);
        $media = new Media();
        $media->setIdProduct($res[0]['idProduct']);
        $media->setIdMedia($res[0]['idMedia']);
        $media->setPath($res[0]['path']);

        return $media;
    }

    public static function existeMediaProduto($id): bool
    {
        $connection = new MySQL();
        $sql = "SELECT * FROM media
                GROUP by idProduct
                HAVING idProduct = {$id}";
        $res = $connection->query($sql);
        if ($res) {
            return true;
        } else {
            return false;

        }


    }
}