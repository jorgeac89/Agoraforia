<?php
function loginLogout(){
	if(isset($_SESSION["uid"], $_REQUEST["logout"])){
		endSession();
		header("Location: ".$_SERVER["REQUEST_URI"]);
		exit;
	}
	if(!isset($_SESSION["uid"]) && isset($_REQUEST["login"], $_REQUEST["nick"], $_REQUEST["password"])){
		startSession($_REQUEST["nick"], $_REQUEST["password"]);
		header("Location: ".$_SERVER["REQUEST_URI"]);
		exit;
	}
}

function cancel(){
	if(isset($_REQUEST["cancel"])){
		header("Location: ".$_SERVER["REQUEST_URI"]);
		exit;
	}
}

function acceptInvitation(){
	if(isset($_SESSION["uid"], $_REQUEST["acceptInvitation"]) && isInvited($_REQUEST["acceptInvitation"])){
		modQuery("
				INSERT INTO members(
					uid, 
					gid)
				VALUES( ".
					$_SESSION["uid"].", ".
					$_REQUEST["acceptInvitation"].") ");
		modQuery("
				DELETE FROM invitations 
				WHERE 
					uid=".$_SESSION["uid"]." AND 
					gid=".$_REQUEST["acceptInvitation"]." ");
		loadSession($_SESSION["uid"]);
		header("Location: ".$_SERVER["REQUEST_URI"]);
		exit;
	}
}

function leaveGroup(){
	if(isset($_SESSION["uid"], $_REQUEST["leaveGroup"]) && isMember($_REQUEST["leaveGroup"])){
		deleteMember($_SESSION["uid"], $_REQUEST["leaveGroup"]);
		loadSession($_SESSION["uid"]);
		header("Location: ".$_SERVER["REQUEST_URI"]);
		exit;
	}
}

function deleteGroup(){
	if(isset($_SESSION["uid"], $_REQUEST["deleteGroup"]) && isOwner($_REQUEST["deleteGroup"])){
		modQuery("
				UPDATE groups SET
					creation_date = creation_date, 
					active = FALSE 
				WHERE 
					id = ".$_REQUEST["deleteGroup"]." ");
		loadSession($_SESSION["uid"]);
		header("Location: ".$_SERVER["REQUEST_URI"]);
		exit;
	}
}

function deleteMember($uid, $gid){
	return modQuery("
			DELETE FROM members
			WHERE
				uid = $uid AND
				gid = $gid ");
}

function reloadSession(){
	if(isset($_REQUEST["reloadSession"])){
		loadSession($_SESSION["uid"]);
		header("Location: ".$_SERVER["REQUEST_URI"]);
		exit;
	}
}

function startSession($nick, $password){
	$uid=validateUser($nick, $password);
	if($uid!=FALSE){
		$_SESSION["uid"]=$uid;
		$_SESSION["nick"]=$nick;
		$_SESSION["home"]=USERS_DIR.$nick;
		$_SESSION["path"]="/";
		if(!is_dir($_SESSION["home"].$_SESSION["path"])){
			mkdir($_SESSION["home"].$_SESSION["path"]);
		}
		$_SESSION["admin"]=array();
		loadSession($uid);
		return TRUE;
	}
	return FALSE;
}

function loadAdmin($uid){
	$forums=selectQuery("
			(SELECT
				a.fid id
			FROM
				admins a
			WHERE
				a.uid = $uid) 
		UNION 
			(SELECT 
				f.id id
			FROM 
				forums f, 
				groups g
			WHERE 
				f.gid = g.id AND 
				g.uid = $uid) ");
	
	$_SESSION["admin"]=array();
	foreach($forums as $forum){
		$_SESSION["admin"][count($_SESSION["admin"])]=$forum["id"];
	}
}

function loadOwnGroups($uid){
	$ownGroups=selectQuery("
			SELECT
				g.id,
				g.name
			FROM
				groups g
			WHERE
				g.uid = $uid AND
				g.active = TRUE ");
	
	$_SESSION["ownGroupsIds"]=array();
	$_SESSION["ownGroupsNames"]=array();
	foreach($ownGroups as $group){
		$_SESSION["ownGroupsIds"][count($_SESSION["ownGroupsIds"])]=$group["id"];
		$_SESSION["ownGroupsNames"][count($_SESSION["ownGroupsNames"])]=$group["name"];
	}
}

function loadGroups($uid){
	$groups=selectQuery("
			SELECT
				g.id,
				g.name
			FROM
				groups g,
				members m
			WHERE
				m.uid = $uid AND
				m.gid = g.id AND
				g.active= TRUE;");
	
	$_SESSION["groupsIds"]=array();
	$_SESSION["groupsNames"]=array();
	foreach($groups as $group){
		$_SESSION["groupsNames"][count($_SESSION["groupsNames"])]=$group["name"];
		$_SESSION["groupsIds"][count($_SESSION["groupsIds"])]=$group["id"];
	}
}

function loadPoster($uid){
	$forums = selectQuery("
			SELECT
				f.id id,
				f.name name 
			FROM
				forums f
			WHERE
				f.visible = TRUE AND 
				f.gid IS NULL
		UNION
			SELECT
				f.id id,
				f.name name 
			FROM
				forums f,
				groups g
			WHERE
				g.active = TRUE AND 
				f.visible = TRUE AND
				g.id = f.gid AND
				g.uid = $uid
		UNION
			SELECT
				f.id id,
				f.name name 
			FROM
				forums f,
				groups g,
				members m
			WHERE
				g.active = TRUE AND 
				f.visible = TRUE AND 
				g.id = f.gid AND
				g.id = m.gid AND
				m.uid = $uid ");
	
	$_SESSION["posterIds"]=array();
	$_SESSION["posterNames"]=array();
	foreach($forums as $forum){
		$_SESSION["posterIds"][count($_SESSION["posterIds"])]=$forum["id"];
		$_SESSION["posterNames"][count($_SESSION["posterNames"])]=$forum["name"];
	}
}

function loadInvitations($uid){
	$_SESSION["invitationsGroupsIds"]=array();
	$_SESSION["invitationsGroupsNames"]=array();
	$invitations=selectQuery("
			SELECT
				g.id,
				g.name
			FROM
				groups g,
				invitations i
			WHERE
				i.uid = $uid AND
				i.gid = g.id AND
				g.active = TRUE;");

	foreach($invitations as $invitation){
		$_SESSION["invitationsGroupsNames"][count($_SESSION["invitationsGroupsNames"])]=$invitation["name"];
		$_SESSION["invitationsGroupsIds"][count($_SESSION["invitationsGroupsIds"])]=$invitation["id"];
	}
}

function loadMessages($uid){
	$messages=selectQuery("
			SELECT
				COUNT(m.id) messages
			FROM
				messages m
			WHERE
				m.reciver_id = $uid ");
	$_SESSION["messages"]=$messages[0]["messages"];
}

function loadSession($uid){
	loadAdmin($uid);
	loadOwnGroups($uid);
	loadGroups($uid);
	loadPoster($uid);
	loadInvitations($uid);
	loadMessages($uid);
}

function endSession(){
	session_unset();
	session_destroy();
}

function validateUser($nick, $password){
	$result=selectQuery("
			SELECT 
				id, 
				nick, 
				password 
			FROM 
				users 
			WHERE 
				nick = '$nick' AND 
				active = TRUE ");
	
	if(count($result)==0 || $result[0]["password"]!=md5($password.$nick)){
		return FALSE;
	}
	return $result[0][id];
}

function isReg($nick){
	$result=selectQuery("
			SELECT 
				nick 
			FROM 
				users 
			WHERE 
				nick = '$nick';");
	
	if(isset($result[0]["nick"])){
		return TRUE;
	}
	return FALSE;
}

function isAdmin($fid){
	if(isset($_SESSION["uid"], $_SESSION["admin"]) && in_array($fid, $_SESSION["admin"])){
		return true;
	}
	return false;
}

function isPoster($fid){
	if(isset($_SESSION["uid"], $_SESSION["posterIds"]) && in_array($fid, $_SESSION["posterIds"])){
		return true;
	}
	return false;
}

function isRegActive($nick){
	$user=selectQuery("
			SELECT
			id
			FROM
			users
			WHERE
			active = TRUE AND
			nick = '$nick' ");
	if(isset($user[0]["id"])){
		return $user[0]["id"];
	}
	return null;
}

function isOwner($gid){
	if(isset($_SESSION["uid"], $_SESSION["ownGroupsIds"]) && in_array($gid, $_SESSION["ownGroupsIds"])){
		return true;
	}
	return false;
}

function isMember($gid){
	if(isset($_SESSION["uid"], $_SESSION["groupsIds"]) && in_array($gid, $_SESSION["groupsIds"])){
		return true;
	}
	return false;
}

function isViewer($gid){
	if($gid == null){
		return true;
	}
	if(isset($_SESSION["uid"], $_SESSION["ownGroupsIds"]) && in_array($gid, $_SESSION["ownGroupsIds"])){
		return true;
	}
	if(isset($_SESSION["uid"], $_SESSION["groupsIds"]) && in_array($gid, $_SESSION["groupsIds"])){
		return true;
	}
	return false;
}

function isInvited($gid){
	if(isset($_SESSION["uid"], $_SESSION["invitationsGroupsIds"]) && in_array($gid, $_SESSION["invitationsGroupsIds"])){
		return true;
	}
	return false;
}

function validateNick($nick){
	if(strlen($nick)>=3 && !isReg($nick)){
		return true;
	}
}

function validatePassword($password){
	if(strlen($password)>=3){
		return true;
	}
	return false;
}

function validateEmail($email){
	return true;
}

function validateName($name){
	if(strlen($name)>=3){
		return true;
	}
	return false;
}

function validateSurname($surname){
	if(strlen($surname)>=3){
		return true;
	}
	return false;
}

function validateRegForm($nick, $password, $email, $name, $surname, $date){
	if(validateNick($nick) && validateEmail($email) && validatePassword($password) && validateName($name) && validateSurname($surname)){
		return true;
	}
	return false;
}

function regUser($nick, $password, $email, $name, $surname, $date){
	if(modQuery("
			INSERT INTO users(
				nick, 
				password, 
				email, 
				name, 
				surname, 
				date, 
				creation_date, 
				creation_ip,
				active) 
			VALUES(
				'$nick', 
				'".md5($password.$nick)."', 
				'$email', 
				'$name', 
				'$surname', 
				'$date', 
				'".date("Y-m-d H:i:s")."', 
				'".$_SERVER["REMOTE_ADDR"]."',  
				TRUE) ")){
		mkdir(USERS_DIR.$nick."/");
		return TRUE;
	}
	return FALSE;
}

function isShared($uid, $path, $file){
	$file=selectQuery("
			SELECT 
				uid 
			FROM 
				shared 
			WHERE 
				uid = $uid AND 
				path = '$path' AND 
				file = '$file';");
	
	if(count($file)==0){
		return FALSE;
	}else{
		return TRUE;
	}
}

function addPost($title, $content, $uid, $fid){
	return modQuery("
			INSERT INTO posts(
				title, 
				content, 
				uid, 
				fid, 
				creation_date, 
				creation_ip,
				visible) 
			VALUES(
				'$title', 
				'$content', 
				'$uid', 
				'$fid', 
				'".date("Y-m-d H:i:s")."', 
				'".$_SERVER["REMOTE_ADDR"]."', 
				TRUE )");
}

function addComment($title, $content, $uid, $pid){
	return modQuery("
			INSERT INTO comments(
				title, 
				content, 
				uid, 
				pid, 
				creation_date, 
				creation_ip, 
				visible) 
			VALUES (
				'$title', 
				'$content', 
				'$uid', 
				'$pid', 
				'".date("Y-m-d H:i:s")."', 
				'".$_SERVER["REMOTE_ADDR"]."', 
				TRUE )");
}

function addForum($forumName, $forumDescription, $gid){
	return modQuery("
			INSERT INTO forums(
				name,
				description,
				gid,
				visible)
			VALUES(
				'$forumName',
				'$forumDescription',
				$gid,
			TRUE) ");
}

function addGroup($uid, $name, $description, $forums){
	$correct=modQuery("
			INSERT INTO groups(
				uid, 
				name, 
				description,
				creation_date,
				creation_ip,
				active) 
			VALUES(
				$uid,
				'$name', 
				'$description', 
				'".date("Y-m-d H:i:s")."', 
				'".$_SERVER["REMOTE_ADDR"]."',
				TRUE) ");
	if($correct){
		$group=selectQuery("
				SELECT 
					id 
				FROM 
					groups
				WHERE 
					uid = $uid AND
					name = '$name' AND
					description = '$description'");
		
		foreach($forums as $forum){
			if($forum["name"]!=null && $forum["name"]!=""){
				addForum($forum["name"], $forum["description"], $group[0]["id"]);
			}
		}
	}
	return $correct;
}

function addAdmin($uid, $fid){
	return modQuery("
			INSERT INTO admins(
				uid,
				fid)
			VALUES(
				$uid, 
				$fid) ");
}

function addMessage($title, $content, $senderId, $recivers){
	foreach($recivers as $reciver){
		$uid = isRegActive($reciver);
		if($uid != null){
			modQuery("
					INSERT INTO messages(
						sender_id,
						reciver_id,
						title,
						content,
						creation_date,
						creation_ip,
						read_date,
						visible)
					VALUES(
						'".$_SESSION["uid"]."',
						'$uid',
						'$title',
						'$content',
						'".date("Y-m-d H:i:s")."',
						'".$_SERVER["REMOTE_ADDR"]."',
						NULL,
						TRUE )");
		}
	}
}

function deletePost($pid){
	return modQuery("
			UPDATE posts SET 
				creation_date = creation_date, 
				visible = FALSE 
			WHERE 
				id = $pid;");
}

function deleteComment($cid){
	return modQuery("
			UPDATE comments SET 
				creation_date = creation_date, 
				visible = FALSE
			WHERE 
				id = $cid;");
}

function deleteForum($fid){
	return modQuery("
			UPDATE forums SET
				visible = FALSE
			WHERE
				id = $fid;");
}

function deleteAdmin($uid, $fid){
	return modQuery("
			DELETE FROM admins
			WHERE
				uid = $uid AND
				fid = $fid ");
}

function editPost($pid, $title, $content){
	return modQuery("
			UPDATE posts SET 
				creation_date = creation_date, 
				title = '$title', 
				content = '$content' 
			WHERE 
				id = $pid ");
}

function editComment($cid, $title, $content){
	echo $cid;
	return modQuery("
			UPDATE comments SET 
				creation_date = creation_date, 
				title = '$title', 
				content = '$content' 
			WHERE 
				id = $cid ");
}

function editForum($fid, $forumName, $forumDescription){
	return modQuery("
			UPDATE forums SET
				name = '$forumName',
				description = '$forumDescription'
			WHERE
				id = $fid " );
}

function getNewMembers($newMembers){
	$newMembers = preg_split("/;/", $newMembers);
	foreach($newMembers as $clave => $valor){
		$newMembers[$clave]=trim($valor);
	}
	return $newMembers;
}

function getSplits($string){
	$splitArray = preg_split("/;/", $string);
	foreach($splitArray as $clave => $valor){
		$splitArray[$clave]=trim($valor);
	}
	return $splitArray;
}

function getDriveSize(){
	return folderSize($_SESSION["home"]."/");
}

//TODO Comprobar si el usuario a invitar ya está invitado o es miembro del grupo.
function sendInvitations($newMembers, $gid){
	foreach($newMembers as $newMember){
		$uid = isRegActive($newMember);
		if($uid != null && isOwner($gid)){					
			modQuery("
					INSERT INTO invitations(
						uid,
						gid) 
					VALUES(
						$uid,
						$gid) ");
		}
	}
}
?>
