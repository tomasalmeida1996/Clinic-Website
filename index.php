<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET["operacao"])) {
	switch($_GET["operacao"]){
	case 'checkLogin':
		if (isset($_POST['user']) AND isset($_POST['pass'])) {
			//tive de pôr a porta para conseguir utilizar a mariaDB				
			$connect = mysqli_connect("127.0.0.84:3307", "root", "","sim");
			$sql = 'SELECT IdUtilizador, IdTipoUtilizador FROM Utilizadores u 
					WHERE (Ativo = 1 AND username = "'. $_POST['user'] .'" AND password = "'.($_POST['pass']) .'")';
			$result = mysqli_query ($connect ,$sql) or die('The query failed: ' . mysqli_error($connect));
			$number = mysqli_num_rows($result); //if returns 1, then is a valid user
		  	//echo"Temos number";
		  	
		   if ($number == 1) {
		   		
				if(isset($_SESSION['authuser'])){
			    	unset($_SESSION['authuser']);
			    }
		  	    $_SESSION['username']= $_POST['user'];
		  	    $row = mysqli_fetch_array($result);
		  	    //$idUtilizador = $row[IdUtilizador];
		  	    $_SESSION['id']=$row[0];
		  	    $_SESSION['IdTipoUtilizador']=$row[1];		  	    
		  	    //header("Location: index.php?operacao=valido?id=$IdUtilizador");
		   }
		   else
		   	$_SESSION['authuser']=0;//utilizador nao existe
		   	$_GET['operacao']='login';

		}
		else {
		  $_SESSION['authuser']=0;//mal preenchido
		  $_GET['operacao']='login';
		}
	break;
	case 'checkRegistoUtilizador':	
		//echo'entrou no registo';
		if (isset($_POST['TipoUtilizador']) AND isset($_POST['nome']) AND isset($_POST['apelido']) AND isset($_POST['user']) AND isset($_POST['pass']) AND isset($_POST['morada']) AND isset($_POST['contacto']) AND isset($_POST['email'])) {
			//campos obrigatórios
			$required = array('TipoUtilizador', 'nome', 'apelido', 'morada', 'contacto', 'email', 'user', 'pass');
			
			//verificar se algum está vazio
			$error = false;
			foreach($required as $field) {
			  if (empty($_POST[$field])) {
			    $error = true;
			  }
			}

			if ($error == false AND $_POST['TipoUtilizador'] != '-1') {
				//tive de pôr a porta para conseguir utilizar a mariaDB				
				$connect = mysqli_connect("127.0.0.84:3307", "root", "","sim");
				$sql = 'SELECT * FROM Utilizadores WHERE (username = "'. $_POST['user'].'")'; //verificar se o utilizador já existe
				$result = mysqli_query ($connect ,$sql) or die('The query failed: ' . mysqli_error($connect));
				$number = mysqli_num_rows($result); 
			  	
			   if ($number == 0) {
			   	//utilizador nao existe, pode registar
				$sql = 'INSERT INTO Utilizadores (`IdTipoUtilizador`, `Nome`, `Morada`, `Email`, `Contacto`, `Username`, `Password`, `Ativo`) 
						VALUES ('. $_POST['TipoUtilizador'].', "'. $_POST['nome'].' '. $_POST['apelido'].'", "'. $_POST['morada'].'", "'. $_POST['email'].'", "'. $_POST['contacto'].'", "'. $_POST['user'].'", "'. $_POST['pass'].'", 1)';
			   	//echo htmlentities($sql);
			   	$result = mysqli_query ($connect ,$sql) or die('The query failed: ' . mysqli_error($connect));

				if(isset($_SESSION['registoUtilizador'])){
			    	unset($_SESSION['registoUtilizador']);
			    }
				//echo"deu certo";
	   	  	    $_SESSION['username']=$_POST['user'];
	   	  	    $_SESSION['id']=mysqli_insert_id($connect);
	   	  	    //echo ' Id = '.$_SESSION['id'];
			   }
			   else {
			   	$_SESSION['registoUtilizador']=0;//utilizador já existe
			   	$_GET['operacao']='RegistarUtilizador';
				//echo"já existe";			   	
			   }	
			}
			else {
			  $_SESSION['registoUtilizador']=-1;//campos em falta
			  $_GET['operacao']='RegistarUtilizador';
				//echo"campos em falta";			  
			}
		}
		
	break;
	case 'checkRegistoUtente':	
		//echo'entrou no registo';
		
		//FALTA A FOTO!!
		if (isset($_POST['nome']) AND isset($_POST['apelido']) AND isset($_POST['user']) AND isset($_POST['pass']) AND isset($_POST['morada']) AND isset($_POST['localidade']) AND  isset($_POST['distrito']) AND isset($_POST['contacto']) AND isset($_POST['email']) AND 'dataNascimento' AND isset($_POST['sexo']) AND isset($_POST['nif']) AND isset($_POST['cartaoSaude']) AND isset($_POST['alergias'])) {
			//campos obrigatórios
			$required = array('nome', 'apelido', 'morada', 'localidade', 'distrito', 'contacto', 'email', 'dataNascimento', 'sexo', 'nif', 'cartaoSaude', 'alergias', 'user', 'pass');
			
			//verificar se algum está vazio
			$error = false;
			foreach($required as $field) {
			  if (empty($_POST[$field])) {
			    $error = true;
			  }
			}

			if ($error == false AND $_POST['TipoUtilizador'] == '2') {
				//tive de pôr a porta para conseguir utilizar a mariaDB				
				$connect = mysqli_connect("127.0.0.84:3307", "root", "","sim");
				$sql = 'SELECT * FROM Utilizadores WHERE (username = "'. $_POST['user'].'")'; //verificar se o utilizador já existe
				$result = mysqli_query ($connect ,$sql) or die('The query failed: ' . mysqli_error($connect));
				$number = mysqli_num_rows($result); 
			  	
			   if ($number == 0) {
			   	//utilizador nao existe, pode registar		
				$sql = 'INSERT INTO Utilizadores (`IdTipoUtilizador`, `Nome`, `Morada`, `Email`, `Contacto`, `Username`, `Password`, `Ativo`) 
						VALUES ('. $_POST['TipoUtilizador'].', "'. $_POST['nome'].' '. $_POST['apelido'].'", "'. $_POST['morada'].'", "'. $_POST['email'].'", "'. $_POST['contacto'].'", "'. $_POST['user'].'", "'. $_POST['pass'].'", 1)';
			   	//echo htmlentities($sql);
			   	
			   	$result = mysqli_query ($connect ,$sql) or die('The query failed: ' . mysqli_error($connect));

				$idUtilizador = mysqli_insert_id($connect);	//Tem o Id inserido nos utilizadores


				$sql = 'INSERT INTO Utentes (`IdUtilizador`, `NomeCompleto`, `Morada`, `Localidade`, `Distrito`, `Email`, `Contacto`, `DataNascimento`, `Sexo`, `NIF`,`CartaoSaude`, `Alergias`) 
						VALUES ('.$idUtilizador .', "'. $_POST['nome'].' '. $_POST['apelido'].'", "'. $_POST['morada'].'", "'. $_POST['localidade'].'", "'. $_POST['distrito'].'", "'. $_POST['email'].'", "'. $_POST['contacto'].'", "'. $_POST['dataNascimento'].'", "'. $_POST['sexo'].'", "'. $_POST['nif'].'", "'. $_POST['cartaoSaude'].'", "'. $_POST['alergias'].'")';
			   	//echo htmlentities($sql);
			   	$result = mysqli_query ($connect ,$sql) or die('The query failed: ' . mysqli_error($connect));

				if(isset($_SESSION['registoUtente'])){
			    	unset($_SESSION['registoUtente']);
			    }
				//echo"deu certo";
	   	  	    $_SESSION['username']=$_POST['user'];
	   	  	    $_SESSION['id']=$idUtilizador;
	   	  	    $_SESSION['IdTipoUtilizador']=$_POST['TipoUtilizador'];	   	  	    
			   }
			   else {
			   	$_SESSION['registoUtente']=0;//utilizador já existe
			   	$_GET['operacao']='registoUtente';
				//echo"já existe";			   	
			   }	
			}
			else {
			  $_SESSION['registoUtente']=-1;//campos em falta
			  $_GET['operacao']='registoUtente';
				//echo"campos em falta";			  
			}
		}
		
	break;
	case 'checkEditUtilizador':
		if (isset($_POST['nome']) AND isset($_POST['user']) AND isset($_POST['pass']) AND isset($_POST['morada']) AND isset($_POST['contacto']) AND isset($_POST['email'])) {
			//campos obrigatórios
			$required = array('nome', 'morada', 'contacto', 'email', 'user', 'pass');
			
			//verificar se algum está vazio
			$error = false;
			foreach($required as $field) {
			  if (empty($_POST[$field])) {
			    $error = true;
			  }
			}
			
			//if ($_POST['ativo'] != '1'){
			if (!isset($_POST['checkAtivo'])){
				$checkAtivo = 0;	//É pra desativar			
			}
			else {
				$checkAtivo = 1;	//É pra desativar			
			}
			
			if ($error == false) {
				//tive de pôr a porta para conseguir utilizar a mariaDB				
				$connect = mysqli_connect("127.0.0.84:3307", "root", "","sim");
				$sql = 'SELECT * FROM Utilizadores WHERE username = "'. $_POST['user'].'" AND IdUtilizador <> '.$_GET['idUtil']; //verificar se o username já existe
				$result = mysqli_query ($connect ,$sql) or die('The query failed: ' . mysqli_error($connect));
				$number = mysqli_num_rows($result); 
			  	
			   if ($number == 0) {
			   	//utilizador nao existe, pode fazer update
				$sql = 'UPDATE `utilizadores` SET `Nome`= "'. $_POST['nome'].'",`Username`= "'. $_POST['user'].'", `Password`= "'. $_POST['pass'].'",`Morada`= "'. $_POST['morada'].'",`Email`= "'. $_POST['email'].'", `Contacto`= "'. $_POST['contacto']."\",`Ativo`= {$checkAtivo} WHERE IdUtilizador = ".$_GET['idUtil'];  

			   	//echo htmlentities($sql);
			   	$result = mysqli_query ($connect ,$sql) or die('The query failed: ' . mysqli_error($connect));

				if(isset($_SESSION['Updated'])){
			    	unset($_SESSION['Updated']);
			    }
			   }
			   else {
			   	$_SESSION['Updated']=0;//utilizador já existe
			   	$_GET['operacao']='EditarUtilizador';
				//echo"já existe";			   	
			   }	
			}
			else {
			  $_SESSION['Updated']=-1;//campos em falta
			  $_GET['operacao']='EditarUtilizador';
				//echo"campos em falta";			  
			}
		}

	break;
	case 'checkEditUtente':
		if (isset($_POST['nome']) AND isset($_POST['user']) AND isset($_POST['pass']) AND isset($_POST['morada']) AND isset($_POST['localidade']) AND  isset($_POST['distrito']) AND isset($_POST['contacto']) AND isset($_POST['email']) AND 'dataNascimento' AND isset($_POST['sexo']) AND isset($_POST['nif']) AND isset($_POST['cartaoSaude']) AND isset($_POST['alergias'])) {
			//campos obrigatórios
			$required = array('nome', 'morada', 'localidade', 'distrito', 'contacto', 'email', 'dataNascimento', 'sexo', 'nif', 'cartaoSaude', 'alergias', 'user', 'pass');
			
			//verificar se algum está vazio
			$error = false;
			foreach($required as $field) {
			  if (empty($_POST[$field])) {
			    $error = true;
			  }
			}
			$checkAtivo = 1;	//enquanto nao for feito a parte do ativo

			//if ($_POST['ativo'] != '1'){
			//if (!isset($_POST['checkAtivo'])){
				//$checkAtivo = 0;	//É pra desativar			
			//}
			//else {
				//$checkAtivo = 1;	//É pra desativar			
			//}
			
			if ($error == false) {
				//tive de pôr a porta para conseguir utilizar a mariaDB				
				$connect = mysqli_connect("127.0.0.84:3307", "root", "","sim");
				$sql = 'SELECT * FROM Utilizadores WHERE username = "'. $_POST['user'].'" AND IdUtilizador <> '.$_GET['idUtil']; //verificar se o username já existe
				$result = mysqli_query ($connect ,$sql) or die('The query failed: ' . mysqli_error($connect));
				$number = mysqli_num_rows($result); 
			  	
			   if ($number == 0) {
			   	//utilizador nao existe, pode fazer update
				$sql = 'UPDATE `utilizadores` SET `Nome`= "'. $_POST['nome'].'",`Username`= "'. $_POST['user'].'", `Password`= "'. $_POST['pass'].'",`Morada`= "'. $_POST['morada'].'",`Email`= "'. $_POST['email'].'", `Contacto`= "'. $_POST['contacto']."\",`Ativo`= {$checkAtivo} WHERE IdUtilizador = ".$_GET['idUtil'];  
			   	//echo htmlentities($sql);
			   	$result = mysqli_query ($connect ,$sql) or die('The query failed: ' . mysqli_error($connect));

				$sql = 'UPDATE `utentes` SET `NomeCompleto`= "'. $_POST['nome'].'",`Morada`= "'. $_POST['morada'].'",`Localidade`= "'. $_POST['localidade'].'",`Distrito`= "'. $_POST['distrito'].'",`Email`= "'. $_POST['email'].'", `Contacto`= "'. $_POST['contacto'].'",`DataNascimento`= "'. $_POST['dataNascimento'].'",`Sexo`= "'. $_POST['sexo'].'",`NIF`= "'. $_POST['nif'].'",`CartaoSaude`= "'. $_POST['cartaoSaude'].'",`Alergias`= "'. $_POST['alergias']."\"  WHERE IdUtilizador = ".$_GET['idUtil'];  
			   	//echo htmlentities($sql);
			   	$result = mysqli_query ($connect ,$sql) or die('The query failed: ' . mysqli_error($connect));
				if(isset($_SESSION['Updated'])){
			    	unset($_SESSION['Updated']);
			    }
			   }
			   else {
			   	$_SESSION['Updated']=0;//utilizador já existe
			   	$_GET['operacao']='EditarUtente';
				//echo"já existe";			   	
			   }	
			}
			else {
			  $_SESSION['Updated']=-1;//campos em falta
			  $_GET['operacao']='EditarUtente';
				//echo"campos em falta";			  
			}
		}

	break;
	case 'checkParametrosUtente':	
		
		if (isset($_POST['duracaoInf']) AND isset($_POST['causa']) AND isset($_POST['imcElemF']) AND isset($_POST['afc']) AND isset($_POST['ftabaco']) AND isset($_POST['mtabaco']) AND  isset($_POST['etniaM'])) {
			//campos obrigatórios
			$required = array('duracaoInf', 'causa', 'imcElemF', 'afc', 'ftabaco', 'mtabaco', 'etniaM');
			
			//verificar se algum está vazio
			$error = false;
			foreach($required as $field) {
			  if (empty($_POST[$field])) {
			    $error = true;
			  }
			}

			if ($error == false AND $_POST['causa'] != '-1' AND $_POST['ftabaco'] != '-1' AND $_POST['mtabaco'] != '-1' AND $_POST['etniaM'] != '-1') {

				$connect = mysqli_connect("127.0.0.84:3307", "root", "","sim");
				$sql = 'SELECT IdUtente FROM Utentes u 
						WHERE (IdUtilizador = "'. $_SESSION['id'].'")';
			   	//echo htmlentities($sql);
			   	
			   	$result = mysqli_query ($connect ,$sql) or die('The query failed: ' . mysqli_error($connect));

		  	    $row = mysqli_fetch_array($result);
		  	    $idUtente = $row[0];

				//atualizar as fichas do cliente para historico
				$sql = 'UPDATE `fichasutente` SET `Historico`= 1 WHERE `Historico`= 0 AND `IdUtente` = '.$idUtente;
			   	//echo htmlentities($sql);
			   	$result = mysqli_query ($connect ,$sql) or die('The query failed: ' . mysqli_error($connect));


				$sql = 'INSERT INTO `fichasutente`(`IdUtente`, `DuracaoInf`, `Causa`, `IMCElemF`, `AFC`, `F_Tabaco`, `M_Tabaco`, `M_Etnia`, `Historico`)
						VALUES ('.$idUtente .', '. $_POST['duracaoInf'].', '. $_POST['causa'].', '. $_POST['imcElemF'].', '. $_POST['afc'].', '. $_POST['ftabaco'].', '. $_POST['mtabaco'].', '. $_POST['etniaM'].', 0)';
			   	//echo htmlentities($sql);
			   	$result = mysqli_query ($connect ,$sql) or die('The query failed: ' . mysqli_error($connect));

				if(isset($_SESSION['registoParametros'])){
			    	unset($_SESSION['registoParametros']);
			    }	
			}
			else {
			  $_SESSION['registoParametros']=-1;//campos em falta
			  $_GET['operacao']='InserirParametros';
				//echo"campos em falta";			  
			}
		}
	break;
	case 'GravarConsulta':	
		
			if ($_POST['recomendacao'] != '-1') {

				$connect = mysqli_connect("127.0.0.84:3307", "root", "","sim");

			    $sql = 'SELECT f.`IdFichaUtente`
					  	FROM `fichasUtente` f
						WHERE f.Historico = 0 AND f.`IdUtente` = '.$_GET['idUtente'];
			   	//echo htmlentities($sql);			   	
			   	$result = mysqli_query ($connect ,$sql) or die('The query failed: ' . mysqli_error($connect));
		  	    $row = mysqli_fetch_array($result);
		  	    $idFichaUtente = $row[0];

				$sql = 'INSERT INTO `consultas`(`IdUtilizador`, `IdFichaUtente`, `TipoConsulta`, `Classificacao`, `PercentagemCalc`, `Recomendacao`, `DataConsulta`, `Concluida`) 
						VALUES ('. $_SESSION['id'].", $idFichaUtente, ". '"'. $_POST['tipoConsulta']. '", "'. $_POST['classAvaliacao']. '", '. $_POST['probFinal']. ', "'. $_POST['recomendacao']. '", CURDATE(), 1)';
			   	//echo htmlentities($sql);
			   	$result = mysqli_query ($connect ,$sql) or die('The query failed: ' . mysqli_error($connect));

				//atualizar as fichas do cliente para historico
				$sql = 'UPDATE `fichasutente` SET `Historico`= 1 WHERE `IdFichaUtente` = '.$idFichaUtente;
			   	//echo htmlentities($sql);
			   	$result = mysqli_query ($connect ,$sql) or die('The query failed: ' . mysqli_error($connect));

				if(isset($_SESSION['gravarConsulta'])){
			    	unset($_SESSION['gravarConsulta']);
			    }	
			}
			else {
			  $_SESSION['gravarConsulta']=-1;//campos em falta
			  $_GET['operacao']='AvaliarUtente';
				//echo"campos em falta";			  
			}
		
	break;
	default:
	break;
//Check user name and password information

}

}
?>

