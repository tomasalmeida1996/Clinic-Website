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

 <?php
 //caso seja administrador pode ver todos os utentes e também editá-los mesmo que não estejam ativos
 //caso seja obstetra pode ver todos os utentes mas não editá-los
 //caso seja investigador tem que ocultar dados pessoais
 //caso seja utente so pode ver/editar os seus dados 

 //$parameters = $_SERVER['QUERY_STRING'];//fica com os parametros que chegam do url para juntar 
 //echo $parameters;
   
   if (isset($_SESSION['IdTipoUtilizador']) AND $_SESSION['IdTipoUtilizador'] == 2 AND isset($_SESSION['id'])){//É utente só podemos mostrar o registo dele
 	  $idUtilizador=$_SESSION['id'];
	  if (isset($_GET["editar"]) && $_GET["editar"] == 0 && isset($_GET["ver"]) && $_GET["ver"] == 1){
		 header( "refresh:0; url=index.php?operacao=VisualizarUtente&idUtil=$idUtilizador" );
	  }
	  else {
	 	 //editar
		 header( "refresh:0; url=index.php?operacao=EditarUtente&idUtil=$idUtilizador" );	 	
	  }
   }

 ?>

 <div class="article">
  <h2><span>Utentes</span></h2>
  <div class="clr"></div>

  <?php

  $limitvalue = ($page-1) * $limitPerPage;
  $newlimit = $limitvalue + $limitPerPage;

  $connect = mysqli_connect("127.0.0.84:3307", "root", "","sim");

  if( isset($_SESSION['IdTipoUtilizador']) AND $_SESSION['IdTipoUtilizador'] == 1){//se for administrador

	  //verificar o total de registos para reter o numero de linhas -> indica o numero de paginas  
	  $query = 'SELECT COUNT(`IdUtilizador`)
			    FROM `utilizadores` JOIN tiposutilizadores t on t.IdTipoUtilizador = utilizadores.IdTipoUtilizador 
			    WHERE t.IdTipoUtilizador = 2';
      $result = mysqli_query ($connect ,$query) or die('The query failed: ' . mysqli_error($connect));
	  $row = mysqli_fetch_array($result);
	  $totalregistos  = $row[0];//fica com o total de registos
			    

	  $query = 'SELECT `IdUtente`, u.`IdUtilizador`, util.`IdTipoUtilizador`, util.`Username`, `NomeCompleto`, u.`Morada`, `Localidade`, `Distrito`, u.`Contacto`, u.`Email`, u.`DataNascimento`, `Sexo`, `NIF`, `CartaoSaude`, `Alergias` 
			  	FROM `utentes` u
			  	JOIN Utilizadores util ON util.IdUtilizador = u.IdUtilizador
	  			WHERE util.IdTipoUtilizador = 2 
	  			ORDER BY `NomeCompleto` 
	  			LIMIT ' .$limitvalue.', '. $newlimit;
  }
  else if(isset($_GET["consulta"]) && $_GET["consulta"] == 1 && ($_SESSION['IdTipoUtilizador'] == 3 OR $_SESSION['IdTipoUtilizador'] == 1)){//é para consulta

	  //verificar o total de registos para reter o numero de linhas -> indica o numero de paginas
	  $query = 'SELECT COUNT(u.`IdUtente`)
			  	FROM `utentes` u
			  	JOIN Utilizadores util ON util.IdUtilizador = u.IdUtilizador
			  	JOIN fichasUtente f ON f.IdUtente = u.IdUtente			  	
	  			WHERE util.Ativo = 1 AND util.IdTipoUtilizador = 2 AND f.Historico = 0'; 
      $result = mysqli_query ($connect ,$query) or die('The query failed: ' . mysqli_error($connect));
	  $row = mysqli_fetch_array($result);
	  $totalregistos  = $row[0];//fica com o total de registos


	  $query = 'SELECT u.`IdUtente`, u.`IdUtilizador`, util.`IdTipoUtilizador`, util.`Username`, `NomeCompleto`, u.`Morada`, `Localidade`, `Distrito`, u.`Contacto`, u.`Email`, u.`DataNascimento`, `Sexo`, `NIF`, `CartaoSaude`, `Alergias` 
			  	FROM `utentes` u
			  	JOIN Utilizadores util ON util.IdUtilizador = u.IdUtilizador
			  	JOIN fichasUtente f ON f.IdUtente = u.IdUtente			  	
	  			WHERE util.Ativo = 1 AND util.IdTipoUtilizador = 2 AND f.Historico = 0
	  			ORDER BY `NomeCompleto` 
	  			LIMIT ' .$limitvalue.', '. $newlimit;
  }  			

  else if(!isset($_GET["consulta"]) AND $_SESSION['IdTipoUtilizador'] != 1){//não é administrador e não é consulta

	  //verificar o total de registos para reter o numero de linhas -> indica o numero de paginas  
	  $query = 'SELECT COUNT(`IdUtilizador`)
			    FROM `utilizadores` JOIN tiposutilizadores t on t.IdTipoUtilizador = utilizadores.IdTipoUtilizador 
			    WHERE t.IdTipoUtilizador =2 AND Ativo = 1';
      $result = mysqli_query ($connect ,$query) or die('The query failed: ' . mysqli_error($connect));
	  $row = mysqli_fetch_array($result);
	  $totalregistos  = $row[0];//fica com o total de registos

	  $query = 'SELECT `IdUtente`, u.`IdUtilizador`, util.`IdTipoUtilizador`, util.`Username`, `NomeCompleto`, u.`Morada`, `Localidade`, `Distrito`, u.`Contacto`, u.`Email`, u.`DataNascimento`, `Sexo`, `NIF`, `CartaoSaude`, `Alergias` 
			  	FROM `utentes` u
			  	JOIN Utilizadores util ON util.IdUtilizador = u.IdUtilizador
	  			WHERE util.Ativo = 1 AND util.IdTipoUtilizador = 2 
	  			ORDER BY `NomeCompleto` 
	  			LIMIT ' .$limitvalue.', '. $newlimit;
  }  			
  //echo htmlentities($query);
  $result = mysqli_query ($connect ,$query) or die('The query failed: ' . mysqli_error($connect));
  $totalrows = mysqli_num_rows($result); 			
  
  if ($totalrows==0) {
    echo '<p>Não tem registos neste momento.</p>';
  }


  if($totalrows>0){

	if(isset($_GET["editar"]) && $_GET["editar"] == 0 && isset($_GET["ver"]) && $_GET["ver"] == 0 AND !isset($_GET["consulta"])) {
	  echo ' 
	  <table style="width:100%" "border:1px">
	  <tr style="text-align:center">
	  <th style="width:5%">ID</th>
	  <th style="width:15%">Username</th>
	  <th style="width:15%">Localidade</th>
	  <th style="width:15%">Distrito</th>
	  <th style="width:20%">Email</th>
	  <th style="width:10%">Data de Nascimento</th>
	  <th style="width:10%">Contacto</th>	  	  
	  <th style="width:5%">Sexo</th>		  
	  </tr>';
	  
	  while($row = mysqli_fetch_array($result)){

		  $idUtilizador=$row['IdUtilizador'];	  
		  $idUtente=$row['IdUtente'];
		  $user=$row['Username'];
		  $localidade=$row['Localidade'];
		  $distrito=$row['Distrito'];
		  $email=$row['Email'];
		  $dataNascimento=$row['DataNascimento'];
		  $contacto=$row['Contacto'];
		  $sexo=$row['Sexo'];		  

		  echo "<tr align='center'>";
		  echo "<td width='5%' > $idUtente</td>";
		  echo "<td width='15%'> $user</td>"; 
		  echo "<td width='15%'> $localidade</td>";
		  echo "<td width='15%'> $distrito</td>";
		  echo "<td width='20%'> $email</td>";
		  echo "<td width='10%'> $dataNascimento</td>";
		  echo "<td width='10%'> $contacto</td>";
		  echo "<td width='5%'> $sexo</td>";		  
		  echo "</tr>";
	  }

  	  echo '</table>';
  	}
  	if($_GET["editar"] == 1 && $_GET["ver"] == 0 AND !isset($_GET["consulta"])){//Pode editar

	  echo ' 
	  <table style="width:100%" "border:1px">
	  <tr style="text-align:center">
	  <th style="width:5%">ID</th>
	  <th style="width:15%">Username</th>
	  <th style="width:15%">Localidade</th>
	  <th style="width:15%">Distrito</th>
	  <th style="width:20%">Email</th>
	  <th style="width:10%">Data de Nascimento</th>
	  <th style="width:10%">Contacto</th>	  	  
	  <th style="width:5%">Sexo</th>		  
	  </tr>';
	  
	  while($row = mysqli_fetch_array($result)){

		  $idUtilizador=$row['IdUtilizador'];	  	  
		  $idUtente=$row['IdUtente'];
		  $user=$row['Username'];
		  $localidade=$row['Localidade'];
		  $distrito=$row['Distrito'];
		  $email=$row['Email'];
		  $dataNascimento=$row['DataNascimento'];
		  $contacto=$row['Contacto'];
		  $sexo=$row['Sexo'];		  

		  echo "<tr align='center'>";
		  echo "<td width='5%' > $idUtente</td>";
		  echo "<td width='15%'> $user</td>"; 
		  echo "<td width='15%'> $localidade</td>";
		  echo "<td width='15%'> $distrito</td>";
		  echo "<td width='20%'> $email</td>";
		  echo "<td width='10%'> $dataNascimento</td>";
		  echo "<td width='10%'> $contacto</td>";
		  echo "<td width='5%'> $sexo</td>";		  
		  echo "<td><a href=\"index.php?operacao=EditarUtente&idUtil=$idUtilizador\">Editar</a></td>";
		  echo "</tr>";
	  }
  	  echo '</table>';
  
  	}

  	if($_GET["editar"] == 0 && $_GET["ver"] == 1 AND !isset($_GET["consulta"])){//Pode visualizar

	  echo ' 
	  <table style="width:100%" "border:1px">
	  <tr style="text-align:center">
	  <th style="width:5%">ID</th>
	  <th style="width:15%">Username</th>
	  <th style="width:15%">Localidade</th>
	  <th style="width:15%">Distrito</th>
	  <th style="width:20%">Email</th>
	  <th style="width:10%">Data de Nascimento</th>
	  <th style="width:10%">Contacto</th>	  	  
	  <th style="width:5%">Sexo</th>		  
	  </tr>';
	  
	  while($row = mysqli_fetch_array($result)){

		  $idUtilizador=$row['IdUtilizador'];	  	  
		  $idUtente=$row['IdUtente'];
		  $user=$row['Username'];
		  $localidade=$row['Localidade'];
		  $distrito=$row['Distrito'];
		  $email=$row['Email'];
		  $dataNascimento=$row['DataNascimento'];
		  $contacto=$row['Contacto'];
		  $sexo=$row['Sexo'];		  

		  echo "<tr align='center'>";
		  echo "<td width='5%' > $idUtente</td>";
		  echo "<td width='15%'> $user</td>"; 
		  echo "<td width='15%'> $localidade</td>";
		  echo "<td width='15%'> $distrito</td>";
		  echo "<td width='20%'> $email</td>";
		  echo "<td width='10%'> $dataNascimento</td>";
		  echo "<td width='10%'> $contacto</td>";
		  echo "<td width='5%'> $sexo</td>";		  
		  echo "<td><a href=\"index.php?operacao=VisualizarUtente&idUtil=$idUtilizador\">Ver</a></td>";
		  echo "</tr>";
	  }
  	  echo '</table>';
  
  	}

  	if(isset($_GET["consulta"]) AND $_GET["consulta"] == 1){//É o obstetra a escolher o utente

	  echo ' 
	  <table style="width:100%" "border:1px">
	  <tr style="text-align:center">
	  <th style="width:5%">ID</th>
	  <th style="width:15%">Username</th>
	  <th style="width:15%">Localidade</th>
	  <th style="width:15%">Distrito</th>
	  <th style="width:20%">Email</th>
	  <th style="width:10%">Data de Nascimento</th>
	  <th style="width:10%">Contacto</th>	  	  
	  <th style="width:5%">Sexo</th>		  
	  </tr>';
	  
	  while($row = mysqli_fetch_array($result)){

		  $idUtilizador=$row['IdUtilizador'];	  	  
		  $idUtente=$row['IdUtente'];
		  $user=$row['Username'];
		  $localidade=$row['Localidade'];
		  $distrito=$row['Distrito'];
		  $email=$row['Email'];
		  $dataNascimento=$row['DataNascimento'];
		  $contacto=$row['Contacto'];
		  $sexo=$row['Sexo'];		  

		  echo "<tr align='center'>";
		  echo "<td width='5%' > $idUtente</td>";
		  echo "<td width='15%'> $user</td>"; 
		  echo "<td width='15%'> $localidade</td>";
		  echo "<td width='15%'> $distrito</td>";
		  echo "<td width='20%'> $email</td>";
		  echo "<td width='10%'> $dataNascimento</td>";
		  echo "<td width='10%'> $contacto</td>";
		  echo "<td width='5%'> $sexo</td>";		  
		  echo "<td><a href=\"index.php?operacao=CriarConsulta&idUtente=$idUtente\">Aconselhar</a></td>";
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
 if(isset($_GET["consulta"])){
  	$parameters = '&consulta='. $_GET["consulta"]. '&ver='. $_GET["ver"]. '&criar='. $_GET["criar"]. '&editar='. $_GET["editar"]. '&eliminar='.$_GET["eliminar"];
 }
 else{
 	$parameters = '&ver='. $_GET["ver"]. '&criar='. $_GET["criar"]. '&editar='. $_GET["editar"]. '&eliminar='.$_GET["eliminar"];
 }
 
 if($page > 1){
	$pageprev = $page-1;
	echo "<a href=\"index.php?operacao=ListarUtentes&page=$pageprev$parameters\">PREV</a>&nbsp;";
 }
 
 echo("Páginas &nbsp;");
 
 $numofpages = ceil($totalrows / $limitPerPage);
 for($i = 1; $i <= $numofpages; $i++){
	if($page == $i){
		echo($i."&nbsp;");
	} else{
		echo"<a href=\"index.php?operacao=ListarUtentes&page=$i$parameters\">$i</a>&nbsp;";
	}
 }
 if($page < $numofpages){
	$pagenext = ($page + 1);
	echo "<a href=\"index.php?operacao=ListarUtentes&page=$pagenext$parameters\">NEXT</a>";
 }

 ?>
 </div>
         <!-- aqui irá ficar o conteudo alteravel-->      
</body>

</html>
