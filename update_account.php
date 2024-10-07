<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับค่าจากฟอร์ม
    $user_account = $_POST['user_account'];
    $email_account = $_POST['email_account'];
    $phone_account = $_POST['phone_account'];
    $address_account = $_POST['address_account'];
    $id_account = $_POST['account_id'];

    // ตรวจสอบความถูกต้องของข้อมูลที่รับมา (optional)
    if (!filter_var($email_account, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
        exit;
    }

    // เชื่อมต่อฐานข้อมูล
    $conn = new mysqli('localhost', 'root', '', 'programing_world');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // เตรียมคำสั่ง SQL เพื่ออัปเดตข้อมูล
    $sql = "UPDATE account SET 
                user_account = ?, 
                email_account = ?, 
                phone_account = ?, 
                address_account = ? 
            WHERE id_account = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $user_account, $email_account, $phone_account, $address_account, $id_account);

    // ดำเนินการอัปเดตข้อมูล
    if ($stmt->execute()) {
        // หลังจากอัปเดตเสร็จสิ้นให้รีเฟรชหน้า
        header("Location: Account.php"); 
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }

    // ปิดการเชื่อมต่อ
    $stmt->close();
    $conn->close();
}
?>
