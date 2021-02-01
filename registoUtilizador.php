<!DOCTYPE html >
<html >

<body>
         <!-- aqui irá ficar o conteudo alteravel-->
         <br>
         Introduza as informações do utilizador!
         <br>
         <?php
         	if(isset($_SESSION['registoUtilizador'])){
 			  	if($_SESSION['registoUtilizador']==0){
			  	 echo'<span style="color:red";text-align:"center"><strong>Este nome de utilizador já existe</strong></span>';
			  	 echo'<br>';
			  	}
			  	else if($_SESSION['registoUtilizador']==-1){
			  	 echo'<span style="color:red";text-align:"center"><strong>Existem campos em falta</strong></span>';
			  	 echo'<br>';
			  	}
			  	unset($_SESSION['registoUtilizador']);
			}
			
			
         ?>
         
       	<form method="POST" action="index.php?operacao=checkRegistoUtilizador">
       	
		 <table style="height: 277px; width: 469px;">
	     <tr>
	      <td class="action">* Tipo de Utilizador:</td>
	      <td>
		  <select name="TipoUtilizador">
    	  <option value="-1" selected>Escolha</option>
    	  <option value="3">Obstetra</option>
	      <option value="4">Investigador</option>
		  </select>
	     </tr>
	     <tr>
	      <td class="action">* Nome:</td>
	      <td>
		  <input type="text" name="nome"  class= "inputbox" style="width: 300px"/></td>
	     </tr>
	     <tr>
	     <td class="action">* Apelido:</td>
	     <td>
		 <input type="text" name="apelido"  class= "inputbox" style="width: 300px"/>
		 </td>
 	     </tr>
 	     <tr>
      	 <td class="action">* Morada:</td>
      	 <td>
		 <input type="text" name="morada" class= "inputbox" style="width: 300px"/>
		 </td>
    	 </tr>
    	 <tr>
      	 <td class="action">* Contacto:</td>
      	 <td>
      	 <input type="text" name="contacto" class= "inputbox"/>
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
      	 <td class="action">* Email:</td>
      	 <td>
      	 <input type="text" name="email" class= "inputbox"style="width: 200px"/>
      	 </td>
    	 </tr>
    	 <tr>
      	 <td class="action">* Username:</td>
      	 <td>
		 <input type="text" name="user" class= "inputbox" style="width: 200px"/>
		 </td>
    	 </tr>
    	 <tr>
      	 <td class="action">* Password:</td>
      	 <td>
		 <input type="password" name="pass" class= "inputbox" style="width: 200px"/>
		 </td>
    	 </tr>
         </table>
         <p>* Campos obrigatórios</p>
         <input type="submit" name="Submit" value="Submit" class= "button">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 	  	 <input type="reset" name="Reset" value="Reset" class= "button">
		</form>		

         <!-- aqui irá ficar o conteudo alteravel-->      
</body>

</html>
