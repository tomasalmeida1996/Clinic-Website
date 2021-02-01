<?php

//$var = @$_GET['q'];
//$trimmed = trim($var);
if (isset($_GET["page"])) {
	$page = $_GET['page'];
	//echo $_GET['page']; //a 1
}
else {
	$page = 1;
}

$limitPerPage=10;
if($page==1) { 
	$newpage = 1; 
} 
else { 
	$newpage = $page + 1; 
}


?>
<html >

<body>

 <div class="article">
  <h2><span>Utilizadores</span> ativos</h2>
  <div class="clr"></div>

  <?php

//caso seja administrador pode ver utilizadores mesmo que nao estejam ativos

  $limitvalue = ($page-1) * $limitPerPage;
  $newlimit = $limitvalue + $limitPerPage;

  $connect = mysqli_connect("127.0.0.84:3307", "root", "","sim");
  if( isset($_SESSION['IdTipoUtilizador']) AND $_SESSION['IdTipoUtilizador'] == 1){//se for administrador
    
	//verificar o total de registos para reter o numero de linhas -> indica o numero de paginas  
	$query = 'SELECT COUNT(`IdUtilizador`)
			  FROM `utilizadores` JOIN tiposutilizadores t on t.IdTipoUtilizador = utilizadores.IdTipoUtilizador 
			  WHERE t.IdTipoUtilizador <> 2';
    //echo htmlentities($query);
    $result = mysqli_query ($connect ,$query) or die('The query failed: ' . mysqli_error($connect));
	$row = mysqli_fetch_array($result);
	$totalregistos  = $row[0];//fica com o total de registos
    
    $query = 'SELECT `IdUtilizador`, t.Descricao AS tipoUtilizador, `Nome`, `Morada`, `Email`, `DataNascimento`, `Contacto` 
    		  FROM `utilizadores` JOIN tiposutilizadores t on t.IdTipoUtilizador = utilizadores.IdTipoUtilizador 
    		  WHERE t.IdTipoUtilizador <> 2 
  	   		  ORDER BY `Nome` LIMIT ' .$limitvalue.', '. $newlimit;
  
  }
  else {
	//verificar o total de registos para reter o numero de linhas -> indica o numero de paginas  
	$query = 'SELECT COUNT(`IdUtilizador`)
			  FROM `utilizadores` JOIN tiposutilizadores t on t.IdTipoUtilizador = utilizadores.IdTipoUtilizador 
			  WHERE t.IdTipoUtilizador IN (3, 4) AND Ativo = 1';

    $result = mysqli_query ($connect ,$query) or die('The query failed: ' . mysqli_error($connect));
	$row = mysqli_fetch_array($result);
	$totalregistos  = $row[0];//fica com o total de registos

  
    $query = 'SELECT `IdUtilizador`, t.Descricao AS tipoUtilizador, `Nome`, `Morada`, `Email`, `DataNascimento`, `Contacto` 
  			  FROM `utilizadores` JOIN tiposutilizadores t on t.IdTipoUtilizador = utilizadores.IdTipoUtilizador 
  			  WHERE t.IdTipoUtilizador IN (3, 4) AND Ativo = 1 ORDER BY `Nome` LIMIT ' .$limitvalue.', '. $newlimit;
  }
  
  //echo htmlentities($query);
  $result = mysqli_query ($connect ,$query) or die('The query failed: ' . mysqli_error($connect));
  $totalrows = mysqli_num_rows($result); 
			
  
  if ($totalrows==0) {
    echo '<p>Sorry, your search returned no results</p>';
  }


  if($totalrows>0){

	if(isset($_GET["editar"]) && $_GET["editar"] == 0 && isset($_GET["ver"]) && $_GET["ver"] == 0) {
	  echo ' 
	  <table style="width:100%" "border:1px">
	  <tr style="text-align:center">
	  <th style="width:5%">ID</th>
	  <th style="width:10%">Tipo de Utilizador</th>
	  <th style="width:25%">Nome</th>
	  <th style="width:20%">Morada</th>
	  <th style="width:20%">Email</th>
	  <th style="width:10%">Data de Nascimento</th>
	  <th style="width:10%">Contacto</th>	  	  
	  </tr>';
	  
	  while($row = mysqli_fetch_array($result)){
		  $idUtilizador=$row['IdUtilizador'];
		  $tipoUtilizador=$row['tipoUtilizador'];
		  $nome=$row['Nome'];
		  $morada=$row['Morada'];
		  $email=$row['Email'];
		  $dataNascimento=$row['DataNascimento'];
		  $contacto=$row['Contacto'];

		  echo "<tr align='center'>";
		  echo "<td width='5%' > $idUtilizador</td>";
		  echo "<td width='10%'> $tipoUtilizador</td>"; 
		  echo "<td width='25%'> $nome</td>";
		  echo "<td width='20%'> $morada</td>";
		  echo "<td width='20%'> $email</td>";
		  echo "<td width='10%'> $dataNascimento</td>";
		  echo "<td width='10%'> $contacto</td>";
		  echo "</tr>";
	  }

  	  echo '</table>';
  	}
  	if($_GET["editar"] == 1 && $_GET["ver"] == 0){//Pode editar

	  echo ' 
	  <table style="width:100%" "border:1px">
	  <tr style="text-align:center">
	  <th style="width:5%">ID</th>
	  <th style="width:10%">Tipo de Utilizador</th>
	  <th style="width:25%">Nome</th>
	  <th style="width:20%">Morada</th>
	  <th style="width:20%">Email</th>
	  <th style="width:10%">Data de Nascimento</th>
	  <th style="width:10%">Contacto</th>	  	  
	  <th style="width:10%">Editar Utilizador</th>	  	  
	  </tr>';
	  
	  while($row = mysqli_fetch_array($result)){
		  $idUtilizador=$row['IdUtilizador'];
		  $tipoUtilizador=$row['tipoUtilizador'];
		  $nome=$row['Nome'];
		  $morada=$row['Morada'];
		  $email=$row['Email'];
		  $dataNascimento=$row['DataNascimento'];
		  $contacto=$row['Contacto'];

		  echo "<tr align='center'>";
		  echo "<td width='5%' > $idUtilizador</td>";
		  echo "<td width='10%'> $tipoUtilizador</td>"; 
		  echo "<td width='25%'> $nome</td>";
		  echo "<td width='20%'> $morada</td>";
		  echo "<td width='20%'> $email</td>";
		  echo "<td width='10%'> $dataNascimento</td>";
		  echo "<td width='10%'> $contacto</td>";
		  echo "<td><a href=\"index.php?operacao=EditarUtilizador&idUtil=$idUtilizador\">Editar</a></td>";
		  echo "</tr>";
	  }
  	  echo '</table>';
  
  	}

  	if($_GET["editar"] == 0 && $_GET["ver"] == 1){//Pode visualizar (parametros)

	  echo ' 
	  <table style="width:100%" "border:1px">
	  <tr style="text-align:center">
	  <th style="width:5%">ID</th>
	  <th style="width:10%">Tipo de Utilizador</th>
	  <th style="width:25%">Nome</th>
	  <th style="width:20%">Morada</th>
	  <th style="width:20%">Email</th>
	  <th style="width:10%">Data de Nascimento</th>
	  <th style="width:10%">Contacto</th>	  	  
	  <th style="width:10%">Editar Utilizador</th>	  	  
	  </tr>';
	  
	  while($row = mysqli_fetch_array($result)){
		  $idUtilizador=$row['IdUtilizador'];
		  $tipoUtilizador=$row['tipoUtilizador'];
		  $nome=$row['Nome'];
		  $morada=$row['Morada'];
		  $email=$row['Email'];
		  $dataNascimento=$row['DataNascimento'];
		  $contacto=$row['Contacto'];

		  echo "<tr align='center'>";
		  echo "<td width='5%' > $idUtilizador</td>";
		  echo "<td width='10%'> $tipoUtilizador</td>"; 
		  echo "<td width='25%'> $nome</td>";
		  echo "<td width='20%'> $morada</td>";
		  echo "<td width='20%'> $email</td>";
		  echo "<td width='10%'> $dataNascimento</td>";
		  echo "<td width='10%'> $contacto</td>";
		  echo "<td><a href=\"index.php?operacao=VisualizarUtilizador&idUtil=$idUtilizador\">Ver</a></td>";
		  echo "</tr>";
	  }
  	  echo '</table>';
  
  	}
  
  }



