
# Testing API Endpoints

For testing using Postman is recommended. Below are the request headers and body formats for each endpoint.

## Request Headers

```plaintext
AUTH_KEY:Bearer default-token
Content-Type:application/json
```

> You can give any value for `AUTH_KEY` as it is given for namesake. Actually a reverse proxy is used to handle the request headers and protect the server but such a server is not yet implemented.

## Request Body Format

### For `/users` Endpoint

#### POST Request Body
```json
{
    "username": "your_username",
    "password": "your_password",
    "email": "your_email",
    "phone": "your_phone_number_in_int",
    "address": "your_address",
    "type": "type_of_user"
}
```
> Type must be either Admin, Stocker or Cashier.

### For `/inventory` Endpoint


#### POST Request Body
```json
{
    "name": "product_name",
    "price": "price_of_product_in_int",
    "stock": "stock_quantity_in_int",
    "description": "Description of the product."
}
```

#### PUT Request Body
```json
{
    "prod_id": "id_of_product_in_int",
    "name": "updated_product_name",
    "price": "price_of_product_in_int",
    "stock": "stock_quantity_in_int",
    "description": "Updated description of the product."
}
```

#### PATCH Request Body
```json
{
    "prod_id": "id_of_product_in_int",
    "new_stock": "stock_quantity_in_int"
}
```

### For `/bills` Endpoint

#### POST Request Body
```json
{
    "cashier_id": "cashier_user_id",
}
```

#### PATCH Request Body
```json
{
    "invoice_no": "invoice_number_of_the_bill",
    "pay_method": "payment_method",
}
```
> Payment method can be either CASH, CARD or UPI.


#### DELETE Request Body
```json
{
    "invoice_no": "invoice_number_of_the_bill"
}
```

### For `/billarchive` Endpoint

#### POST Request Body
```json
{
    "products": [
        {
            "prod_id": "product_id_1",
            "quantity": "quantity_of_product_1"
        },
        {
            "prod_id": "product_id_2",
            "quantity": "quantity_of_product_2"
        }
    ]
}
```

#### PUT Request Body
```json
{
    "invoice_no": "invoice_number_of_the_bill",
    "prod_id": "product_id_to_add",
    "quantity": "quantity_of_product_to_add"
}
```

#### PATCH Request Body
```json
{
    "invoice_no": "invoice_number_of_the_bill",
    "prod_id": "product_id_to_update",
    "new_quantity": "new_quantity_value"
}
```

#### DELETE Request Body
```json
{
    "invoice_no": "invoice_number_of_the_bill",
    "prod_id": "product_id_to_remove"
}
```