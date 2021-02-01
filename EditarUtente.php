
<!DOCTYPE html >
<html>
<body>
<!--
<form name="form" action="search2.php" method="get">
  <input type="text" name="q" />
	<input type="hidden" name="n" value="<? echo $newpage; ?>">
  <input type="submit" name="Submit" value="Search" />
</form>
-->
         <!-- aqui irá ficar o conteudo alteravel-->
         <br>
         Estamos a editar o utente!
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
          
		  $query = 'SELECT `IdUtente`, u.`IdUtilizador`, util.`IdTipoUtilizador`, util.`Username` AS Username, util.`Password` AS Password, `NomeCompleto`, u.`Morada`, u.`Localidade`, u.`Distrito`, u.`Contacto`, u.`Email`, u.`DataNascimento`, u.`Sexo`, `NIF`, `CartaoSaude`, `Alergias` 
				  	FROM `utentes` u
				  	JOIN Utilizadores util ON util.IdUtilizador = u.IdUtilizador
					WHERE u.`IdUtilizador` = '.$_GET['idUtil'];
		  //echo htmlentities($query);
		  $result = mysqli_query ($connect ,$query) or die('The query failed: ' . mysqli_error($connect));
		  $totalrows = mysqli_num_rows($result); 

		  $row = mysqli_fetch_array($result);
		  
		  $idUtente=$row['IdUtente'];
		  $idUtilizador=$row['IdUtilizador'];
		  $nome=$row['NomeCompleto'];
		  $user=$row['Username'];
		  $pass=$row['Password'];		  		  
		  $morada=$row['Morada'];
		  $localidade=$row['Localidade'];
		  $distrito=$row['Distrito'];		  
		  $email=$row['Email'];
		  $dataNascimento=$row['DataNascimento'];
		  $contacto=$row['Contacto'];
		  $sexo=$row['Sexo'];
		  $nif=$row['NIF'];
		  $cartaoSaude=$row['CartaoSaude'];
		  $alergias=$row['Alergias'];

         ?>
         
       	<form method="POST" action="index.php?operacao=checkEditUtente&idUtil=<?php echo $row['IdUtilizador']; ?>">
       	
		 &nbsp;&nbsp;<table style="height: 277px; width: 469px;">
	     <tr>
	      <td class="action"> Nome:</td>
	      <td>
		  <input type="text" name="nome" value="<?php echo $row['NomeCompleto']; ?>" class= "inputbox" style="width: 300px"/></td>
	     </tr>
 	     <tr>
      	 <td class="action"> Morada:</td>
      	 <td>
		 <input type="text" name="morada" value="<?php echo $row['Morada']; ?>" class= "inputbox" style="width: 300px"/>
		 </td>
    	 </tr>
 	     <tr>
      	 <td class="action"> Localidade:</td>
      	 <td>
		 <input type="text" name="localidade" value="<?php echo $row['Localidade']; ?>" class= "inputbox" style="width: 200px"/>
		 </td>
    	 </tr>
 	     <tr>
      	 <td class="action"> Distrito:</td>
      	 <td>
		 <input type="text" name="distrito" value="<?php echo $row['Distrito']; ?>" class= "inputbox" style="width: 200px"/>
		 </td>
    	 </tr>
    	 <tr>
      	 <td class="action"> Contacto:</td>
      	 <td>
      	 <input type="text" name="contacto" value="<?php echo $row['Contacto']; ?>" class= "inputbox"/>
      	 </td>
    	 </tr>
    	 <tr>
      	 <!--
      	 <td class="action">Instituição:</td>
      	 <td>
		 <input type="text" name="insti" class= "inputbox" style="width: 300px"/></td>
    	 </tr>
		 -->
    	 <tr>
      	 <td class="action"> Email:</td>
      	 <td>
      	 <input type="text" name="email" value="<?php echo $row['Email']; ?>" class= "inputbox"style="width: 200px"/>
      	 </td>
    	 </tr>
 	     <tr>
      	 <td class="action"> Data de Nascimento:</td>
      	 <td>
		 <input type="date" name="dataNascimento" value="<?php echo $row['DataNascimento']; ?>" class= "inputbox" style="width: 130px"/>
		 </td>
    	 </tr>
 	     <tr>
      	 <td class="action"> Sexo:</td>
      	 <td>
		  <select name="sexo">
      	 <?php
      	 if($sexo == 'M') {
    	  echo '<option value="F">Feminino</option>';
    	  echo '<option value="M" selected>Masculino</option>';
    	 }
    	 else {
    	  echo '<option value="F" selected>Feminino</option>';
    	  echo '<option value="M">Masculino</option>';    	 
		 } 
		 ?>		 
		 </select>		 		 
		 </td>
    	 </tr>
 	     <tr>
      	 <td class="action"> NIF:</td>
      	 <td>
		 <input type="text" name="nif" value="<?php echo $row['NIF']; ?>" class= "inputbox" style="width: 150px"/>
		 </td>
    	 </tr>
 	     <tr>
      	 <td class="action"> Cartão de Saude:</td>
      	 <td>
		 <input type="text" name="cartaoSaude" value="<?php echo $row['CartaoSaude']; ?>" class= "inputbox" style="width: 150px"/>
		 </td>
    	 </tr>
 	     <tr>
      	 <td class="action"> Alergias:</td>
      	 <td>
		 <input type="text" name="alergias" value="<?php echo $row['Alergias']; ?>" class= "inputbox" style="width: 300px"/>
		 </td>
    	 </tr>
    	 <tr>
      	 <td class="action"> Username:</td>
      	 <td>
		 <input type="text" name="user" value="<?php echo $row['Username']; ?>" class= "inputbox" style="width: 200px"/>
		 </td>
    	 </tr>
    	 <tr>
      	 <td class="action"> Password:</td>
      	 <td>
		 <input type="password" name="pass" value="<?php echo $row['Password']; ?>" class= "inputbox" style="width: 200px"/>
		 </td>
    	 </tr>    	 
         </table>
         <p>&nbsp;&nbsp;</p>
         
         &nbsp;&nbsp;<input type="submit" name="Submit" value="Submit" class= "button">
 	  	 </form>		

         <!-- aqui irá ficar o conteudo alteravel-->      
</body>

</html>
