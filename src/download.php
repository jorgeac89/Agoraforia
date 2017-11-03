<?php
include("scripts/init.php");

if(!isset($_REQUEST["file"])){
	header("Location: index.php");
	exit;
}

$file=selectQuery("
		SELECT 
			u.nick nick, 
			s.uid uid, 
			s.path, 
			path, 
			s.file file 
		FROM 
			users u, 
			shared s 
		WHERE 
			s.uid = u.id AND 
			hash = '".$_REQUEST["file"]."';");

if(count($file)==0){
	header("Location: index.php");
	exit;
}

if(is_file("./users/".$file[0]["nick"].$file[0]["path"].$file[0]["file"])){
	header("Content-Disposition: attachment; filename=\"".$file[0]["file"]."\"");
	header("Content-Type: application/force-download");
	header("Content-Transfer-Encoding: binary");
	header("Content-Length: ".filesize("./users/".$file[0]["nick"].$file[0]["path"].$file[0]["file"]));
	readfile("./users/".$file[0]["nick"].$file[0]["path"].$file[0]["file"]);
	exit;
}else{
	modQuery("
			DELETE FROM shared 
			WHERE 
				uid = ".$_SESSION["uid"]." AND 
				path = '".$_SESSION["path"]."' AND 
				file = '".$_REQUEST["share"]."';");
}

?>
