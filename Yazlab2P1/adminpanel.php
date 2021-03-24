
    <?php 
    session_start();
    include("veritabani.php");
    if(strlen($_SESSION['alogin'])==0)
       {   
         header('location:index.php');
       }
    else
    { 

 ?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>K4RK1N Yönetici Paneli</title>
    <link rel="stylesheet" href="admin.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        
            <form action="" method="post" enctype="multipart/form-data">
				<table class="table" style="margin-left:-30px;margin-top:10px;width:40%">
                    
                    <tr class="bg-info">
						<td></td><td><th>Kitap Ekle:</th></td>
						<td></td><td><input type="file" name="img"/></td>
                    </tr>
                   
                </table>
                <td><input class="btn btn-success" style="margin-left:450px;margin-top:-50px;" type="submit" name="Kaydet" value="Veritabanına Kaydet"></td>
                <td><input class="input-group-text" style="font-family:verdana;font-size:18px;height:30px;width:200px;margin-left:-625px;margin-top:-50px;" type="text" id="KitapAdı" name="KitapAdı" placeholder="Kitap Adı"></td>
                <td><input class="input-group-text" style="font-family:verdana;font-size:18px;height:30px;width:200px;margin-left:25px;margin-top:-50px;" type="text" id="YazarAdı" name="YazarAdı" placeholder="Yazar Adı"></td>
                <br><br><br>
                
                <td><input class="btn btn-primary" style="margin-left:935px;margin-top:-235px;" type="submit" name="Listele0"value="Tüm Kullanıcıları Listele"></td>
                <table style="margin-left:850px;margin-top:-100px;width:30%" class="table table-dark">
            
                <tr class="bg-info">
                    <th>Sıra No</th>
                    <th>Ad</th>
                    <th>Soyad</th> 
                    <th></th>
                </tr>
               
    
                <?php
                //https://mesutd.com/php-ile-mysql-veritabanina-baglanip-veri-ekleme-silme-duzenleme-ve-listeleme bir kısım kod parçalarını kendi koduma uyarladım.

                if(isset($_POST["Listele0"]))
                {
                    $no=0;
                    $sorgu0 = $baglanti->query("SELECT kullanici_ad,kullanici_soyad FROM kullanicilar"); 
                    
                    while ( $sonuc0 = $sorgu0->fetch_assoc()) 
                    { 
                    $ad = $sonuc0['kullanici_ad'];
                    $soyad = $sonuc0['kullanici_soyad'];
                    $no=1+$no;

                    ?>

                    <tr class="bg-warning">
                        <td><?php echo $no; ?></td>
                        <td><?php echo $ad; ?></td>
                        <td><?php echo $soyad; ?></td><td>
                    
                    </tr>

                        <?php 
                    } ;
            

                }
                        ?>


        </table>

            </form>
      



            <?php 
                    
                    
                if(isset($_POST["Kaydet"]))
                    {

                        
                        $Orgname=   $_FILES["img"]["name"];
                        $IamgeType=   $_FILES["img"]["type"];
                        $ImageSize=   $_FILES["img"]["size"];
                        $TmpName=   $_FILES["img"]["tmp_name"];
                        $ImageError=   $_FILES["img"]["error"];


                        $MaxBoyut=1024*1024*3;


                        if ($ImageError == 4)
                        {
                        echo '<script>alert("Lütfen bir dosyanızı seçin")</script>';
                        }
                        else 
                        { 
                        $uzanti = explode('.', $Orgname);
                        $new_name =rand() . '.' . $uzanti[1];
                        $hedef = $_SERVER['DOCUMENT_ROOT'].'/yazlab/upload/'.$new_name;

                        if($_FILES["img"]["size"]>$MaxBoyut)
                        {
                        echo '<script>alert("Dosya Boyutu En Fazla 3MB Olabilir")</script>';
                        }
                        else
                        {
                            $filetype=$_FILES["img"]["type"];
                            if($filetype=="image/jpeg"|| $filetype=="image/png")
                            {
                                if(is_uploaded_file($TmpName))
                                {
                                    $move=move_uploaded_file($_FILES['img']['tmp_name'], $hedef);
                                    if($move)
                                    {   
                                        
                                        $imgpath= ($uzanti[1] == "png") ? imagecreatefrompng("C:/xampp/htdocs/yazlab/upload/{$new_name}") : imagecreatefromjpeg("C:/xampp/htdocs/yazlab/upload/{$new_name}");

                                        //GD kütüphanesi bi takım görüntü işleme algoritmaları
                                        imagefilter($imgpath, IMG_FILTER_GRAYSCALE);
                                        $emboss = array(array(4, 0, 0), array(0, -1, 0), array(0, 0, -1));
                                        imageconvolution($imgpath, $emboss, 1, -87);
                                        imagefilter($imgpath, IMG_FILTER_CONTRAST, -35);
                                        if($uzanti[1] == "png") imagepng($imgpath, "C:/xampp/htdocs/yazlab/gd/{$new_name}");
                                        else if($uzanti[1] == "jpeg" || $uzanti[1] == "jpg") imagejpeg($imgpath, "C:/xampp/htdocs/yazlab/gd/{$new_name}");



                                        echo '<img src="upload/'.$new_name.'" width="420"height="500">';
                                        //echo '<script>alert("Dosya yükleme başarılı")</script>';

                                        //tesseract işlemi
                                        $exe = "C:/Program Files/Tesseract/tesseract.exe";
                                        $img = "C:/xampp/htdocs/yazlab/gd/{$new_name}";
                                        $txt = "C:/xampp/htdocs/yazlab/tesseract/output";
                                        $output = exec("\"$exe\" \"$img\" \"$txt\" ");
                                        
                                        
                                    }
                                    else
                                    {
                                        echo '<script>alert("Hatalı durum,dosya yüklenemedi")</script>';
                                    }
                                }
                            }
                            else
                            {
                                echo '<script>alert("Yüklediğiniz resim sadece JPEG,PNG formatında olmalı")</script>';
                            }
                        }

                        }

                        //print_r($_FILES);

                        $isbn_output = fopen('C:/xampp/htdocs/yazlab/tesseract/output.txt', 'r');
                        $isbn_metin1 = fread($isbn_output, filesize('C:/xampp/htdocs/yazlab/tesseract/output.txt')); 
                        $isbn_metin2=explode("ISBN",$isbn_metin1); 
                        $isbn_metin3=str_replace(array("-", " ",":"), array('','',''), $isbn_metin2[1]);
                        $isbn_metin4=substr($isbn_metin3,0,13);
                        /*echo $isbn_metin2[1];
                        echo "\n son\n";
                        echo $isbn_metin3;
                        echo "\n son\n";
                        echo $isbn_metin4;*/
                        fclose($isbn_output);

                
                        $eklenecek_kitap_ad=$_POST["KitapAdı"];
                        $eklenecek_yazar_ad=$_POST["YazarAdı"];

                        if($isbn_metin4)
                        {
                            mysqli_query($baglanti,"INSERT INTO kitaplar ( kitap_isbn,kitap_adi ,kitap_yazar,kitap_durumu) 
                            values ('$isbn_metin4','$eklenecek_kitap_ad','$eklenecek_yazar_ad',0)");
                            echo '<script>alert("KAYIT BAŞARILI")</script>'; 
                        }

                        else echo '<script>alert("ISBN okunamadı. Lütfen daha net bir fotoğraf seçiniz.")</script>';

                    }
                    
                
            ?>
           

			<form action="" method="post" enctype="multipart/form-data">

				<td><input class="btn btn-primary" style="margin-left:350px;margin-top:70px;" type="submit" name="Listele"value="Kullanıcıları Listele"></td>
					
			</form>
            
    
        <table style="margin-left:-70px;margin-top:10px;width:90%" class="table table-dark">
            
                <tr class="bg-info">
                    <th>Sıra No</th>
                    <th>Ad</th>
                    <th>Soyad</th>
                    <th>Üzerindeki Kitaplar</th>
                    <th>Alım Tarihi</th> 
                    <th>Teslim Tarihi</th>   
                    <th></th>
                </tr>


            <?php
                //https://mesutd.com/php-ile-mysql-veritabanina-baglanip-veri-ekleme-silme-duzenleme-ve-listeleme bir kısım kod parçalarını kendi koduma uyarladım.

                if(isset($_POST["Listele"]))
                {
                    $no=0; 
                    $sorgu = $baglanti->query("SELECT X.kullanici_ad,X.kullanici_soyad,Y.kitap_adi,Z.kitap_alan_kullanici_id,Z.alinan_kitap_isbn,Z.kitap_alinma_tarihi,Z.kitap_teslim_tarihi 
                    FROM kullanicilar X ,kitaplar Y,kitap_islemleri Z
                    WHERE X.kullanici_id=Z.kitap_alan_kullanici_id AND Y.kitap_isbn=Z.alinan_kitap_isbn");
            
                    while ($sonuc = $sorgu->fetch_assoc()) 
                    { 
                    $alinan_kitap_isbn=$sonuc['alinan_kitap_isbn'];
                    $kitap_alan_kullanici_id=$sonuc['kitap_alan_kullanici_id'];
                    $kitap_adi = $sonuc['kitap_adi']; 
                    $ad = $sonuc['kullanici_ad'];
                    $soyad = $sonuc['kullanici_soyad'];
                    $alimTarihi=$sonuc['kitap_alinma_tarihi'];
                    $teslimTarihi=$sonuc['kitap_teslim_tarihi'];
                    $no=1+$no;

                    ?>

                    <tr class="bg-warning">
                        <td><?php echo $no; ?></td>
                        <td><?php echo $ad; ?></td>
                        <td><?php echo $soyad; ?></td>
                        <td><?php echo $kitap_adi; ?></td>
                        <td><?php echo $alimTarihi; ?></td>
                        <td><?php echo $teslimTarihi; ?></td>
                        <td><a href="zamanatama.php?id=<?php echo $kitap_alan_kullanici_id;?>&isbn=<?php echo $alinan_kitap_isbn;?>" class="btn btn-primary">Süreyi Uzat</a></td>
                    </tr>

                        <?php 
                    } ;
            

                }
                        ?>

        </table>
  </div>
</body>
</html> 
		<a class="btn btn-warning btn-lg active" href="logout.php"  style="padding:7px;width:110px;margin-left:1175px;margin-top:-100px;position:relative;" >Çıkış Yap</a>
        <div class="badge badge-primary text-wrap" style="font-family:arial;font-size:25px;width:24rem;height:3.75rem;margin-left:1290px;margin-top:-140px"><?php echo $_SESSION['alogin'];echo " "; echo $_SESSION['aslogin']; ?></div>
      
    <?php } ?>



