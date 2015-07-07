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

//print '<p><a href="../index.html">retour à l\'accueil</a> -</p>' ;
printHeader($page,$errMsg);

?>
	<p><a href="edit.php">Création d´un nouvel article</a></p>
		<div class="tableau"><p class="legende,ligne"><span class="case1">Titre</span><span class="case2">Actions</span>
		<?php
		$files = listPostFiles();
		foreach ($files as $file) {
			$metaData = extractMetaFromPostFile($file);
			$shortFile = basename($file,'.md');
			print '<p classe="ligne"><span class="case1">'.$metaData['title'].'</span><span class="case2"><a href="edit.php?edition='.$shortFile.'">Modifier</a> - <a href="?action=delete&file='.$shortFile.'">Supprimer</a></span></p>';
			}
		?>
		</div>
	<br><br><div class="apply"><a href="main.php?action=publish" class="droid police">Appliquer</a></div>
<?php 
printFooter();