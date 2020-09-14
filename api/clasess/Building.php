<?php


class Building
{
    private $id;
    private $description;
    private $image;
    private $year;
    private $user_id;
    private $address;

    private $conn;
    private $table_name;

    public function __construct($db)
    {
        $this->conn = $db;
        $this->table_name = "building";
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

        $query = "INSERT INTO ".$this->table_name." SET description = ?, image = ?, year = ?, user_id = ?, address = ?";

        $obj = $this->conn->prepare($query);
        $obj->bind_param("ssiis",$this->description,$this->image,$this->year,$this->user_id,$this->address);

        if ($obj->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function get_all_buildings(){
        $query = "SELECT * from ".$this->table_name;
        $obj = $this->conn->prepare($query);
        $obj->execute();
        return $obj->get_result();
    }

    public function get_one_building(){
        $query = "SELECT * from ".$this->table_name." WHERE id = ?";
        $obj = $this->conn->prepare($query);
        $obj->bind_param("i",$this->id);
        $obj->execute();

        return $obj->get_result()->fetch_assoc();
    }

    public function update_building(){
        $query = "UPDATE building SET description = ?, image = ?, year = ?, user_id = ?, address = ? WHERE id = ?";
        $obj = $this->conn->prepare($query);

        $obj->bind_param("ssiisi",$this->description,$this->image,$this->year,$this->user_id,$this->address,$this->id);

        if($obj->execute()) {
            return true;
        } else {}
        return false;
    }

    public function decouple_user_from_building($user_id_decouple){
        $query = "UPDATE building SET user_id = NULL WHERE user_id = ?";
        $obj = $this->conn->prepare($query);
        $obj->bind_param("i",$user_id_decouple);

        if($obj->execute()) {
            return true;
        } else {
            return false;
        }

    }

    public function delete_building(){
        $query = "DELETE from building WHERE id = ?";
        $obj = $this->conn->prepare($query);

        $obj->bind_param("i",$this->id);

        if($obj->execute()) {
            return true;
        } else {}
        return false;
    }

}