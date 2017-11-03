<?php
include("scripts/init.php");

if(isset($_SESSION["uid"])){
	header("Location: index.php");
	exit;
}
if(isset($_REQUEST["register"], $_REQUEST["regNick"], $_REQUEST["regPassword"], $_REQUEST["regEmail"], $_REQUEST["regName"], $_REQUEST["regSurname"], $_REQUEST["regDate"])){
	if(validateRegForm($_REQUEST["regNick"], $_REQUEST["regPassword"], $_REQUEST["regEmail"], $_REQUEST["regName"], $_REQUEST["regSurname"], $_REQUEST["regDate"])){
		regUser($_REQUEST["regNick"], $_REQUEST["regPassword"], $_REQUEST["regEmail"], $_REQUEST["regName"], $_REQUEST["regSurname"], $_REQUEST["regDate"]);
		if(startSession($_REQUEST["regNick"], $_REQUEST["regPassword"])){
			header("Location: user.php?id=".$_SESSION["uid"]);
			exit;
		}
	}
}
$FORWARD = findForward("registration");
include(TEMPLATE_FILE);
?>
