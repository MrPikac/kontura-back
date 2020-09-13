<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
include_once ("../config/Database.php");
include_once ("../clasess/Building.php");

$db = new Database();
$connection = $db->connect();
$building = new Building($connection);

if($_SERVER['REQUEST_METHOD']==="GET"){
    $data = $building->get_all_buildings();
    if($data->num_rows > 0) {
        $buildings["records"] = array();
        while ($row = $data->fetch_assoc()) {
            array_push($buildings["records"],array(
                "id" => $row['id'],
                "description" => $row['description'],
                "address" => $row['address'],
                "user_id"=> $row['user_id'],
                "image"=> $row['image'],
                "year"=>$row['year']
            ));
        }
        http_response_code(200);
        echo json_encode(
            $buildings["records"]
        );
    }

} else {
    http_response_code(403);
    echo "Access denied!";
}
