<?php
function alert_redirect($message,$path){
    echo '<script>
            alert("'.$message.'");
            window.location.replace("'.$path.'");
        </script>';
}

function redirect(){
    echo '<script>
            history.pushState(null, "", window.location.pathname);
        </script>';
}
?>