<?php
include("scripts/init.php");

if(!isset($_REQUEST["id"])){
	header("Location: index.php");
	exit;
}

$forum = selectQuery("
		SELECT 
			f.id,
			f.gid,
			f.name 
		FROM 
			forums f 
		WHERE 
			f.visible = TRUE AND 
			f.id = $_REQUEST[id]");

$_REQUEST["forum"]=$forum;

if(count($forum)==0){
	header("Location: index.php");
	exit;
}

$posts = selectQuery("
		SELECT 
			p.id id, 
			p.fid fid, 
			p.title title, 
			p.creation_date creation_date, 
			(SELECT 
				count(c.id) 
			FROM 
				comments c 
			WHERE 
				c.pid = p.id AND 
				c.visible = TRUE) comments 
		FROM 
			posts p 
		WHERE 
			p.visible = TRUE AND 
			p.fid = $_REQUEST[id]
		ORDER BY 
			creation_date 
		DESC LIMIT 10;");

$_REQUEST["posts"]=$posts;

if(count($posts) == 0){
	if($forum[0]["gid"] != null){
		header("Location: group.php?id=".$forum[0]["gid"]);
	}else{
		header("Location: index.php");
	}
	exit;
}

$admins = selectQuery("
		SELECT
			u.id,
			u.nick
		FROM
			users u,
			admins a
		WHERE
			u.id =  a.uid AND
			a.fid = ".$_REQUEST["id"]." ");

$_REQUEST["admins"]=$admins;

if($forum[0]["gid"] != null){
	if($_SESSION["uid"] == null || !isViewer($forum[0]["gid"])){
		header("Location: index.php");
		exit;
	}
	
	$allGroupsIds = array_merge($_SESSION["ownGroupsIds"], $_SESSION["groupsIds"]);
	$allGroupsNames = array_merge($_SESSION["ownGroupsNames"], $_SESSION["groupsNames"]);
	$_REQUEST["group"]=array(0=>array(id => $forum[0]["gid"], name => $allGroupsNames[array_search($forum[0]["gid"], $allGroupsIds)]));
	
	$members=selectQuery("
			SELECT
				u.id,
				u.nick
			FROM
				users u,
				members m
			WHERE
				u.id =  m.uid AND
				u.id NOT IN (
				SELECT
					a.uid
				FROM
					admins a
				WHERE
					a.uid = u.id AND
					a.fid = ".$_REQUEST["id"].") AND
					m.gid = ".$forum[0]["gid"]." ");
	
	$_REQUEST["members"]=$members;

	if(isOwner($forum[0]["gid"])){
		if(isset($_REQUEST["addAdmin"], $_REQUEST["newAdmin"])){
			addAdmin($_REQUEST["newAdmin"], $_REQUEST["id"]);
			header("Location: forum.php?id=".$_REQUEST["id"]);
			exit;
		}
		
		if(isset($_REQUEST["deleteAdmin"])){
			deleteAdmin($_REQUEST["deleteAdmin"], $_REQUEST["id"]);
			header("Location: forum.php?id=".$_REQUEST["id"]);
			exit;
		}
	}
}

$FORWARD = $FORWARD = findForward("forum");
include(TEMPLATE_FILE);
?>
