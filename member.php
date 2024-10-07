<?php
    session_start();
    $open_connect=1;
    require('connect.php');

    if(!isset($_SESSION['id_account']) || !isset($_SESSION['role_account'])){
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="member.css">
    <title>Customer</title>

    <script
  src="https://code.jquery.com/jquery-3.7.1.js"
  integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
  crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="member.js"></script>
  
    <?php
    $Imagelogo = "<img src='Picture\logo-kab-phone-white.png' alt='Logo' width=70>";
    $Imagecart = "<img src='Picture\Cart.png' alt='Logo' width=40>";
    $ImageUser = "<img src='UserPNG\icons8-user-48.png' alt='User' width=50>";
    $ImageLogout = "<img src='UserPNG\icons8-log-out-50.png' alt='User' width=50>";
    $ImagePhone = "<img src='Picture\iphone.png' alt='User' width=300>";
    $ImageBlackcart = "<img src='Picture\BlackCart.png' alt='Logo' width=25>";
    ?>
</head>
<body>
    
    <div class="black-bar">
    <button class="openbtn" onclick="openNav()">☰</button>
    <p id="result"></p>
        <div class="KabPigture">
        <?php echo $Imagelogo; ?>
        <div class="KABTEXT">KAB SHOP</div>
        
        <a onclick="openCart()" style="cursor: pointer;" class="cart-btn">
        <div class="nav-profile-cart">
            
        </div><?php echo $Imagecart; ?>
        <div id="cartcount" class="cartcount" style="display: none;">
            0
        </div>
        </a>
        
        </div>
      
        
    </div>
        <div class="sidebar" id="mySidebar" >
            <h1 style="color: black;">MENU</h1>
            <br>
            <hr width="100%" size="2" color="Black" noshade>
            <br>
            <h3>Username : <?php echo ($result_show['user_account']); ?> </h3>
            <a href="Account.php" style="color: black;" class="menu-item">
        <!-- ภาพหรือไอคอนของผู้ใช้ -->
        <?php echo $ImageUser; ?>
        <span>My Account</span>
    </a>
    <a href="member.php?logout=1" style="color: black;" class="menu-item">
        <!-- ภาพหรือไอคอนออกจากระบบ -->
        <?php echo $ImageLogout; ?>
        <span>LogOut</span>
    </a>
    </div>
    <div class="container">
        <br> 
        <div><iframe width="100%" height="500vh" controls autoplay src="https://www.youtube.com/embed/eDqfg_LexCQ?si=f7pInpt26TC96fai" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe></div>
        <br><h2>CATEGORY</h2><br>
        <div class="menubar" id="pointer">
        <a onclick="searchproduct('General')" class="sidebar-items" >General</a>
        <a onclick="searchproduct('Gaming')" class="sidebar-items" >Gaming</a>
        <a onclick="searchproduct('Work')" class="sidebar-items" >Work</a>
        <a onclick="searchproduct('Entertainment')" class="sidebar-items" >Entertainment</a>  

        </div>
        <br>
        <h2>All Product</h2>
        <br>
        <div id="productlist"class="product">
            
        </div>
     <!--   <br>
        <h2>RECOMMEND</h2>
        <br>
        <div id="productlist"class="product">
            
        </div>
        <br>
        <h2>GENERAL</h2>
        <br>
        <div id="productlist"class="product">-->
    
    </div>
    <div id="modalDesc" class="modal" style="display: none;">
        <div onclick="closeModal()" class="modal-bg"></div>
        <div class="modal-page">
            <h2 >DETAIL</h2><br>
            <div class="modaldesc-content">
                <img id="mdd-img"class="modaldesc-img" src="Picture\iphone.png" alt="">
            <div class="modaldesc-detail">
                <h2 id="mdd-name">MOBILE</h2>
                <div id="mdd-price"class="pricebar">$ xxx,xxx</div>
                <br>
                <p id="mdd-desc"style="color:#adadad;">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Eius enim, animi esse modi totam vel harum iusto mollitia, ad officiis ipsam sit facilis eligendi possimus voluptate ratione consequuntur rem. Alias.</p>
            <br>
            <div class="btn-control">
                <button onclick="closeModal()" class="btn">
                    Cancel
                </button>
                <button onclick="addtocart()" class="btn btn-buy">
                    Add to cart
                </button>
            </div>

            </div>
            </div>
        </div>

    </div>
    <div id="modalCart" class="modal" style="display: none;">
    <div onclick="closeModal()" class="modal-bg"></div>
    <div class="modal-page">
      <h2>My Cart</h2>
      <br>
      <div id="mycart" class="cartlist">

      </div>
      <div class="btn-control">
        <button onclick="closeModal()" class="btn">
          Cancel
        </button>
        <button onclick="buynow()" class="btn btn-buy">
          Buy
        </button>
      </div>
    </div>
  </div>
    </div>
        
    <?php  
    echo '<script>
    function openNav() {
        var sidebar = document.getElementById("mySidebar");
        var main = document.getElementById("main");

        if (sidebar.style.width === "400px") {
            // ถ้า sidebar เปิดอยู่ ให้ปิด
            sidebar.style.width = "0";
            main.style.marginLeft = "0";
        } else {
            // ถ้า sidebar ปิดอยู่ ให้เปิด
            sidebar.style.width = "400px";
            main.style.marginLeft = "400px";
        }
    }
</script>'
    
    ?> 
</body>
</html>