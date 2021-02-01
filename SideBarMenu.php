<?php
if (isset($_SESSION['IdTipoUtilizador'])) {
	//if ($_SESSION['id']=1) {//É administrador
	$connect = mysqli_connect("127.0.0.84:3307", "root", "","sim");
	$sql = 'SELECT UrlCompleto FROM utilizadorfuncionalidades WHERE IdTipoUtilizador = "'. $_SESSION['IdTipoUtilizador'].'"';
	//echo htmlentities($sql);
	$result = mysqli_query ($connect ,$sql) or die('The query failed: ' . mysqli_error($connect));
	$number = mysqli_num_rows($result); //if returns 1, then is a valid user
	while ($row = mysqli_fetch_assoc($result) ) {
		echo '<li class="active">'.$row["UrlCompleto"].'</li>';
	}
}

//Por IdTipoUtilizador
?>
