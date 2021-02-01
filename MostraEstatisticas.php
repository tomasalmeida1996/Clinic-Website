<?php

//if(isset($_GET['consulta']) AND $_GET['consulta'] == 1){
//grava a consulta
//	if ($_POST['recomendacao'] != '-1') {

$connect = mysqli_connect("127.0.0.84:3307", "root", "","sim");

$sql = 'SELECT 
		MIN(`DuracaoInf`) AS duracaoMin, ROUND(AVG(`DuracaoInf`), 1) AS duracaoAvg, MAX(`DuracaoInf`) AS duracaoMax, 
		MIN(`IMCElemF`) AS imcElemFMin, ROUND(AVG(`IMCElemF`), 1) AS imcElemFAvg, MAX(`IMCElemF`) AS imcElemFMax, 
		MIN(`AFC`) AS afcMin, ROUND(AVG(`AFC`), 1) AS afcAvg, MAX(`AFC`) AS afcMax 
		FROM `fichasutente` ';
		
//echo htmlentities($sql);			   	
$result = mysqli_query ($connect ,$sql) or die('The query failed: ' . mysqli_error($connect));
$row = mysqli_fetch_array($result);


$duracaoMin=$row['duracaoMin'];
$duracaoAvg=$row['duracaoAvg'];
$duracaoMax=$row['duracaoMax'];
$imcElemFMin=$row['imcElemFMin'];
$imcElemFMax=$row['imcElemFMax'];
$imcElemFAvg=$row['imcElemFAvg'];
$afcMin=$row['afcMin'];
$afcMax=$row['afcMax'];
$afcAvg=$row['afcAvg'];

//causa
$sql = 'SELECT `Causa`, COUNT(`Causa`)
		FROM `fichasutente` 
		GROUP BY `Causa` 
		ORDER BY COUNT(`Causa`) DESC
		LIMIT 1 ';		
//echo htmlentities($sql);			   	
$result = mysqli_query ($connect ,$sql) or die('The query failed: ' . mysqli_error($connect));
$row = mysqli_fetch_array($result);
$causaMax=$row[0];

$sql = 'SELECT `Causa`, COUNT(`Causa`)
		FROM `fichasutente` 
		GROUP BY `Causa` 
		ORDER BY COUNT(`Causa`)
		LIMIT 1 ';		
//echo htmlentities($sql);			   	
$result = mysqli_query ($connect ,$sql) or die('The query failed: ' . mysqli_error($connect));
$row = mysqli_fetch_array($result);
$causaMin=$row[0];

			//mediana
$sql = 'SELECT ROUND(AVG(ff.Causa), 0) as median_val
		FROM (
		SELECT f.Causa, @rownum:=@rownum+1 as `row_number`, @total_rows:=@rownum
		  FROM fichasutente f, (SELECT @rownum:=0) r
		  WHERE f.Causa is NOT NULL
		  ORDER BY f.Causa
		) as ff
		WHERE ff.row_number IN ( FLOOR((@total_rows+1)/2), FLOOR((@total_rows+2)/2) ) ';		
//echo htmlentities($sql);			   	
$result = mysqli_query ($connect ,$sql) or die('The query failed: ' . mysqli_error($connect));
$row = mysqli_fetch_array($result);
$causaMediana=$row[0];


switch($causaMax){
	case '1': $causaMax = 'Endometriose';
	break;
	case '2': $causaMax = 'Fator Masculino';
	break;
	case '3': $causaMax = 'Fatores Femininos e Masculinos';
	break;
	case '4': $causaMax = 'Infertilidade Inexplicada';
	break;
	case '5': $causaMax = 'Múltiplos Fatores Exclusivamente Femininos';
	break;
	case '6': $causaMax = 'Outro';
	break;
	case '7': $causaMax = 'Ovulatório';
	break;
	case '8': $causaMax = 'Tubário';
	break;
	default: $causaMax = '';
	break;	   	  
}

switch($causaMin){
	case '1': $causaMin = 'Endometriose';
	break;
	case '2': $causaMin = 'Fator Masculino';
	break;
	case '3': $causaMin = 'Fatores Femininos e Masculinos';
	break;
	case '4': $causaMin = 'Infertilidade Inexplicada';
	break;
	case '5': $causaMin = 'Múltiplos Fatores Exclusivamente Femininos';
	break;
	case '6': $causaMin = 'Outro';
	break;
	case '7': $causaMin = 'Ovulatório';
	break;
	case '8': $causaMin = 'Tubário';
	break;
	default: $causaMin = '';
	break;	   	  
}

