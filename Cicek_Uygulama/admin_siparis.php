<?php

@include 'baglanti.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:giris.php');
};

if(isset($_POST['update_order'])){
   $order_id = $_POST['order_id'];
   $update_payment = $_POST['update_payment'];
   mysqli_query($conn, "UPDATE `orders` SET payment_status = '$update_payment' WHERE id = '$order_id'") or die('baglanti hatasi');
   $message[] = 'Ödeme Durumu Güncellendi!';
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `orders` WHERE id = '$delete_id'") or die('baglanti hatasi');
   header('location:admin_siparis.php');
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

<section class="placed-orders">

   <h1 class="title">Verilen Siparişler</h1>

   <div class="box-container">

      <?php
      
      $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('baglanti hatasi');
      if(mysqli_num_rows($select_orders) > 0){
         while($fetch_orders = mysqli_fetch_assoc($select_orders)){
      ?>
      <div class="box">
         <p> Kullanıcı id : <span><?php echo $fetch_orders['user_id']; ?></span> </p>
         <p> Yer Alan : <span><?php echo $fetch_orders['placed_on']; ?></span> </p>
         <p> İsim : <span><?php echo $fetch_orders['name']; ?></span> </p>
         <p> Telefon No : <span><?php echo $fetch_orders['number']; ?></span> </p>
         <p> E-mail : <span><?php echo $fetch_orders['email']; ?></span> </p>
         <p> Adres : <span><?php echo $fetch_orders['address']; ?></span> </p>
         <p> Toplam Ürün : <span><?php echo $fetch_orders['total_products']; ?></span> </p>
         <p> Toplam Fiyat : <span>$<?php echo $fetch_orders['total_price']; ?>/-</span> </p>
         <p> Ödeme Şekli : <span><?php echo $fetch_orders['method']; ?></span> </p>
         <form action="" method="post">
            <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
            <select name="update_payment">
               <option disabled selected><?php echo $fetch_orders['payment_status']; ?></option>
               <option value="pending">Bekliyor</option>
               <option value="completed">Tamamlandı</option>
            </select>
            <input type="submit" name="update_order" value="Güncelle" class="option-btn">
            <a href="admin_siparis.php?delete=<?php echo $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('Bu Siparişi Sil?');">Sil</a>
         </form>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">Henüz Sipariş Verilmedi!</p>';
      }
      ?>
   </div>

</section>

<script src="js/admin_script.js"></script>

</body>
</html>