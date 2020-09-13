<?php

header("Access-Control-Allow-Origin: *");
header("Content-type: application/json; charset: UTF-8");
header("Access-Control-Allow-Methods: POST");
include_once ("../config/Database.php");
include_once ("../clasess/Building.php");

$db = new Database();
$connection = $db->connect();
$building = new Building($connection);

if($_SERVER['REQUEST_METHOD']==="POST") {
    $param = json_decode(file_get_contents("php://input"));
    if (!empty($param->id)) {
        $building->id = $param->id;
        $building_data = $building->get_one_building();

        if (!empty($building_data)) {
            http_response_code(200);
            echo json_encode(
                $building_data
            );
        } else {
            http_response_code(404);
        }
    }
} else {
    http_response_code(403);
    echo "Access denied!";
}
