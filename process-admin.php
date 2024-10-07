<?php
session_start();
include 'config.php';

    $name = mysqli_real_escape_string($conn, trim($_POST['product_insert_name']));
    $price = mysqli_real_escape_string($conn, trim($_POST['product_insert_price']));
    $description = mysqli_real_escape_string($conn, trim($_POST['product_insert_desc']));
    $type = mysqli_real_escape_string($conn, trim($_POST['product_insert_type']));

   
    $image_name = $_FILES['product_insert_file']['name'];
    $image_tmp = $_FILES['product_insert_file']['tmp_name'];
    $folder = 'IphoneImg/';
    $image_location = $folder . $image_name;

    if (move_uploaded_file($image_tmp, $image_location)){
        $query = mysqli_query($conn, "INSERT INTO sp_product (name, img, price, description, type) 
                                      VALUES ('$name', '$image_name', '$price', '$description', '$type')")
        or die('Query failed: ' . mysqli_error($conn));
        $_SESSION['message'] = 'Product saved successfully';
    header('Location: admin.php'); 
    exit();
    } else {

    $_SESSION['message'] = 'Product Save Failed';
    header('Location: admin.php');
    exit();
    }

?>

