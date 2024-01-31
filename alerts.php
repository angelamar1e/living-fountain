<?php
function alert_redirect($message,$path){
    echo '<script>
            alert("'.$message.'");
            window.location.replace("'.$path.'");
        </script>';
}

function refresh(){
    echo '<script>
            window.location.href = window.location.href;
        </script>';
}

function reset_url(){
    echo '<script>
            history.pushState(null, "", window.location.pathname);
        </script>';
}
?>