<?php
    session_start();
    include 'config.php';

    if(!empty($_GET['id'])){
        $query_product = mysqli_query($conn, "SELECT * FROM sp_product WHERE id='{$_GET['id']}'");
        $result = mysqli_fetch_assoc($query_product);
        @unlink('IphoneImg/' . $result['img']);

        $query = mysqli_query($conn,"DELETE FROM sp_product WHERE id='{$_GET['id']}'")or die('query failed');
        mysqli_close($conn);

        if($query){
            $_SESSION['message'] = 'Product Deleted successfully';
            header('Location: /admin.php'); 
        }else{
            $_SESSION['message'] = 'Product could not be deleted!';
            header('Location: /admin.php'); 
        }
    }
?>