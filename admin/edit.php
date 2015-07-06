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
printHeader($page,$errMsg);
?>
	<form method="POST">
		<label for="title">Titre de l´article</label><br>
		<input id="title" name="title" <?php if ($metaData['title']) echo 'value="'.$metaData['title'].'"';?>><br>
		<label for"description">En-tête (sans retour à la ligne)</label><br>
		<textarea id="description" name="description" rows="5" cols="60"><?php if ($description) echo $description;?></textarea><br>
		<label for="content">Contenu</label><br><textarea id="content" rows="25" cols="60" name="content"><?php if ($content) echo "$content";?></textarea><br>
		<iframe src="imgmgr.php" height="388" widthz="300"></iframe>
		<input type="submit">
	</form>
<?php
printFooter();
?>