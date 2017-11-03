<?php
include("scripts/init.php");

if(!isset($_SESSION["uid"])){
	header("Location: index.php");
	exit;
}


if(isset($_REQUEST["title"], $_REQUEST["content"], $_REQUEST["recivers"])){
	$recivers = getSplits($_REQUEST["recivers"]);
	addMessage($_REQUEST["title"], $_REQUEST["content"], $_SESSION["uid"], $recivers);
	header("Location: createmessage.php");
	exit;
}

$FORWARD = $FORWARD = findForward("postEditor");
include(TEMPLATE_FILE);
?>
