<?php

@include 'baglanti.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:giris.php');
};

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `users` WHERE id = '$delete_id'") or die('baglanti hatasi');
   header('location:admin_kullanicilar.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Gösterge Paneli</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php @include 'admin_baslik.php'; ?>

<section class="users">

   <h1 class="title">Kullanıcı Hesabı</h1>

   <div class="box-container">
      <?php
         $select_users = mysqli_query($conn, "SELECT * FROM `users`") or die('baglanti hatasi');
         if(mysqli_num_rows($select_users) > 0){
            while($fetch_users = mysqli_fetch_assoc($select_users)){
      ?>
      <div class="box">
         <p>Kullanıcı id : <span><?php echo $fetch_users['id']; ?></span></p>
         <p>İsim : <span><?php echo $fetch_users['name']; ?></span></p>
         <p>E-mail : <span><?php echo $fetch_users['email']; ?></span></p>
         <p>Kullanıcı Tipi : <span style="color:<?php if($fetch_users['user_type'] == 'admin'){ echo 'var(--orange)'; }; ?>"><?php echo $fetch_users['user_type']; ?></span></p>
         <a href="admin_kullanicilar.php?delete=<?php echo $fetch_users['id']; ?>" onclick="return confirm('Kullanıcıyı Silmek İstiyor Musunuz?');" class="delete-btn">Sil</a>
      </div>
      <?php
         }
      }
      ?>
   </div>

</section>

<script src="js/admin_script.js"></script>

</body>
</html>