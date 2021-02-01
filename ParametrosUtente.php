<!DOCTYPE html >
<html >

<body>
         <!-- aqui irá ficar o conteudo alteravel-->
         Seja bem-Vindo
         <br>
         Introduza por favor as suas informações!
         <br>
         <?php
         	if(isset($_SESSION['registoParametros'])){
			  	if($_SESSION['registoParametros']==-1){
			  	 echo'<span style="color:red";text-align:"center"><strong>Existem campos em falta</strong></span>';
			  	 echo'<br>';
			  	}
			  	unset($_SESSION['registoParametros']);
			}
			
         ?>
       	<form method="POST" action="index.php?operacao=checkParametrosUtente">
       	
		 <table style="height: 277px; width: 469px;">
	     <tr>
	      <td class="action">* Duração da Infertilidade? (em meses)</td>
	      <td>
	      <input type="hidden" value="2" name="TipoUtilizador" /><!-- Utente tem Id 2 -->
		  <input type="number" step="0.1" name="duracaoInf"  class= "inputbox" style="width: 300px"/></td>
	     </tr>
	     <tr>
	     <td class="action">* Causa da Infertilidade?</td>
      	 <td>
		  <select name="causa">
    	  <option value="-1" selected>Escolha</option>
    	  <option value="1">Endometriose</option>
    	  <option value="2">Fator Masculino</option>
    	  <option value="3">Fatores Femininos e Masculinos</option>
    	  <option value="4">Infertilidade Inexplicada</option>
    	  <option value="5">Múltiplos Fatores Exclusivamente Femininos</option>
    	  <option value="6">Outro</option>
    	  <option value="7">Ovulatório</option>
    	  <option value="8">Tubário</option>    	  
    	  </select>		 
		 </td>
 	     </tr>
 	     <tr>
      	 <td class="action">* IMC Elemento Feminino?</td>
      	 <td>
		 <input type="number" step="0.1" name="imcElemF" class= "inputbox" style="width: 300px"/>
		 </td>
    	 </tr>
 	     <tr>
      	 <td class="action">* Valor da contagem de Foliculos antrais?</td>
      	 <td>
		 <input type="number" step="0.1" name="afc" class= "inputbox" style="width: 150px"/>
		 </td>
    	 </tr>
 	     <tr>
      	 <td class="action">* Elemento Feminino Fuma?</td>
      	 <td>
		  <select name="ftabaco">
    	  <option value="-1" selected>Escolha</option>
    	  <option value="1">Anteriores</option>
    	  <option value="2">Nunca</option>
    	  <option value="3">Presentes</option>    	  
		  </select>		 
		 </td>
    	 </tr>    	 
    	 <tr>
      	 <td class="action">* Elemento Masculino Fuma?</td>
      	 <td>
		  <select name="mtabaco">
    	  <option value="-1" selected>Escolha</option>
    	  <option value="1">Anteriores</option>
    	  <option value="2">Nunca</option>
    	  <option value="3">Presentes</option>    	  
		  </select>		 
		 </td>
    	 </tr>
    	 <tr>
      	 <td class="action">* Etnia Elemento Masculino?</td>
      	 <td>
		  <select name="etniaM">
    	  <option value="-1" selected>Escolha</option>
    	  <option value="1">Asiática</option>
    	  <option value="2">Caucasiana</option>
    	  <option value="3">Cigana</option>  
    	  <option value="4">Indiana</option>
    	  <option value="5">Mista</option>
    	  <option value="6">Negra</option>
		  </select>		 
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
