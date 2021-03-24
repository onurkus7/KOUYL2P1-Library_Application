
 <?php 
    session_start();
    include("veritabani.php");
    if(strlen($_SESSION['login'])==0)
       {   
         header('location:index.php');
       }
    else
    { 
    //echo "HOŞGELDİNİZ {$_SESSION['slogin']}";
 ?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>K4RK1N Kullanıcı Paneli</title>
    <link rel="stylesheet" href="user.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
    <div class="container">

            <form action="" method="post" enctype="multipart/form-data">
				<table class="table" style="margin-left:-60px;margin-top:10px;width:40%">
                    
                    <tr class="bg-info">
						<td></td><td><th>Kitap Teslim Et:</th></td>
						<td></td><td><input type="file" name="img"/></td>
                    </tr>
                   
                </table>
				<td><input class="btn btn-primary" style="margin-left:410px;margin-top:-100px;" type="submit" name="FotoUpload" value="Kitabı Ver"></td>
               
                <td><input class="btn btn-primary" style="margin-left:900px;margin-top:-140px;" type="submit" name="Aldıklarım"value="Aldığım Kitaplar"></td>
                <table class="table" style="margin-left:590px;margin-top:-50px;width:65%">
                    
                    
                    <tr class="bg-info">
                        <th></th><th>Kitap Adı</th>
                        <th></th><th>Yazar</th>
                        <th></th><th>ISBN</th>
                        <th></th><th>Alınma Tarihi</th>  
                        <th></th><th>Teslim Tarihi</th>  
                        
                    </tr>
                    <?php
                
                        if(isset($_POST["Aldıklarım"]))
                            {   
                                $no=0; 
                                
                             
                                $sorgu = $baglanti->query("SELECT X.kitap_adi,X.kitap_yazar,X.kitap_isbn,Y.kitap_alinma_tarihi,Y.kitap_teslim_tarihi 
                                FROM kitaplar X,kitap_islemleri Y WHERE {$_SESSION['id']}=Y.kitap_alan_kullanici_id AND X.kitap_isbn=Y.alinan_kitap_isbn");

                                while ($sonuc = $sorgu->fetch_assoc()) 
                                { 
                                    $kitap_adi = $sonuc['kitap_adi']; 
                                    $yazar= $sonuc['kitap_yazar'];
                                    $kitap_ISBN = $sonuc['kitap_isbn'];
                                    $alinma_tarihi=$sonuc['kitap_alinma_tarihi'];
                                    $teslim_tarihi=$sonuc['kitap_teslim_tarihi'];
                                    $no=1+$no;
                
                                    ?>
                
                                    <tr class="bg-warning">
                                        <th></th><td><?php echo $kitap_adi; ?></td>
                                        <th></th><td><?php echo $yazar; ?></td>
                                        <th></th><td><?php echo $kitap_ISBN; ?></td>
                                        <th></th><td><?php echo $alinma_tarihi; ?></td>
                                        <th></th><td><?php echo $teslim_tarihi; ?></td>
                                    </tr>

                                    <?php 
                                } ;
                            }
                    ?>
                
                </table>
            </form>
      



            <?php 
                    
                    
                if(isset($_POST["FotoUpload"]))
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
                    //echo $isbn_metin4;
                    fclose($isbn_output);

                
                    if($isbn_metin4)
                    {
                        $kontrol=mysqli_query($baglanti,"DELETE FROM kitap_islemleri WHERE alinan_kitap_isbn={$isbn_metin4} AND kitap_alan_kullanici_id={$_SESSION['id']}");
                        if($kontrol)
                        {
                            mysqli_query($baglanti,"UPDATE kitaplar SET kitap_durumu = 0 WHERE kitap_isbn={$isbn_metin4}");
                            echo '<script>alert("İŞLEM BAŞARILI")</script>';
                        }
                        else echo '<script>alert("Kullanıcının üzerindeki kitaplar ile uyuşmayan ISBN !")</script>';
                    }

                    else echo '<script>alert("ISBN okunamadı. Lütfen daha net bir fotoğraf seçiniz.")</script>';

                }
                
            ?>

		<form action="" method="post" enctype="multipart/form-data">
				
			<td><input class="input-group-text" style="font-family:verdana;font-size:18px;height:30px;width:220px;margin-left:370px;margin-top:50px;" type="text" id="KitapArama" name="KitapArama" placeholder="   Kitap Adı veya ISBN"></td>
            <td><input class="btn btn-primary" style="margin-left:-175px;margin-top:70px;" type="submit" name="Listele"value="Kütüphanede Ara"></td>
            
		</form>
            
    
        <table style="margin-left:-70px;margin-top:10px;width:90%" class="table table-dark">
            
                <tr class="bg-info">
				<th></th><th>Sıra No</th>
				<th></th><th>Kitap Adı</th>
				<th></th><th>Yazar</th>
				<th></th><th>Kitap ISBN</th>
				<th></th><th>Kitap Durumu</th>  
				<th></th>
                </tr>
                


            <?php
                //https://mesutd.com/php-ile-mysql-veritabanina-baglanip-veri-ekleme-silme-duzenleme-ve-listeleme bir kısım kod parçalarını kendi kodumuza göre uyarladım.

                if(isset($_POST["Listele"]))
                {
                    
                    $no=0; 
                    // ARAMA SORGUSU
                    $ara=$_POST["KitapArama"];
                    $sorgu = $baglanti->query("SELECT * FROM kitaplar WHERE kitap_adi LIKE '%$ara%' OR  kitap_isbn LIKE '%$ara%'");
                    
                    while ($sonuc = $sorgu->fetch_assoc()) 
                    { 
                    $kitap_alan=$_SESSION['id'];
                    $isbn=$sonuc['kitap_isbn'];
                    $kitap_adi = $sonuc['kitap_adi']; 
                    $yazar = $sonuc['kitap_yazar'];
                    $kitap_durumu=$sonuc['kitap_durumu'];
                    if($kitap_durumu==0) $kitap_durumu2="Müsait";
                    else $kitap_durumu2="Dolu";
                    $no=1+$no;
                    
            ?>

                        <tr class="bg-warning">
                            <th></th><td><?php echo $no; ?></td>
                            <th></th><td><?php echo $kitap_adi; ?></td>
                            <th></th><td><?php echo $yazar; ?></td>
                            <th></th><td><?php echo $isbn; ?></td>  
                            <th></th><td><?php echo $kitap_durumu2; ?></td>
                            <?php if($kitap_durumu==0)
                            {
                            ?>
                            <td><a href="kitapal.php?id=<?php echo $isbn;?>" class="btn btn-primary">Kitabı Al</a></td>
                            <?php 
                            } 
                            ?>
                            <?php if($kitap_durumu==1)
                            {
                            ?>
                            <td><a class="btn btn-danger">Kitap Alınamaz</a></td>
                            <?php 
                            } 
                            ?>
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
        <div class="badge badge-primary text-wrap" style="font-family:arial;font-size:25px;width:24rem;height:3.75rem;margin-left:1290px;margin-top:-140px"><?php echo $_SESSION['login'];echo " "; echo $_SESSION['slogin']; ?></div>
            
    <?php } ?>