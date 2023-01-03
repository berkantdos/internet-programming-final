<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

    <div class="flex">

        <a href="anasayfa.php" class="logo">Wabu Çiçek</a>

        <nav class="navbar">
            <ul>
                <li><a href="anasayfa.php">Ana Sayfa</a></li>
                <li><a href="#">Sayfalar +</a>
                    <ul>
                        <li><a href="hakkinda.php">Hakkında</a></li>
                        <li><a href="iletisim.php">İletişim</a></li>
                    </ul>
                </li>
                <li><a href="magaza.php">Mağaza</a></li>
                <li><a href="siparis.php">Siparişler</a></li>
                <li><a href="#">Hesaba +</a>
                    <ul>
                        <li><a href="giris.php">Giriş Yap</a></li>
                        <li><a href="kayit.php">Kayıt Ol</a></li>
                    </ul>
                </li>
            </ul>
        </nav>

        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="arama_ekrani.php" class="fas fa-search"></a>
            <div id="user-btn" class="fas fa-user"></div>
            <?php
                $select_wishlist_count = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE user_id = '$user_id'") or die('query failed');
                $wishlist_num_rows = mysqli_num_rows($select_wishlist_count);
            ?>
            <a href="dilek_kutucugu.php"><i class="fas fa-heart"></i><span>(<?php echo $wishlist_num_rows; ?>)</span></a>
            <?php
                $select_cart_count = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
                $cart_num_rows = mysqli_num_rows($select_cart_count);
            ?>
            <a href="kart.php"><i class="fas fa-shopping-cart"></i><span>(<?php echo $cart_num_rows; ?>)</span></a>
        </div>

        <div class="account-box">
            <p>Kullanıcı Adı : <span><?php echo $_SESSION['user_name']; ?></span></p>
            <p>E-mail : <span><?php echo $_SESSION['user_email']; ?></span></p>
            <a href="cikis.php" class="delete-btn">Çıkış Yap</a>
        </div>

    </div>

</header>