switch($causaMediana){
	case '1': $causaMediana = 'Endometriose';
	break;
	case '2': $causaMediana = 'Fator Masculino';
	break;
	case '3': $causaMediana = 'Fatores Femininos e Masculinos';
	break;
	case '4': $causaMediana = 'Infertilidade Inexplicada';
	break;
	case '5': $causaMediana = 'Múltiplos Fatores Exclusivamente Femininos';
	break;
	case '6': $causaMediana = 'Outro';
	break;
	case '7': $causaMediana = 'Ovulatório';
	break;
	case '8': $causaMediana = 'Tubário';
	break;
	default: $causaMediana = '';
	break;	   	  
}


//F_Tabaco
$sql = 'SELECT `F_Tabaco`, COUNT(`F_Tabaco`)
		FROM `fichasutente` 
		GROUP BY `F_Tabaco` 
		ORDER BY COUNT(`F_Tabaco`) DESC
		LIMIT 1 ';		
//echo htmlentities($sql);			   	
$result = mysqli_query ($connect ,$sql) or die('The query failed: ' . mysqli_error($connect));
$row = mysqli_fetch_array($result);
$tabacoFMax=$row[0];

$sql = 'SELECT `F_Tabaco`, COUNT(`F_Tabaco`)
		FROM `fichasutente` 
		GROUP BY `F_Tabaco` 
		ORDER BY COUNT(`F_Tabaco`)
		LIMIT 1 ';		
//echo htmlentities($sql);			   	
$result = mysqli_query ($connect ,$sql) or die('The query failed: ' . mysqli_error($connect));
$row = mysqli_fetch_array($result);
$tabacoFMin=$row[0];

			//mediana
$sql = 'SELECT ROUND(AVG(ff.F_Tabaco), 0) as median_val
		FROM (
		SELECT f.F_Tabaco, @rownum:=@rownum+1 as `row_number`, @total_rows:=@rownum
		  FROM fichasutente f, (SELECT @rownum:=0) r
		  WHERE f.F_Tabaco is NOT NULL
		  ORDER BY f.F_Tabaco
		) as ff
		WHERE ff.row_number IN ( FLOOR((@total_rows+1)/2), FLOOR((@total_rows+2)/2) ) ';		
//echo htmlentities($sql);			   	
$result = mysqli_query ($connect ,$sql) or die('The query failed: ' . mysqli_error($connect));
$row = mysqli_fetch_array($result);
$tabacoFMediana=$row[0];

switch($tabacoFMax){
	case '1': $tabacoFMax= 'Anteriores';
	break;
	case '2': $tabacoFMax= 'Nunca';
	break;
	case '3': $tabacoFMax= 'Presentes';
	break;
	default: $tabacoFMax= '';
	break;	   	  
}

switch($tabacoFMin){
	case '1': $tabacoFMin= 'Anteriores';
	break;
	case '2': $tabacoFMin= 'Nunca';
	break;
	case '3': $tabacoFMin= 'Presentes';
	break;
	default: $tabacoFMin= '';
	break;	   	  
}
switch($tabacoFMediana){
	case '1': $tabacoFMediana= 'Anteriores';
	break;
	case '2': $tabacoFMediana= 'Nunca';
	break;
	case '3': $tabacoFMediana= 'Presentes';
	break;
	default: $tabacoFMediana= '';
	break;	   	  
}


//M_Tabaco
$sql = 'SELECT `M_Tabaco`, COUNT(`M_Tabaco`)
		FROM `fichasutente` 
		GROUP BY `M_Tabaco` 
		ORDER BY COUNT(`M_Tabaco`) DESC
		LIMIT 1 ';		
//echo htmlentities($sql);			   	
$result = mysqli_query ($connect ,$sql) or die('The query failed: ' . mysqli_error($connect));
$row = mysqli_fetch_array($result);
$tabacoMMax=$row[0];

$sql = 'SELECT `M_Tabaco`, COUNT(`M_Tabaco`)
		FROM `fichasutente` 
		GROUP BY `M_Tabaco` 
		ORDER BY COUNT(`M_Tabaco`)
		LIMIT 1 ';		
