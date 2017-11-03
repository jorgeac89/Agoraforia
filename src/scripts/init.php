<?php
include("scripts/generalFunctions.php");
include("scripts/administration.php");

loadConfiguration("config/config.ini");
if(AUTO_START_SESSION){
	session_start();
}
loginLogout();
cancel();
htmlspecialcharsToRequest();
acceptInvitation();
leaveGroup();
deleteGroup();
reloadSession();
?>
