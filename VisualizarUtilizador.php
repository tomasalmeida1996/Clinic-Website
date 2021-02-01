
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
         Estamos a ver o utilizador!
         <br>
         <?php
         
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
	      <td class="action"> Tipo de Utilizador:</td>
	      <td>
		  <input type="text" name="tipoUtilizador" value="<?php echo $row['tipoUtilizador']; ?>" class= "inputbox" style="width: 300px" readonly/></td>
	     </tr>
	     <tr>
	      <td class="action"> Nome:</td>
	      <td>
		  <input type="text" name="nome" value="<?php echo $row['Nome']; ?>" class= "inputbox" style="width: 300px" readonly/></td>
	     </tr>
 	     <tr>
      	 <td class="action"> Morada:</td>
      	 <td>
		 <input type="text" name="morada" value="<?php echo $row['Morada']; ?>" class= "inputbox" style="width: 300px" readonly/>
		 </td>
    	 </tr>
    	 <tr>
      	 <td class="action"> Contacto:</td>
      	 <td>
      	 <input type="text" name="contacto" value="<?php echo $row['Contacto']; ?>" class= "inputbox" readonly/>
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
      	 <input type="text" name="email" value="<?php echo $row['Email']; ?>" class= "inputbox"style="width: 200px" readonly/>
      	 </td>
    	 </tr>
    	 <tr>
      	 <td class="action"> Username:</td>
      	 <td>
		 <input type="text" name="user" value="<?php echo $row['Username']; ?>" class= "inputbox" style="width: 200px" readonly/>
		 </td>
    	 </tr>
    	 <tr>
      	 <td class="action"> Password:</td>
      	 <td>
		 <input type="password" name="pass" value="<?php echo $row['Password']; ?>" class= "inputbox" style="width: 200px" readonly/>
		 </td>
    	 </tr>
    	 <?php
    	 if ($idTipoUtilizador == 1 OR $idTipoUtilizador == 3) {
    	 ?>
    	 <tr>
      	 <td class="action"> Ativo:</td>
      	 <td>
		 <?php 
			 if($row['Ativo'] == 1){
			 	echo '<select name="Ativo">';
 	    	    echo '<option value="1" selected>Sim</option>';
			    echo '</select>';

			 }
			 else{
			 	echo '<select name="Ativo">';
 	    	    echo '<option value="0" selected>Não</option>';
			    echo '</select>'; 	    	    
			 } 
		 ?>
		 </td>
    	 </tr>
    	 <?php
    	 }//fechar o if
    	 ?>
         </table>
         <p>&nbsp;&nbsp;</p>
         <!--
         &nbsp;&nbsp;<input type="submit" name="Submit" value="Submit" class= "button">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 	  	 <input type="reset" name="Reset" value="Reset" class= "button">
 	  	 -->
 	  	 </form>		

         <!-- aqui irá ficar o conteudo alteravel-->      
</body>

</html>