//echo htmlentities($sql);			   	
$result = mysqli_query ($connect ,$sql) or die('The query failed: ' . mysqli_error($connect));
$row = mysqli_fetch_array($result);
$tabacoMMin=$row[0];

			//mediana
$sql = 'SELECT ROUND(AVG(ff.M_Tabaco), 0) as median_val
		FROM (
		SELECT f.M_Tabaco, @rownum:=@rownum+1 as `row_number`, @total_rows:=@rownum
		  FROM fichasutente f, (SELECT @rownum:=0) r
		  WHERE f.M_Tabaco is NOT NULL
		  ORDER BY f.M_Tabaco
		) as ff
		WHERE ff.row_number IN ( FLOOR((@total_rows+1)/2), FLOOR((@total_rows+2)/2) ) ';		
//echo htmlentities($sql);			   	
$result = mysqli_query ($connect ,$sql) or die('The query failed: ' . mysqli_error($connect));
$row = mysqli_fetch_array($result);
$tabacoMMediana=$row[0];

switch($tabacoMMax){
	case '1': $tabacoMMax= 'Anteriores';
	break;
	case '2': $tabacoMMax= 'Nunca';
	break;
	case '3': $tabacoMMax= 'Presentes';
	break;
	default: $tabacoMMax= '';
	break;	   	  
}

switch($tabacoMMin){
	case '1': $tabacoMMin= 'Anteriores';
	break;
	case '2': $tabacoMMin= 'Nunca';
	break;
	case '3': $tabacoMMin= 'Presentes';
	break;
	default: $tabacoMMin= '';
	break;	   	  
}
switch($tabacoMMediana){
	case '1': $tabacoMMediana= 'Anteriores';
	break;
	case '2': $tabacoMMediana= 'Nunca';
	break;
	case '3': $tabacoMMediana= 'Presentes';
	break;
	default: $tabacoMMediana= '';
	break;	   	  
}

//M_Etnia
$sql = 'SELECT `M_Etnia`, COUNT(`M_Etnia`)
		FROM `fichasutente` 
		GROUP BY `M_Etnia` 
		ORDER BY COUNT(`M_Etnia`) DESC
		LIMIT 1 ';		
//echo htmlentities($sql);			   	
$result = mysqli_query ($connect ,$sql) or die('The query failed: ' . mysqli_error($connect));
$row = mysqli_fetch_array($result);
$etniaMMax=$row[0];

$sql = 'SELECT `M_Etnia`, COUNT(`M_Etnia`)
		FROM `fichasutente` 
		GROUP BY `M_Etnia` 
		ORDER BY COUNT(`M_Etnia`)
		LIMIT 1 ';		
//echo htmlentities($sql);			   	
$result = mysqli_query ($connect ,$sql) or die('The query failed: ' . mysqli_error($connect));
$row = mysqli_fetch_array($result);
$etniaMMin=$row[0];


			//mediana
$sql = 'SELECT ROUND(AVG(ff.M_Etnia), 0) as median_val
		FROM (
		SELECT f.M_Etnia, @rownum:=@rownum+1 as `row_number`, @total_rows:=@rownum
		  FROM fichasutente f, (SELECT @rownum:=0) r
		  WHERE f.M_Etnia is NOT NULL
		  ORDER BY f.M_Etnia
		) as ff
		WHERE ff.row_number IN ( FLOOR((@total_rows+1)/2), FLOOR((@total_rows+2)/2) ) ';		
//echo htmlentities($sql);			   	
$result = mysqli_query ($connect ,$sql) or die('The query failed: ' . mysqli_error($connect));
$row = mysqli_fetch_array($result);
$etniaMMediana=$row[0];

switch($etniaMMax){
	case '1': $etniaMMax= 'Asiática';
	break;
	case '2': $etniaMMax= 'Caucasiana';
	break;
	case '3': $etniaMMax= 'Cigana';
	break;
	case '4': $etniaMMax= 'Indiana';
	break;
	case '5': $etniaMMax= 'Mista';
	break;
	case '6': $etniaMMax= 'Negra';
	break;
	default: $etniaMMax= '';
	break;	   	  
}

