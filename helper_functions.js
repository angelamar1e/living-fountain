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

document.getElementById('date').addEventListener('change', function() {
    // Trigger form submission when input value changes
    document.getElementById('dateForm').submit();
});

// Select all select elements with the class "status    "
var selects = document.querySelectorAll(".status");

// Add event listeners to all select elements
selects.forEach(function(select) {
    select.addEventListener("change", function() {
        // Submit the corresponding form when the select value changes
        this.closest("form").submit();
    });
});




