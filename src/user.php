<?php
include("scripts/init.php");

if(!isset($_REQUEST["id"])){
	header("Location: index.php");
	exit;
}

$user=selectQuery("
		SELECT 
			u.id id, 
			u.nick nick, 
			u.email email, 
			u.name name, 
			u.surname surname, 
			u.date date, 
			(SELECT 
				count(p.id)
			FROM 
				posts p 
			WHERE 
				p.uid = u.id) posts,
			(SELECT 
				count(c.id)
			FROM 
				comments c 
			WHERE 
				c.uid = u.id) comments
		FROM 
			users u
		WHERE 
			u.active = TRUE AND 
			u.id = ".$_REQUEST["id"].";");

$_REQUEST["user"]=$user;

if(count($user)==0){
	header("Location: index.php");
	exit;
}

$ownGroups=selectQuery("
		SELECT
			g.id,
			g.name
		FROM
			groups g
		WHERE
			g.active = TRUE AND
			g.uid = ".$_REQUEST["id"]." ");

$_REQUEST["ownGroups"]=$ownGroups;

$groups=selectQuery("
		SELECT
			g.id,
			g.name
		FROM
			groups g,
			members m
		WHERE
			g.active = TRUE AND
			m.gid = g.id AND
			m.uid = ".$_REQUEST["id"]." ");

$_REQUEST["groups"]=$groups;

if(isset($_SESSION["uid"]) && $_SESSION["uid"] == $user[0]["id"]){
	$messages=selectQuery("
			SELECT
				m.id id,
				m.sender_id sender_id,
				u.nick sender_nick,
				m.title title,
				m.creation_date
			FROM
				messages m, 
				users u
			WHERE
				u.id = m.sender_id AND
				m.reciver_id = ".$_SESSION["uid"]." ");
	
	$_REQUEST["messages"] = $messages;
}
$FORWARD = findForward("userPage");
include(TEMPLATE_FILE);
?>
