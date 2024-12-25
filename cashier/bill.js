
const invoiceno = document.getElementById('invNo');
const prodId = document.getElementById('prodid');
const prodName = document.getElementById('prodname');
const quantity = document.getElementById('quantity');
const price = document.getElementById('price');
const tprice = document.getElementById('tprice');
const dialog = document.getElementById('status');
let sno = 2;

prodId.oninput = () =>{
    if (prodId.value) {
        const xhr = new XMLHttpRequest();
        xhr.open("GET", `./billFunctions/getProduct.php?prodid=${prodId.value}`, true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                console.log(xhr.responseText);
                const product = JSON.parse(xhr.responseText);
                if (product) {
                    prodName.value = product.name;
                    price.value = product.price;
                    dialog.innerHTML = "";
                    updateTotalPrice();
                } else {
                    dialog.innerHTML = "Product not found!";
                }
            }
        };
        xhr.send();
    }
}

function updateTotalPrice() {
    checkQty(quantity.value);
    checkStock(quantity.value,prodId.value, function(result) {
        if (result) {
            return true;
        }else {
            return false;
        }
    });
    const totalPrice = price.value * quantity.value;
    tprice.value = totalPrice;
}

function updateTable() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', `./billFunctions/fetchBillData.php?invoiceNo=${invoiceno.value}`, true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            console.log(xhr.responseText);
            const data = JSON.parse(xhr.responseText);
            const tableBody = document.getElementById('billBody');
            
            
            tableBody.innerHTML = '';

           
            data.forEach((item, index) => {
                const row = document.createElement('tr');
                row.setAttribute('id',item.prodid);

                const snoCell = document.createElement('td');
                snoCell.textContent = index + 1;
                row.appendChild(snoCell);

                const prodIdCell = document.createElement('td');
                prodIdCell.textContent = item.prodid;
                row.appendChild(prodIdCell);

                const prodNameCell = document.createElement('td');
                prodNameCell.textContent = item.name;
                row.appendChild(prodNameCell);

                const priceCell = document.createElement('td');
                priceCell.textContent = item.price;
                row.appendChild(priceCell);

                const quantityCell = document.createElement('td');
                quantityCell.textContent = item.qty;
                row.appendChild(quantityCell);

                const totalPriceCell = document.createElement('td');
                totalPriceCell.textContent = item.tprice;
                row.appendChild(totalPriceCell);

                // Edit button
                const editCell = document.createElement('td');
                const editButton = document.createElement('button');
                editButton.textContent = 'Edit Quantity';
                editButton.onclick = function() {
                    openEditModal(item.invoiceno,item.prodid, item.price, item.qty);
                };
                editCell.appendChild(editButton);
                row.appendChild(editCell);

                // Delete button
                // const deleteCell = document.createElement('td');
                const deleteButton = document.createElement('button');
                deleteButton.textContent = 'Delete';
                deleteButton.onclick = function() {
                    deleteEntry(item.invoiceno,item.prodid);
                };
                editCell.appendChild(deleteButton);
                row.appendChild(editCell);

                tableBody.appendChild(row);
            });
        } else {
            alert('Failed to retrieve data.');
        }
    };

    xhr.send();
}


function addEntry() {

    if (!prodId.value || !prodName.value || !price.value || !quantity.value) {
        alert("Please fill in all the fields.");
        return;
    }

    if(checkQty(quantity.value)){
        alert('Stock cannot have value 0 or negative');
        return false;
    }

    checkStock(quantity.value,prodId.value, function(result) {
        if (result) {
            alert('Error! Cannot add Item to bill! Quantity higher than Inventory Quantity...');
            return false;
        }else{
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "./billFunctions/addToBill.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            xhr.onload = function () {
                if (xhr.status === 200) {
                    if (xhr.responseText === "success") {
                        alert("Product Added Successfully");
                        updateTable();
                        document.getElementById("productForm").reset();
                    } else {
                        alert("Error: " + xhr.responseText);
                    }
                }
            };

            xhr.send(`invoiceno=${invoiceno.value}&prodid=${prodId.value}&prodname=${prodName.value}&price=${price.value}&quantity=${quantity.value}&totalPrice=${tprice.value}`);
        }
    });
}


//For Editing Quantity Functionality

function openEditModal(invno, prodid, price, currentQuantity) {
    document.getElementById("editInvoiceNo").value = invno;
    document.getElementById("editProdId").value = prodid;
    document.getElementById("editPrice").value = price;
    document.getElementById("editQuantity").value = currentQuantity;
    document.getElementById("editModal").style.display = "block";
}

