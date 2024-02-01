function sendData() {
    var blk = document.getElementById("blk").value;
    var lot = document.getElementById("lot").value;
    var ph = document.getElementById("ph").value;

    $.ajax({
        url: "add_order.php",
        type: "POST",
        data: { 
            blk: blk,
            lot: lot,
            ph: ph}
    });
}

// for the dateForm
document.getElementById('date').addEventListener('change', function() {
    // Trigger form submission when input value changes
    document.getElementById('dateForm').submit();
});


// for real-time status update
// Select all select elements with the class "status"
var selects = document.querySelectorAll(".status");

// Add event listeners to all select elements
selects.forEach(function(select) {
    select.addEventListener("change", function() {
        // Submit the corresponding form when the select value changes
        this.closest("form").submit();
    });
});

// handles confirmation of delete actions and encodes the url with primary key value of the record to be deleted
function confirm_delete_order(id){
    if(confirm('Are you sure you want to delete this order?')){
        bool = true;
        var order = '' + id;
        window.location.href='sales.php?id='+order+'&delete='+bool;
    }
}

