<?php

@include 'baglanti.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:giris.php');
};

if(isset($_POST['order'])){

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $method = mysqli_real_escape_string($conn, $_POST['method']);
    $address = mysqli_real_escape_string($conn, 'flat no. '. $_POST['flat'].', '. $_POST['street'].', '. $_POST['city'].', '. $_POST['country'].' - '. $_POST['pin_code']);
    $placed_on = date('d-M-Y');

    $cart_total = 0;
    $cart_products[] = '';

    $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    if(mysqli_num_rows($cart_query) > 0){
        while($cart_item = mysqli_fetch_assoc($cart_query)){
            $cart_products[] = $cart_item['name'].' ('.$cart_item['quantity'].') ';
            $sub_total = ($cart_item['price'] * $cart_item['quantity']);
            $cart_total += $sub_total;
        }
    }

    $total_products = implode(', ',$cart_products);

    $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE name = '$name' AND number = '$number' AND email = '$email' AND method = '$method' AND address = '$address' AND total_products = '$total_products' AND total_price = '$cart_total'") or die('query failed');

    if($cart_total == 0){
        $message[] = 'Sepetiniz Boş!';
    }elseif(mysqli_num_rows($order_query) > 0){
        $message[] = 'Sipariş Zaten Verildi!';
    }else{
        mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on) VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on')") or die('query failed');
        mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
        $message[] = 'Sipariş Başarıyla Verildi!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php @include 'baslik.php'; ?>

<section class="heading">
    <h3>Ödeme Sırası</h3>
    <p> <a href="anasayfa.php">Ana Sayfa</a> / Ödeme </p>
</section>

<section class="display-order">
    <?php
        $grand_total = 0;
        $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
        if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
            $grand_total += $total_price;
    ?>    
    <p> <?php echo $fetch_cart['name'] ?> <span>(<?php echo 'TL'.$fetch_cart['price'].'/-'.' x '.$fetch_cart['quantity']  ?>)</span> </p>
    <?php
        }
        }else{
            echo '<p class="empty">Sepetiniz Boş</p>';
        }
    ?>
    <div class="grand-total">Genel Toplam : <span>TL<?php echo $grand_total; ?>/-</span></div>
</section>

<section class="checkout">

    <form action="" method="POST">

        <h3>Siparişiniz</h3>

        <div class="flex">
            <div class="inputBox">
                <span>İsim :</span>
                <input type="text" name="name" placeholder="İsim Giriniz">
            </div>
            <div class="inputBox">
                <span>Telefon No :</span>
                <input type="number" name="number" min="0" placeholder="Telefon No Giriniz">
            </div>
            <div class="inputBox">
                <span>E-mail :</span>
                <input type="email" name="email" placeholder="E-Mail Giriniz">
            </div>
            <div class="inputBox">
                <span>Ödeme Şekli:</span>
                <select name="method">
                    <option value="cash on delivery">Kapıda Ödeme</option>
                    <option value="credit card">Kredi Kartı</option>
                    <option value="paypal">Paypal</option>
                    <option value="paytm">Paytm</option>
                </select>
            </div>
            <div class="inputBox">
                <span>Adres 1 :</span>
                <input type="text" name="flat" placeholder="örn. Mah.">
            </div>
            <div class="inputBox">
                <span>Adres 2 :</span>
                <input type="text" name="street" placeholder="örn. Kapı No.">
            </div>
            <div class="inputBox">
                <span>Şehir :</span>
                <input type="text" name="city" placeholder="örn. İzmir.">
            </div>
            <div class="inputBox">
                <span>İlçe :</span>
                <input type="text" name="state" placeholder="örn. Bornova.">
            </div>
            <div class="inputBox">
                <span>Ülke :</span>
                <input type="text" name="country" placeholder="örn. Türkiye">
            </div>
            <div class="inputBox">
                <span>Posta Kodu :</span>
                <input type="number" min="0" name="pin_code" placeholder="örn. 05984">
            </div>
        </div>

        <input type="submit" name="order" value="Sipariş Ver" class="btn">

    </form>

</section>

<?php @include 'alt_bilgi.php'; ?>

<script src="js/script.js"></script>

</body>
</html>