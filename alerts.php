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

// handles alert for deletion of order, depending on result
function delete_alerts($result){
    if ($result){
        echo '<script>
                    alert("Transaction deleted successfully.");
                    window.location.replace("sales.php");
                </script>';
    }
    else{
        echo '<script>
                    alert("Error: '.mysqli_error($conn).'");
                    window.location.replace("sales.php");
                </script>';
    }
}
?>