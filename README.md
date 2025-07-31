# INVENTORY MANAGEMENT SYSTEM (With MCP Support)

> This Branch contains the mcp module. Changes are on mcp_api folder. Check out the MCP Server repository [InventorySystemMCP](https://github.com/AllanSJoseph/InventorySystem_MCP_Server)

>**Please don't merge this branch with the main branch.**

Inventory Management System is a web based application made to track and manage product storage efficiently, preventing overstocking or stockouts.

It offers features like stock forecasting and detailed reporting, reducing manual errors and ensuring optimal stock levels.

This system also provides a built in Billing System for updating stock when products are purchased.

This project is made by me and my friends Rajnish Kumar, Neha. A. Pillai and Devika .R for our college Software Engineering miniproject conducted on our Fifth Semester.

<h2>Technologies Used</h2>

<table align="center">
  <tr>
    <td align="center" width="96">
      <img src="https://skillicons.dev/icons?i=html" width="48" height="48" alt="HTML" />
      <br>HTML
    </td>
    <td align="center" width="96">
      <img src="https://skillicons.dev/icons?i=css" width="48" height="48" alt="CSS" />
      <br>CSS
    </td>
    <td align="center" width="96">
      <img src="https://skillicons.dev/icons?i=js" width="48" height="48" alt="JS" />
      <br>JavaScript
    </td>
    <td align="center" width="96">
      <img src="https://skillicons.dev/icons?i=php" width="48" height="48" alt="PHP" />
      <br>PHP
    </td>
    <td align="center" width="96">
      <img src="https://skillicons.dev/icons?i=mysql" width="48" height="48" alt="MySQL" />
      <br>MySQL
    </td>
  </tr>
  <tr>
    <td align="center" colspan=3>Frontend</td>
    <td align="center" colspan=2>Backend</td>
  </tr>
</table>


<h2>Project Overview</h2>

<h3>Core Features</h3>

<ul>
    <li>
    <b>Inventory Tracking and Management 📦</b>
    <br>
    Realtime Inventory Tracking and tracking outgoing items and a panel to update the stock of incoming items.
    </li>
    <li>
    <b>Billing System 💵</b>
    <br>
    A billing system to create and manage invoices which syncs with the stock entries and updates it accordingly.
    </li>
    <li>
    <b>Secure 🪪</b>
    <br>
    Passwords are hashed when stored in the database.
    </li>
    <li>
    <b>Admin Panel 👤</b>
    <br>
    A panel for the admin for overseeing the users, stock and the invoices generated.
    </li>
</ul>

<h3>Implementation</h3>

<h4>Tables Used</h4>
<ul>
  <li><b>Users: </b>Stores the records of the user.</li>
  <li><b>Products: </b>Records the products and thier stock.</li>
  <li><b>Bills: </b>Records the bills generated.</li>
  <li><b>Bill_Archive: </b>Storage of contents of each bill.</li>
</ul>

<h4>Types of Users and their roles</h4>
<ul>
  <li><b>Admin: </b>Oversees the stock and bills, have highet authority, can create new users and assign their roles.</li>
  <li><b>Stocker: </b>Enter the incoming stocks and products.</li>
  <li><b>Cashier: </b>Creates bills which records the outgoing products.</li>
</ul>

## Shoutouts

Shoutout to my friend <a href="https://github.com/Rajnishtheone">Rajnish Kumar</a> for his contribution on the frontend and styling of this project. You may not see his contribution on the history of this repo since he done most of the work on my laptop and the commits were from my account, as we aren't that experienced with git at that time. 

Also shoutout to Neha A Pillai and Devika R for the documentation and presentaion on class.