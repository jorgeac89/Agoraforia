<?php
include("scripts/init.php");

if(!isset($_SESSION["uid"])){
	header("Location: index.php");
	exit;
}

if(isset($_REQUEST["noSelect"])){
	if(isset($_SESSION["select"])){
		unset($_SESSION["select"]);
	}
}

if(isset($_REQUEST["doSelection"])){
	if(!isset($_REQUEST["select"])){
		if(isset($_SESSION["select"])){
			unset($_SESSION["select"]);
		}
	}else{
		$_SESSION["select"] = array();
		foreach($_REQUEST["select"] as $path){
			if(existsFileDir($_SESSION["home"].$path) && !in_array($path, $_SESSION["select"])){
				$_SESSION["select"][count($_SESSION["select"])] = $path;
			}
		}
	}
}

if(isset($_REQUEST["path"]) && is_dir($_SESSION["home"].$_REQUEST["path"])){
	$_SESSION["path"]=$_REQUEST["path"];
}

if(isset($_REQUEST["download"]) && is_file($_SESSION["home"].$_SESSION["path"].$_REQUEST["download"])){
	header("Content-Disposition: attachment; filename=\"".$_REQUEST["download"]."\"");
	header("Content-Type: application/force-download");
	header("Content-Transfer-Encoding: binary");
	header("Content-Length: ".filesize($_SESSION["home"].$_SESSION["path"].$_REQUEST["download"]));
	readfile($_SESSION["home"].$_SESSION["path"].$_REQUEST["download"]);
	exit;
}

if(isset($_REQUEST["share"])){
	if(isShared($_SESSION["uid"], $_SESSION["path"], $_REQUEST["share"])){
		modQuery("
				DELETE FROM shared 
				WHERE 
					uid = ".$_SESSION["uid"]." AND 
					path = '".$_SESSION["path"]."' AND 
					file = '".$_REQUEST["share"]."';");
		
	}elseif(is_file($_SESSION["home"].$_SESSION["path"].$_REQUEST["share"])){
		modQuery("
				INSERT INTO shared(
					uid, 
					path, 
					file, 
					hash) 
				VALUES( 
					".$_SESSION["uid"].", 
					'".$_SESSION["path"]."', 
					'".$_REQUEST["share"]."', 
					md5(concat('".$_SESSION["uid"]."', '".$_SESSION["path"]."', '".$_REQUEST["share"]."')));");
	}
}

if(isset($_REQUEST["delete"]) && existsFileDir($_SESSION["home"].$_SESSION["path"].$_REQUEST["delete"])){
	delFileDir($_SESSION["home"].$_SESSION["path"].$_REQUEST["delete"]);
	if(is_file($_SESSION["home"].$_SESSION["path"].$_REQUEST["delete"])){
		if(isShared($_SESSION["uid"], $_SESSION["path"], $_REQUEST["delete"])){
			modQuery("
					DELETE FROM shared
					WHERE
						uid = ".$_SESSION["uid"]." AND
						path = '".$_SESSION["path"]."' AND
						file = '".$_REQUEST["delete"]."';");
		}
	}
}

if(isset($_REQUEST["directory"])){
	if(is_dir($_SESSION["home"].$_SESSION["path"]."Nueva carpeta")){
		for($i=0; $i<100; $i++){
			if(!is_dir($_SESSION["home"].$_SESSION["path"]."Nueva carpeta ".$i)){
				$create=mkdir($_SESSION["home"].$_SESSION["path"]."Nueva carpeta ".$i);
				break;
			}
		}
	}else{
		mkdir($_SESSION["home"].$_SESSION["path"]."Nueva carpeta");
	}
}

if(count($_FILES)>0 && $_FILES["file"]["name"]!=""){
	foreach($_FILES as $file){
		if((getDriveSize() + filesize($file["tmp_name"])) <=10*1024*1024){
			copy($file["tmp_name"], $_SESSION["home"].$_SESSION["path"].$file["name"]);
		}
	}
}

cleanGet();

$_REQUEST["files"]=dirToArray($_SESSION["home"].$_SESSION["path"]);

$_REQUEST["sharedFiles"]=selectQuery("
		SELECT 
			CONCAT('".$_SESSION["home"]."', path, file) path, 
			hash hash 
		FROM 
			shared 
		WHERE 
			uid = '".$_SESSION["uid"]."';");

$_REQUEST["sharedPaths"] = Array();

foreach($_REQUEST["sharedFiles"] as $sharedFile){
	$_REQUEST["sharedPaths"][count($_REQUEST["sharedPaths"])]=$sharedFile["path"];
}

$FORWARD = findForward("drive");
include(TEMPLATE_FILE);
?>
