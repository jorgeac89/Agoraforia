<?php
include("scripts/init.php");

if($_REQUEST["id"] == null || $_SESSION["uid"] == null || !isViewer($_REQUEST["id"])){
	header("Location: index.php");
	exit;
}

$allGroupsIds = array_merge($_SESSION["ownGroupsIds"], $_SESSION["groupsIds"]);
$allGroupsNames = array_merge($_SESSION["ownGroupsNames"], $_SESSION["groupsNames"]);
$_REQUEST["group"]=array(0=>array("id" => $_REQUEST["id"], "name" => $allGroupsNames[array_search($_REQUEST["id"], $allGroupsIds)]));

$forums=selectQuery("
		SELECT 
			f.id id, 
			f.name name, 
			f.description description, 
			(SELECT 
				count(p.id) 
			FROM 
				posts p 
			WHERE 
				p.fid = f.id AND
				p.visible = TRUE) posts, 
			(SELECT 
				count(c.id) 
			FROM 
				comments c, 
				posts p
			WHERE 
				p.fid = f.id AND
				c.pid = p.id AND
				p.visible = TRUE AND 
				c.visible = TRUE) comments 
		FROM 
			forums f 
		WHERE 
			f.visible = TRUE AND
			f.gid = ".$_REQUEST["id"]." ");

$_REQUEST["forums"]=$forums;

$owner=selectQuery("
		SELECT 
			u.id,
			u.nick 
		FROM
			users u,
			groups g 
		WHERE 
			u.id = g.uid AND
			g.id = ".$_REQUEST["id"]." ");

$_REQUEST["owner"]=$owner;

$members=selectQuery("
		SELECT 
			u.id,
			u.nick 
		FROM
			users u,
			groups g,
			members m 
		WHERE 
			u.id = m.uid AND
			g.id = m.gid AND
			g.id = ".$_REQUEST["id"]." ");

$_REQUEST["members"]=$members;
if(isOwner($_REQUEST["id"])){
	if(isset($_REQUEST["addForum"], $_REQUEST["forumName"], $_REQUEST["forumDescription"])){
		addForum($_REQUEST["forumName"], $_REQUEST["forumDescription"], $_REQUEST["id"]);
		header("Location: group.php?id=".$_REQUEST["id"]);
		exit;
	}
	
	if(isset($_REQUEST["forumId"], $_REQUEST["forumName"], $_REQUEST["forumDescription"])){
		editForum($_REQUEST["forumId"], $_REQUEST["forumName"], $_REQUEST["forumDescription"]);
		header("Location: group.php?id=".$_REQUEST["id"]);
		exit;
	}
	
	if(isset($_REQUEST["deleteForum"])){
		deleteForum($_REQUEST["deleteForum"]);
		header("Location: group.php?id=".$_REQUEST["id"]);
		exit;
	}
	
	if(isset($_REQUEST["addMembers"], $_REQUEST["newMembers"])){
		$newMembers=getNewMembers($_REQUEST["newMembers"]);
		sendInvitations($newMembers, $_REQUEST["id"]);
		header("Location: group.php?id=".$_REQUEST["id"]);
		exit;
	}
	
	if(isset($_REQUEST["deleteMember"])){
		deleteMember($_REQUEST["deleteMember"], $_REQUEST["id"]);
		header("Location: group.php?id=".$_REQUEST["id"]);
		exit;
	}
}

$FORWARD = findForward("forums");
include(TEMPLATE_FILE);
?>
