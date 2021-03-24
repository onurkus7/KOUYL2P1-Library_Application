<?php 
    session_start();
    include("veritabani.php"); 
    //print($_SESSION['id']);
    //print($_GET['id']);
    $aldıgı_toplam_kitap=mysqli_query($baglanti,"SELECT kitap_alan_kullanici_id FROM kitap_islemleri WHERE kitap_alan_kullanici_id='".$_SESSION['id']."'");
    
    $teslim_tarihi_kontrol=mysqli_query($baglanti,"SELECT DATEDIFF(kitap_teslim_tarihi,CURDATE()) AS Fark FROM kitap_islemleri 
    WHERE kitap_alan_kullanici_id='".$_SESSION['id']."'");
    $Fark=$teslim_tarihi_kontrol->fetch_assoc();

    if($Fark['Fark']>=0)
    {   
        if(mysqli_num_rows($aldıgı_toplam_kitap)<3)
        {   
            $result= mysqli_query($baglanti,"INSERT INTO kitap_islemleri( kitap_alan_kullanici_id,alinan_kitap_isbn,kitap_alinma_tarihi,kitap_teslim_tarihi) 
            values ('".$_SESSION['id']."','".$_GET['id']."',CURDATE(),ADDDATE(CURDATE(),INTERVAL 7 DAY ))");

            if ($result)
                {  
                    mysqli_query($baglanti,"UPDATE kitaplar SET kitap_durumu = 1 WHERE kitap_isbn='".$_GET['id']."'");
                    header("location:userpanel.php");     
                }
            
            else
                {  
                    echo '<script>alert("Hata oluştu: KİTAP ALINMAK İÇİN MÜSAİT DEĞİL")</script>'; 
                }
        }
        else
        {  
            echo '<script>alert("MAKSİMUM KİTAP ALIMI ! \nEN FAZLA 3 KİTAP ALMA HAKKINIZ VARDIR")</script>';
            header("refresh:0;url=userpanel.php"); 
        }
    }
    else
    {
        echo '<script>alert("===KİTAP ALMA HAKKINIZ DURDURULMUŞTUR===\nLÜTFEN ÜZERİNİZDEKİ BÜTÜN KİTAPLARI TESLİM EDİNİZ.")</script>';
        header("refresh:0;url=userpanel.php"); 
    }
    
         
?>
