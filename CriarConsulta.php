
<!DOCTYPE html >
<html>

<head>
<link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>
<script>
function goBack() {
    window.history.back();
}
</script>

	<div>
	  <div class="divsubtitle">
         <!-- aqui irá ficar o conteudo alteravel-->
         <br>
         Estamos a visualizar os dados do utente da consulta!
         <br>
         Pretende voltar atrás? 
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button onclick="goBack()" class= "button">Voltar</button>
      </div>
         <?php
         
         if(isset($_SESSION['erroAvaliar']) AND $_SESSION['erroAvaliar'] ==1) {
		  	 echo'<span style="color:red";text-align:"center"><strong>O campo Tipo de Consulta está em falta!</strong></span>';
		  	 echo'<br>';         
         }
         
          $connect = mysqli_connect("127.0.0.84:3307", "root", "","sim");
          
          //Contar o numero de fichas do utente em historico
		  $query = 'SELECT COUNT(f.`IdFichaUtente`)
				  	FROM `fichasUtente` f
					WHERE f.Historico = 1 AND f.`IdUtente` = '.$_GET['idUtente'];
		  //echo htmlentities($query);
		  $result = mysqli_query ($connect ,$query) or die('The query failed: ' . mysqli_error($connect));
		  $row = mysqli_fetch_array($result);
		  $totalHistorico = $row[0];

          //Contar o numero de consultas efetuadas a este cliente por todos os obstetras
		  $query = 'SELECT COUNT(IdConsulta) 
					FROM `consultas` c 	
					JOIN fichasutente f ON f.IdFichaUtente = c.IdFichaUtente
					WHERE c.Concluida = 1 AND f.`IdUtente` = '.$_GET['idUtente'];
		  //echo htmlentities($query);
		  $result = mysqli_query ($connect ,$query) or die('The query failed: ' . mysqli_error($connect));
		  $row = mysqli_fetch_array($result);
		  $totalConsultas = $row[0];
          
		  $query = 'SELECT u.`IdUtente`, u.`NomeCompleto`, u.`Contacto`, u.`DataNascimento`, u.`Sexo`, f.`DuracaoInf`, `Causa`, `IMCElemF`, `AFC`, `F_Tabaco`, `M_Tabaco`, `M_Etnia`, `Historico` 
				  	FROM `fichasUtente` f
				  	JOIN Utentes u ON u.IdUtente = f.IdUtente
					WHERE f.Historico = 0 AND u.`IdUtente` = '.$_GET['idUtente'];
		  //echo htmlentities($query);
		  $result = mysqli_query ($connect ,$query) or die('The query failed: ' . mysqli_error($connect));
		  $totalrows = mysqli_num_rows($result); 

		  $row = mysqli_fetch_array($result);

		  $idUtente=$row['IdUtente'];
		  $nome=$row['NomeCompleto'];
		  $dataNascimento=$row['DataNascimento'];
		  $contacto=$row['Contacto'];
		  if ($row['Sexo'] == 'M'){
		  	$sexo = 'Masculino';
		  }		  
		  else {
		  	$sexo = 'Feminino';
		  }
		  $duracaoInf=$row['DuracaoInf'];
		  //$causa=$row['Causa'];		  
		  switch($row['Causa']){
		   	  case '1': $causa = 'Endometriose';
		   	  break;
		   	  case '2': $causa = 'Fator Masculino';
		   	  break;
		   	  case '3': $causa = 'Fatores Femininos e Masculinos';
		   	  break;
		   	  case '4': $causa = 'Infertilidade Inexplicada';
		   	  break;
		   	  case '5': $causa = 'Múltiplos Fatores Exclusivamente Femininos';
		   	  break;
		   	  case '6': $causa = 'Outro';
		   	  break;
		   	  case '7': $causa = 'Ovulatório';
		   	  break;
		   	  case '8': $causa = 'Tubário';
		   	  break;
			  default: $causa = '';
			  break;	   	  
		  }
		  
		  $imcElemF=$row['IMCElemF'];
		  $afc=$row['AFC'];
		  //$tabacoF=$row['F_Tabaco'];
		  switch($row['F_Tabaco']){
		   	  case '1': $tabacoF= 'Anteriores';
		   	  break;
		   	  case '2': $tabacoF= 'Nunca';
		   	  break;
		   	  case '3': $tabacoF= 'Presentes';
		   	  break;
			  default: $tabacoF= '';
			  break;	   	  
		  }

		  //$tabacoM=$row['M_Tabaco'];
		  switch($row['M_Tabaco']){
		   	  case '1': $tabacoM= 'Anteriores';
		   	  break;
		   	  case '2': $tabacoM= 'Nunca';
		   	  break;
		   	  case '3': $tabacoM= 'Presentes';
		   	  break;
			  default: $tabacoM= '';
			  break;	   	  
		  }
		  $etniaM=$row['M_Etnia'];
		  switch($row['M_Etnia']){
		   	  case '1': $etniaM= 'Asiática';
		   	  break;
		   	  case '2': $etniaM= 'Caucasiana';
		   	  break;
		   	  case '3': $etniaM= 'Cigana';
		   	  break;
		   	  case '4': $etniaM= 'Indiana';
		   	  break;
		   	  case '5': $etniaM= 'Mista';
		   	  break;
		   	  case '6': $etniaM= 'Negra';
		   	  break;
			  default: $etniaM= '';
			  break;	   	  
		  }
		  
		  $historico=$row['Historico'];

         ?>         

	  <div class="divSubColumn">
	   <div class="subColumnLeft">
 		 <form method="POST" action="index.php?operacao=AvaliarUtente&idUtente=<?php echo $row['IdUtente']; ?>">
       	
		 &nbsp;&nbsp;<table style="height: 277px; width: 469px;">
	     <tr>
	      <td class="action"> Total de fichas em histórico:</td>
	      <td>
		  <input type="text" name="nome" value="<?php echo $totalHistorico; ?>" class= "inputbox" style="width: 300px" readonly/></td>
	     </tr>
	     <tr>
	      <td class="action"> Total de consultas efetuadas a este utente:</td>
	      <td>
		  <input type="text" name="nome" value="<?php echo $totalConsultas; ?>" class= "inputbox" style="width: 300px" readonly/></td>
	     </tr>
	     <tr>
	     
	     </tr>
	     <tr>
	      <td class="action"> Nome:</td>
	      <td>
		  <input type="text" name="nome" value="<?php echo $row['NomeCompleto']; ?>" class= "inputbox" style="width: 300px" readonly/></td>
	     </tr>
    	 <tr>
      	 <td class="action"> Contacto:</td>
      	 <td>
      	 <input type="text" name="contacto" value="<?php echo $row['Contacto']; ?>" class= "inputbox" readonly/>
      	 </td>
    	 </tr>
 	     <tr>
      	 <td class="action"> Data de Nascimento:</td>
      	 <td>
		 <input type="text" name="dataNascimento" value="<?php echo $row['DataNascimento']; ?>" class= "inputbox" style="width: 300px" readonly/>
		 </td>
    	 </tr>
 	     <tr>
      	 <td class="action"> Sexo:</td>
      	 <td>
		 <input type="text" name="sexo" value="<?php echo $sexo; ?>" class= "inputbox" style="width: 300px" readonly/>
		 </td>
    	 </tr>
    	 <tr>
      	 <td class="action"> Duração Infertilidade:</td>
      	 <td>
		 <input type="text" name="user" value="<?php echo $duracaoInf; ?>" class= "inputbox" style="width: 200px" readonly/>
		 </td>
    	 </tr>
    	 <tr>
      	 <td class="action"> Causa da Infertilidade:</td>
      	 <td>
		 <input type="text" name="user" value="<?php echo $causa; ?>" class= "inputbox" style="width: 200px" readonly/>
		 </td>
    	 </tr>
    	 <tr>
      	 <td class="action"> IMC do elemento Feminino:</td>
      	 <td>
		 <input type="text" name="user" value="<?php echo $imcElemF; ?>" class= "inputbox" style="width: 200px" readonly/>
		 </td>
    	 </tr>
    	 <tr>
      	 <td class="action"> Contagem de foliculos antrais:</td>
      	 <td>
		 <input type="text" name="user" value="<?php echo $afc; ?>" class= "inputbox" style="width: 200px" readonly/>
		 </td>
    	 </tr>
    	 <tr>
      	 <td class="action"> Tabagismo elemento feminino:</td>
      	 <td>
		 <input type="text" name="user" value="<?php echo $tabacoF; ?>" class= "inputbox" style="width: 200px" readonly/>
		 </td>
    	 </tr>
    	 <tr>
      	 <td class="action"> Tabagismo elemento masculino:</td>
      	 <td>
		 <input type="text" name="user" value="<?php echo $tabacoM; ?>" class= "inputbox" style="width: 200px" readonly/>
		 </td>
    	 </tr>
    	 <tr>
      	 <td class="action"> Etnia Elemento Masculino:</td>
      	 <td>
		 <input type="text" name="user" value="<?php echo $etniaM; ?>" class= "inputbox" style="width: 200px" readonly/>
		 </td>
    	 </tr>
    	 <tr>
      	 <td class="action"> Tipo de Consulta:</td>
      	 <td>
		  <select name="tipoConsulta">
    	  <option value="-1" selected>Escolha</option>
    	  <option value="AntesTratamento">Antes-Tratamento</option>
    	  <option value="PósTratamento">Pós-Tratamento</option>
		  </select>		 
		 </td>
    	 </tr>
         </table>
         <p>&nbsp;&nbsp;</p>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="Avaliar" value="Avaliar" class= "button">
 	  	 </form>
 	   </div>	
 	   <div class="subColumnRight">
 	   
 	   
 	   </div>
	  </div>
         <!-- aqui irá ficar o conteudo alteravel-->      
    </div>
</body>

</html>
