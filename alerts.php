<!-- sends a popup alert and redirects to a page -->
<?php
function alert_redirect($message,$path){
    echo '<script>
            alert("'.$message.'");
            window.location.replace("'.$path.'");
        </script>';
}

// refreshes to the same page
function refresh(){
    echo '<script>
            window.location.href = window.location.href;
        </script>';
}

// resets url, removing query strings
function reset_url(){
    echo '<script>
            history.pushState(null, "", window.location.pathname);
        </script>';
}
?>