<!DOCTYPE html >
<html >

<body>
         <!-- aqui irá ficar o conteudo alteravel-->
         Seja bem-Vindo
         <br>Introduza por favor as suas credenciais de acesso!
         
       	<form method="POST" action="index.php?operacao=checkLogin">
		    <strong>Utilizador</strong>:&nbsp;&nbsp; 
			<input type="text" name="user" style="width: 144px; " class= "inputbox">
		 <br>
		 <br><strong>Password</strong>:&nbsp;
		 <input type="password" name="pass" style="width: 146px" class= "inputbox"> <br>
		 <br>
		 <?php
		 	
 			  if(isset($_SESSION['authuser'])){
 			  	if($_SESSION['authuser']==0){
			  	echo'<span style="color:red";text-align:"center"><strong>Por favor introduza as credenciais corretas</strong></span>';
			  	echo'<br>';
			  	}
		    	unset($_SESSION['authuser']);
			  }
			  else if (isset($_SESSION['id'])){
			  	echo'<span style="color:green";text-align:"center"><strong>Login efectuado com sucesso</strong></span>';
			  	echo'<br>';
			  }
		 ?>
		 <br>
	  	 <input type="submit" name="Submit" value="Submit" class= "button">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 	  	 <input type="button" name="Recuperar" value="Recuperar Palavra-passe" class= "button" style="width: 160px">
 		 <br>
		 <br>
		</form>		
       	<form method="POST" action="index.php?operacao=registoUtente">
		 <p >Se é um utente da nossa clinica e ainda não está inscrito no site por favor faça o seu registo!</p>
		 <input type="submit" name="Registar" value="Registar Agora" class="button" style="width: 170px">
		</form>


         <!-- aqui irá ficar o conteudo alteravel-->      
</body>

</html>
