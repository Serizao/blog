<?php
function printFooter(){
	print "</body></html>"; 
	}

function printHeader($page, $errMsg=null){
	print '<!DOCTYPE html><html><head><title>fwzte.xyz - ';
	print $page['windowTitle'];
	print '</title><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"></head><body><h1>Administration</h1>';
	print '<div><a href="../index.html" class="droid">Retour à l\'accueil</a> - <a href="index.php?action=logout" class="droid">Terminer la session</a></div><h2>';
	print $page['title'].'</h2>';
	print '<link rel="stylesheet" type="text/css" href="css/main.css">';
	print $errMsg;
	}

function secureAccess(){
	session_start();
	if (!checkaccess()){
	header('location: index.php'); // on redirige vers index.php
	exit;
	}
	}

function checkAccess(){
	return ($_SESSION['username']=='admin');
	}

function listPostFiles(){
	return glob('posts/*.md');
	}

function extractMetaFromPostFile ($file){
	$fh=fopen($file, 'r');
	$line=fgets($fh);
	fclose($fh);
	return json_decode($line,true);
	}	
function getFromConfig($var){
	static $config;
	include_once('config.php');
	return $config[$var];
}

?>