switch($etniaMMin){
	case '1': $etniaMMin= 'Asiática';
	break;
	case '2': $etniaMMin= 'Caucasiana';
	break;
	case '3': $etniaMMin= 'Cigana';
	break;
	case '4': $etniaMMin= 'Indiana';
	break;
	case '5': $etniaMMin= 'Mista';
	break;
	case '6': $etniaMMin= 'Negra';
	break;
	default: $etniaMMin= '';
	break;	   	  
}

switch($etniaMMediana){
	case '1': $etniaMMediana= 'Asiática';
	break;
	case '2': $etniaMMediana= 'Caucasiana';
	break;
	case '3': $etniaMMediana= 'Cigana';
	break;
	case '4': $etniaMMediana= 'Indiana';
	break;
	case '5': $etniaMMediana= 'Mista';
	break;
	case '6': $etniaMMediana= 'Negra';
	break;
	default: $etniaMMediana= '';
	break;	   	  
}

//arredondar valores máximos
$duracaoMax = ROUND($duracaoMax, 1);  
$imcElemFMax = ROUND($imcElemFMax, 1);	  
$afcMax = ROUND($afcMax, 1);

//definir as dimensoes das caixas de minimo e average
$duracaoMinLen = ROUND(($duracaoMin*300/$duracaoMax), 0);
$duracaoAvgLen = ROUND(($duracaoAvg*300/$duracaoMax), 0);

$imcElemFMinLen = ROUND(($imcElemFMin*300/$imcElemFMax), 0);
$imcElemFAvgLen = ROUND(($imcElemFAvg*300/$imcElemFMax), 0);

$afcMinLen = ROUND(($afcMin*300/$afcMax), 0);
$afcAvgLen = ROUND(($afcAvg*300/$afcMax), 0);

?>


<!DOCTYPE html >
<html>

<head>
<link href="style.css" rel="stylesheet" type="text/css">
<style type="text/css">
.auto-style1 {
	text-align: center;
}
</style>
</head>

