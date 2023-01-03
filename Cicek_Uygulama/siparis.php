<?php

@include 'baglanti.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:giris.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Siparişler</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php @include 'baslik.php'; ?>

<section class="heading">
    <h3>Siparişleriniz</h3>
    <p> <a href="anasayfa.php">Ana Sayfa</a> / Sipariş </p>
</section>

<section class="placed-orders">

    <h1 class="title">Verilen Siparişler</h1>

    <div class="box-container">

    <?php
        $select_orders = mysqli_query($baglan, "SELECT * FROM `orders` WHERE user_id = '$user_id'") or die('baglanti hatasi');
        if(mysqli_num_rows($select_orders) > 0){
            while($fetch_orders = mysqli_fetch_assoc($select_orders)){
    ?>
    <div class="box">
        <p> Tarih : <span><?php echo $fetch_orders['placed_on']; ?></span> </p>
        <p> İsim : <span><?php echo $fetch_orders['name']; ?></span> </p>
        <p> Telefon No : <span><?php echo $fetch_orders['number']; ?></span> </p>
        <p> E-mail : <span><?php echo $fetch_orders['email']; ?></span> </p>
        <p> Adres : <span><?php echo $fetch_orders['address']; ?></span> </p>
        <p> Ödeme Şekli : <span><?php echo $fetch_orders['method']; ?></span> </p>
        <p> Siparişleriniz : <span><?php echo $fetch_orders['total_products']; ?></span> </p>
        <p> Toplam Fiyat : <span>TL<?php echo $fetch_orders['total_price']; ?>/-</span> </p>
        <p> Ödeme Durumu : <span style="color:<?php if($fetch_orders['payment_status'] == 'pending'){echo 'tomato'; }else{echo 'green';} ?>"><?php echo $fetch_orders['payment_status']; ?></span> </p>
    </div>
    <?php
        }
    }else{
        echo '<p class="empty">Henüz Sipariş Verilmedi!</p>';
    }
    ?>
    </div>

</section>

<?php @include 'alt_bilgi.php'; ?>

<script src="js/script.js"></script>

</body>
</html>