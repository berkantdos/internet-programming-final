<?php

@include 'baglanti.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:giris.php');
};

if(isset($_POST['send'])){

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $msg = mysqli_real_escape_string($conn, $_POST['message']);

    $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE name = '$name' AND email = '$email' AND number = '$number' AND message = '$msg'") or die('baglanti hatasi');

    if(mysqli_num_rows($select_message) > 0){
        $message[] = 'Mesaj Zaten Gönderildi!';
    }else{
        mysqli_query($conn, "INSERT INTO `message`(user_id, name, email, number, message) VALUES('$user_id', '$name', '$email', '$number', '$msg')") or die('baglanti hatasi');
        $message[] = 'Mesaj Başarıyla Gönderildi!';
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>İletişim</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php @include 'baslik.php'; ?>

<section class="heading">
    <h3>Bize Ulaşın</h3>
    <p> <a href="anasayfa.php">Ana Sayfa</a> / İletişim </p>
</section>

<section class="contact">

    <form action="" method="POST">
        <h3>Bize Mesaj Gönder!</h3>
        <input type="text" name="name" placeholder="İsim Giriniz" class="box" required> 
        <input type="email" name="email" placeholder="E-mail Giriniz" class="box" required>
        <input type="number" name="number" placeholder="Telefon No Giriniz" class="box" required>
        <textarea name="message" class="box" placeholder="Mesajınızı Giriniz" required cols="30" rows="10"></textarea>
        <input type="submit" value="send message" name="send" class="btn">
    </form>

</section>

<?php @include 'alt_bilgi.php'; ?>

<script src="js/script.js"></script>

</body>
</html>