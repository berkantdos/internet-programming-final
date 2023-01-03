<?php

@include 'baglanti.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:giris.php');
};

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$delete_id'") or die('query failed');
    header('location:kart.php');
}

if(isset($_GET['delete_all'])){
    mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    header('location:kart.php');
};

if(isset($_POST['update_quantity'])){
    $cart_id = $_POST['cart_id'];
    $cart_quantity = $_POST['cart_quantity'];
    mysqli_query($conn, "UPDATE `cart` SET quantity = '$cart_quantity' WHERE id = '$cart_id'") or die('query failed');
    $message[] = 'Sepet Miktarı Güncellendi!';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Alışveriş Kartı</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php @include 'baslik.php'; ?>

<section class="heading">
    <h3>Alışveriş Kartı</h3>
    <p> <a href="anasayfa.php">Ana Sayfa</a> / Kartlarım </p>
</section>

<section class="shopping-cart">

    <h1 class="title">Eklenen Ürünler</h1>

    <div class="box-container">

    <?php
        $grand_total = 0;
        $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
        if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
    ?>
    <div  class="box">
        <a href="kart.php?delete=<?php echo $fetch_cart['id']; ?>" class="fas fa-times" onclick="return confirm('Kartı Silmek İstiyor Musunuz?');"></a>
        <a href="inceleme_sayfasi.php?pid=<?php echo $fetch_cart['pid']; ?>" class="fas fa-eye"></a>
        <img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" alt="" class="image">
        <div class="name"><?php echo $fetch_cart['name']; ?></div>
        <div class="price">TL<?php echo $fetch_cart['price']; ?>/-</div>
        <form action="" method="post">
            <input type="hidden" value="<?php echo $fetch_cart['id']; ?>" name="cart_id">
            <input type="number" min="1" value="<?php echo $fetch_cart['quantity']; ?>" name="cart_quantity" class="qty">
            <input type="submit" value="Güncelle" class="option-btn" name="update_quantity">
        </form>
        <div class="sub-total"> Ara Toplam : <span>TL<?php echo $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>/-</span> </div>
    </div>
    <?php
    $grand_total += $sub_total;
        }
    }else{
        echo '<p class="empty">Sepetiniz Boş</p>';
    }
    ?>
    </div>

    <div class="more-btn">
        <a href="kart.php?delete_all" class="delete-btn <?php echo ($grand_total > 1)?'':'disabled' ?>" onclick="return confirm('Hepsi Sepetten Silinsin Mi?');">Hepsini Sil</a>
    </div>

    <div class="cart-total">
        <p>Genel Toplam : <span>TL<?php echo $grand_total; ?>/-</span></p>
        <a href="magaza.php" class="option-btn">Alışverişe Devam Et</a>
        <a href="odeme.php" class="btn  <?php echo ($grand_total > 1)?'':'disabled' ?>">Ödemeye Doğru İlerle</a>
    </div>

</section>

<?php @include 'alt_bilgi.php'; ?>

<script src="js/script.js"></script>

</body>
</html>