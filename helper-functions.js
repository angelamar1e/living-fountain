function sendData() {
    var blk = document.getElementById("blk").value;
    var lot = document.getElementById("lot").value;
    var ph = document.getElementById("ph").value;

    $.ajax({
        url: "add-order.php",
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
