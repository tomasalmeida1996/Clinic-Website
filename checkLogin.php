<!DOCTYPE html >
<html >

<head>
<title>SocialNet</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body style="height: 221px; color: #000000;">
         <!-- aqui irá ficar o conteudo alteravel-->
         <?php
		 	
 			  if(!isset($_SESSION['id'])){
 			  	//echo '<br>';
 			  	include "login.php";
			  }
			  
			  else {//login sucesso
			  	echo '<br>';
			  	echo '<span style="color:green";text-align:"center"><strong>Login efectuado com sucesso</strong></span>';
			  	echo '<br>';
			  }
		 ?>
		
         <!-- aqui irá ficar o conteudo alteravel-->      
</body>

</html>
