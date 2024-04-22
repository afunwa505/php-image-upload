<?php
// DELETE IMAGE WHEN DELETE BUTTON IS CLICKED
    include "connect.php";
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $sql = "DELETE FROM images WHERE id = $id ";
        $delete = mysqli_query($conn, $sql);
        if(!$delete){
            die("failed");
            
        }
        
        header("location:upload.php");
    }
?>