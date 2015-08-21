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

$dataDa=date('Y-1-1');
$dataA=date('Y-12-31');
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
				<!--
				<a href="scegli_report.php" role="button" class="btn btn-primary btn-block">Report</a>
				<a href="inserisci_spesa.php" role="button" class="btn btn-primary btn-block">Inserisci spesa</a>
				-->
				<h4>Spese anno corrente</h4>
				<table class="table table-striped">
					<thead>
						<tr>
							<th align="left">Importo</th>
							<th align="left">Note</th>
							<th align="left">Descrizione</th>
							<th align="center">Data</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$sql="SELECT SUM(SPESA.importo) as totale
								  FROM SPESA
								  WHERE (SPESA.data BETWEEN '$dataDa' AND '$dataA') ";
							$result = mysql_query($sql);
							while ($row = mysql_fetch_array($result)) {
								echo '<b>Totale: ' . ' ' . $row['totale'] . '</b>';
							}
							echo '<br/>';
		 					$sql="SELECT SPESA.importo, SPESA.note, TIPO_SPESA.descrizione, SPESA.data
								  FROM SPESA, TIPO_SPESA
								  WHERE SPESA.id_tipo_spesa = TIPO_SPESA.id 
								  AND (SPESA.data BETWEEN '$dataDa' AND '$dataA') 
								  ORDER BY SPESA.data ASC ";
							$result = mysql_query($sql);
							while ($row = mysql_fetch_array($result)) {
								echo ' <tr> ';
								echo ' <td> ';
								echo $row['importo'];
								echo ' <td> ';
								echo $row['note'];
								echo ' <td> ';
								echo $row['descrizione'];
								echo ' <td> ';
								echo $row['data'];
							}	
						?>
					</tbody>
				</table>
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
