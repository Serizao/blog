<?php
session_start();
$page['windowTitle'] = 'Connexion';
if ($_GET['action']=='logout'){
	$_SESSION = array();
	$errMsg = '<div style="border:solid 2px green;background:lightgreen;color:green;padding:1em;display:inline-block" class="droid">Votre session est terminée.</div>';
}
if (isset($_GET['action']) and isset($_SESSION['username']) and $_SESSION['username']=='admin'){
	header('location: main.php');
	exit;}
if ($_POST){
	if ($_POST['username']=='admin' && $_POST['password']=='monpass'){
		$_SESSION['username']=$_POST['username'];
		header('location: main.php');
		exit;
	}else{
		$errMsg = '<div style="border:solid 2px red; background:pink;color:red;padding:1em;display:inline-block" class="droid">Nom d´utilisateur ou mot de passe invalide.</div>' ;
	}
}
?>
<!DOCTYPE html>
	<html>
		<head>
			<title>fwzte.xyz - <?php print $page['windowTitle']?></title>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<link rel="stylesheet" type="text/css" href="css/main.css">
		</head>
		<body>
			<h1>Connexion</h1>
			<p class="helvetica">Veuillez vous identifier</p>
			<form method="POST">
				<input class="helvetica" name="username" placeholder="Nom d´utilisateur">
				<input class="helvetica" name="password" placeholder="Mot de passe" type="password">
				<input class="input" type="submit" value="Valider">
			</form>
			<br><a href="../index.html">retour à l'accueil</a>
<?php
include_once('includes/footer.php') 
?>
