<?php 
  
   include("database.php");
   
   sleep(1);

  $value = $_POST["value"];
  
  if(!$value){
	  	
	echo "bir kelime girmeniz gerekiyor...";

  }else {
	  
	  $row = $db->prepare("SELECT * FROM kitaplar WHERE kitap_adi LIKE ?");
	  $row->execute(array("%".$value."%"));
	  $goster = $row->fetchAll(PDO::FETCH_ASSOC);
	  $x = $row->rowCount();
	  
	   if($x){
		   
		   foreach($goster as $liste){
			   
			   echo "<a href=''>".$liste["kitap_adi"]."</a><br />";
		   }
		   
	   }else {
		   
		  echo "Aradığınız kitap veritabana kayıtlı değil...";
		   
	   }
	  
  }


?>