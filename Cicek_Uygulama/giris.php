<?php

@include 'baglanti.php';

session_start();

if(isset($_POST['giris'])){

   $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
   $email = mysqli_real_escape_string($conn, $filter_email);
   $filter_sifre = filter_var($_POST['sifre'], FILTER_SANITIZE_STRING);
   $sifre = mysqli_real_escape_string($conn, md5($filter_sifre));

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$sifre'") or die('baglanti hatasi');


   if(mysqli_num_rows($select_users) > 0){
      
      $row = mysqli_fetch_assoc($select_users);

      if($row['user_type'] == 'admin'){

         $_SESSION['admin_name'] = $row['name'];
         $_SESSION['admin_email'] = $row['email'];
         $_SESSION['admin_id'] = $row['id'];
         header('location:admin_sayfasi.php');

      }elseif($row['user_type'] == 'user'){

         $_SESSION['user_name'] = $row['name'];
         $_SESSION['user_email'] = $row['email'];
         $_SESSION['user_id'] = $row['id'];
         header('location:anasayfa.php');

      }else{
         $message[] = 'Kullanıcı Bulunamadı!';
      }

   }else{
      $message[] = 'Yanlış E-mail Veya Şifre!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Giriş</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <link rel="stylesheet" href="css/style.css">

</head>
<body>

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
   
<section class="form-container">

   <form action="" method="post">
      <h3>Giriş Yap</h3>
      <input type="email" name="email" class="box" placeholder="E-mail Adresi Giriniz" required>
      <input type="password" name="sifre" class="box" placeholder="Şifre Giriniz" required>
      <input type="submit" class="btn" name="giris" value="Giriş Yap">
      <p>Hesabınız Yok Mı? <a href="kayit.php">Şimdi Kayıt Ol</a></p>
   </form>

</section>

</body>
</html>