?>  
  <br>
  <br>
  <br>
 </div>
 
 <div class="pagenavi">
  <br>
  <br>
  <br>

 <?php
 
 $string = '&ver='.$_GET["ver"]. '&criar='.$_GET["criar"]. '&editar='. $_GET["editar"]. '&eliminar='.$_GET["eliminar"];
 
 if($page > 1){
	$pageprev = $page-1;
//	echo '<a href=\"ListarUtilizadores.php?page=$pageprev\">PREV</a>&nbsp;';
	echo "<a href=\"index.php?operacao=ListarUtilizadores&page=$pageprev$string\">PREV</a>&nbsp;";
 }
 
 echo("Páginas &nbsp;");
 
 $numofpages = ceil($totalregistos / $limitPerPage);
 for($i = 1; $i <= $numofpages; $i++){
	if($page == $i){
		echo($i."&nbsp;");
	} else{
		echo"<a href=\"index.php?operacao=ListarUtilizadores&page=$i$string\">$i</a>&nbsp;";
	}
 }
 if($page < $numofpages){
	$pagenext = ($page + 1);
	echo "<a href=\"index.php?operacao=ListarUtilizadores&page=$pagenext$string\">NEXT</a>";
 }


 ?>
 </div>
         <!-- aqui irá ficar o conteudo alteravel-->      
</body>

</html>
