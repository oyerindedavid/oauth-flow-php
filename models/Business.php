<?php
declare(strict_types = 1);

class Business{

    public function __construct(public $con)
    {
        $this->con = $con;
    }

    public function getAbusinessById($business_id) : array{
        $sql = "SELECT * FROM business WHERE id = '$business_id' ";
        $query = mysqli_query($this->con, $sql);

        $row = mysqli_fetch_array($query);
        if($row){
            extract($row);
            $res = [
                    "id" => $id,
                    "name"=> $name
                ];
        }else{
            $res = ["status" => "No record", "message"=>"We could find a record that match your request"];
        }
        return $res;
    }

    public function getAllBusiness() : array{
        $sql = "SELECT * FROM business";
        $query = mysqli_query($this->con, $sql);

        $result = [];
        while($row = mysqli_fetch_array($query)){
           extract($row);
           $res = [
                    "id" => $id,
                    "name"=> $name,
                ];
           array_push($result, $res);
        }
        
        return $result;
    }

    public function createbusiness($name): bool{
        $business_id = md5($name);

        $sql = "INSERT INTO business (id, name) VALUES ('$business_id', '$name')";
        $query = mysqli_query($this->con, $sql);

        if($query){
            return true;
        }else{
            return false;
        }
    }

}