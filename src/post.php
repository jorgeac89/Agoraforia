<?php
include("scripts/init.php");

if(!isset($_REQUEST["id"])){
	header("Location: index.php");
	exit;
}

$post=selectQuery("
		SELECT 
			p.id id, 
			p.fid fid, 
			p.title title, 
			p.content content, 
			p.creation_date creation_date,
			f.gid gid,
			f.name fname,  
			(SELECT 
				count(c.id) 
			FROM 
				comments c 
			WHERE 
				c.pid = p.id AND 
				c.visible = TRUE) comments 
		FROM 
			posts p, 
			forums f 
		WHERE 
			f.id = p.fid AND 
			f.visible = TRUE AND 
			p.visible = TRUE AND 
			p.id = ".$_REQUEST["id"].";");

$_REQUEST["post"] = $post;

$_REQUEST["forum"][0]["id"] = $post[0]["fid"];
$_REQUEST["forum"][0]["name"] = $post[0]["fname"];

if(count($post)==0){
	header("Location: index.php");
	exit;
}

$comments=selectQuery("
		SELECT
			c.id id,
			p.fid fid,
			c.uid uid,
			u.nick nick,
			c.title title,
			c.content content,
			c.creation_date creation_date
		FROM
			posts p,
			comments c,
			users u
		WHERE
			c.pid = p.id AND
			c.uid = u.id AND
			c.visible = TRUE AND
			c.pid = ".$_REQUEST["id"]."
		ORDER BY
			creation_date
		LIMIT 10;");

$_REQUEST["comments"] = $comments;

if($post[0]["gid"] != null){
	if($_SESSION["uid"]==null || !isViewer($post[0]["gid"])){
		header("Location: index.php");
		exit;
	}
	
	$group=selectQuery("
			SELECT 
				id,
				name
			FROM 
				groups 
			WHERE 
				id = ".$post[0]["gid"]." ");
	
	$_REQUEST["group"]=$group;
}

if(isset($_REQUEST["newCommentTitle"], $_REQUEST["newCommentContent"]) && isPoster($post[0]["fid"])){
	if(addComment($_REQUEST["newCommentTitle"], $_REQUEST["newCommentContent"], $_SESSION["uid"], $_REQUEST["id"])){
		header("Location: post.php?id=".$_REQUEST["id"]);
		exit;
	}
}

if(isAdmin($post[0]["fid"])){
	if(isset($_REQUEST["deletePost"])){
		if(deletePost($_REQUEST["deletePost"])){
			header("Location: forum.php?id=".$post[0]["fid"]);
			exit;
		}
	}
	
	if(isset($_REQUEST["deleteComment"])){
		if(deleteComment($_REQUEST["deleteComment"])){
			header("Location: post.php?id=".$_REQUEST["id"]);
			exit;
		}
	}
	
	if(isset($_REQUEST["editPostTitle"], $_REQUEST["editPostContent"])){
		if(editPost($_REQUEST["id"], $_REQUEST["editPostTitle"], $_REQUEST["editPostContent"])){
			header("Location: post.php?id=".$_REQUEST["id"]);
			exit;
		}
	}
	
	if(isset($_REQUEST["editCommentId"], $_REQUEST["editCommentTitle"], $_REQUEST["editCommentContent"])){
		if(editComment($_REQUEST["editCommentId"], $_REQUEST["editCommentTitle"], $_REQUEST["editCommentContent"])){
			header("Location: post.php?id=".$_REQUEST["id"]);
			exit;
		}
	}
}

$FORWARD = $FORWARD = findForward("post");
include(TEMPLATE_FILE);
?>
