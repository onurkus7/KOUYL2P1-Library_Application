<?php 
   /* session_start();
	include("veritabani.php");
	error_reporting(0);
    if(strlen($_SESSION['alogin'])!=0)
       {   
         header('location:adminpanel.php');
       }
	elseif(strlen($_SESSION['login'])!=0)
	   {   
		 header('location:userpanel.php');
	   }
*/
 ?>

<!DOCTYPE HTML>
<html lang="en-US">
<head>
<div class="header_logo">
</div>

<form action="index.php" method="POST">
<button type="submit" name="adminButon" id="adminButon">Yönetici Girişi</button>
<button type="submit" name="userButon" id="userButon">Kullanıcı Girişi</button>
</form>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<meta charset="UTF-8">
	<title>K4RK1N</title>
	<link rel="stylesheet" href="style.css" />
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
	<script type="text/javascript">  
  
    $(function(){
		
	   $("#sonuc").hide();
	   
	   $("input[name=ara]").keyup(function(){
		   
		   var value  = $(this).val(); 
		   var konu   = "value="+value;
		   
		   $.ajax({
			   
			   type: "post",
               url:   "kitapajax.php",
               data: konu, 
			   beforeSend: function(){
				   
				  $("#sonuc").fadeIn().html('<img src="http://i.hizliresim.com/Eg605Z.gif" width="20" height="20" />'); 
				   
			   },
			   
               success: function(sonuc){
				   
				  $("#sonuc").show().html(sonuc); 
				   
			   }			   
		   }); 
	   });
	});
	</script>	
	  
</head>
<style>
body {
  background-image: url('wallpaper/home.jpg');
}
</style>
<body>
	 <div id="genel">  
	 <div id="ara"> 
	 <h2 style="margin:10px 2px ;padding:5px;border:1px solid #eee;width:300px;background:#eee">K4RK1N Kütüphanesi</h2>
	 <input type="text" name="ara" placeholder="Kitap Adı"  /> 
	 <button type="submit">ARA</button>
	 </div>
	 
	 <div id="sonuc">  
	 <span>sonuc</span>
	 </div>
	
	 </div>
	 
</body>
</html>

<?php

  if(isset($_POST["adminButon"]))
    {
      header('Location: adminlogin.php');
    }
  elseif(isset($_POST["userButon"]))
    {	
      header('Location: userlogin.php');
    }

?>