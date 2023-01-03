<?php

@include 'baglanti.php';

if(isset($_POST['kaydet'])){

   $filter_name = filter_var($_POST['isim']);
   $isim = mysqli_real_escape_string($conn, $filter_name);
   $filter_email = filter_var($_POST['email']);
   $email = mysqli_real_escape_string($conn, $filter_email);
   $filter_sifre = filter_var($_POST['sifre']);
   $sifre = mysqli_real_escape_string($conn, md5($filter_sifre));
   $filter_resifre = filter_var($_POST['resifre']);
   $resifre = mysqli_real_escape_string($conn, md5($filter_resifre));

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('baglanti hatasi');

   if(mysqli_num_rows($select_users) > 0){
      $message[] = 'Bu Kullanıcı Zaten Var!';
   }else{
      if($pass != $cpass){
         $message[] = 'Şifreler Birbiriyle Eşleşmiyor!';
      }else{
         mysqli_query($conn, "INSERT INTO `users`(name, email, password) VALUES('$isim', '$email', '$sifre')") or die('baglanti hatasi');
         $message[] = 'Başarıyla Kayıt Edildi!';
         header('location:anasayfa.php');
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Kayıt Sayfası</title>

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
      <h3>Şimdi Üye Ol</h3>
      <input type="text" name="isim" class="box" placeholder="Kullanıcı Adı Giriniz" required>
      <input type="email" name="email" class="box" placeholder="E-mail Giriniz" required>
      <input type="password" name="sifre" class="box" placeholder="Şifre Giriniz" required>
      <input type="password" name="resifre" class="box" placeholder="Şifreyi Onaylayın" required>
      <input type="submit" class="btn" name="kaydet" value="Üye Ol">
      <p>Zaten Bir Hesabım Var? <a href="giris.php">Giriş Yap</a></p>
   </form>

</section>

</body>
</html>