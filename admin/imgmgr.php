<?php
	$page['title']='Gestionnaire d´images';
	$page['windowTitle'] = 'Gestion des images';
	include_once ('includes/functions.php');
	include_once ('includes/imagesFunctions.php');
	secureAccess();
	$imagesRoot = getFromConfig('imgdirectory');
	if (!array_key_exists('imgmgr',$_SESSION)) $_SESSION['imgmgr'] = array();
	//reglage du repertoire courant
	if (isset($_GET['chdir'])) {
		$newDir = realpath($_SERVER['DOCUMENT_ROOT']).'/'.$_GET['chdir'];
		$absoluteImagesRoot = realpath($_SERVER['DOCUMENT_ROOT'].'/'.$imagesRoot);
		if (substr($newDir,0,strlen($absoluteImagesRoot)) == $absoluteImagesRoot) {
			$curDir = $_SESSION['imgmgr']['currentdir'] = $_GET['chdir'];
		}else {
			// il s´agit d´un chemin interdit
			$curDir = $_SESSION['imgmgr']['currentdir'] = $imagesRoot;
		}
	}elseif ($_SESSION['imgmgr']['currentdir']) {
		$curDir = $_SESSION['imgmgr']['currentdir'];
	}else {
		$curDir = $_SESSION['imgmgr']['currentdir'] = $imagesRoot;
	}
	$absoluteCurDir = realpath($_SERVER['DOCUMENT_ROOT'].'/'.$curDir).'/';

	if (isset($_GET['action']) AND $_GET['action']=='upload' && $_POST && $_FILES['imagefile']) {
		if (strpos($_FILES['imagefile']['type'],'image')!==0){
			$errMsg = '<div style="border:solid 2px red;background:pink;color:red;padding:1em;display:inline-block" class="free_sans">Le fichier n´est pas reconnu comme une image.</div>';
		}
		else 
		{
			move_uploaded_file($_FILES['imagefile']['tmp_name'] , $absoluteCurDir.basename($_FILES['imagefile']['name']));
	}		
	}

	if (isset($_GET['action']) AND $_GET['action']=='createdir' && $crdir = basename ($_POST['directoryname'])) {
		if (mkdir($absoluteCurDir.$crdir)) {
			$curDir.=$crdir.'/';
			$absoluteCurDir = realpath($_SERVER['DOCUMENT_ROOT'].'/'.$curDir).'/';
		}else {
			$errMsg = '<div style="border:solid 2px red;background:pink;color:red;padding:1em;display:inline-block" class="free_sans">Impossible de créer le dossier '.$crdir.'</div>'; //cddir
		}
	}
?>

<!DOCTYPE html>
	<html>
		<head>
			<title>fwzte.xyz - <?php print $page['windowTitle']?></title>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0"></head>
			<link rel="stylesheet" type="text/css" href="css/main.css">
		<body>
		<h1>Administration</h1>
		<ul class="columns"><li class="case left"><a href="../index.html" class="free_sans bouton">Home</a></li><li class="case left"><a href="main.php" class="free_sans bouton">Posts</a></li><li class="case left active"><a href="imgmgr.php" class="free_sans bouton">Images</a></li><li class="case right"><a href="index.php?action=logout" class="bouton free_sans">Terminer la session</a></li></ul>
		<h3>Gestionnaire d´images</h3>
		<? if (isset($errMsg)) { php print $errMsg; } ?>
		<fieldset>
		<legend><h3>Dossiers</h3></legend>
		<p class="free_sans">Emplacement actuel :</p>
		<?php
			echo '/'.substr($curDir,strlen($imagesRoot),-1);
			//remonter d´un niveau ?
			if ($curDir != $imagesRoot) {
				print '<a href="?chdir='.dirname($curDir).'/" class="free_sans"> Remonter d´un niveau</a>';
			}
			// affichage des dossiers
			$dirs = glob($absoluteCurDir.'*', GLOB_ONLYDIR);
			if ($dirs) {
				print '<ul>';
				foreach ($dirs as $dir) {
					$dir=basename($dir);
					print '<li>';
					print '<a href="?chdir='.$curDir.$dir.'/" class="free_sans">'.$dir.'</a>';
					print '</li>';
				}
				print '</ul>';
			}
		?></fieldset>
		<fieldset>
		<legend><h3>Images</h3></legend>
		<?php
			$imageFiles = array();
			$finfo = finfo_open(FILEINFO_MIME_TYPE);
			foreach (glob($absoluteCurDir.'*') as $filename) {
				if (strpos(finfo_file($finfo, $filename),'image')===0){
					$imageFiles[]=$filename;
				}
			}
			finfo_close($finfo);
			if ($imageFiles) {
				$width = getFromConfig('thumbWidth');
				$height = getFromConfig('thumbHeight');
				foreach ($imageFiles as $imageFile) {
					print '<div class="apercu">';
					$url = substr(realpath($imageFile),strlen($_SERVER['DOCUMENT_ROOT']));
					$url = substr($url,1); 
					print '<img src="../'.getResized($imageFile,$width,$height).'" onclick="javascript:c=parent.document.getElementById(\'content\');c. value+=\'![texte]('.$url.')\';c.focus();"><br>';
					echo $url . '<br>';
					print '</div>';
					}
			}
		?></fieldset>
		<fieldset>
			<legend class="free_sans">Télécharger une image</legend>
			<form enctype="multipart/form-data" method="POST" action="?action=upload">
				<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo getFromConfig('maxuploadedfilesize');?>">
				<label for="imagefile">Choisissez une image à télécharger :</label><br>
				<input type="file" name="imagefile"><br>
				<input class="input" type="submit" style="margin-top:10px;">
			</form>
		</fieldset>
		
		<form method="POST" action="?action=createdir">
			<fieldset>
				<legend class="free_sans">Créer un dossier</legend>
				<label for="directoryname">Nom du dossier à créer :</label><br>
				<input name="directoryname" id="directoryname"><br>
				<input class="input" type="submit" style="margin-top:10px;">
			</fieldset>
		</form>
	<?php
printFooter();
?>