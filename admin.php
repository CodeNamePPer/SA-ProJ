<?php
    session_start();
    $open_connect=1;
    require('connect.php');
    if(!isset($_SESSION['id_account']) || $_SESSION['role_account'] != 'admin'){
        die(header('Location: Login.php'));
    }elseif(isset($_GET['logout'])){
        session_destroy();
        die(header('Location: Login.php'));
    }else{
        $id_account = $_SESSION['id_account'];
        $query_show = "SELECT * FROM account WHERE id_account= '$id_account'";
        $call_back_show = mysqli_query($connect, $query_show);
        $result_show = mysqli_fetch_assoc($call_back_show);
        
    }

?>

<?php
    include 'config.php';
    $query = mysqli_query($conn,"SELECT * FROM sp_product");
    $rows = mysqli_num_rows($query);

    $transactionQuery = mysqli_query($conn,"SELECT * FROM sp_transaction");
    $transactionRows = mysqli_num_rows($transactionQuery);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="admin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script
  src="https://code.jquery.com/jquery-3.7.1.js"
  integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
  crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="admin.js"></script>
</head>

<body>
<div class="center-container">
        <h1>
            Welcome to Admin page: 
            <?php echo ($result_show['user_account']); ?>
        </h1>
        <br>
        <a  href="admin.php?logout=1" class="logout-btn">LogOut</a>
    </div>
    <div class="Insert-form-container">
    <form method="POST" class="container" enctype="multipart/form-data" action="process-admin.php">
        <h1 style="text-align: center;">Manage Product</h1>
        <div class="textheader">Input Product Name</div>
        <input name="product_insert_name" value="" type="text" placeholder="Product Name" required>
        <div class="textheader">Choose Image Product</div>
        <input name="product_insert_file" type="file" placeholder="Img" required>
        <div class="textheader">Create Price</div>
        <input name="product_insert_price" value="" type="number" placeholder="Price" required>
        <div class="textheader">Create Description</div>
        <textarea name="product_insert_desc" placeholder="Description" rows="5" cols="55" required></textarea>
        <div class="textheader">Create Type</div>
        <select name="product_insert_type" required>
            <option value="" disabled selected>Select Type</option>
            <option value="Gaming">Gaming</option>
            <option value="Work">Work</option>
            <option value="Entertainment">Entertainment</option>
        </select>
        <br>
        <input class="ButtonLG" type="submit" value="Create">
    </form>

    </div>
    
    

</div>
<div class="sidebar-container">
    <a onclick="searchproduct('Product')" class="sidebar-items">Product</a>
    <a onclick="searchproduct('Transaction')" class="sidebar-items">Transaction</a>
</div>

<!-- Product Table -->
<div id="productTable" class="row" style="display: none;">
    <div class="col-12">
        <table class="table table-bordered border-info">
            <thead>
                <tr>
                    <th style="width: 70px">ID</th>
                    <th style="width: 70px">Image</th>
                    <th style="width: 70px">Product Name</th>
                    <th style="width: 70px">Price</th>
                    <th style="width: 70px">Description</th>
                </tr>
            </thead>
            <tbody>
                <?php if($rows > 0): ?>
                    <?php while($product = mysqli_fetch_assoc($query)): ?>
                    <tr>
                        <td><?php echo $product['id']; ?></td>
                        <td><img src="IphoneImg/<?php echo($product['img']); ?>" alt="Product Image" width="200vw"></td>
                        <td><?php echo $product['name']; ?></td>
                        <td><?php echo $product['price']; ?></td>
                        <td><?php echo $product['description']; ?></td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5"><h4 class="text-center text-danger">No Products Found</h4></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Transaction Table -->
<div id="transactionTable" class="row" style="display: none;">
    <div class="col-12">
        <table class="table table-bordered border-info">
            <thead>
                <tr>
                    <th style="width: 70px">ID</th>
                    <th style="width: 70px">TransID</th>
                    <th style="width: 70px">Orderlist</th>
                    <th style="width: 70px">Amount</th>
                    <th style="width: 70px">Shipping</th>
                    <th style="width: 70px">operation</th>
                    <th style="width: 70px">mil</th>
                    <th style="width: 70px">Date At</th>
                    <th style="width: 70px">ID_Customer</th>
                </tr>
            </thead>
            <tbody>
                <?php if($rows > 0): ?>
                    <?php while($transaction = mysqli_fetch_assoc($transactionQuery)): ?>
                    <tr>
                        <td><?php echo $transaction['id']; ?></td>
                        <td><?php echo $transaction['transid']; ?></td>
                        <td><?php echo $transaction['orderlist']; ?></td>
                        <td><?php echo $transaction['amount']; ?></td>
                        <td><?php echo $transaction['shipping']; ?></td>
                        <td><?php echo $transaction['operation']; ?></td>
                        <td><?php echo $transaction['mil']; ?></td>
                        <td><?php echo $transaction['updated_at']; ?></td>
                        <td><?php echo $transaction['id_account']; ?></td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8"><h4 class="text-center text-danger">No Transactions Found</h4></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>

