<?php

$connect = mysqli_connect("127.0.0.84:3307", "root", "","sim");
$sql = 'SELECT IdUtente FROM Utentes u 
		WHERE (IdUtilizador = "'. $_SESSION['id'].'")';
$result = mysqli_query ($connect ,$sql) or die('The query failed: ' . mysqli_error($connect));

$row = mysqli_fetch_array($result);
$idUtente = $row[0];

//Verificar se o utente já tem uma ficha actualmente
$connect = mysqli_connect("127.0.0.84:3307", "root", "","sim");
$sql = 'SELECT `IdFichaUtente` FROM `fichasutente` WHERE `Historico` = 0 AND `IdUtente` = '. $idUtente;
$result = mysqli_query ($connect ,$sql) or die('The query failed: ' . mysqli_error($connect));
$number = mysqli_num_rows($result); 
			  	
if ($number == 0) {

	$ficha = -1;//nao tem uma ficha pode registar

}
else {
	$ficha = 0;//já tem uma ficha - apresenta opcoes
}

?>
<!DOCTYPE html >
<html >

<body>
	
	<?php

	if($ficha == -1){
		//envia para o inserir
		//InserirParametros
		header( "refresh:0; url=index.php?operacao=InserirParametros" );
	}

	else{
	

         echo '<br>';
         echo 'Neste momento ja tem uma ficha de utente preenchida!';
         echo '<br>';
         echo 'Pretende INSERIR uma nova ficha com informacoes atualizadas ou VER a ficha actual?';
	?>
		<br>
		<form method="POST" action="index.php?operacao=InserirParametros">
		 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		 <input type="submit" name="Submit" value="Inserir" class= "button">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</form>	

		<form method="POST" action="index.php?operacao=VerParametros">
		 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		 <input type="submit" name="Submit" value="Ver Ficha" class= "button">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;		 
		</form>		 
		
	<?php	
	}
	?>

</body>

</html>
