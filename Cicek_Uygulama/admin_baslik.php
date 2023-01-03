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

      <a href="admin_sayfasi.php" class="logo">Admin<span>Paneli</span></a>

      <nav class="navbar">
         <a href="admin_sayfasi.php">Ana Sayfa</a>
         <a href="admin_urun.php">Ürünler</a>
         <a href="admin_siparis.php">Siparişler</a>
         <a href="admin_kullanicilar.php">Kullanıcılar</a>
         <a href="admin_kisiler.php">Gelen Mesajlar</a>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="account-box">
         <p>Kullanıcı Adı : <span><?php echo $_SESSION['admin_name']; ?></span></p>
         <p>E-mail : <span><?php echo $_SESSION['admin_email']; ?></span></p>
         <a href="cikis.php" class="delete-btn">Çıkış Yap</a>
         <div>Yeni <a href="giris.php">Giriş</a> | <a href="kayit.php">Kayıt Ol</a> </div>
      </div>

   </div>

</header>