<?php
if(isset($_POST['tipoConsulta']) AND $_POST['tipoConsulta'] == -1){//se não tiver o campo tipoConsulta
	$_SESSION['erroAvaliar'] = 1;
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	exit;
}

if(isset($_SESSION['erroAvaliar']) AND isset($_POST['tipoConsulta']) AND $_POST['tipoConsulta'] != -1){//já tem o campo
	unset($_SESSION['erroAvaliar']);//destroi a variavel de sessao
}	

$connect = mysqli_connect("127.0.0.84:3307", "root", "","sim");
$query = 'SELECT u.`IdUtente`, u.`NomeCompleto`, u.`Contacto`, u.`DataNascimento`, u.`Sexo`, f.`DuracaoInf`, `Causa`, `IMCElemF`, `AFC`, `F_Tabaco`, `M_Tabaco`, `M_Etnia`, `Historico` 
	  	  FROM `fichasUtente` f
		  JOIN Utentes u ON u.IdUtente = f.IdUtente
		  WHERE f.Historico = 0 AND u.`IdUtente` = '.$_GET['idUtente'];
//echo htmlentities($query);
$result = mysqli_query ($connect ,$query) or die('The query failed: ' . mysqli_error($connect));
$totalrows = mysqli_num_rows($result); 

$row = mysqli_fetch_array($result);

$idUtente=$row['IdUtente'];
$duracaoInf=$row['DuracaoInf'];
$causa=$row['Causa'];		  
$imcElemF=$row['IMCElemF'];
$afc=$row['AFC'];
$tabacoF=$row['F_Tabaco'];
$tabacoM=$row['M_Tabaco'];
$etniaM=$row['M_Etnia'];		  
$historico=$row['Historico'];

/*Terminal Node 1*/
if
(
    $afc <= 10.5 
)
{
    $terminalNode = -1;
    $class = 0;
    $probClass0 = 0.812698;
    $probClass1 = 0.187302;
}

/*Terminal Node 2*/
if
(
  (
       $causa == 1 ||
       $causa == 3 ||
       $causa == 4 ||
       $causa == 8 
  ) &&
    $afc > 10.5 &&
    $duracaoInf <= 105.5 &&
    $imcElemF <= 18.5 
)
{
    $terminalNode = -2;
    $class = 1;
    $probClass0 = 0.285714;
    $probClass1 = 0.714286;
}

/*Terminal Node 3*/
if
(
  (
       $causa == 1 ||
       $causa == 3 ||
       $causa == 4 ||
       $causa == 8 
  ) &&
    $afc > 10.5 &&
    $duracaoInf <= 105.5 &&
    $imcElemF > 18.5 &&
    $imcElemF <= 19.5 
)
{
    $terminalNode = -3;
    $class = 0;
    $probClass0 = 0.9;
    $probClass1 = 0.1;
}

/*Terminal Node 4*/
if
(
  (
       $causa == 1 ||
       $causa == 3 ||
       $causa == 4 ||
       $causa == 8 
  ) &&
    $afc > 10.5 &&
    $duracaoInf <= 105.5 &&
    $imcElemF > 19.5 &&
    $imcElemF <= 24.5 
)
{
    $terminalNode = -4;
    $class = 1;
    $probClass0 = 0.582677;
    $probClass1 = 0.417323;
}

/*Terminal Node 5*/
if
(
  (
       $causa == 1 ||
       $causa == 3 ||
       $causa == 4 ||
       $causa == 8 
  ) &&
    $afc > 10.5 &&
    $imcElemF <= 24.5 &&
    $duracaoInf > 105.5 
)
{
    $terminalNode = -5;
    $class = 1;
    $probClass0 = 0.166667;
    $probClass1 = 0.833333;
}

/*Terminal Node 6*/
if
(
  (
       $etniaM == 1 ||
       $etniaM == 2 ||
       $etniaM == 3 ||
       $etniaM == 4 
  ) &&
  (
       $causa == 1 ||
       $causa == 3 ||
       $causa == 4 ||
       $causa == 8 
  ) &&
    $afc > 10.5 &&
    $imcElemF > 24.5 &&
    $imcElemF <= 28.5 
)
{
    $terminalNode = -6;
    $class = 0;
    $probClass0 = 0.829787;
    $probClass1 = 0.170213;
}

/*Terminal Node 7*/
if
(
  (
       $etniaM == 1 ||
       $etniaM == 2 ||
       $etniaM == 3 ||
       $etniaM == 4 
  ) &&
  (
       $causa == 1 ||
       $causa == 3 ||
       $causa == 4 ||
       $causa == 8 
  ) &&
    $afc > 10.5 &&
    $imcElemF > 28.5 &&
    $imcElemF <= 32.5 
)
{
    $terminalNode = -7;
    $class = 1;
    $probClass0 = 0.5;
    $probClass1 = 0.5;
}

