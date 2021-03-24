<?php 


   try {
	   
	  $db = new PDO("mysql:host=localhost;dbname=yazlab;charset=utf8","root","root"); 
	   
   }catch (PDOException $mesaj) {
	   
	  echo $mesaj->getmessage(); 
	   
   }


?>