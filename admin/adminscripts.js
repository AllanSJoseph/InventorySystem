

function validate(){
    let name = nameField.value;
    let email = emailField.value;
    let mob = mobField.value;
    let address = addressField.value;
    let password = passField.value;
    let confpassword = confPassField.value;

    if (name === '' || email === '' || mob === '' || address === '' || password === '' || confpassword === '') {
        alert('Please fill in all fields.');
        return false;
    }

    if (password !== confpassword) {
        alert('Passwords do not match.');
        return false;
    }

    return true;
}

function checkUser(){

}

function viewBill(invoiceno){
    window.open(`view_bill.php?invoiceno=${invoiceno}`,"_blank");
}

function OpenEditModal(){
    document.getElementById('editUModal').style.display =  'block';
}

function closeEditModal(){
    document.getElementById('editUModal').style.display =  'none';
}

function editUser(userid){
    const xhr = new XMLHttpRequest();
    xhr.open("GET", `fetch_user_details.php?userid=${userid}`, true);

    xhr.onload = function () {
        if(xhr.status === 200){
            console.log(xhr.responseText);
            const data = JSON.parse(xhr.responseText);

            if (data.status === "1" && data.details) {
                document.getElementById("uid").value = data.details.userid;
                document.getElementById("uname").value = data.details.username;
                document.getElementById("editEmail").value = data.details.email;
                document.getElementById("editPhone").value = data.details.phone;
                document.getElementById("editAddress").value = data.details.address;

                document.getElementById("editUModal").style.display = "block";
            } else {
                alert(data.message || "Failed to load user details.");
            }
        }
    }

    xhr.send();
    OpenEditModal();
}

function saveUser(){
    if (confirm("Are you sure you want to edit the details of this user?")){
        const uid = document.getElementById("uid").value;
        const newUname = document.getElementById("uname").value;
        const newEmail = document.getElementById("editEmail").value;
        const newPhone = document.getElementById("editPhone").value;
        const newAddress = document.getElementById("editAddress").value;

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "edit_user.php", true);
        xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");

        xhr.onreadystatechange = function () {
            if(xhr.readyState === 4 && xhr.status === 200){
                const response = JSON.parse(xhr.responseText);

                if (response.status === "1") {
                    alert(response.message || "User details updated successfully.");
                    closeEditModal();
                } else {
                    alert(response.message || "Failed to update user details.");
                }
            }
        }

        const params = `uid=${encodeURIComponent(uid)}&username=${encodeURIComponent(newUname)}&email=${encodeURIComponent(newEmail)}&phone=${encodeURIComponent(newPhone)}&address=${encodeURIComponent(newAddress)}`;
        xhr.send(params);
    }
}

function deleteUser(userid){
    if(confirm('Are you sure you want to delete this user?')){
        const xhr = new XMLHttpRequest();
        xhr.open("GET", `delete_user.php?userid=${userid}`, true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                if (xhr.responseText === "success") {
                    alert("User Removed Succesfully!");
                    window.location = "display_user.php";
                } else {
                    alert("Error: " + xhr.responseText);
                }
            }
        }

        xhr.send();
    }
}