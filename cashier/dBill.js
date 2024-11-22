// JS file that contains the frontend functions of display_bills.php

function viewBill(invoiceno){
    window.open(`view_bill.php?invoiceno=${invoiceno}`,"_blank");
}

function editBill(invoiceno){
    window.open(`draft_bill.php?invoiceno=${invoiceno}`,"_blank");
}


function discardBill(invoiceno) {
    if (confirm("Are you sure you want to delete this bill?")) {
        const xhr = new XMLHttpRequest();
        xhr.open('GET',`discard_bill.php?invoiceno=${invoiceno}&ajxr=1`);

        xhr.onload = function () {
            if(xhr.responseText == "success"){
                alert('Bill Discarded Successfully!');
                window.location = "display_bills.php";
            }else{
                alert('Cannot Discard Bill! Please try again later...');
            }
        }

        xhr.send();
    }
}