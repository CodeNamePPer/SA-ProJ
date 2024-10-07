<?php
    session_start();
    
    // เชื่อมต่อกับฐานข้อมูล programing_world
    $connect_programing_world = new mysqli("localhost", "root", "", "programing_world");
    if ($connect_programing_world->connect_error) {
        die("Connection failed: " . $connect_programing_world->connect_error);
    }

    // เชื่อมต่อกับฐานข้อมูล shoping
    $connect_shoping = new mysqli("localhost", "root", "", "shoping");
    if ($connect_shoping->connect_error) {
        die("Connection failed: " . $connect_shoping->connect_error);
    }

    // ตรวจสอบการเข้าสู่ระบบ
    if (!isset($_SESSION['id_account']) || $_SESSION['role_account'] != 'member') {
        die(header('Location: Login.php'));
    } elseif (isset($_GET['logout'])) {
        session_destroy();
        die(header('Location: Login.php'));
    } else {
        // ดึง id_account จาก session
        $id_account = $_SESSION['id_account'];

        // ดึงข้อมูลผู้ใช้จากฐานข้อมูล programing_world
        $query_user = "SELECT * FROM account WHERE id_account = '$id_account'";
        $call_back_user = mysqli_query($connect_programing_world, $query_user);
        $result_user = mysqli_fetch_assoc($call_back_user);

        // ตรวจสอบว่าพบข้อมูลผู้ใช้หรือไม่
        if (!$result_user) {
            die("No user found.");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <link rel="stylesheet" href="Account.css">
</head>
<body>
    <img src="Picture\logo-kab-phone-black.png" class="logonav" width="100px">

    <div class="nav-profile">
        <p class="nav-profile-name">Member Page</p>
    </div>

    <h1>Edit Member Page: <?php echo $result_user['user_account']; ?>
    <form action="update_account.php" method="POST">
        <label>Username:</label>
        <input type="text" name="user_account" value="<?php echo htmlspecialchars($result_user['user_account']); ?>" required><br>

        <label>Email:</label>
        <input type="email" name="email_account" value="<?php echo htmlspecialchars($result_user['email_account']); ?>" required><br>

        <label>Phone:</label>
        <input type="text" name="phone_account" value="<?php echo htmlspecialchars($result_user['phone_account']); ?>" required><br>

        <label>Address:</label>
        <input type="text" name="address_account" value="<?php echo htmlspecialchars($result_user['address_account']); ?>" required><br>

        <input type="hidden" name="account_id" value="<?php echo $result_user['id_account']; ?>">
        <button class="ButtonLG" type="submit">Update</button>
    </form>
    <a class="ButtonLG" href="member.php" >Back</a>
    </h1>
    
    <div class="order">
        <h2>Your Order</h2>

        <?php
            // ดึงข้อมูลการสั่งซื้อโดยใช้ id_account
            $query_orders = "SELECT * FROM sp_transaction WHERE id_account = '$id_account' ORDER BY updated_at DESC";
            $call_back_orders = mysqli_query($connect_shoping, $query_orders);

            // ตรวจสอบว่ามีคำสั่งซื้อหรือไม่
            if (mysqli_num_rows($call_back_orders) > 0) {
                // แสดงข้อมูลการสั่งซื้อ
                while ($order = mysqli_fetch_assoc($call_back_orders)) {
                    echo "Transaction ID: " . $order['transid'] . "<br>";
                    echo "Order List: " . $order['orderlist'] . "<br>";
                    echo "Amount: " . $order['amount'] . "<br>";
                    echo "Shipping: " . $order['shipping'] . "<br>";
                    echo "Status: " . $order['operation'] . "<br>";
                    echo "Order Date: " . date("Y-m-d H:i:s", $order['mil']/1000) . "<br><br>";
                }
            } else {
                echo "No orders found.";
            }
        ?>
    </div>
</body>
</html>
