<?php 
// API that can read the user details, it can only read the user details

require '../admin/admin.php';

$method = $_SERVER['REQUEST_METHOD'];

switch($method){
    // Get all Users
    case 'GET':
        $users = $admin->displayUsers('all');
        http_response_code(200);
        echo json_encode(["requested_service" => "Get All Users","users" => $users]);
        break;
    
    // Add a new user 
    case 'POST':
        $input = json_decode(file_get_contents("php://input"), true);
        if (isset($input['username']) && isset($input['password']) && isset($input['email']) && isset($input['phone']) && isset($input['address']) && isset($input['type'])){
            $user = $admin->addUser($input['username'], $input['password'], $input['email'], $input['phone'], $input['address'], $input['type']);
            if ($user['status'] === 1){
                http_response_code(201);
                echo json_encode(["message" => "User added successfully!"]);
            } else {
                http_response_code(500);
                echo json_encode(["error" => "Failed to add user!"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Bad Request! Input Missing!"]);
        }
        break;
    
    default:
        http_response_code(400);
        echo json_encode(["error" => "Bad Request! Requested Method: $method Not Allowed!"]);
}


?>