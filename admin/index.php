<?php
session_start();
if ($_GET['action']=='logout'){
	$_SESSION = array();
	$errMsg = '<div style="border:solid 2px green;background:lightgreen;color:green;padding:1em;display:inline-block">Votre session est terminée.</div>';
}
if ($_SESSION['username']=='admin'){
	header('location: main.php');
	exit;}
if ($_POST){
	if ($_POST['username']=='admin' && $_POST['password']=='monpass'){
		$_SESSION['username']=$_POST['username'];
		header('location: main.php');
		exit;
	}else{
		$errMsg = '<div style="border:solid 2px red; background:pink;color:red;padding:1em;display:inline-block">Nom d´utilisateur ou mot de passe invalide.</div>' ;
	}
}
include_once('includes/header.php');
?>
	<p>Veuillez vous identifier</p>
	<form method="POST">
		<input name="username" placeholder="Nom d´utilisateur">
		<input name="password" placeholder="Mot de passe" type="password">
		<input type="submit">		
	</form>
<?php
include_once('includes/footer.php')
?>