<!DOCTYPE html >
<html >

<head>
<title>NextGen</title>

<link href="style.css" rel="stylesheet" type="text/css" />

<!--
<script type="text/javascript" src="js/script.js"></script>
-->

</head>

<body style="height: 221px">
<div class="main">
  <div class="main_resize">
    <div class="header">
      <div class="logo">
        <h1><a href="#"><span>Next</span>Gen<small>Clinica de Fertilidade</small></a></h1>
      </div>
      <!--
      <div class="search">
        <form method="get" id="search" action="#">
          <span>
          <input type="text" value="Search..." name="s" id="s" />
          <input name="searchsubmit" type="image" src="orange.gif" value="Go" id="searchsubmit" class="btn" height="22" style="width: 22px"  />
          
          </span>
        </form>
       
        <div class="clr"></div>
      </div>
      -->
      <div class="clr"></div>
      <div class="menu_nav">
        <ul>
         <li><a href="index.php?operacao=homepage">Home</a></li>
		 <?php
		 if (!isset($_SESSION['id'])) {
		  
          echo '<li><a href="index.php?operacao=login">Login</a></li>';
		 }
		 if (!isset($_SESSION['id'])) {
          echo '<li><a href="index.php?operacao=registoUtente">Registar</a></li>';                    
         } 
         ?>
          <li><a href="index.php?operacao=servicos">Serviços</a></li>          
          <li><a href="index.php?operacao=informacoes">Informações</a></li>
          <li><a href="index.php?operacao=contactos">Contactos</a></li>
         <?php
		 if (isset($_SESSION['id'])) {
          echo '<li><a href="index.php?operacao=logout">Logout</a></li>';
		 }
		 ?> 
        </ul>
        <div class="clr"></div>
      </div>
      <div class="hbg"><img src="home_image.jpg" width="923" height="300" alt="" />
      </div>
      <div class="content">
	   <div class="content_bg">
        <div class="mainbar">
         <!-- aqui irá ficar o conteudo alteravel-->
         <?php
			if (!isset($_GET['operacao'])) {
				include "homepage.php";
			}
			else if (isset($_GET["operacao"])) {
				//echo "/ operacao é a " .$_GET['operacao'];
				switch($_GET["operacao"]){
				  case 'login':
				    include "checkLogin.php";
				  break;
				  case 'registoUtente':
					include "registoUtente.php";
				  break;
				  case 'RegistarUtilizador':
					include "registoUtilizador.php";
				  break;
				  case 'logout':
					include "logout.php";
				  break;
				  case 'ListarUtilizadores':
					include "ListarUtilizadores.php";
				  break;
				  case 'VisualizarUtilizador':
					include "VisualizarUtilizador.php";
				  break;
				  case 'EditarUtilizador':
					include "EditarUtilizador.php";
				  break;
				  case 'ListarUtentes':
					include "ListarUtentes.php";
				  break;
				  case 'VisualizarUtente':
					include "VisualizarUtente.php";
				  break;
				  case 'EditarUtente':
					include "EditarUtente.php";
				  break;
				  case 'OpcaoParametros':
					include "OpcaoParametros.php";
				  break;
				  case 'InserirParametros':
					include "ParametrosUtente.php";
				  break;
				  case 'VerParametros':
					include "VerParametrosUtente.php";
				  break;
				  case 'CriarConsulta':
					include "CriarConsulta.php";
				  break;				  
				  case 'AvaliarUtente':
					include "AvaliarUtente.php";
				  break;
				  case 'EnviarEmail':
					include "EnviarEmail.php";
				  break;
				  case 'MostraEstatisticas':
					include "MostraEstatisticas.php";
				  break;
				  default:
				    include "homepage.php";
				  break;
				}
			}
			?>
		 <br>	
		 <br>
		 <br>
		 <br>
		 <br>
		 <br>
         <!-- aqui irá ficar o conteudo alteravel-->      
        </div>
        <div class="sidebar">
          <!--Menu Sidebar-->      
        <?php
        if(isset($_SESSION['id']) && $_SESSION['id'] > 0){ 
        
        echo '<h2 class="star">Menu</h2>';
         echo '<div class="clr">';
         echo '</div>';
          echo '<ul class="sb_menu">';
          //linhas do menu
          include "SideBarMenu.php"; 
          echo '</ul>';
         echo '</div>';
        } 
        ?>       
    </div>
   </div>
  </div>

</body>

</html>
