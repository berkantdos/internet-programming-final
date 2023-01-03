<?php

@include 'baglanti.php';

session_start();
session_unset();
session_destroy();

header('location:giris.php');

?>