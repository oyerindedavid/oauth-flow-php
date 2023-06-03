<?php
declare(strict_types = 1);

class Client{

    public function __construct(public $con)
    {
        $this->con = $con;
    }

    public function getAClientById($client_id) : array{
        $sql = "SELECT * FROM clients WHERE id = '$client_id' ";
        $query = mysqli_query($this->con, $sql);

        $row = mysqli_fetch_array($query);
        if($row){
            extract($row);
            $res = [
                    "id" => $id,
                    "secrete"=> $secrete,
                    "name"=> $name
                ];
        }else{
            $res = ["status" => "No record", "message"=>"We could find a record that match your request"];
        }
        return $res;
    }

    public function getAllClient() : array{
        $sql = "SELECT * FROM clients";
        $query = mysqli_query($this->con, $sql);

        $result = [];
        while($row = mysqli_fetch_array($query)){
           extract($row);
           $res = [
                    "id" => $id,
                    "name"=> $name,
                    "secrete" => $secrete,
                    "last_modified" => $last_modified
                ];
           array_push($result, $res);
        }
        
        return $result;
    }

    public function createClient($name): bool{
        $client_id = md5($name);
        $secrete = hash('sha256', $name);

        $sql = "INSERT INTO clients (id, name, secrete) VALUES ('$client_id', '$name', '$secrete')";
        $query = mysqli_query($this->con, $sql);

        if($query){
            return true;
        }else{
            return false;
        }
    }

    public function updateClient($client_id): bool{
        $secrete = hash('sha256', $client_id);

        $sql = "UPDATE clients SET secrete= '$secrete' WHERE id= '$client_id' ";
        $query = mysqli_query($this->con, $sql);

        if($query){
            return true;
        }else{
            return false;
        }
    }

}