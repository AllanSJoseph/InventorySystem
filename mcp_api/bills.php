<?php 
// API that can read all the bill records and list them


$method = $_SERVER['REQUEST_METHOD'];

switch($method){
    // Get all Bill Records
    case 'GET':
        require '../admin/admin.php';
        $bill_recs = $admin->displayBillHistory();
        http_response_code(200);
        echo json_encode(["requested_service" => "Fetch all bills stored in database", "bill records" => $bill_recs]);
        break;

    // Filter bill records by stocker
    case 'POST':
        require '../cashier/cashier.php';
        $input = json_decode(file_get_contents("php://input"), true);
        if (isset($input['cashier_id'])){
            $bill_recs_cashier = $cashier->displayBillHistory($input['cashier_id']);
            if ($bill_recs_cashier === []){
                http_response_code(200);
                echo json_encode(["requested_service" => "Fetch all Bill History of a cashier from database", "message" => "Found an empty list, Either Cashier does not exist or has not created a single bill...", "bill records" => $bill_recs_cashier]);
            } else {
                http_response_code(200);
                echo json_encode(["requested_service" => "Fetch all Bill History of a cashier from database", "message" => "Successfully fetched all bill records of cashier", "bill records" => $bill_recs_cashier]);
            }
            }else{
            http_response_code(400);
            echo json_encode(["error" => "Bad Request! Input Missing!"]);
        }
        break;
    
    case 'PATCH':
        require '../cashier/cashier.php';
        $input = json_decode(file_get_contents("php://input"), true);
        
        if (isset($input['invoice_no']) && isset($input['pay_method'])){
            $details = $cashier->displayBill($input['invoice_no']);

            if (!$details) {
                http_response_code(404);
                echo json_encode(["error" => "Bill not found!"]);
                exit;
            }

            if ($details['cashier'] !== 4) {
                http_response_code(403);
                echo json_encode(["error" => "Forbidden! You are not allowed to issue this bill!"]);
                exit;
            }

            if ($details['paymethod'] !== NULL) {
                http_response_code(403);
                echo json_encode(["error" => "Forbidden! You are not allowed to delete a paid bill!"]);
                exit;
            }

            $totalPrice = $cashier->calculateTotalPrice($input['invoice_no']);

            if ($cashier->issueBill($input['invoice_no'], $totalPrice, $input['pay_method'])) {
                http_response_code(200);
                echo json_encode(["message" => "Bill issued successfully!", "invoice_no" => $input['invoice_no'], "total_price" => $totalPrice, "paymethod" => $input['paymethod']]);
            } else {
                http_response_code(500);
                echo json_encode(["error" => "Failed to issue bill!"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Bad Request! Invoice number and payment method are required."]);
        }
        break;
    
    case 'DELETE':
        require '../cashier/cashier.php';
        $input = json_decode(file_get_contents("php://input"), true);

        if (isset($input['invoice_no'])) {
            $invoiceno = $input['invoice_no'];

            $details = $cashier->displayBill($invoiceno);

            if (!$details) {
                http_response_code(404);
                echo json_encode(["error" => "Bill not found!"]);
                exit;
            }

            if ($details['cashier'] !== 4) {
                http_response_code(403);
                echo json_encode(["error" => "Forbidden! You are not allowed to delete this bill!"]);
                exit;
            }

            if ($details['paymethod'] !== NULL) {
                http_response_code(403);
                echo json_encode(["error" => "Forbidden! You are not allowed to delete a paid bill!"]);
                exit;
            }

            $result = $cashier->discardBill($invoiceno);
            if ($result) {
                http_response_code(200);
                echo json_encode(["message" => "Bill Discarded successfully!"]);
            } else {
                http_response_code(500);
                echo json_encode(["error" => "Failed to delete bill!"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Bad Request! Invoice number is required."]);
        }
        break;
    
    default:
        http_response_code(400);
        echo json_encode(["error" => "Bad Request! Requested Method: $method Not Allowed!"]);
        break;
}


?>