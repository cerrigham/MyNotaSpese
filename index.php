<?php
include("db.php");
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST")
{
	// username and password sent from Form
	$myusername=addslashes($_POST['myusername']);
	$mypassword=addslashes($_POST['mypassword']);

	$sql="SELECT u.* FROM UTENTE u WHERE u.username='$myusername' AND u.password='$mypassword' ";
    //$sql="SELECT u.* FROM UTENTE u WHERE u.username='luigicerrato' AND u.password='17neaples' ";

	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);

	$count=mysql_num_rows($result);

	// If result matched $myusername and $mypassword, table row must be 1 row
	if($count==1) {
    	$_SESSION['id_utente']=$row[0];
		$_SESSION['login_user']=$row[1];
		if($myusername == 'admin') {
			header("location: panel_admin.php");
		} else {
			header("location: inserisci_spesa.php");
		}
	} else {
?>
<script>
    alert("Username o password sbagliata");
</script>
<?php
    	/* log su file
		$testo = $testo."\n\rAltre info: ".$myusername;
        $testo = $testo."\n\rAltre info: ".$mypassword;
		$var=fopen("logger.txt","a");
		fwrite($var,$testo);
		fclose($var);
        */
	}
}
?>
<html lang="en">
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
</head>

<body>
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div id="titolo">
					<center><b>MyNotaSpese</b><br/>by Luigi Cerrato<br/><br/></center>
				</div>
				<div id="centro">
					<form action="" method="post" name="login_form">
						<div class="form-group">
							<label for="username" class="control-label">Username</label>
							<input type="text" class="form-control" name="myusername" id="username"placeholder="Your username" required="true">
						</div>
						<div class="form-group">
							<label for="password" class="control-label">Password</label>
							<input type="password" class="form-control" name="mypassword" id="password"placeholder="Your password" required="true">
						</div>
						<button type="submit" class="btn btn-primary">Accedi</button>
					</form>
				</div>
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