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