<?php 
include("veritabani.php");

if (TRUE) { 

    if ($baglanti->query("UPDATE kitap_islemleri SET kitap_teslim_tarihi =ADDDATE(kitap_teslim_tarihi , INTERVAL 20 DAY )
    WHERE kitap_alan_kullanici_id='".$_GET['id']."' AND alinan_kitap_isbn='".$_GET['isbn']."'")) 
      {
       header("location:adminpanel.php"); 
      }
    else
      {
        echo "Hata oluştu:Bilgiler Güncellenemedi";
      }
}
?>
