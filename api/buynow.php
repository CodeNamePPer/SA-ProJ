<?php
    require_once('./db.php');
    session_start(); // เริ่ม session

    try {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $object = new stdClass();
            $amount = 0;
            $product = $_POST['product'];

            // ดึงข้อมูล id_account จาก session หรือ query จากตาราง programing_world
            $id_account = $_SESSION['id_account']; // สมมติว่าเก็บ id_account ใน session
            // หากไม่มีใน session สามารถใช้ query นี้แทนได้
            /*
            $stmt = $db->prepare('SELECT id FROM programing_world WHERE username = ?');
            $stmt->execute([$_SESSION['username']]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $id_account = $user['id'];
            */

            // Query ข้อมูลสินค้า
            $stmt = $db->prepare('SELECT id, price FROM sp_product ORDER BY id DESC');
            if ($stmt->execute()) {
                
                $queryproduct = array();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    $items = array(
                        "id" => $id,
                        "price" => $price
                    );
                    array_push($queryproduct, $items);
                }

                // คำนวณยอดรวมสินค้า
                for ($i = 0; $i < count($product); $i++) {
                    for ($k = 0; $k < count($queryproduct); $k++) { 
                        if (intval($product[$i]['id']) == intval($queryproduct[$k]['id'])) {
                            $amount += intval($product[$i]['count']) * intval($queryproduct[$k]['price']);
                            break;
                        } 
                    }
                }

                // คำนวณค่าส่งสินค้า
                $shipping = $amount * 0.1 + $amount;
                $transid = round(microtime(true) * 1000); // สร้าง transaction ID
                $product = json_encode($product);
                $mil = time() * 1000;
                $updated_at = date("Y-m-d h:i:sa");

                // Insert ข้อมูลการสั่งซื้อ (เพิ่ม id_account)
                $stmt = $db->prepare('INSERT INTO sp_transaction (transid, orderlist, amount, shipping, operation, mil, updated_at, id_account) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
                if ($stmt->execute([
                    $transid, $product, $amount, $shipping, 'PENDING', $mil, $updated_at, $id_account
                ])) {
                    // สำเร็จ
                    $object->RespCode = 200;
                    $object->RespMessage = 'success';
                    $object->Amount = new stdClass();
                    $object->Amount->Amount = $amount;
                    $object->Amount->Shipping = $shipping;

                    if ($object->RespCode == 200) {
                        // ลบข้อมูลตะกร้าจาก session
                        unset($_SESSION['cart']);
                    }
                } else {
                    // ล้มเหลวในการบันทึก transaction
                    $object->RespCode = 300;
                    $object->Log = 0;
                    $object->RespMessage = 'bad : insert transaction fail';
                    http_response_code(300);
                }
            } else {
                // ล้มเหลวในการดึงข้อมูลสินค้า
                $object->RespCode = 300;
                $object->Log = 1;
                $object->RespMessage = 'bad : cant get product';
                http_response_code(500);
            }

            echo json_encode($object);
            
        } else {
            http_response_code(405); // ไม่รองรับ method ที่ไม่ใช่ POST
        }
        
    } catch (PDOException $e) {
        http_response_code(500);
        echo $e->getMessage();
    }
?>
