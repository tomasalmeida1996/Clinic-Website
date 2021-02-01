
<!DOCTYPE html >
<html>

<head>
<style type="text/css">
.auto-style1 {
	margin-left: 40px;
}
</style>
</head>

<body>
         <!-- aqui irá ficar o conteudo alteravel-->
         <br>
         Introduza por favor as suas informações!
         <br>
         <?php
         if(isset($_SESSION['Updated'])){
 		  	if($_SESSION['Updated']==0){
		  	 echo'<span style="color:red";text-align:"center"><strong>Este nome de utilizador já existe</strong></span>';
		  	 echo'<br>';
		  	}
		  	else if($_SESSION['Updated']==-1){
		  	 echo'<span style="color:red";text-align:"center"><strong>Existem campos em falta</strong></span>';
		  	 echo'<br>';
		  	}
		  	unset($_SESSION['Updated']);
 		 }
         
		  //fazer select ao utilizador
          $connect = mysqli_connect("127.0.0.84:3307", "root", "","sim");
		  $query = 'SELECT `IdUtilizador`, t.IdTipoUtilizador, t.Descricao AS tipoUtilizador, `Nome`, `Username`, `Password`, `Morada`, `Email`, `DataNascimento`, `Contacto`, `Ativo` FROM `utilizadores`
					JOIN tiposutilizadores t ON t.IdTipoUtilizador = utilizadores.IdTipoUtilizador
					WHERE `IdUtilizador` = '.$_GET['idUtil'];
		  //echo htmlentities($query);
		  $result = mysqli_query ($connect ,$query) or die('The query failed: ' . mysqli_error($connect));
		  $totalrows = mysqli_num_rows($result); 

		  $row = mysqli_fetch_array($result);
		  
		  $idUtilizador=$row['IdUtilizador'];
		  $idTipoUtilizador=$row['IdTipoUtilizador'];
		  $tipoUtilizador=$row['tipoUtilizador'];
		  $nome=$row['Nome'];
		  $user=$row['Username'];
		  $pass=$row['Password'];		  		  
		  $morada=$row['Morada'];
		  $email=$row['Email'];
		  $dataNascimento=$row['DataNascimento'];
		  $contacto=$row['Contacto'];
		  $ativo=$row['Ativo'];		  

         ?>
         
       	<form method="POST" action="index.php?operacao=checkEditUtilizador&idUtil=<?php echo $row['IdUtilizador']; ?>">
       	
		 &nbsp;&nbsp;<table style="height: 277px; width: 469px;">
	     <tr>
	      <td class="action">* Tipo de Utilizador:</td>
	      <td>
		  <input type="text" name="tipoUtilizador" value="<?php echo $row['tipoUtilizador']; ?>" class= "inputbox" style="width: 300px" readonly/></td>
	     </tr>
	     <tr>
	      <td class="action">* Nome:</td>
	      <td>
		  <input type="text" name="nome" value="<?php echo $row['Nome']; ?>" class= "inputbox" style="width: 300px"/></td>
	     </tr>
 	     <tr>
      	 <td class="action">* Morada:</td>
      	 <td>
		 <input type="text" name="morada" value="<?php echo $row['Morada']; ?>" class= "inputbox" style="width: 300px"/>
		 </td>
    	 </tr>
    	 <tr>
      	 <td class="action">* Contacto:</td>
      	 <td>
      	 <input type="text" name="contacto" value="<?php echo $row['Contacto']; ?>" class= "inputbox"/>
      	 </td>
    	 </tr>
      	 <!--
    	 <tr>
      	 <td class="action">Instituição:</td>
      	 <td>
		 <input type="text" name="insti" class= "inputbox" style="width: 300px"/></td>
    	 </tr>
		 -->
    	 <tr>
      	 <td class="action">* Email:</td>
      	 <td>
      	 <input type="text" name="email" value="<?php echo $row['Email']; ?>" class= "inputbox"style="width: 200px"/>
      	 </td>
    	 </tr>
    	 <tr>
      	 <td class="action">* Username:</td>
      	 <td>
		 <input type="text" name="user" value="<?php echo $row['Username']; ?>" class= "inputbox" style="width: 200px"/>
		 </td>
    	 </tr>
    	 <tr>
      	 <td class="action">* Password:</td>
      	 <td>
		 <input type="password" name="pass" value="<?php echo $row['Password']; ?>" class= "inputbox" style="width: 200px"/>
		 </td>
    	 </tr>
    	 <?php
    	 if ($idTipoUtilizador == 1 OR $idTipoUtilizador == 3) {
    	 ?>
    	 <tr>
      	 <td class="action">* Ativo:</td>
      	 <td>
		 <?php 
		 if($row['Ativo'] == 1){
		 	echo '<input type="checkbox" name="checkAtivo" checked="checked"/>';
		 }
		 else{
	 		echo '<input type="checkbox" name="checkAtivo" value="1"/>';
		 } 
		 ?>
		 </td>
    	 </tr>
    	 <?php
    	 }//fechar o if
    	 ?>
         </table>
         <p>&nbsp;&nbsp;* Campos obrigatórios</p>
         &nbsp;&nbsp;<input type="submit" name="Submit" value="Submit" class= "button">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 	  	 <input type="reset" name="Reset" value="Reset" class= "button"></form>		

         <!-- aqui irá ficar o conteudo alteravel-->      
</body>

</html>
