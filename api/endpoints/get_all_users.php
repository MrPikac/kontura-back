<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
include_once ("../config/Database.php");
include_once ("../clasess/User.php");

$db = new Database();
$connection = $db->connect();
$user = new User($connection);

if($_SERVER['REQUEST_METHOD']==="GET"){
    $data = $user->get_all_users();
    if($data->num_rows > 0) {
        $users["records"] = array();
        while ($row = $data->fetch_assoc()) {
            array_push($users["records"],array(
                "id" => $row['id'],
                "userName" => $row['username'],
                "password" => $row['password'],
                "firstName"=> $row['first_name'],
                "lastName"=>$row['last_name'],
                "role"=>$row['role'],
                "email"=>$row['email'],
                "contact"=>$row['contact'],
            ));
        }
        http_response_code(200);
        echo json_encode(
            $users["records"]
        );
    }

} else {
    http_response_code(403);
    echo "Access denied!";
}
