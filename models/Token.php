<?php
declare(strict_types = 1);

class Token{

    public function __construct(public $con)
    {
        $this->con = $con;
    }

    public function getAtokenByBusinessId($business_id) : array{
        $sql = "SELECT t.token, t.max_request FROM tokens AS t
                    INNER JOIN business AS b
                    ON t.business_id = b.id
                    WHERE t.business_id = '$business_id' ";
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

    public function getAClientByToken($token) : array{
        $sql = "SELECT * FROM tokens AS t
                    INNER JOIN clients AS c
                    ON t.client_id = c.id
                    WHERE t.token = '$token' ";
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

    public function createtoken($business_id, $client_id, $token): bool{
        $sql = "INSERT INTO tokens (business_id, client_id, token) VALUES ('$business_id', '$client_id', '$token')";
        $query = mysqli_query($this->con, $sql);

        if($query){
            return true;
        }else{
            return false;
        }
    }

    public function updatetoken($token_id): bool{
        $secrete = md5(date('h:i:s'));

        $sql = "UPDATE tokens SET secrete= '$secrete' WHERE id= '$token_id' ";
        $query = mysqli_query($this->con, $sql);

        if($query){
            return true;
        }else{
            return false;
        }
    }

}