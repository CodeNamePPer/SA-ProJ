function searchproduct(type) {
    // ซ่อนทุก div ก่อน
    document.getElementById("productTable").style.display = "none";
    document.getElementById("transactionTable").style.display = "none";

    // แสดง div ตามค่าที่ได้รับ
    if (type === 'Product') {
        document.getElementById("productTable").style.display = "block";
    } else if (type === 'Transaction') {
        document.getElementById("transactionTable").style.display = "block";
    }
}

