function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
    document.getElementById('errPrice').style.display = 'none';
    document.getElementById('errStock').style.display = 'none';
    document.getElementById('errrStock').style.display = 'none';
}

function closeEditStockModal() {
    document.getElementById('editStockModal').style.display = 'none';
    document.getElementById('errStock').style.display = 'none';
    document.getElementById('errrStock').style.display = 'none';
}

function editProduct(pid) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'fetchProductDetails.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (xhr.status === 200) {
            const product = JSON.parse(xhr.responseText);

            document.getElementById('prodid').value = product.prodid;
            document.getElementById('editName').value = product.name;
            document.getElementById('editPrice').value = product.price;
            document.getElementById('editStock').value = product.stock;
            document.getElementById('editDescription').value = product.description;

            document.getElementById('editModal').style.display = 'block';
        } else {
            alert('Failed to fetch product details.');
        }
    };

    xhr.send('pid=' + pid);
}

function editStock(pid){
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'fetchProductDetails.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    
    xhr.onload = function() {
        if (xhr.status === 200) {
            const product = JSON.parse(xhr.responseText);

            document.getElementById('spid').value = pid;
            document.getElementById('pname').innerHTML = product.name;
            document.getElementById('editStockk').value = product.stock;
    
            document.getElementById('editStockModal').style.display = 'block';
        } else {
            alert('Failed to fetch product details.');
        }
    };
    
    xhr.send('pid=' + pid);
}

function saveProduct(){
    let prodid =  document.getElementById('prodid').value;
    let newName = document.getElementById('editName').value;
    let newPrice = document.getElementById('editPrice').value;
    let newStock = document.getElementById('editStock').value;
    let newDescription = document.getElementById('editDescription').value;

    if(newName === "" || newPrice === "" || newStock === "" || newDescription === ""){
        alert('Please fill out all the fields');
        return false;
    }

    if(checkQty(newStock)){
        alert('Stock cannot have value 0 or negative');
        return false;
    }

    if(checkPrice(newPrice)){
        alert('Price cannot have value 0 or negative');
        return false;
    }

    if(confirm('Are you sure you want to make changes to this product?')){
       const xhr = new XMLHttpRequest();
        xhr.open('POST', 'updateItem.php',true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        xhr.onload = function() {
            if(xhr.status === 200){
                if (xhr.responseText === "success") {
                    alert("Product Details updated successfully!");
                    closeEditModal();
                    location.replace(location.href);
                } else {
                    alert("Failed to update Product Details.");
                }
            }else{
                alert('Failed to Update Product Details, cannot connect to server.');
            }
        };

        xhr.send(`pid=${prodid}&name=${newName}&price=${newPrice}&stock=${newStock}&description=${newDescription}`); 
    }
}


function saveProductStock() {
    const pid = document.getElementById('spid').value;
    const stock = document.getElementById('editStockk').value;

    if(stock === ""){
        alert("Please fill out the required Field...");
        return false;
    }

    if(checkQty(stock)){
        alert('Stock cannot have value 0 or negative');
        return false;
    }

    if(confirm('Are you sure, you want to update the stock of this product?')){
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'updateProductStock.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        xhr.onload = function() {
            if (xhr.status === 200) {
                if (xhr.responseText === "success"){
                    alert('Stock updated successfully!');
                    closeEditStockModal();
                    location.replace(location.href);
                }else {
                    alert('Failed to Update Stock.');
                }
                
            } else {
                alert('Failed to update stock.');
            }
        };

        xhr.send(`pid=${pid}&stock=${stock}`);  
    }
    
}

function deleteProduct(pid){
    const confirmDelete = confirm("Are you sure you want to delete this product?");
    if (!confirmDelete) return;

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'deleteProduct.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (xhr.status === 200) {
            if (xhr.responseText === "success") {
                alert("Product deleted successfully!");
                location.replace(location.href);
            } else {
                alert("Failed to delete product: " + xhr.responseText);
            }
        } else {
            alert("An error occurred while deleting the product.");
        }
    };

    xhr.send('pid=' + pid);
}

function checkQty(qty){
    if(qty <= 0){
        document.getElementById('errStock').style.display = 'block';
        document.getElementById('errrStock').style.display = 'block';
        return true;
    }else{
        document.getElementById('errStock').style.display = 'none';
        document.getElementById('errrStock').style.display = 'none';
        return false;
    }
}

function checkPrice(price){
    if(price <= 0){
        document.getElementById('errPrice').style.display = 'block';
        return true;
    }else{
        document.getElementById('errPrice').style.display = 'none';
        return false;
    }
}

function validate(){
    const pname = document.getElementById('pname').value;
    const price = document.getElementById('price').value;
    const stock = document.getElementById('stock').value;
    const description = document.getElementById('description').value;

    if(pname === "" || price === "" || stock === "" || description === ""){
        alert('Please fill out all the fields');
        return false;
    }

    if(checkQty(stock)){
        console.log('if stock statement called...');
        alert('Stock cannot have value 0 or negative');
        return false;
    }

    if(checkPrice(price)){
        alert('Price cannot have value 0 or negative');
        return false;
    }

    return true;
}