function closeEditModal() {
    document.getElementById("editModal").style.display = "none";
}

function saveQuantity() {
    const itemInvoiceNo = document.getElementById("editInvoiceNo").value;
    const itemProdId = document.getElementById("editProdId").value;
    const itemPrice = document.getElementById("editPrice").value;
    const newQuantity = document.getElementById("editQuantity").value;

    if(checkQty(newQuantity)){
        alert('Stock cannot have value 0 or negative');
        document.getElementById('errQty').style.display = 'none';
        return false;
    }

    checkStock(newQuantity,itemProdId, function(result) {
        if (result) {
            alert('Error! Cannot add Item to bill! Quantity higher than Inventory Quantity...');
            return false;
        }else{
            const xhr = new XMLHttpRequest();
            xhr.open('POST', './billFunctions/updateQuantity.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhr.onload = function () {
                if (xhr.status === 200) {
                    if (xhr.responseText === "success") {
                        alert("Quantity updated successfully!");
                        closeEditModal();
                        updateTable(); 
                    } else {
                        alert("Failed to update quantity.");
                    }
                }
            };

            xhr.send(`invoiceno=${itemInvoiceNo}&prodid=${itemProdId}&price=${itemPrice}&quantity=${newQuantity}`);
        }
    });    
}


function deleteEntry(invNo,pid) {
    console.log(invNo);
    console.log(pid);
    if (confirm("Are you sure you want to delete this entry?")) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', './billFunctions/deleteEntry.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        xhr.onload = function () {
            if (xhr.status === 200) {
                if (xhr.responseText === "success") {
                    alert("Entry deleted successfully!")
                    updateTable();
                } else {
                    console.log(xhr.responseText);
                    alert("Failed to delete bill Entry.");
                }
            }
        };

        xhr.send(`invoiceno=${invNo}&prodid=${pid}`);
    }
}


function discardBill() {
    if (confirm("Are you sure you want to discard this bill?")) {
        window.location = "discard_bill.php?invoiceno="+invoiceno.value;
    }
}

function openPaymentModel(){
    document.getElementById("paymentModal").style.display = "block";
}

function closePaymentModel(){
    document.getElementById("paymentModal").style.display = "none";
}

function issueBill(){
    const paymentM = document.getElementById("payment").value;
    closePaymentModel();

    const xhr = new XMLHttpRequest();
    xhr.open('GET',`issue_bill.php?invoiceno=${invoiceno.value}&payment=${paymentM}`,true);
    
    xhr.onload = function() {
        if(xhr.status == 200){
            console.log(xhr.responseText);
            const result = JSON.parse(xhr.responseText);

            if(result.status === "error"){
                if(result.discrepancies){
                    alert('Error! Cannot Issue Bill! Quantity higher than Inventory Quantity...');
                    result.discrepancies.forEach((item) => {
                        const markid = item.prodid;
                        document.getElementById(markid).style.color = "red";
                    });
                    
                }else{
                    alert('Error! Something Went Wrong... Please Try again later');
                }
            }else if(result.status === "success"){
                alert('Bill Issued Successfully! Consider to share my greetings to the Customer :)');
                window.location = "cashier_home.php";
            }

        }
    }

    xhr.send();
}

function checkStock(qty,pid,callback){
    const xhr = new XMLHttpRequest();
    xhr.open('GET',`./billFunctions/checkQuantity.php?pid=${pid}&qty=${qty}`,true);

    xhr.onload = function() {
        if(xhr.status == 200){
            console.log(xhr.responseText);
            if(xhr.responseText === "Error"){
                document.getElementById('errStk').style.display = 'block';
                callback(true);
            }else{
                document.getElementById('errStk').style.display = 'none';
                callback(false);
            }
        }
    }

    xhr.send();
}

function checkQty(qty){
    if(qty <= 0){
        document.getElementById('errQty').style.display = 'block';
        return true;
    }else{
        document.getElementById('errQty').style.display = 'none';
        return false;
    }
}

function validateEditQuantity(){
    const eqty = document.getElementById('editQuantity').value;
    const epid = document.getElementById('editProdId').value;
    if(checkQty(eqty)){
        document.getElementById('errQty').style.display = 'none';
        document.getElementById('errrQty').style.display = 'block';
        return false;
    }else{
        document.getElementById('errrQty').style.display = 'none';
    }

    checkStock(eqty,epid, function(result) {
        if (result) {
            document.getElementById('errStk').style.display = 'none';
            document.getElementById('errrStk').style.display = 'block';
            return false;
        }else{
            document.getElementById('errrStk').style.display = 'none';
            return true;
        }
    });    
}

window.onload = updateTable;