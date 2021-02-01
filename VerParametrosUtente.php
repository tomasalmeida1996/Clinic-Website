<?php

$connect = mysqli_connect("127.0.0.84:3307", "root", "","sim");
$sql = 'SELECT IdUtente FROM Utentes u 
		WHERE (IdUtilizador = "'. $_SESSION['id'].'")';
//echo htmlentities($sql);
			   	
$result = mysqli_query ($connect ,$sql) or die('The query failed: ' . mysqli_error($connect));

$row = mysqli_fetch_array($result);
$idUtente = $row[0];

//Contar o numero de fichas do utente em historico
$sql = "SELECT COUNT(f.`IdFichaUtente`) FROM `fichasUtente` f WHERE f.Historico = 1 AND f.`IdUtente` = $idUtente";
//echo htmlentities($query);
$result = mysqli_query ($connect ,$sql) or die('The query failed: ' . mysqli_error($connect));
$row = mysqli_fetch_array($result);
$totalHistorico = $row[0];
		  
//Contar o numero de consultas efetuadas a este utente por todos os obstetras
$sql = "SELECT COUNT(IdConsulta) FROM `consultas` c JOIN fichasutente f ON f.IdFichaUtente = c.IdFichaUtente WHERE c.Concluida = 1 AND f.`IdUtente` = $idUtente";
//echo htmlentities($query);
$result = mysqli_query ($connect ,$sql) or die('The query failed: ' . mysqli_error($connect));
$row = mysqli_fetch_array($result);
$totalConsultas = $row[0];


//Pesquisar a ficha de utente correspondente
$sql = "SELECT `DuracaoInf`, `Causa`, `IMCElemF`, `AFC`, `F_Tabaco`, `M_Tabaco`, `M_Etnia`, `Historico` FROM `fichasutente` WHERE `Historico` = 0 AND `IdUtente` = $idUtente";
//echo htmlentities($sql);
$result = mysqli_query ($connect ,$sql) or die('The query failed: ' . mysqli_error($connect));
$totalrows = mysqli_num_rows($result); 

$row = mysqli_fetch_array($result);

$duracaoInf=$row['DuracaoInf'];

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

<!DOCTYPE html >
<html >

<head>
<link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>

<script>
function goBack() {
    window.history.back();
}
</script>

         <!-- aqui irá ficar o conteudo alteravel-->
         
         <br>
         Estamos a ver os parametros do utente!
         <br>
         <br>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button onclick="goBack()" class= "button">Voltar</button>
       	<form method="POST" action="index.php?operacao=checkParametrosUtente">
       	
		 <table style="height: 277px; width: 469px;">
	     <tr>
	      <td class="action">* Duração da Infertilidade? (em meses)</td>
	      <td>
		  <input type="number" step="0.1" name="duracaoInf" value="<?php echo $duracaoInf; ?>" class= "inputbox" style="width: 100px" readonly=""/>
		  </td>
	     </tr>
	     <tr>
	     <td class="action">* Causa da Infertilidade?</td>
      	 <td>
		  <input type="text" name="causa" value="<?php echo $causa; ?>" class= "inputbox" style="width: 300px" readonly=""/>
		 </td>
 	     </tr>
 	     <tr>
      	 <td class="action">* IMC Elemento Feminino?</td>
      	 <td>
		  <input type="number" step="0.1" name="imcElemF" value="<?php echo $imcElemF; ?>" class= "inputbox" style="width: 100px" readonly=""/>
		 </td>
    	 </tr>
 	     <tr>
      	 <td class="action">* Valor da contagem de Foliculos antrais?</td>
      	 <td>
		  <input type="number" step="0.1" name="afc" value="<?php echo $afc; ?>" class= "inputbox" style="width: 100px" readonly=""/>
		 </td>
    	 </tr>
 	     <tr>
      	 <td class="action">* Elemento Feminino Fuma?</td>
      	 <td>
		  <input type="text" name="tabacoF" value="<?php echo $tabacoF; ?>" class= "inputbox" style="width: 200px" readonly=""/>		 </td>
    	 </tr>    	 
    	 <tr>
      	 <td class="action">* Elemento Masculino Fuma?</td>
      	 <td>
		  <input type="text" name="tabacoM" value="<?php echo $tabacoM; ?>" class= "inputbox" style="width: 200px" readonly=""/>		 </td>
    	 </tr>
    	 <tr>
      	 <td class="action">* Etnia Elemento Masculino?</td>
      	 <td>
		  <input type="text" name="etniaM" value="<?php echo $etniaM; ?>" class= "inputbox" style="width: 150px" readonly=""/>		 </td>
    	 </tr>
         </table>
		</form>		

         <!-- aqui irá ficar o conteudo alteravel-->      
</body>

</html>
