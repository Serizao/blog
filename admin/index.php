<?php
session_start();
if ($_GET['action']=='logout'){
	$_SESSION = array();
	$errMsg = '<div style="border:solid 2px green;background:lightgreen;color:green;padding:1em;display:inline-block" class="droid">Votre session est terminée.</div>';
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
		$errMsg = '<div style="border:solid 2px red; background:pink;color:red;padding:1em;display:inline-block" class="droid">Nom d´utilisateur ou mot de passe invalide.</div>' ;
	}
}
include_once('includes/header.php');
?>
	<p class="droid">Veuillez vous identifier</p>
	<form method="POST">
		<input class="droid" name="username" placeholder="Nom d´utilisateur">
		<input class="droid" name="password" placeholder="Mot de passe" type="password">
		<input type="submit">		
	</form>
<?php
include_once('includes/footer.php')
?>