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

    public function isExistBusinessAccount($email, $password) : array{
        $sql = "SELECT * FROM business WHERE email = '$email' AND password = '$password' ";
        $query = mysqli_query($this->con, $sql);
        $row = mysqli_fetch_array($query);
        
        

        $count = mysqli_num_rows($query);
        if($count > 0){
            $data['is_exist'] = true;
            extract($row);
            $data['info'] = ["id" => $id,"name"=> $name];
        }else{
            $data['is_exist'] = false;
            $data['is_info'] = "No record found";
        }

        return $data;
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

    public function createBusiness($name, $email, $password): bool{
        $business_id = md5($name);

        $sql = "INSERT INTO business (id, name) VALUES ('$business_id', '$name', '$email', '$password')";
        $query = mysqli_query($this->con, $sql);

        if($query){
            return true;
        }else{
            return false;
        }
    }

}