<body>

 		 <form method="POST" action="index.php?operacao=AvaliarUtente">

		 &nbsp;&nbsp;<table style="height: 600px; width: 469px;">
	     <tr>
	      <td class="action"> Duração de infertilidade:</td>
	      <td style="width:100px">
	      <input type="text" value="minimo" class= "inputbox" style="width: 100px" readonly/>
		  <input type="text" value="médio" class= "inputbox" style="width: 100px" readonly/>
		  <input type="text" value="máximo" class= "inputbox" style="width: 100px" readonly/>
		  </td>
		  <td >
		  <input type="text" value="<?php echo $duracaoMin; ?>" class= "inputbox" style="<?php echo "width: $duracaoMinLen";echo"px"; ?>" readonly/>
		  <?php echo "<br>"; ?>
		  <input type="text" value="<?php echo $duracaoAvg; ?>" class= "inputbox" style="<?php echo "width: $duracaoAvgLen";echo"px"; ?>" readonly/>
		  <input type="text" value="<?php echo $duracaoMax; ?>" class= "inputbox" style="width: 300px" readonly/>
		  </td>		  		  
	     </tr>
	     <tr>
	      <td class="action"> IMC do elemento feminino:</td>
	      <td style="width:80px">
	      <input type="text" value="minimo" class= "inputbox" style="width: 100px" readonly/>
		  <input type="text" value="médio" class= "inputbox" style="width: 100px" readonly/>
		  <input type="text" value="máximo" class= "inputbox" style="width: 100px" readonly/>
		  </td>
		  <td >
		  <input type="text" value="<?php echo $imcElemFMin; ?>" class= "inputbox" style="<?php echo "width: $imcElemFMinLen";echo"px"; ?>" readonly/>
		  <?php echo "<br>"; ?>
		  <input type="text" value="<?php echo $imcElemFAvg; ?>" class= "inputbox" style="<?php echo "width: $imcElemFAvgLen";echo"px"; ?>" readonly/>
		  <input type="text" value="<?php echo $imcElemFMax; ?>" class= "inputbox" style="width: 300px" readonly/>
		  </td>		  		  
	     </tr>
	     <tr>
	      <td class="action"> Contagem de foliculos antrais:</td>
	      <td style="width:80px">
	      <input type="text" value="minimo" class= "inputbox" style="width: 100px" readonly/>
		  <input type="text" value="médio" class= "inputbox" style="width: 100px" readonly/>
		  <input type="text" value="máximo" class= "inputbox" style="width: 100px" readonly/>
		  </td>
		  <td >
		  <input type="text" value="<?php echo $afcMin; ?>" class= "inputbox" style="<?php echo "width: $afcMinLen";echo"px"; ?>" readonly/>
		  <?php echo "<br>"; ?>
		  <input type="text" value="<?php echo $afcAvg; ?>" class= "inputbox" style="<?php echo "width: $afcAvgLen";echo"px"; ?>" readonly/>
		  <input type="text" value="<?php echo $afcMax; ?>" class= "inputbox" style="width: 300px" readonly/>
		  </td>		  		  
	     </tr>
	     <tr>
	      <td class="action"> Causa da Infertilidade:</td>
	      <td style="width:100px">
	      <input type="text" value="minimo vezes" class= "inputbox" style="width: 100px" readonly/>
		  <input type="text" value="mediana" class= "inputbox" style="width: 100px" readonly/>
		  <input type="text" value="máximo vezes" class= "inputbox" style="width: 100px" readonly/>
		  </td>
		  <td >
		  <input type="text" value="<?php echo $causaMin; ?>" class= "inputbox" style="width: 300px" readonly/>
		  <?php echo "<br>"; ?>
		  <input type="text" value="<?php echo $causaMediana; ?>" class= "inputbox" style="width: 300px" readonly/>
		  <input type="text" value="<?php echo $causaMax; ?>" class= "inputbox" style="width: 300px" readonly/>
		  </td>		  		  
	     </tr>
	     <tr>
	      <td class="action"> Tabagismo elemento feminino:</td>
	      <td style="width:80px">
	      <input type="text" value="minimo vezes" class= "inputbox" style="width: 100px" readonly/>
		  <input type="text" value="mediana" class= "inputbox" style="width: 100px" readonly/>
		  <input type="text" value="máximo vezes" class= "inputbox" style="width: 100px" readonly/>
		  </td>
		  <td >
		  <input type="text" value="<?php echo $tabacoFMin; ?>" class= "inputbox" style="width: 300px" readonly/>
		  <?php echo "<br>"; ?>
		  <input type="text" value="<?php echo $tabacoFMediana; ?>" class= "inputbox" style="width: 300px" readonly/>
		  <input type="text" value="<?php echo $tabacoFMax; ?>" class= "inputbox" style="width: 300px" readonly/>
		  </td>		  		  
	     </tr>
	     <tr>
	      <td class="action"> Tabagismo elemento masculino:</td>
	      <td style="width:80px">
	      <input type="text" value="minimo vezes" class= "inputbox" style="width: 100px" readonly/>
		  <input type="text" value="mediana" class= "inputbox" style="width: 100px" readonly/>
		  <input type="text" value="máximo vezes" class= "inputbox" style="width: 100px" readonly/>
		  </td>
		  <td >
		  <input type="text" value="<?php echo $tabacoMMin; ?>" class= "inputbox" style="width: 300px" readonly/>
		  <?php echo "<br>"; ?>
		  <input type="text" value="<?php echo $tabacoMMediana; ?>" class= "inputbox" style="width: 300px" readonly/>
		  <input type="text" value="<?php echo $tabacoMMax; ?>" class= "inputbox" style="width: 300px" readonly/>
		  </td>		  		  
	     </tr>
	     <tr>
	      <td class="action"> Etnia elemento masculino:</td>
	      <td style="width:80px">
	      <input type="text" value="minimo vezes" class= "inputbox" style="width: 100px" readonly/>
		  <input type="text" value="mediana" class= "inputbox" style="width: 100px" readonly/>
		  <input type="text" value="máximo vezes" class= "inputbox" style="width: 100px" readonly/>
		  </td>
		  <td >
		  <input type="text" value="<?php echo $etniaMMin; ?>" class= "inputbox" style="width: 300px" readonly/>
		  <?php echo "<br>"; ?>
		  <input type="text" value="<?php echo $etniaMMediana; ?>" class= "inputbox" style="width: 300px" readonly/>
		  <input type="text" value="<?php echo $etniaMMax; ?>" class= "inputbox" style="width: 300px" readonly/>
		  </td>		  		  
	     </tr>
         </table>
         <p>&nbsp;&nbsp;</p>
 	  	 </form>



</body>

</html>
