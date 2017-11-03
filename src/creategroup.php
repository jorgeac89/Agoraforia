<?php
include("scripts/init.php");

if(!isset($_SESSION["uid"])){
	header("Location: index.php");
	exit;
}

if(!isset($_REQUEST["forumInputs"])){
	$_REQUEST["forumInputs"] = 1 ;
}

if(isset($_REQUEST["deleteForumInput"])){
	unset($_REQUEST["groupForums"][$_REQUEST["deleteForumInput"]]);
	$_REQUEST["groupForums"] = array_values($_REQUEST["groupForums"]);
	$_REQUEST["forumInputs"] = count($_REQUEST["groupForums"]);
}

if(isset($_REQUEST["createGroup"], $_REQUEST["groupName"], $_REQUEST["groupDescription"])){
	if(addGroup($_SESSION["uid"], $_REQUEST["groupName"], $_REQUEST["groupDescription"], $_REQUEST["groupForums"])){
		$group = selectQuery("SELECT MAX(g.id) id FROM groups g;");
		loadOwnGroups($_SESSION["uid"]);
		loadPoster($_SESSION["uid"]);
		header("Location: group.php?id=".$group[0]["id"]);
		exit;
	}
}

$FORWARD = findForward("groupEditor");
include(TEMPLATE_FILE);
?>