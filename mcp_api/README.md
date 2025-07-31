# Extra MCP Module 

>**Please don't merge this branch with the main branch.**

This module is not part of the full project and is used to try integration of the app with a third-party LLM, using Model Context Protol. The MCP Server is on a separate repository, you can open it here: [MCP Server](https://github.com/AllanSJoseph/InventorySystem_MCP_Server).

## API Endpoints

| Endpoint       | Request Method Allowed        |
|----------------|-------------------------------|
| `/users`       | GET, POST                     |
| `/inventory`   | GET, POST, PUT, PATCH         |
| `/bills`       | GET, POST, PUT, DELETE        |
| `/billarchive` | GET, POST, PUT, PATCH, DELETE |

Each endpoint allows you to perform CRUD operations on the respective resources depending on the request method used.

### Usage

#### Endpoint: ```/users```

| Request Method | Description                 |
| -------------- |-----------------------------|
| GET            | Retrieve the list of users. |      
| POST           | Create a new user.          |      

#### Endpoint: ```/inventory```

| Request Method | Description                                 |
| -------------- |---------------------------------------------|
| GET            | Retrieve inventory items.                   |
| POST           | Add a new inventory item.                   |
| PUT            | Update all details of an inventory item.    |
| PATCH          | Update Only the stock of an inventory item. |

#### Endpoint: ```/bills```

| Request Method | Description                       |
| -------------- |-----------------------------------|
| GET            | Retrieve a list of bills.         |
| POST           | Filter bills by cashier_id.       |
| PATCH          | Update fields of a bill.          |
| DELETE         | Remove a bill.                    |

#### Endpoint: ```/billarchive```


| Request Method | Description                                                                                                 |
| -------------- |-------------------------------------------------------------------------------------------------------------|
| GET            | Retrieve items inside a bill by its invoice no. <br> **Note:** Use url ```/billarchive/{invoice_no}``` url. |
| POST           | Create a new bill and add items to it.                                                                      |
| PUT            | Add a new Item to the bill.                                                                                 |
| PATCH          | Update quantity of an item in a bill.                                                                       |
| DELETE         | Remove an item from a bill.                                                                                 |