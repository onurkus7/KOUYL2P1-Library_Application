<?php


$baglanti = mysqli_connect("localhost","root","root","yazlab");
mysqli_set_charset($baglanti, "utf8");


if(isset($_POST['username'])){
   
   $uname=$_POST['username'];
   $password=$_POST['password'];
   
   $sorgu="SELECT * FROM kullanicilar WHERE kullanici_rumuz='".$uname."' AND kullanici_sifre='".$password."' LIMIT 1"; 
   $result= mysqli_query($baglanti, $sorgu);
   
  if(mysqli_num_rows($result)==1){
       echo "GİRİŞ BAŞARILI";
       header('Location: anasayfa.php');
       //exit();
        }
   else{
       echo " KULLANICI ADI VEYA ŞİFRE YANLIŞ";
       exit();
   }
       
}


?>