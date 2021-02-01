<?php
		
	if(isset($_GET['consulta']) AND $_GET['consulta'] == 1){
			//grava a consulta
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
			   	echo htmlentities($sql);
			   	$result = mysqli_query ($connect ,$sql) or die('The query failed: ' . mysqli_error($connect));
				$idConsulta = mysqli_insert_id($connect);	//Tem o Id inserido da consulta
				
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
			  header('Location: ' . $_SERVER['HTTP_REFERER']);			  
			}

		$connect = mysqli_connect("127.0.0.84:3307", "root", "","sim");
		$query = 'SELECT `IdUtente`, `NomeCompleto`, u.`Contacto`, u.`Email`, u.`DataNascimento`, `Sexo`
			  	  FROM `utentes` u
				  WHERE u.IdUtente = '.$_GET['idUtente'];
		//echo htmlentities($sql);
		$result = mysqli_query ($connect ,$query) or die('The query failed: ' . mysqli_error($connect));
		$row = mysqli_fetch_array($result);
		
		$nome=$row['NomeCompleto'];
		$contacto=$row['Contacto'];
		$email=$row['Email'];
		$dataNascimento=$row['DataNascimento'];
		$sexo=$row['Sexo'];
		
		$query = "SELECT `IdUtilizador`, `TipoConsulta`, `Recomendacao`, `DataConsulta`, `Concluida` FROM `consultas` WHERE `IdConsulta` = $idConsulta";
		//echo htmlentities($query);
		$result = mysqli_query ($connect ,$query) or die('The query failed: ' . mysqli_error($connect));
		$row = mysqli_fetch_array($result);
		
		$idObstetra=$row['IdUtilizador'];
		$tipoConsulta=$row['TipoConsulta'];
		//$recomendacao=$row['Recomendacao'];
		switch($row['Recomendacao']){
			case 'Sim': $recomendacao= 'Recomendamos tratamento';
			break;
			case 'Nao': $recomendacao= 'Nao se recomenda tratamento';
			break;
			case 'Fertilizacao invitro': $recomendacao= 'Recomendamos fertilizacao invitro';
			break;
			default: $recomendacao= 'Nao temos';
			break;	   	  
		}

		$dataConsulta=$row['DataConsulta'];
		$concluida=$row['Concluida'];
	
	}

//já envia emails agora é preciso fazer a construção do email

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer(false);                              // Passing `true` enables exceptions
try {
    //Server settings
    $mail->SMTPDebug = 0;//estava a 2                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'sim.nextgen2018@gmail.com';                 // SMTP username
    $mail->Password = 'NextGen123';                           // SMTP password
    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('sim.nextgen2018@gmail.com', 'Mailer');
    //$mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient

	if(isset($_GET['consulta']) AND $_GET['consulta'] == 1){//quando vem do gravar consulta e enviar email
	    $mail->addAddress('sim.nextgen2018@gmail.com');   //aqui alteramos o email
	    //$mail->addReplyTo('info@example.com', 'Information');

	    //$mail->addCC('cc@example.com');	//Podemos enviar com conhecimento para o obstetra

	    //$mail->addBCC('bcc@example.com');
	
	    //Attachments
	    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
	    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
	
	    //Content
	    $mail->isHTML(true);                                  // Set email format to HTML
	    $mail->Subject = 'Resultado da Consulta';
	    
	    if($sexo == 'M'){
		    $mail->Body    = "Sr. $nome após uma extensa análise aos parâmetros por si introduzidos o nosso obstetra chegou à seguinte recomendação: <b>$recomendacao</b>.<br> Estaremos ao seu dispor para qualquer dúvida que possamos esclarecer.<br><br><br> A clinica <b>NextGen!</b>";
		    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
	    }
	    else {
		    $mail->Body    = "Sr.ª $nome após uma extensa análise aos parâmetros por si introduzidos o nosso obstetra chegou à seguinte recomendação: <b>$recomendacao</b>.<br> Estaremos ao seu dispor para qualquer dúvida que possamos esclarecer.<br><br><br> A clinica <b>NextGen!</b>";
		    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';	    
	    }
	}
	else {//para testes standart
	    $mail->addAddress('sim.nextgen2018@gmail.com');               // Name is optional
	    //$mail->addReplyTo('info@example.com', 'Information');
	    //$mail->addCC('cc@example.com');
	    //$mail->addBCC('bcc@example.com');
	
	    //Attachments
	    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
	    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
	
	    //Content
	    $mail->isHTML(true);                                  // Set email format to HTML
	    $mail->Subject = 'Here is the subject';
	    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
	    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
	}

    $mail->send();
    echo 'Mensagem enviada';
} catch (Exception $e) {
    echo 'Erro ao enviar mensagem. Mailer Error: ', $mail->ErrorInfo;
}
?>