/*Terminal Node 8*/
if
(
  (
       $etniaM == 1 ||
       $etniaM == 2 ||
       $etniaM == 3 ||
       $etniaM == 4 
  ) &&
  (
       $causa == 1 ||
       $causa == 3 ||
       $causa == 4 ||
       $causa == 8 
  ) &&
    $afc > 10.5 &&
    $imcElemF > 32.5 
)
{
    $terminalNode = -8;
    $class = 0;
    $probClass0 = 0.9375;
    $probClass1 = 0.0625;
}

/*Terminal Node 9*/
if
(
  (
       $etniaM == 5 ||
       $etniaM == 6 
  ) &&
  (
       $causa == 1 ||
       $causa == 3 ||
       $causa == 4 ||
       $causa == 8 
  ) &&
    $afc > 10.5 &&
    $imcElemF > 24.5 
)
{
    $terminalNode = -9;
    $class = 1;
    $probClass0 = 0.2;
    $probClass1 = 0.8;
}

/*Terminal Node 10*/
if
(
  (
       $causa == 2 ||
       $causa == 5 ||
       $causa == 6 ||
       $causa == 7 
  ) &&
    $afc > 10.5 
)
{
    $terminalNode = -10;
    $class = 1;
    $probClass0 = 0.516854;
    $probClass1 = 0.483146;
}


$query = 'SELECT u.`IdUtente`, u.`NomeCompleto`, u.`Contacto`, u.`DataNascimento`, u.`Sexo`, f.`DuracaoInf`, `Causa`, `IMCElemF`, `AFC`, `F_Tabaco`, `M_Tabaco`, `M_Etnia`, `Historico` 
	  	  FROM `fichasUtente` f
		  JOIN Utentes u ON u.IdUtente = f.IdUtente
		  WHERE f.Historico = 0 AND u.`IdUtente` = '.$_GET['idUtente'];
//echo htmlentities($query);
$result = mysqli_query ($connect ,$query) or die('The query failed: ' . mysqli_error($connect));


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
	
	<div class="auto-style1">
		A Avaliação foi efetuada com sucesso!
		<br>
		<br>
		<br>

		A classificação do Utente foi a seguinte:
		<?php
		
		if($class == 0){
			$probClass0 = round(($probClass0 * 100.00),1,PHP_ROUND_HALF_UP);
			echo '<span style="color:green";text-align:"center"><strong>Recomendado para tratamento</strong></span>';
			echo '<br>';		
			echo '<br>';
			echo "Com uma probabilidade de: $probClass0%";
			$probFinal = $probClass0;
			$classificacao = 'Sim';
		}
		else {
			$probClass1 = round(($probClass1 * 100.00),1,PHP_ROUND_HALF_UP);		
			echo'<span style="color:red";text-align:"center"><strong>Não Recomendadável para tratamento</strong></span>';
			echo '<br>';
			echo '<br>';
			echo "Com uma probabilidade de: $probClass1%";		
			$probFinal = $probClass1;
			$classificacao = 'Nao';
		}
		
		$tipoConsulta = $_POST['tipoConsulta'];
		
		echo '<br>';
		echo '<br>';
				
        if(isset($_SESSION['gravarConsulta']) AND $_SESSION['gravarConsulta'] == -1){
   	    	echo'<span style="color:red";text-align:"center"><strong>É necessário escolher uma recomendação</strong></span>';
		  	echo'<br>';
		}
		
		?>

 		 <form method="POST" action="index.php?operacao=GravarConsulta&idUtente=<?php echo $row['IdUtente']; ?>">
       	
		 &nbsp;&nbsp;
		 <table style="margin-right:auto; margin-left:auto">
    	 <tr>
      	 <td style="text-align:right"> Recomendação tratamento: </td>
      	 <td>
		  <select name="recomendacao">
    	  <!--<option value="-1" selected>Escolha</option>  tive que tirar por causa do mail, podemos por o default na classif-->
    	  <option value="Sim">Sim</option>
    	  <option value="Nao">Não</option>
    	  <option value="Fertilizacao invitro">Fertilizacao invitro</option>    	  
		  </select>	
		  <input type="hidden" name="probFinal" value="<?php echo $probFinal; ?>"/>
		  <input type="hidden" name="classAvaliacao" value="<?php echo $classificacao; ?>"/>
		  <input type="hidden" name="tipoConsulta" value="<?php echo $tipoConsulta; ?>"/>		  
		 </td>
         </table>
         <p>&nbsp;&nbsp;</p>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="gravar" value="Gravar Consulta" class= "button">
         &nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="gravarEnviar" value="Gravar e Enviar Email" class= "button" formaction="index.php?operacao=EnviarEmail&consulta=1&idUtente=<?php echo $row['IdUtente']; ?>">
        </form>
	     

	</div>
	
</body>

</html>
