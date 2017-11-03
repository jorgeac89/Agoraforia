<?php
function loadConfiguration($configFilePath){
	$configuration=parse_ini_file($configFilePath);
	define("PAGE_DIR", $configuration["pageDir"]);
	define("PAGE_ROOT", $_SERVER["DOCUMENT_ROOT"].PAGE_DIR);
	define("USERS_DIR", $configuration["usersDir"]);
	define("RESOURCES_FILE", $configuration["resourcesFile"]);
	define("TEMPLATE_FILE", $configuration["templateFile"]);
	define("AUTO_START_SESSION", $configuration["autoStartSession"]);
	$resources = new DOMDocument();
	$resources->load(PAGE_ROOT.RESOURCES_FILE);
	$resourcesXpath = new DOMXPath($resources);
	$resourcesXpath ->registerNamespace("ns", $resources->lookupNamespaceUri($resources->namespaceURI));
	$dataBase = $resourcesXpath->query("/ns:resources/ns:databases/ns:database[@name='".$configuration["dataBase"]."']")->item(0);
	define("DATA_BASE_URL", $resourcesXpath->query("ns:url", $dataBase)->item(0)->nodeValue);
	define("DATA_BASE_USER", $resourcesXpath->query("ns:user", $dataBase)->item(0)->nodeValue);
	define("DATA_BASE_PASSWORD", $resourcesXpath->query("ns:password", $dataBase)->item(0)->nodeValue);
	define("DATA_BASE_NAME", $resourcesXpath->query("ns:name", $dataBase)->item(0)->nodeValue);
	define("DATA_BASE_CHARSET", $configuration["dataBaseCharset"]);
}

function findForward($forwardName){
	$resources = new DOMDocument();
	$resources->load(PAGE_ROOT.RESOURCES_FILE);
	$resourcesXpath = new DOMXPath($resources);
	$resourcesXpath = new DOMXPath($resources);
	$resourcesXpath ->registerNamespace("ns", $resources->lookupNamespaceUri($resources->namespaceURI));
	$forward = $resourcesXpath->query("/ns:resources/ns:mappings/ns:forward[@name='".$forwardName."']")->item(0);
	return $resourcesXpath->query("ns:path", $forward)->item(0)->nodeValue;
}

function selectQuery($query){
	mysql_connect(DATA_BASE_URL, DATA_BASE_USER, DATA_BASE_PASSWORD);
	mysql_set_charset(DATA_BASE_CHARSET);
	mysql_selectdb(DATA_BASE_NAME);
	$result=mysql_query($query);
	if($result==FALSE){
		return FALSE;
	}
	$i=0;
	$rows=array();
	while($row=mysql_fetch_array($result)){
		$rows[$i]=$row;
		$i++;
	}
	mysql_free_result($result);
	return $rows;
}

function modQuery($query){
	mysql_connect(DATA_BASE_URL, DATA_BASE_USER, DATA_BASE_PASSWORD);
	mysql_set_charset(DATA_BASE_CHARSET);
	mysql_selectdb(DATA_BASE_NAME);
	return mysql_query($query);
}

function dirToArray($path){
	if(is_dir($path) && ($dir=opendir($path))){
		$files=array();
		while(($file=readdir($dir))){
			$files[count($files)]=$file;
		}
		closedir($dir);
		unset($files[array_search(".", $files)]);
		unset($files[array_search("..", $files)]);
		return $files;
	}
	return NULL;
}

function existsFileDir($path){
	if(is_file($path) || is_dir($path)){
		return TRUE;
	}
	return FALSE;
}

function delFileDir($path){
	if(is_dir($path)){
		if(substr($path, strlen($path)-1, 1) != "/"){
			$path = "$path/";
		}
		$dir=dirToArray($path);
		foreach($dir as $file){
			delFileDir($path.$file);
		}
		rmdir($path);
	}
	else if(is_file($path)){
		unlink($path);
	}
}

function folderSize($path){
	if(is_dir($path) && ($dir = opendir($path))){
		$size = 0;
		$files = array();
		while(($file = readdir($dir))){
			if($file != "." && $file != ".."){
				if(is_dir($path.$file)){
					$size += folderSize($path.$file."/");
				}
				$size += filesize($path.$file);
			}
		}
		closedir($dir);
		return $size;
	}
	return NULL;
}

function mimeType($path){
	$finfo = finfo_open(FILEINFO_MIME_TYPE);
	$mimeType = finfo_file($finfo, $path);
	finfo_close($finfo);
	return $mimeType;
}

function cleanPost(){
	if(count($_POST)!=0 || count($_FILES)!=0)
		header("Location: ".$_SERVER[REQUEST_URI]);
}

function cleanGet(){
	if(count($_GET)!=0)
		header("Location: ".preg_replace("/\?.*$/", "", $_SERVER[REQUEST_URI]));
}

function htmlspecialcharsRecursive($stringArray){
	foreach($stringArray as $clave => $valor){
		if(is_array($valor)){
			$stringArray[$clave]=htmlspecialcharsRecursive($valor);
		}else{
			$stringArray[$clave] = htmlspecialchars($valor, ENT_QUOTES);
		}
	}
	return $stringArray;
}

function htmlspecialcharsToRequest(){
	if(isset($_REQUEST)){
		$_REQUEST=htmlspecialcharsRecursive($_REQUEST);
	}
}
?>