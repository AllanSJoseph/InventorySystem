<?php

// API that can read the items in the bill and perform operations on them

// require '../cashier/cashier.php';
require '../cashier/billFunctions/bill.php';


$method = $_SERVER['REQUEST_METHOD'];

function validateBill($invoiceno, $cashier_id){
    global $cashier;

    $details = $cashier->displayBill($invoiceno);

            if (!$details) {
                http_response_code(404);
                echo json_encode(["error" => "Bill not found!"]);
                exit;
            }

            if ($details['cashier'] !== $cashier_id) {
                http_response_code(403);
                echo json_encode(["error" => "Forbidden! You are not allowed to edit or delete this bill!"]);
                exit;
            }

            if ($details['paymethod'] !== NULL) {
                http_response_code(403);
                echo json_encode(["error" => "Forbidden! You are not allowed to edit or delete a paid bill!"]);
                exit;
            }
}

switch ($method) {
    // Get all items in the bill
    case 'GET':
        if (isset($_GET['invoice_no'])) {
            $invoiceno = $_GET['invoice_no'];
            $items = $bill->fetchBillData($invoiceno);
            if ($items) {
                http_response_code(200);
                echo json_encode(["requested_service" => "Fetch all items in the bill", "items" => $items]);
            } else {
                http_response_code(404);
                echo json_encode(["error" => "No items found for this invoice number."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Bad Request! Invoice number is required."]);
        }
        break;

    // Create Draft Bill
    case 'POST':
        $input = json_decode(file_get_contents("php://input"), true);
        
        if (isset($input['products'])) {
            $invoiceno = $cashier->generateDraftBill(4);
            if (!$invoiceno) {
                http_response_code(500);
                echo json_encode(["error" => "Failed to generate draft bill."]);
                exit;
            }

            // Find the length of the products array and create a count variable
            $payloadCount = count($input['products']);
            $insertedCount = 0;
            $didntInsert = [];

            foreach ($input['products'] as $product) {
                if (!isset($product['prod_id']) || !isset($product['quantity'])) {
                    http_response_code(400);
                    echo json_encode(["error" => "Bad Request! Product ID and quantity are required."]);
                    exit;
                }
                $productResult = $bill->returnProdDetails($product['prod_id']);
                $productdetails = $productResult ? $productResult->fetch_assoc() : null;
                if ($productdetails) {
                    $totalprice = $productdetails['price'] * $product['quantity'];
                    $result = $bill->addEntry($invoiceno, $product['prod_id'], $product['quantity'], $totalprice);
                    if ($result) {
                        $insertedCount++;
                    } else {
                        $didntInsert[] = [$product['prod_id'] => "Internal Server Error!"];
                    }
                }else {
                    $didntInsert[] = [$product['prod_id'] => "Product not found!"];
                }
            }

            if ($insertedCount == $payloadCount){
                http_response_code(201);
                echo json_encode(["message" => "All items added successfully!", "invoice_no" => $invoiceno]);
            } else {
                http_response_code(207); // Partial Content
                echo json_encode([
                    "message" => "Some items were not added successfully.",
                    "invoice_no" => $invoiceno,
                    "inserted_count" => $insertedCount,
                    "total_count" => $payloadCount,
                    "didnt_insert" => $didntInsert
                ]);
            }

        }else {
            http_response_code(400);
            echo json_encode(["error" => "Bad Request! Input Missing!"]);
        }
        break;

    case 'PUT':
        $input = json_decode(file_get_contents("php://input"), true);
        
        if (isset($input['invoice_no']) && isset($input['prod_id']) && isset($input['quantity'])) {
            $invoiceno = $input['invoice_no'];
            $prodid = $input['prod_id'];
            $quantity = $input['quantity'];

            validateBill($invoiceno, 4); // Validate the bill before updating

            $productResult = $bill->returnProdDetails($prodid);
            if ($productResult) {
                $productdetails = $productResult->fetch_assoc();
                if ($productdetails) {
                    $totalprice = $productdetails['price'] * $quantity;
                    if ($bill->addEntry($invoiceno, $prodid, $quantity, $totalprice)) {
                        http_response_code(200);
                        echo json_encode(["message" => "Item updated successfully."]);
                    } else {
                        http_response_code(500);
                        echo json_encode(["error" => "Failed to update item."]);
                    }
                } else {
                    http_response_code(404);
                    echo json_encode(["error" => "Product not found."]);
                }
            } else {
                http_response_code(404);
                echo json_encode(["error" => "Product not found."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Bad Request! Invoice number, product ID and quantity are required."]);
        }
        break;
    
    case 'PATCH':
        $input = json_decode(file_get_contents("php://input"), true);
        if (isset($input['invoice_no']) && isset($input['prod_id']) && isset($input['quantity'])) {
            $invoiceno = $input['invoice_no'];
            $prodid = $input['prod_id'];
            $quantity = $input['quantity'];

            validateBill($invoiceno, 4); // Validate the bill before updating

            $productResult = $bill->returnProdDetails($prodid);
            if ($productResult) {
                $productdetails = $productResult->fetch_assoc();
                if ($productdetails) {
                    if ($bill->editQuantity($invoiceno, $prodid, $productdetails['price'], $quantity)) {
                        http_response_code(200);
                        echo json_encode(["message" => "Item updated successfully."]);
                    } else {
                        http_response_code(500);
                        echo json_encode(["error" => "Failed to update item."]);
                    }
                } else {
                    http_response_code(404);
                    echo json_encode(["error" => "Product not found."]);
                }
            } else {
                http_response_code(404);
                echo json_encode(["error" => "Product not found."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Bad Request! Invoice number, product ID and quantity are required."]);
        }
        break;

    
    case 'DELETE':
        $input = json_decode(file_get_contents("php://input"), true);

        if (isset($input['invoice_no']) && isset($input['prod_id'])) {
            $invoiceno = $input['invoice_no'];
            $prodid = $input['prod_id'];

            validateBill($invoiceno, 4); // Validate the bill before deleting

            if ($bill->deleteEntry($invoiceno, $prodid)) {
                http_response_code(200);
                echo json_encode(["message" => "Item deleted successfully."]);
            } else {
                http_response_code(404);
                echo json_encode(["error" => "Item not found or could not be deleted."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Bad Request! Invoice number and product ID are required."]);
            exit;
        }
        break;

    default:
        http_response_code(400);
        echo json_encode(["error" => "Bad Request! Requested Method: $method Not Allowed!"]);
        break;
}



?>