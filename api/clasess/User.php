<?php

include_once ("../clasess/Building.php");

class User
{
    private $id;
    private $username;
    private $password;
    private $firstName;
    private $lastName;
    private $email;
    private $contact;
    private $role;

    private $conn;
    private $table_name;

    public function __construct($db)
    {
        $this->conn = $db;
        $this->table_name = "user";
    }

    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value) {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }

        return $this;
    }

    public function create_data() {

        $query = "INSERT INTO ".$this->table_name." SET username = ?, password = ?, first_name = ?, last_name = ?,
         email = ?, contact = ?, role = ?";

        $obj = $this->conn->prepare($query);
        $obj->bind_param("sssssss",$this->username,$this->password,$this->firstName,$this->lastName,$this->email,$this->contact,$this->role);

        if ($obj->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function get_all_users(){
        $query = "SELECT * from ".$this->table_name;
        $obj = $this->conn->prepare($query);
        $obj->execute();
        return $obj->get_result();
    }

    public function get_one_user(){
        $query = "SELECT * from ".$this->table_name." WHERE id = ?";
        $obj = $this->conn->prepare($query);
        $obj->bind_param("i",$this->id);
        $obj->execute();

        return $obj->get_result()->fetch_assoc();
    }

    public function login($username,$password){
        $query = "SELECT * from ".$this->table_name." WHERE username = ? AND password = ?";
        $obj = $this->conn->prepare($query);
        $obj->bind_param("ss",$username,$password);
        $obj->execute();

        return $obj->get_result()->fetch_assoc();
    }

    public function update_user(){
        $query = "UPDATE user SET username = ?, password = ?, first_name = ?, last_name = ?,
         email = ?, contact = ?, role = ? WHERE id = ?";
        $obj = $this->conn->prepare($query);

        $obj->bind_param("sssssssi",$this->username,$this->password,$this->firstName,$this->lastName,$this->email,$this->contact,$this->role,$this->id);

        if($obj->execute()) {
            return true;
        } else {}
        return false;
    }

    public function delete_user(){
        $building = new Building($this->conn);

        if ($building->decouple_user_from_building($this->id)) {

            $query = "DELETE from user WHERE id = ?";
            $obj = $this->conn->prepare($query);


            $obj->bind_param("i",$this->id);

            if($obj->execute()) {
                return true;
            } else {}
            return false;

        } else {
            return false;
        }
    }



}