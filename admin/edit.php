<?php
include_once('includes/functions.php'); 
$page['title']  = 'Création / modification d´un article';
$page['windowTitle'] = 'Gestion des articles';
secureAccess();
if ($_POST){
	if (trim($_POST['title'])){ 
		$filename = $_GET['edition']?$_GET['edition']:strtolower(trim($_POST['title']));
		$originCharacters = array('à','â','ç','è','é','ê','ë','ï','ô','ù');
		$destinCharacters = array('a','a','c','e','e','e','e','i','o','u');
		$filename = str_replace($originCharacters,$destinCharacters,$filename);
		$filename = preg_replace('/[^a-z0-9-]/','-',$filename);
		$filename = 'posts/'.$filename.'.md';
		$metaData['title'] = $_POST['title'];
		$fileContent = json_encode($metaData)."\n";
		$fileContent.= str_replace("\n",'',strip_tags($_POST['description']))."\n";
		$fileContent.= strip_tags($_POST['content']);
			if (file_put_contents($filename,$fileContent)) {
				header('location: main.php');
				exit;
			}
			else{
				$errMsg = '<div style="border:solid 2px red; background:pink;color:red;padding:1em;display:inline-block">Impossible d´enregistrer le fichier</div>' ;
			}
	}
	else{
		$errMsg = '<div style="border:solid 2px red; background:pink;color:red;padding:1em;display:inline-block">Titre invalide</div>' ;
	}
}
elseif ($_GET['edition']){
	$fileContent = file_get_contents('posts/'.$_GET['edition'].'.md');
	$explodedContent = explode("\n", $fileContent , 3 );
	$metaData = json_decode($explodedContent[0],true);
	$description = $explodedContent[1];
	$content = $explodedContent[2];
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
			<h1>Administration</h1>
			<ul class="columns"><li class="case left"><a href="../index.html" class="helvetica bouton">Home</a></li><li class="case left active"><a href="main.php" class="helvetica bouton">Posts</a></li><li class="case left"><a href="imgmgr.php" class="helvetica bouton">Images</a></li><li class="case right"><a href="index.php?action=logout" class="bouton helvetica">Logout</a></li></ul>
			<?php print '<h2>Création / modification d´un article</h2>';?>
			
			<?php print $errMsg;?>
			<form method="POST">
				<label for="title">Titre de l´article</label><br>
				<input id="title" name="title" <?php if ($metaData['title']) echo 'value="'.$metaData['title'].'"';?>><br>
				<label for"description">En-tête (sans retour à la ligne)</label><br>
<textarea id="description" name="description" rows="5" cols="100"><?php if (isset($description)) echo $description;?></textarea><br>
				<label for="content">Contenu</label><br>
				<textarea id="content" rows="25" cols="100" name="content"><?php if (isset($content)) echo "$content";?></textarea><br>
				<input class="input" type="submit" value="Valider">
			</form>
				
			<?php printFooter(); ?>
