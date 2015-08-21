<?php
include("db.php");
session_start();

$id_utente = $_SESSION['id_utente'];
$utenteLoggato = $_SESSION['login_user'];

$messaggio = <<<EOT
		<p id="p-destro" align="right">
<font size="2"> User: $utenteLoggato <a href="logout.php">Esci</a><br /> </font>
</p>
</font>
<br/><br/>
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
		header("location: scegli_spesa.php");
	} else {
?>
<script>alert("Inserimento fallito");</script>
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
					<li><a href="inserisci_spesa.php">Inserisci spesa</a></li>
					<li class="active"><a href="scegli_report.php">Report</a></li>
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
				<a href="report_spese_mese.php" role="button" class="btn btn-primary btn-block">Report spese ultimo mese</a>
				<a href="report_spese_due_mesi.php" role="button" class="btn btn-primary btn-block">Report spese ultimi due mesi</a>
				<a href="report_spese_sei_mesi.php" role="button" class="btn btn-primary btn-block">Report spese ultimi sei mesi</a>
				<a href="report_spese_anno_corrente.php" role="button" class="btn btn-primary btn-block">Report spese anno corrente</a>
        </div>
    </div>
<!-- Bootstrap core JavaScript
    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="./bootstrap-3.3.2-dist/js/bootstrap.min.js"></script>
</body>
</html>
