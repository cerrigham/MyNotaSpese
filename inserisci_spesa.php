<?php
include("db.php");
session_start();

$id_utente = $_SESSION['id_utente'];
$utenteLoggato = $_SESSION['login_user'];

$messaggio = <<<EOT
		<p id="p-destro" align="right">
<font size="2"> User: $utenteLoggato <a href="logout.php">Esci</a><br/> </font>
</p>
</font>
<br/><br/>
EOT;

$messaggio1 = <<<EOT
User: $utenteLoggato
EOT;
//echo $messaggio;

if($_SERVER["REQUEST_METHOD"] == "POST")
{
$myimporto=addslashes($_POST['importo']);
$mydata=addslashes($_POST['data']);
$mynote=addslashes($_POST['note']);
$mytipospesa=addslashes($_POST['tipospesa']);

$sql="INSERT INTO SPESA (importo, id_utente, id_tipo_spesa, note, flag_importante, flag_da_sistemare, data)
VALUES ('$myimporto', '$id_utente', '$mytipospesa', '$mynote', 'N', 'N', '$mydata')";

$result=mysql_query($sql);
if ($result) {
?>
<script>alert("Inserimento riuscito");</script>
<?php
	if (isset($_FILES['userfile'])) {
		$sqlUltimoInsert="SELECT MAX(id) as idMax FROM SPESA ";
		$resultUltimoInsert=mysql_query($sqlUltimoInsert);

		while ($row = mysql_fetch_array($resultUltimoInsert)) {
			$id_spesa = $row['idMax'];
		}
		$uploaddir = './allegati/';
		// recupero il percorso temporaneo del file
		$userfile_tmp = $_FILES['userfile']['tmp_name'];

		// recupero il nome originale del file caricato
		$userfile_name = $_FILES['userfile']['name'];
   	
		// recupero estensione del file
		$temp = explode('.', $_FILES['userfile']['name']);
		$estensione = end($temp);
		$mynotenospazi = str_replace(" ", "", $mynote);
		$aaaammgg = str_replace("-", "", $mydata);
		// il nuovo nome del file e' formato da: id della spesa, data in formato aaaammgg, note della spesa (senza spazi) ed estensione
		$nomeFile = $id_spesa . "_" . $aaaammgg . "_" . $mynotenospazi .  "."  . $estensione;
		$nomeFileAssoluto = $uploaddir . $nomeFile;
		// memorizzo il file nella cartella allegati e salvo il suo nome dentro il db
		move_uploaded_file($userfile_tmp, $uploaddir . $nomeFile);
		$pos = strpos($nomeFile, "nofile");
		if ($pos == false) {
			$sql="UPDATE SPESA set nome_file = '$nomeFileAssoluto' WHERE id = '$id_spesa' ";
			$result=mysql_query($sql);
		}
	}
} else {
?>
<script>alert("Inserimento non riuscito");</script>
<?php
	}
}
?>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>MyNotaSpese</title>

    <!-- Bootstrap core CSS -->
    <link href="./bootstrap-3.3.2-dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <style>
    	.glyphicon:before {
 			visibility: visible;
		}
		.glyphicon.glyphicon-star-empty:checked:before {
   			content: "\e006";
		}
		input[type=checkbox].glyphicon{
    		visibility: hidden;
		}
	</style>
</head>

<body>
	<nav class="navbar navbar-default">
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">MyNotaSpese</a>
			</div>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li class="active"><a href="inserisci_spesa.php">Inserisci spesa</a></li>
					<li><a href="scegli_report.php">Report</a></li>
					<li><a href="modifica_ultima_spesa.php">Modifica ultima spesa</a></li>
					<li><a href="elimina_ultima_spesa.php">Elimina ultima spesa</a></li>
					<li><a href="inserisci_tipo_spesa.php">Nuovo tipo spesa</a></li> 
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li>
						<a href="logout.php">
							<?php
							echo $messaggio1 . " ";	
							?>
							Esci
						</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<?php
					//echo $messaggio;
				?>
				<!--
				<a href="scegli_report.php" role="button" class="btn btn-primary btn-block">Report</a>
				-->
				<form action="" method="post" name="aggiungi_spesa" enctype="multipart/form-data">
						<h4>Aggiungi spesa</h4>
						<div class="form-group">
							<label for="importo" class="control-label">Importo</label>
							<input type="number" class="form-control" step="any" id="importo" required="true" name="importo">
						</div>
						<div class="form-group">
							<label for="data" class="control-label">Data</label>
							<input type="date" class="form-control" id="data" required="true" name="data">
						</div>
						<div class="form-group">
							<label for="note" class="control-label">Note</label>
							<input type="text" class="form-control" id="note" name="note" maxlength="150" size="150">
						</div>
						<div class="form-group">
							<label for="tipospesa" class="control-label">Tipo spesa</label>
							<?php
							$query="SELECT id, descrizione FROM TIPO_SPESA ORDER BY descrizione";
							$res = mysql_query($query);
							if ($res && mysql_num_rows($res)>0){
							?>
							<select id="tipospesa" name="tipospesa" class="form-control">
							<?php
								while($row=mysql_fetch_assoc($res)){
							?>
								<option value="<?php echo $row['id']?>"><?php echo $row['descrizione']?></option>
								<?php
									}
								?>
							</select>
							<?php
								}
							?>
						</div>
                        <div class="form-group">
							<label for="note" class="control-label">Foto</label>
							<input type="file" accept="image/*" capture  id="userfile" name="userfile">
						</div>
       					<button type="submit" class="btn btn-primary">Salva</button>
				</form>
			</div>
        </div>
    </div>
<!-- Bootstrap core JavaScript
    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="./bootstrap-3.3.2-dist/js/bootstrap.min.js"></script>
</body>
</html>
