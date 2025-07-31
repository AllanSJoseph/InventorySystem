<?php 
// API that can read the inventory stock, it can Read all items stored in the inventory..

require '../stocker/stocker.php';

$method = $_SERVER['REQUEST_METHOD'];


switch($method){
    // Get all Inventory items
    case 'GET':
        $inventory = $stocker->displayProductInventory();
        http_response_code(200);
        echo json_encode(["requested_service" => "Get All Items stored in the inventory", "inventory" => $inventory]);
        break;
    
    // Add new item to inventory
    case 'POST':
        $input = json_decode(file_get_contents("php://input"), true);
        if (isset($input['name']) && isset($input['price']) && isset($input['stock']) && isset($input['description'])){
            $result = $stocker->addItem($input['name'], $input['price'], $input['stock'], $input['description']);
            if ($result === 1){
                http_response_code(201);
                echo json_encode(["message" => "Item added successfully!"]);
            } else {
                http_response_code(500);
                echo json_encode(["error" => "Failed to add item!"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Bad Request! Input Missing!"]);
        }
        break;
    
    // Edit all details on an existing item
    case 'PUT':
        $input = json_decode(file_get_contents("php://input"), true);
        if (isset($input['prod_id']) && isset($input['name']) && isset($input['price']) && isset($input['stock']) && isset($input['description'])){
            $result = $stocker->updateItem($input['prod_id'], $input['name'], $input['price'], $input['stock'], $input['description']);
            if ($result === 1){
                http_response_code(200);
                echo json_encode(["message" => "Item updated successfully!"]);
            } else {
                http_response_code(500);
                echo json_encode(["error" => "Failed to update item!"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Bad Request! Input Missing!"]);
        }
        break;

    // Edit the stock of an existing item
    case 'PATCH':
        $input = json_decode(file_get_contents("php://input"), true);
        if (isset($input['prod_id']) && isset($input['new_stock'])){
            $result = $stocker->updateStock($input['prod_id'], $input['new_stock']);
            if ($result === 1){
                http_response_code(200);
                echo json_encode(["message" => "Stock updated successfully!"]);
            } else {
                http_response_code(500);
                echo json_encode(["error" => "Failed to update stock!"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Bad Request! Input Missing!"]);
        }
        break;
    
    default:
        http_response_code(400);
        echo json_encode(["error" => "Bad Request! Requested Method: $method Not Allowed!"]);
        break;
    
}




?>