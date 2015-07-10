<?php
$page['title']  = 'Accueil';
$page['windowTitle'] = 'Gestion des articles';
include_once('includes/functions.php');
secureAccess();
if ($_GET){
	if ($_GET['action']=='delete'){
		$filename = 'posts/'.$_GET['file'].'.md';
		if (unlink($filename)){
			$errMsg = '<div style="border:solid 2px green;background:lightgreen;color:green;padding:1em;display:inline-block">'.$filename.' a bien été effacé.</div>';
		} else{
			$errMsg = '<div style="border:solid 2px red;background:pink;color:red;padding:1em;display:inline-block">Impossible d´effacer le fichier '.$filename.'</div>';
		}
	}
	if ($_GET['action']=='publish'){
		include_once('includes/templatesFunctions.php');
		include_once('libs/parsedown/Parsedown.php');
		$errMsg = publish();
		}
}
?>

<!DOCTYPE html>
	<html>
		<head>
			<title>fwzte.xyz - <?php print $page['windowTitle']?></title>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
		</head>
		<body>
			<h1>Administration</h1>
			<ul class="columns"><li class="case left"><a href="../index.html" class="free_sans bouton">Home</a></li><li class="case left active"><a href="main.php" class="free_sans bouton">Posts</a></li><li class="case left"><a href="imgmgr.php" class="free_sans bouton">Images</a></li><li class="case right"><a href="index.php?action=logout" class="bouton free_sans">Terminer la session</a></li></ul>
			<?php print '<h2>Accueil</h2>';?>
			<link rel="stylesheet" type="text/css" href="css/main.css">
			<div class="apply"><a href="edit.php" class="free_sans police">Création d´un nouvel article</a></div><br>
			<?php if (isset($errMsg)) { print $errMsg; } ?>
			<div class="ligne"> <div class="titre"><p>Titres</p></div><div class="action"><p>Actions</p></div></div>
			<?php
			$files = listPostFiles();
			foreach ($files as $file) {
				$metaData = extractMetaFromPostFile($file);
				$shortFile = basename($file,'.md');
				print '<div class="ligne"> <div class="titre free_sans"><p class="free_sans">'.$metaData['title'].'</p></div><div class="action"><div class="apply"><a href="edit.php?edition='.$shortFile.'" class="free_sans police">Modifier</a></div><div class="apply"><a href="?action=delete&file='.$shortFile.'" class="free_sans police">Supprimer</a></div></div></div>';
			}
			?>
		
	<div class="apply" style="margin-top:20px;"><a href="main.php?action=publish" class="free_sans police">Appliquer</a></div>
<?php 
printFooter();