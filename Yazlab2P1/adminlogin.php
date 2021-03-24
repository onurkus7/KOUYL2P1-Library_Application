<!DOCTYPE HTML>
<html lang="en-US" dir="ltr">
<head>
<title>K4RK1N Library Yönetici Girişi</title>
<div class="header_logo">
</div>

<form action="adminlogin.php" method="POST">
<div class="login-box">
  <h1>Yönetici Girişi</h1>
  <div class="textbox">
    <i class="fas fa-user"></i>
    <input type="text" placeholder="Kullanıcı Adı"name="username">
  </div>

  <div class="textbox">
    <i class="fas fa-lock"></i>
    <input type="password" placeholder="Kullanıcı Şifresi"name="password">
  </div>

  <input type="submit" class="btn" value="GİRİŞ YAP">
</div>
</form>
	<meta charset="UTF-8">
	<title>K4RK1N</title>
    <link rel="stylesheet" href="stil.css">
</head>

<body> 
<style>
body {
  background-image: url('wallpaper/adminlogin1.jpg');
}
</style>
</body>
</html>

<?php
session_start();

$baglanti = mysqli_connect("localhost","root","root","yazlab");
mysqli_set_charset($baglanti, "utf8");


if(isset($_POST['username']))
{
   
   $username=$_POST['username'];
   $password=$_POST['password'];
   
   $sorgu="SELECT * FROM yoneticiler WHERE yonetici_rumuz='".$username."' AND yonetici_sifre='".$password."' LIMIT 1"; 
   $result= mysqli_query($baglanti, $sorgu);
    
    if(mysqli_num_rows($result)==1)
    {   
        $adminbilgi = mysqli_fetch_assoc($result);
        echo '<script>alert("GİRİŞ BAŞARILI")</script>'; 
        $_SESSION['alogin']=$adminbilgi['yonetici_ad'];
        $_SESSION['aslogin']=$adminbilgi['yonetici_soyad'];
        $_SESSION['aid']=$adminbilgi['yonetici_id'];

        header('Location: adminpanel.php');
        exit();
    }

    else
    {
        echo '<script>alert("KULLANICI ADI VEYA ŞİFRE YANLIŞ")</script>'; 
        exit();
    }
       
}


?>

