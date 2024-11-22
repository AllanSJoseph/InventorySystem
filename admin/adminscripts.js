function validate(){
    
}

function checkUser(){

}

function viewBill(invoiceno){
    window.open(`view_bill.php?invoiceno=${invoiceno}`,"_blank");
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